<?php
date_default_timezone_set("Asia/Taipei");

class MY_SqlFunction extends CI_Controller {

	private $SM_key = 0;
	private $SM_name;	
	private $login = 0;
	private $photo = "no-user.png";

	//加密
    private $_publicKey = "";
    private $_token = "";

	public function __construct(){
		parent::__construct();
		session_start();
		session_regenerate_id();
		header("X-Frame-Options: DENY");
		$this->load->model("SqlFunction_model","",TRUE);
		$this->load->model("login_model","",TRUE);
		$this->load->helper('cookie');

		if(($account=$this->input->cookie('account',TRUE))!="" && ($user_id=$this->input->cookie('user_id',TRUE))!=""){
			$password=$this->login_model->loginid($account,$user_id);
			$this->input->set_cookie('md5Id',$password,2592000);
			if($password){
				$_SESSION['account'] = $account;
				$_SESSION['password']= $password;
			}
		}

		// session_destroy();
		if(isset($_SESSION["account"]) && isset($_SESSION["password"]) && $_SESSION["account"] && $_SESSION["password"]) {
			$system_memebr = $this->SqlFunction_model->check_member($_SESSION["account"],$_SESSION["password"]);

			if($system_memebr->num_rows()){
				//取得會員資料ˋ
				$this->SM_key = $system_memebr->row()->SM_key;
				$this->SM_name = $system_memebr->row()->SM_name;
				$this->login=1; //進到裡面代表存在該筆會員資料 把login設成1 = 登入成功
				//$this->photo="會員圖片，若存在則輸出檔名，若不存在則輸出no-user.png";
				if($system_memebr->row()->SM_photo != null){
					$this->photo = $system_memebr->row()->SM_photo;
				}else{
					$this->photo = "no-user.png";
				}
				//取得加密資訊
				if(isset($_SESSION['publicKey'])){
					$this->_publicKey = $_SESSION['publicKey'];
				}else{
					$_SESSION['publicKey'] = $this->rsaStart();
					$this->_publicKey = $_SESSION['publicKey'];
				}
		    	$this->_token = $_SESSION['token'];
			}else{
				$this->login=0; //登入失敗
			}
		}

	}

	//資料消毒
	public function xss(array $array){

		foreach ($array as &$value){
			if(is_array($value)){
				$value = $this->xss($value);
			}else{
				$value = $this->security->xss_clean($value);
			}
		}
		
		return $array;
	}

	public function getSMkey(){
		return $this->SM_key;
	}

	public function getSMname(){
		return $this->SM_name;
	}

	public function getlogin(){
		return $this->login;
	}

	public function getPhoto(){
		return $this->photo;
	}

	public function viewItem($title){
		$data['title'] = $title; //取得標題
		$data["membername"] = $this->getSMname(); //取得會員名稱
		$data["login"] = $this->getlogin(); //取得登入狀況
		$data["photo"] = $this->getPhoto();
		if($this->getlogin()==1){
			if($this->loginTest()==0){
				$data["loginTest"] = "你的帳號已於他處登入，請重新登入。";
			}else{
				$data["token"] = $this->tokenEncrypt();
			}
		}
		return $data;
	}

	//取得新的令牌
	public function getNewToken(){
        $key = '';
        $word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($word);
        for ($i = 0; $i < 50; $i++) {
            $key .= $word[rand() % $len];
        }
        return base64_encode($key);
    }

    /*********************
	底層Function
		基層的加解密、與產生公私鑰。
	*********************/
    public function rsaStart(){
    	$privateKey = "";
    	$resource = openssl_pkey_new();
        openssl_pkey_export($resource, $privateKey);
        $detail = openssl_pkey_get_details($resource);
        //私鑰放入資料庫
        $this->SqlFunction_model->set_privateKey($this->getSMkey(),$privateKey);
        //回傳公鑰
        return $detail['key'];
    }

    //公鑰加密
    public function publicEncrypt($data){
        openssl_public_encrypt($data, $encrypted, $this->getPublicKey());
        return $encrypted;
    }
    //私鑰解密
    public function privateDecrypt($data){
        openssl_private_decrypt($data, $decrypted, $this->getPrivateKey());
        return $decrypted;
    }

    //取得私鑰
    public function getPrivateKey(){
        return $this->SqlFunction_model->get_privateKey($this->SM_key,"SM_privateKey");
    }

    //取得令牌
    public function getToken(){
        return $this->_token;
    }

    //取得最後一次登入時間
    public function getLoginDateTime(){
        return $this->SqlFunction_model->get_privateKey($this->SM_key,"SM_dateTime");
    }

    //取得公鑰
    public function getPublicKey(){
        return $this->_publicKey;
    }


    /*********************
	應用Function
		回傳已加密、解密的字串。
	*********************/

    //主鍵加密，回傳加密的主鍵、token(成為本次資料庫交易唯一碼)
    public function primaryKeyEncrypt($data){
    	$str = $data.",".$this->_token;
        return base64_encode($this->publicEncrypt($str));
    }
    //token加密，回傳加密的token
    public function tokenEncrypt(){
        return base64_encode($this->publicEncrypt($this->_token));
    }

    //主鍵解密，判斷是否為合法主鍵
    //return Array("check"=>"true|false" , "key"=>"data primary")
    public function primaryKeyDecrypt($data){
    	$str = base64_decode($data);
    	$strArray = explode(",", $this->privateDecrypt($str));
    	if(count($strArray)==0){
    		return Array("check"=>false , "key"=>"");
    	}else{
    		if($strArray[0]==""){
    			return Array("check"=>false , "key"=>"");
    		}else{
    			if($strArray[1]==$this->getToken()){
	    			return Array("check"=>true , "key"=>$strArray[0]);
	    		}else{
	    			return Array("check"=>false , "key"=>"");
	    		}
    		}
    	}
    }

    //token解密，判斷是否為合法token，回傳True或False
    public function tokenDecrypt($data){
    	$str = base64_decode($data);
    	if($this->privateDecrypt($str) == $this->getToken()){
    		return true;
    	}else{
    		return false;
    	}
    }

    //登入判斷
    public function loginTest(){
    	//取得目前TOKEN，使用公鑰加密
    	$checkToken = $this->publicEncrypt($this->getToken());
    	//檢查私鑰解密後，是否與原始值相同
    	if($this->getToken() == $this->privateDecrypt($checkToken)){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    //URL加密
    function url_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	//URL解密
	function url_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return $this->security->xss_clean(base64_decode($data));
	}

	
}

?>