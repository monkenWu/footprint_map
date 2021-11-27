<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Recover extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("recover_model","",TRUE);
		$this->load->library('email');
		// $this->load->library('email');
	}

	public function index() {
		$data = $this->viewItem("忘記密碼");

		$this->load->view("recover_view",$data);
	} 

	//我不是機器人驗證
	public function recaptcha(){
		$ReCaptchaResponse=filter_input(INPUT_POST, 'reCaptchaResponse');
		$Response=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6Ldx9lIUAAAAAIy44omdFxd8tTStXEEAl9EA_l_9&response='.$ReCaptchaResponse."&remoteip=".$_SERVER['REMOTE_ADDR']);
		echo ($Response)?'OK':'ERROR';
	}

	/***
		傳入值為：$_Post['email','type']
				 type : 0初步請求 1確定刪除前一個請求，重新請求
		EMAIL寄送方式與方法：
			1. SMTP
			2. CI3 寄送詳情 https://codeigniter.org.tw/user_guide/libraries/email.html
		傳入驗證：務必進行資料消毒、資料驗證的工作。
		成功echo 1; 已有過請求echo 0; 發送失敗 echo 2;
		***/
	public function email(){

		
		$post = $this->xss($_POST);
		$email = trim($post['email']); //去空白 以防有人打錯
		$result = $this->recover_model->email_exists($email);
		$type = $post['type'];
		if($this->recover_model->check_email($email)){
 			echo "3";
 		}else{
		$system_key = $this->recover_model->get_SMkey($email); //取得SM_email對應的SM_key
		$system_time = $this->recover_model->get_time_check($email); //取得SM_email對應的時間比數
		$time = $this->recover_model->get_time($email);	//取得SM_email對應的時間值
		$SM_key = $system_key->row()->SM_key;
 		if(time()-strtotime($time)>1800){
			$this->recover_model->delete_code($SM_key);
			echo "1";
			$this->send_reset_password_email($email,$result,$SM_key);

		}else if($system_time->num_rows()){ //要是驗證已經有存在一筆了 就詢問是否要重新發送
			$SRE_dateTime = $system_time->row()->SRE_dateTime;
			// if(time()-strtotime($SRE_dateTime)>60){
			// 	$this->recover_model->delete_code($SM_key);

			// }
			echo $type;
			//重新發送驗證碼 
			if($type =="1"){	
				$this->send_reset_password_email_update($email,$result);
			}
		}

		//沒有過請求的話 直接發送
		else if($result){
			$this->send_reset_password_email($email,$result,$SM_key);
			echo "1";
		}	
		else{
			echo "2";
		}
	}
	}

	public function send_reset_password_email($email,$name,$SM_key){

		//製造一個6位數的16進位數字
		$number = mt_rand(0x000000,0xffffff);

		$number = dechex($number & 0xffffff);

		$number = str_pad($number, 6);
		// $email_code = md5($this->config->item('salt') . $SM_name);

		$this->email->from('footprintmaps@gmail.com','footprintmaps');
		$this->email->to($email);
		$this->email->subject("Please reset your passwrod");
		
		$message = '<!DOCTYPE html>
		<html>
		<head>
		<meta charset="utf-8">	
		</head><body>';

		$message .= '<p>親愛的 ' . $name . ',<p>';
		$message .= '<p>我們想要幫助您重設您的密碼，請輸入此號碼'.$number.'來重設您的密碼</p>';
		$message .= '</body></html>';

		$this->email->message($message);
		$this->email->send();
		
		//發送驗證碼
		$this->recover_model->send_code($email,$number,$SM_key);

	}

	public function send_reset_password_email_update($email,$name){
		//製造一個6位數的16進位數字
		$number = mt_rand(0x000000,0xffffff);

		$number = dechex($number & 0xffffff);

		$number = str_pad($number, 6);
		// $email_code = md5($this->config->item('salt') . $SM_name);

		$this->email->from('footprintmaps@gmail.com','footprintmaps');
		$this->email->to($email);
		$this->email->subject("Please reset your passwrod");
		
		$message = '<!DOCTYPE html>
		<html>
		<head>
		<meta charset="utf-8">	
		</head><body>';

		$message .= '<p>親愛的 ' . $name . ',<p>';
		$message .= '<p>我們想要幫助您重設您的密碼，請輸入此號碼'.$number.'來重設您的密碼</p>';
		$message .= '</body></html>';

		$this->email->message($message);
		$this->email->send();
		
		//發送驗證碼
		$this->recover_model->send_code_update($email,$number);
	}


	/***
		傳入值為：$_Post['email','number']
		傳入驗證：進行資料消毒，必須與資料庫中的驗證碼、EMAIL匹配
		成功echo 1; 失敗 echo 0;
		***/
		public function number(){
			$post = $this->xss($_POST);
		$email = trim($post['email']); //去空白 以防有人打錯
		$number =  $post['number'];

		//判斷驗證碼是否存在
		if(!$this->recover_model->check_code($email,$number)){
			echo 1;
		}
		else{
			echo 0;
		}

	}

	/***
		傳入值為：$_Post['email','number','password']
		傳入驗證：進行資料消毒，必須與資料庫中的驗證碼、EMAIL匹配才可以修改密碼
		成功echo 1; 失敗 echo 0;
		***/
		public function password(){
			$post = $this->xss($_POST);
		$email = trim($post['email']); //去空白 以防有人打錯
		$number =  $post['number'];
		$password = md5($post['password']);

		$system_key = $this->recover_model->get_SMkey($email); //取得SM_email對應的SM_key

		if($system_key->num_rows()){ //判斷是否存在一筆
			$SM_key = $system_key->row()->SM_key;		//是的話 取出SM_key SM_key為該筆email的key

			if(!$this->recover_model->check_code($email,$number)){ //要是有找到一筆驗證碼的話
				$this->recover_model->reset_password($password,$SM_key); //重設密碼
				$this->recover_model->delete_code($SM_key);
				echo 1;
			}
			else{
				echo 0;
			}
		}
	}


}
