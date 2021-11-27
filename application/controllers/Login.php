<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Login extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("login_model","",TRUE);
	}

	public function index() {

		$data = $this->viewItem("footprint - 登入");
		
		if($data['login']==0){//要是非登入狀態導到登入頁面
			$_SESSION['loginToken'] = $this->getNewToken();
			$data['loginToken'] = $_SESSION['loginToken'];
			$this->load->view("login_view",$data);
		}else{
			redirect("home");
		}

	} 

	//我不是機器人驗證
	public function recaptcha(){
		$ReCaptchaResponse=filter_input(INPUT_POST, 'reCaptchaResponse');
		$Response=file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret={key}&response='.$ReCaptchaResponse."&remoteip=".$_SERVER['REMOTE_ADDR']);
		echo ($Response)?'OK':'ERROR';
	}

	/***
		傳入值為：$_Post['account','password','login'] 
				  login=1 保持登入 ; login=0 一般登入;
		傳入驗證：資料消毒
		成功echo 1; 失敗echo 0; 偽造請求 echo2;
		***/
	public function signin(){

		if(!isset($_POST['token'])){
			@header("http/1.1 404 not found");
			@header("status: 404 not found");
			echo '偽造請求';//直接輸出錯誤訊息
			exit();
		}

		if($_POST['token'] != $_SESSION['loginToken']){
			@header("http/1.1 404 not found");
			@header("status: 404 not found");
			echo '偽造請求';//直接輸出錯誤訊息
			exit();
		}else{
			$post = $this->xss($_POST);
			$account = $post['account'];
			$password = md5($post['password']); //將密碼使用md5加密法加密

			$user_id = $this->login_model->login($account,$password); //取得該筆會員的id
			$login=$post['login'];

			if(isset($_POST["account"]) && isset($_POST["password"])){ 
				if($user_id){ //要是存在 把帳號密碼丟給SESSION
					$_SESSION['account'] = $account;
					$_SESSION['password'] = $password;
					if($login==1){
		  				$this->input->set_cookie('account',$account,2592000);
		  				$this->input->set_cookie('user_id',md5($user_id),2592000);
					}
					//取得本次登入令牌
					$_SESSION['token'] = $this->getNewToken();
					session_regenerate_id();
					echo 1;
				}else{
					echo 0;
				}
			}
		}
	}

	public function tokenCheck(){
		if($this->getlogin() == 1 && isset($_SESSION["token"])){
			echo $this->loginTest();
		}else{
			redirect("home");
		}
	}


}
