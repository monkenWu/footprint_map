<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Signup extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("signup_model","",TRUE);
	}

	public function index() {
		$data = $this->viewItem("Footprint - 會員註冊");

		if($data['login']==0){ //要是非登入狀態導到註冊頁面
			$_SESSION['signupToken'] = $this->getNewToken();
			$data['signupToken'] = $_SESSION['signupToken'];
			$this->load->view("signup_view",$data);
		}
		else{
			redirect("home");
		}
	} 

	//我不是機器人驗證
	public function recaptcha(){
		$ReCaptchaResponse=filter_input(INPUT_POST, 'reCaptchaResponse');
		$Response=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6Ldx9lIUAAAAAIy44omdFxd8tTStXEEAl9EA_l_9&response='.$ReCaptchaResponse."&remoteip=".$_SERVER['REMOTE_ADDR']);
		echo ($Response)?'OK':'ERROR';
	}

	/***
		傳入值為：$_Post['account','password','username','email','sex']
		傳入驗證：帳號必須介於6到18個字符之間。不允許特殊字符。
				  密碼必須介於6到20個字符之間。不允許特殊字符。
				  暱稱必須介於2到10個字符之間。不允許特殊字符。
				  務必進行資料消毒、資料驗證的工作。
		成功echo 1; 失敗(任一資料空值)echo 0; 帳號重複 2; 信箱重複3;
		***/
		public function add(){


		if(!isset($_POST['token'])){
			@header("http/1.1 404 not found");
			@header("status: 404 not found");
			echo '偽造請求';//直接輸出錯誤訊息
			exit();
		}

		if($_POST['token'] != $_SESSION['signupToken']){
			@header("http/1.1 404 not found");
			@header("status: 404 not found");
			echo '偽造請求';//直接輸出錯誤訊息
			exit();
		}


		$post = $this->xss($_POST);
		$enc_password = md5($post['password']); //將密碼使用md5加密法加密
		$account = $post['account'];
		$email = trim($post['email']); //去空白以防有人打錯

		//檢測是否存在這些post資料
		if(isset($post['account']) && isset($post['password']) && isset($post['username']) && isset($post['email']) && isset($post['sex'])){

		//要是帳號密碼暱稱信箱其中一欄是空值的話返回0	
			if($post['account']=="" || $post['password']=="" || $post['username']=="" || $post['email']==""){ 
				echo 0;
			}

			//驗證帳號密碼暱稱信箱 是否為規定型態 不可有特殊字符
			else if(!preg_match('/^[A-Za-z0-9]{6,18}$/',$account) || !preg_match('/^[A-Za-z0-9]{6,18}$/',$post['password']) ||
			   !preg_match('/^[\w\x{4e00}-\x{9fa5}]+$/u ',$post['username']) || !preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/',$post['email'])){
				echo 0;
			}

			//要是帳號重複的話返回2
			else if(!$this->signup_model->account_isreapet($account)){ 
				echo 2;
			}

			//要是信箱重複的話返回3
			else if(!$this->signup_model->email_isreapet($email)){ 
				echo 3;
			}

			//要是註冊成功 就把值丟進資料庫 並返回1
			else{
				$this->signup_model->register($post,$enc_password,$email); 
				echo 1; 
				
			}
		}
	}
}
