<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Profile extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("profile_model","",TRUE);
	}

	/****
		每次進入頁面都要判斷是否登入若否則重新導向到HOME。
	****/
	public function index() {
		if($this->getlogin() == 1){
			redirect("profile/member/".$this->url_b64encode($this->getSMkey()));
		}else{
			$data = $this->viewItem("Footprint - 個人主頁");
			$data['error'] = "沒有登入，請登入後再試";
			$data['member'] = 0 ;
			$this->load->view("profile_view",$data);
			//redirect("login");
		}
	//$this->load->view("home_view",$data);
	}

	/****
		判斷進入頁面是否為帳號擁有者本人，以及判斷傳入的id資料庫內是否真的存在。
	****/
	public function member($id=""){
		if($this->getlogin() == 1){
			if($id==""){
				redirect("profile/member/".$this->url_b64encode($this->getSMkey()));
			}else{
				$deID = $this->url_b64decode($id);
				if($deID == $this->getSMkey()){
					//為本人
					$data = $this->viewItem("Footprint - 個人主頁");
					$data['member'] = 1 ; 
					$data['id'] = $id;
					$this->load->view("profile_view",$data);
				}else{
					//非本人
					$data = $this->viewItem("Footprint - 個人主頁");
					$data['member'] = 0 ;
					$data['id'] = $id;

					//判斷是否有這個SMkey，若否則傳出$data['error']="資料錯誤請確認再試";
					if($this->profile_model->check_SMkey($deID)){
						redirect("home");
					}else{
						$data['thisMember'] = $deID;
					}
					
					$this->load->view("profile_view",$data);
				}
			}
		}else{
			//非本人
			$deID = $this->url_b64decode($id);
			$data = $this->viewItem("Footprint - 個人主頁");
			$data['member'] = 0 ; 
			$data['id'] = $id;
			//判斷是否有這個SMkey，若否則傳出$data['error']="資料錯誤請確認再試";
			if($this->profile_model->check_SMkey($deID)){
				redirect("home");
			}
			//$data['error'] = "沒有登入，請登入後再試";
			$this->load->view("profile_view",$data);
		}
	}


	/***
		傳入值為：$_Post['groupName','token'] 
				  groupName="團體名稱"，必須判斷為大於三，並且小於20的字傳
				  token = 判斷是否擁有權限。
		傳入驗證：資料消毒
		成功echo 1; 資料庫有相同名稱 echo 0; 數值不符合條件 echo 2
	***/
	public function addGroup(){

		if($this->getlogin() == 1 && isset($_POST["token"])){

			if($this->tokenDecrypt($_POST["token"])){
				$post = $this->xss($_POST);
				$groupName = $post["groupName"];
				$id = $this->getSMkey();
				
				if(!(mb_strlen($groupName,"utf-8") > 3 && mb_strlen($groupName,"utf-8") < 20)){
					//長度大於三 小於20的字串
					echo "2";
				}elseif(!$this->profile_model->check_groupName($groupName)){ 
					//判斷團體名稱是否相同
					echo "0";
				}else{
					//成功
					$this->profile_model->add_Group($groupName,$id); 

					echo "1";
				}
			}else{
				echo "444";
			}
		}else{
			redirect("home");
		}
	}

	/***
		回傳目前登入會員所加入的所有團體。
	***/
	public function getGroupSelect(){
		if($this->getlogin() == 1){
			
			$returnArray = array();
			$returnArray2 = array();
			$id = $this->getSMkey();
			$array = array();
			$array2 = array();

			//key+token 加密
			// $RSA_Group = $this->primaryKeyEncrypt($id);

			//解密 check key
			// $RSA_Exp = $this->primaryKeyDecrypt($RSA_Group);

			//登入判斷
			if($this->loginTest() == 1){
				// if(!$this->profile_model->isExist_group($id)){
				// $returnArray = $this->profile_model->getGroup($id);	//帶入key

				// foreach ($returnArray as $row) {
				// 	$array[] = array
				// 	(
				// 		"name" => $row["SG_name"],
				// 		"key" =>$this->primaryKeyEncrypt($row['SG_key'])
				// 	);
				// 	}
				// }

				if(!$this->profile_model->isExist_class($id)){
					$returnArray2 = $this->profile_model->getGroup_class($id);	//帶入key
					foreach ($returnArray2 as $row) {
						$array2[] = array(
							"name" => $row["SG_name"],
							"key" =>$this->primaryKeyEncrypt($row['SG_key'])
						);
					}
				}

			}else{
				//不符合 回傳444
				echo json_encode(array(444));
			}	
			// $array = array_merge($array,$array2);
			echo json_encode($array2);

			// echo json_encode($returnArray2);
		}else{
			//echo $this->getlogin();
			redirect("home");
		}
	}

	/***
		傳入值為：$_Post['account','id']
				  account="帳號"，必須判斷是否真實存在資料庫
				  id="團體key"
		傳入驗證：判斷帳號是否存在，若存在，則將這筆會員加入到團隊中。
		成功echo 1; 沒有這個帳號 echo 0; 已在團隊中 echo 2
	***/
	public function addGroupMember(){
		if($this->getlogin() == 1){
			$key = $_POST['id'];
  			$checkArray = $this->primaryKeyDecrypt($key);
			if($checkArray['check']){
				$post = $this->xss($_POST);
				$account = $post["account"];
				$group_id = $checkArray['key'];
				$id = $this->getSMkey();

				$member_id = $this->profile_model->get_memberId($account);
				$myself_account = $this->profile_model->get_myselfAccount($id);
				//登入判斷
				if($this->profile_model->check_account($account)){ 
					//判斷帳號是否存在
					echo "0";
				}elseif(!$this->profile_model->check_group($group_id,$member_id)){
					//判斷該會員是否已在團隊中
					echo "2";
				}elseif($myself_account == $account){
					echo "2";
				}else{
					//成功
					$this->profile_model->add_GroupMember($group_id,$member_id);
					echo "1";
				}
			}else{
				echo "444";
			}
		}else{
			redirect("home");
		}
	}


	/***
		傳入值為：$_Post['groupId']
				  id="團體key"
		回傳內容：回傳這個key底下的所有成員，判斷這個請求的會員是否為這個團體的管理員，若是的話則傳出管理員的資料
	***/
  	function getGroupTable(){
  		if($this->getlogin() == 1){
  			$key = $_POST['groupId'];
  			$checkArray = $this->primaryKeyDecrypt($key);
			if($checkArray['check']){
				$post = $this->xss($_POST);
	  			$member_id = $this->getSMkey();
	  			$group_id = $checkArray['key'];
	  			// print_r($post);
	  			$admin_id = $this->profile_model->getadminId($group_id);
	  			$isAdmin = !$this->profile_model->check_admin($group_id,$member_id);
	  			$memberkey = 0;
	  			$array2 = array();

	  			//是管理員的話
	  			if($isAdmin){
	  				$returnArray = $this->profile_model->getTable_admin($group_id);//不需要印按鈕id

	  				$returnArray2 = $this->profile_model->getTable($group_id,$admin_id);
	  				//需要印按鈕id
	  				foreach ($returnArray as $row) {
						$array []= array(
							"name" => $row["SM_name"],
							"email" =>$row["SM_email"],
							"button"  =>"隊長",
						);	
					}

	  				foreach ($returnArray2 as $row) {
	  					$key = $this->primaryKeyEncrypt($row["SM_key"]);
						$array2 []= array(
							"name" => $row["SM_name"],
							"email" =>$row["SM_email"],
							"button"  =>"<button type='button' class='btn btn-danger' onclick=\"delMember('".$key."')\">刪除</button>", //錯誤
						);	
					}

					$array3 [] = array(
						"add" =>'<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editGroupModal">編輯團隊</button> <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addGroupMemberModal">新增團員</button>'
					);

					$array4 = array_merge($array2,$array3);

	  				$array5 = array_merge($array,$array4);

					echo json_encode($array5);
		  		}else{
		  			$i = 1;
		  			$returnArray = $this->profile_model->getTable_noadmin($group_id,$admin_id);
		  			$returnArray2 = $this->profile_model->getTable_admin($group_id);

		  			foreach ($returnArray2 as $row) {
						$array []= array(
							"name" => $row["SM_name"],
							"email" =>$row["SM_email"],
							"button"  =>"隊長",
						);	
					}

		  			foreach ($returnArray as $row) {
						$array []= array(
							"name" => $row["SM_name"],
							"email" =>$row["SM_email"],
							"button"  =>$i,
							$i+=1
						);	
					}

					$array2 [] = array(
						"add" =>''
					);

					$array=array_merge($array,$array2);
					echo json_encode($array);
		  		}
  			}else{
  				//不符合 回傳444
				echo json_encode(array(444));
  			}	
		}else{
			redirect("home");
		}
  	}

  	/***
		傳入值為：$_Post['delId','groupId']
				  delId="欲刪除會員ID",
				  groupId = "團隊主鍵"
	***/
	public function delMemberGroup(){
		if($this->getlogin() == 1){
			//會員ID解密
			$delIdKey = $_POST['delId'];
  			$checkDelIdArray = $this->primaryKeyDecrypt($delIdKey);

  			//團隊主鍵解密
			$groupKey = $_POST['groupId'];
  			$checkGroupArray = $this->primaryKeyDecrypt($groupKey);
  			
			if($checkGroupArray['check'] && $checkDelIdArray['check']){
				$delId = $checkDelIdArray['key'];
				$groupId = $checkGroupArray["key"];
				$this->profile_model->delMember($delId,$groupId);
				echo '1';
			}else{
				echo '444';
			}
			
		}else{
			redirect("home");
		}
	}

	/***
		傳入值為：$_Post['groupId']
				  id="團體key"
		回傳內容：回傳這個key底下的所有成員、成員主鍵,以及回傳這個團體的名稱。
	***/
  	function editGroupInfo(){
  		if($this->getlogin() == 1){
  			$key = $_POST['groupId'];
  			$checkArray = $this->primaryKeyDecrypt($key);

			if($checkArray['check']){
				
				$SG_name = null;
				$SM_name = null;
				$post = $this->xss($_POST);
	  			$member_id = $this->getSMkey();
	  			$admin_id = $this->profile_model->getadminId($checkArray['key']);
	  			//假回傳資料(請參考其結構) $this->primaryKeyEncrypt

	  			//取得團體名稱
	  			$returnArray = $this->profile_model->getOneGroup($checkArray['key']);
	  			//取得隊長名稱
	  			$returnArray2 = $this->profile_model->getTable_admin($checkArray['key']);
	  			//取得隊員名稱
	  			$returnArray3 = $this->profile_model->getTable_noadmin($checkArray['key'],$admin_id);


	  			// print_r($returnArray);

	  			

	  			foreach ($returnArray as $row) {
	  					$SG_name = $row['SG_name'];  				
	  			}


	  			$array2 = array();
	  			$array['member'] = array();

	  			foreach ($returnArray2 as $row) {
	  				$arr = array
	  				(
	  					'key' => $this->primaryKeyEncrypt($row['SM_key']),
	  					"name" => $row["SM_name"],
	  				);	
	  				array_push($array['member'],$arr);
	  			}
	  			
	  			foreach ($returnArray3 as $row) {
	  				$rowArray = array
	  						(
	  						'key' => $this->primaryKeyEncrypt($row['SM_key']),
	  						"name" => $row["SM_name"],
	  						
	  						);
	  				array_push($array['member'],$rowArray);
	  			}



	  			$array['name'] = $SG_name;
	  			// $array['nametwo'] = $SM_name;

	  			

	  			echo json_encode($array);
	  			
	  			// $array = array('name' => '樹德科技大學國際同圓社',
	  			// 				'member' => array(
	  			// 					array('key'  =>'1651dsfsdfs6df156w1ef=',
	  			// 						  'name' =>'吳孟賢'),
	  			// 					array('key'  =>'4545sdfsd=3woprk0o45d4',
	  			// 						  'name' =>'吳延陵'),
	  			// 					array('key'  =>'sdfsd451s56f156sd1f56=+',
	  			// 						  'name' =>'林淑偵')));
	  			// $array3 = array_merge($array,$array2);
	  			
  			}else{
  				//不符合 回傳444
				echo json_encode(array(444));
  			}	
		}else{
			redirect("home");
		}
  	}

  	/***
		傳入值為：$_Post['groupId','memberId','groupName']
				  groupId="團體key",
				  memberId="團體新隊長MEMBER ID",
				  groupName="團體名稱"，必須判斷為大於三，並且小於20的字傳
		回傳內容：成功echo 1; 資料庫有相同名稱 echo 0; 數值不符合條件 echo 2 ;無權限444
	***/
  	function editGroup(){
  		if($this->getlogin() == 1){
  			$groupKey = $_POST['groupId'];
  			$memberKey = $_POST['memberId'];
  			$groupCheckArray = $this->primaryKeyDecrypt($groupKey);
  			$memberCheckArray = $this->primaryKeyDecrypt($memberKey);
			if($groupCheckArray['check'] && $memberCheckArray['check']){
				$post = $this->xss($_POST);
				//獲取當前group名稱
				$pregroupName = $this->profile_model->getgroupName($groupCheckArray['key']);
				$groupName = $post["groupName"];
				$group_id = $groupCheckArray['key'];
				$member_id = $memberCheckArray['key'];

				$id = $this->getSMkey();
				if(!(mb_strlen($groupName,"utf-8") > 3 && mb_strlen($groupName,"utf-8") < 20)){
					//長度大於三 小於20的字串
					echo "2";
				}else if($pregroupName == $groupName){
					//判斷輸入的團體名稱是否和當前的團體名稱相同
					// $this->profile_model->update_class($group_id,$member_id,$id);
					$this->profile_model->update_group($group_id,$member_id,$groupName);
					echo "1";
				}
				elseif(!$this->profile_model->check_groupName($groupName)){ 
					//判斷團體名稱是否相同
					echo "0";
				}else{
					// $this->profile_model->update_class($group_id,$member_id,$id);
					$this->profile_model->update_group($group_id,$member_id,$groupName);
					echo "1";
				}

			}else{
				echo "444";
			}
		}else{
			redirect("home");
		}
  	}

  	/***
		傳入值為：$_Post['memberId']
				  
				 memberId="會員MEMBER ID",
				  
		回傳內容：回傳該會員所參與的團體、服務，以及該會員的個人資訊
	***/
  	function getMemberInformation(){
  		//$member_id = $_POST['memberId']
  		$post = $this->xss($_POST);
  		$member_id = $this->url_b64decode($post['memberId']);
  		$member_id = $this->security->xss_clean($member_id);
  		//參與的團體
  		// $returnArray = $this->profile_model->getMemberGroup($member_id);
  		if($this->profile_model->check_SMkey(utf8_decode($member_id))){
			redirect("home");
		}
  		$returnArray2 = $this->profile_model->getMemberGroupClass($member_id);

  		$array['group'] = array();
  		foreach ($returnArray2 as $row) {
  			array_push($array['group'], $row["SG_name"]);
  		}


  		//參與的服務
  		$returnArray3 = $this->profile_model->getService($member_id);
  		$array['service'] = array();
  		foreach ($returnArray3 as $row) {
  			array_push($array['service'], $row["SF_name"]);
  		}

  		//個人資訊
  		$returnArray4 = $this->profile_model->getMemberProfile($member_id);
  		foreach ($returnArray4 as $row) {
  			$array['profile'] = array
  			(
  				"job" => $row["SM_job"],
  				"school" => $row["SM_school"],
  				"web" => $row["SM_web"],
  				"name" => $row["SM_name"]
  			);
  		}
  		$footprint_count = $this->profile_model->getFootprint_Count($member_id);
  		$comment_count = $this->profile_model->getComment_Count($member_id);
  		//計數資訊

  		$array['count'] = array
			(
				"footprint" => $footprint_count,
				"comment" => $comment_count,
			);

  		// print_r($returnArray3);



  		// $returnArray = array(
  		// 	"group" => ["groupName" => "樹德科技大學國際同圓社"],

  		// 	"service" => ["serviceName" => "說話的藝術-冬令營"],

  		// 	"profile" => ["job" =>  "學生",
  		// 				  "school" => "樹德科技大學",
  		// 				  "web" => "https://hello.world.com"]
  		// );

  		echo json_encode($array);

  	}

  	/***
		傳入值為：$_POST['imgInput','token']
				 imgInput="BASE64的圖片格式"
				 token = "本次登入階段之權限，使用$this->tokenDecrypt() 進行判斷"
		回傳內容：成功echo 1; 無法寫入、格式錯誤 echo 0;無權限444
		本次傳入值不須XSS解析，皆為加密字串
	***/
	function upLoadImg(){
  		if($this->getlogin() == 1){
  			$token = $_POST['token'];
  			if($this->tokenDecrypt($token)){
  				define('UPLOAD_PATH', FCPATH.'dist'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'user'.DIRECTORY_SEPARATOR);
  				
  				$img = $_POST['imgInput'];
  				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
  				$SM_key = $this->getSMkey();

  				$data = base64_decode($img);
  				$fileName = uniqid() . '.jpg';
  				$file = UPLOAD_PATH . $fileName;

  				//寫入磁碟
  				$success = file_put_contents($file, $data);

  				if($success){
  					$this->profile_model->updateImage($SM_key,$fileName);
  					echo "1";
  				}else{
  					echo "0";
  				}
  			}else{
  				echo "444";
  			}
		}else{
			redirect("home");
		}
  	}

	/***
		傳入值為：$_Post['memberId']
		回傳內容：json['pictureName'] = "XXXXXXXX.png"
		若資料庫沒有該筆會員之大頭貼，則輸出no-user.png
		此為公開資料，不須判斷任何權限、加密。
	***/
  	function getMemberImg(){
  		$post = $this->xss($_POST);
  		$member_id = $this->url_b64decode($post['memberId']);
  		$member_id = $this->security->xss_clean($member_id);
  		$img = "no-user.png";
  		// echo json_encode(array('pictureName'=>'no-user.png'));
  		// echo $member_id;
  		if($this->profile_model->check_SMkey(utf8_decode($member_id))){
			redirect("home");
		}

  		// if($this->profile_model->img_exist()){

  		// }

  		$returnArray = $this->profile_model->getImg($member_id);	


  		$array['pictureName'] = array();
  		foreach ($returnArray as $row ) {
  			if($row["SM_photo"] != null){
  			array_push($array['pictureName'], $row["SM_photo"]);
  			}else{
  				array_push($array['pictureName'], $img);
  			}
  		}

  		echo  json_encode($array);

  	}

  	/***
		傳入值為：$_Post['id','content','token']
				  id="帳號"，必須判斷是否真的有這個帳號
				  content="留言內容"
				  token="本次連線驗證用"
		傳入驗證：判斷帳號是否存在，若存在，則將留言寫入資料庫。
		成功echo 1; 欄位不可為空 echo 0; 無權限 echo 444
	***/
	public function addMessage(){
		if($this->getlogin() == 1){
			
			if($this->tokenDecrypt($_POST['token'])){
				$post = $this->xss($_POST);
				$content = $post["content"];
				$member_id = $this->url_b64decode($_POST['id']);
				$str = trim($content);
				$SM_key = $this->getSMkey();

				if (!empty($_SERVER["HTTP_CLIENT_IP"])){
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}else{
					$ip = $_SERVER["REMOTE_ADDR"];
				}

				if($str == ""){
					echo "0";
				}else if(!$this->profile_model->check_member($member_id)){
					$this->profile_model->add_Message($member_id,$SM_key,$ip,$content);
					echo "1";
				}

				
			}else{
				echo "444";
			}
		}else{
			redirect("home");
		}
	}



  				// $returnArray=array(
				// 	array(
				// 		"photo"    => "no-user.png",   //回覆者頭貼
				// 		"url"     => base_url("profile/member/").$this->url_b64encode(32/*32是SMKEY*/),//回覆者主頁網址
				// 		"name"    =>"吳孟賢",//回覆者名
				// 		"date"    =>"2017/07/15 19:00:00",//留言時間
				// 		"content" => " 很棒很棒好想參加ㄛ",//活動主旨
				// 		"button" => '<button type="button" class="comment-row-item-action edit" onclick="commentEdit(\''.$scKey.'\')"><i class="font-icon font-icon-pencil"></i></button><button type="button" class="comment-row-item-action del" onclick="commentDel(\''.$scKey.'\')"><i class="font-icon font-icon-trash"></i></button>'//當帳號為留言者本人時的按鈕，如果這個留言非本人留下，直接為空
				// 	),
				// 	array(
				// 		"photo"    => "no-user.png",   //回覆者頭貼
				// 		"url"     =>base_url("profile/member/")."MzI",//回覆者主頁網址
				// 		"name"    =>"小花",//回覆者名
				// 		"date"    =>"2017/07/15 19:00:00",//留言時間
				// 		"content" => "好棒好棒<br>好棒喔喔喔喔喔喔喔",//活動主旨
				// 		"button" => ''//當帳號為留言者本人時的按鈕，如果這個留言分本人留下，直接為空
				// 	)
				// );

  	/***
		傳入值為：$_Post['id']
				  id="帳號"，必須判斷是否真的有這個帳號
		回傳內容：不必判斷權限，回傳這個key底下的所有訪客留言，不用處理BR(只有單行)
		回傳限制：若留言比數大於十筆，則傳出十筆，時間排序由新到舊
	***/
  	function getMessage(){
  		if($this->getlogin() == 1){
  			$member_id = $this->url_b64decode($_POST['id']);
  			// $PC_key = "dfaopfmopwamopfkmpowskfop_SD";//假裝有一個加密ㄉ訪客留言主鍵
  				// echo $member_id;
  			$SM_key = $this->getSMkey();
  			if($this->profile_model->check_SMkey(utf8_decode($member_id))){
				redirect("home");
			}
  			
  			$array['message'] = array();
  			
  				// print_r($returnArray);
  			if(!$this->profile_model->check_member($member_id)){
  				$returnArray = $this->profile_model->get_message($member_id);	
  					foreach ($returnArray as $row) {
  						if($member_id != $this->getSMkey()){
	  						if($row['do_SM_key']==$SM_key){
									$a= '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$this->primaryKeyEncrypt($row['PC_key']).'\')"><i class="font-icon font-icon-trash"></i></button>';
							}else{
								$a='';
							}
						}else{
							$a= '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$this->primaryKeyEncrypt($row['PC_key']).'\')"><i class="font-icon font-icon-trash"></i></button>';
						}

				  			if($row['SM_photo'] == null){
				  				$img = "no-user.png";
				  			}else{
				  				$img = $row['SM_photo'];
				  			}

			  			$arr = array(
					  		"photo" => $img,
							"url" => base_url('profile/member/').$this->url_b64encode($row['do_SM_key']),
							"name" => $row['SM_name'],
							"date" => $row['PC_time'],
							"content" => $row['PC_content'],
							"button" => $a
		  					);
			  		array_push($array['message'], $arr);
  				}
  			}	
 		 	
  			
 		 	


  	// 		$returnArray['message']=array(
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     => base_url("profile/member/").$this->url_b64encode(32/*32是SMKEY*/),//留言者主頁網址
			// 		"name"    =>"吳孟賢",//留言者名子
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => " 很棒很棒好想參加ㄛ",//內容
			// 		"button" => '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$PC_key.'\')"><i class="font-icon font-icon-trash"></i></button>'//如果目前的登入帳號為留言者本人或個人主頁本人，則印出按鈕
			// 	),
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     =>base_url("profile/member/")."MzI",//回覆者主頁網址
			// 		"name"    =>"小花",//回覆者名
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => "好棒好棒好棒喔喔喔喔喔喔喔",//活動主旨
			// 		"button" => ''//當帳號為留言者本人時的按鈕，如果這個留言分本人留下，直接為空
			// 	)
			// );
			$array['count'] = $this->profile_model->message_count($member_id);//總共筆數，不需要做加減
			echo json_encode($array);

		}else{
			$member_id = $this->url_b64decode($_POST['id']);
			$array['message'] = array();
  			
  				// print_r($returnArray);
  			if(!$this->profile_model->check_member($member_id)){	
  				$returnArray = $this->profile_model->get_message($member_id);	
		  			foreach ($returnArray as $row) {
			  			$arr = array(
		 					"photo" => $row['SM_photo'],
							"url" => base_url('profile/member/').$this->url_b64encode($row['do_SM_key']),
							"name" => $row['SM_name'],
							"date" => $row['PC_time'],
							"content" => $row['PC_content'],
							"button" => ''
		  					);
		  				array_push($array['message'], $arr);
  					}
  			}
			$array['count'] = $this->profile_model->message_count($member_id);//總共筆數，不需要做加減
			echo json_encode($array);
			
		}
  	}

  	/***
		傳入值為：$_Post['id','startNum']
				  id="帳號"，必須判斷是否真的有這個帳號
				  startNum="開始筆數"
		回傳內容：不必判斷權限，回傳這個key底下的所有訪客留言，不用處理BR(只有單行)
		回傳限制：若留言比數大於十筆，則傳出十筆，時間排序由新到舊
	***/
  	function appendMessage(){
  		if($this->getlogin() == 1){

  			$member_id = $this->url_b64decode($_POST['id']);
  			$startNum = $_POST['startNum'];
  			// $PC_key = "dfaopfmopwamopfkmpowskfop_SD";//假裝有一個加密ㄉ訪客留言主鍵
  			$SM_key = $this->getSMkey();
  			$array['message'] = array();

  			$returnArray = $this->profile_model->get_message_append($member_id,$startNum);
  			if(!$this->profile_model->check_member($member_id)){
  				foreach ($returnArray as $row) {
  					if($member_id != $this->getSMkey()){
	  					if($row['do_SM_key']==$SM_key){
								$a= '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$this->primaryKeyEncrypt($row['PC_key']).'\')"><i class="font-icon font-icon-trash"></i></button>';
							}else{
								$a='';
							}
						}else{
							$a= '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$this->primaryKeyEncrypt($row['PC_key']).'\')"><i class="font-icon font-icon-trash"></i></button>';
						}
				  			if($row['SM_photo'] == null){
				  				$img = "no-user.png";
				  			}else{
				  				$img = $row['SM_photo'];
				  			}

			  			$arr = array(
					  		"photo" => $img,
							"url" => base_url('profile/member/').$this->url_b64encode($row['do_SM_key']),
							"name" => $row['SM_name'],
							"date" => $row['PC_time'],
							"content" => $row['PC_content'],
							"button" => $a
		  					);
			  		array_push($array['message'], $arr);
  				}
  			}	
  	// 		$returnArray['message']=array(
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     => base_url("profile/member/").$this->url_b64encode(32/*32是SMKEY*/),//留言者主頁網址
			// 		"name"    =>"吳孟賢",//留言者名子
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => " 很棒很棒好想參加ㄛ",//內容
			// 		"button" => '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$PC_key.'\')"><i class="font-icon font-icon-trash"></i></button>'//如果目前的登入帳號為留言者本人或個人主頁本人，則印出按鈕
			// 	),
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     =>base_url("profile/member/")."MzI",//回覆者主頁網址
			// 		"name"    =>"小花",//回覆者名
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => "好棒好棒好棒喔喔喔喔喔喔喔",//活動主旨
			// 		"button" => ''//當帳號為留言者本人時的按鈕，如果這個留言分本人留下，直接為空
			// 	)
			// );
  				// echo $startNum;
			$array['count'] = $this->profile_model->append_count($member_id,$startNum);//本次總共筆數，不需要做加減
			// echo $array['count'];
			echo json_encode($array);

		}else{
			$member_id = $this->url_b64decode($_POST['id']);
			$startNum = $_POST['startNum'];
  			// $PC_key = "dfaopfmopwamopfkmpowskfop_SD";//假裝有一個加密ㄉ訪客留言主鍵
  			$SM_key = $this->getSMkey();
  			$array['message'] = array();

  			$returnArray = $this->profile_model->get_message_append($member_id,$startNum);
  			if(!$this->profile_model->check_member($member_id)){
  				foreach ($returnArray as $row) {
  					if($member_id != $this->getSMkey()){
	  					if($row['do_SM_key']==$SM_key){
							$a= '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$this->primaryKeyEncrypt($row['PC_key']).'\')"><i class="font-icon font-icon-trash"></i></button>';
							}else{
								$a='';
							}
						}else{
							$a= '<button type="button" class="comment-row-item-action del" onclick="messageDel(\''.$this->primaryKeyEncrypt($row['PC_key']).'\')"><i class="font-icon font-icon-trash"></i></button>';
						}

				  			if($row['SM_photo'] == null){
				  				$img = "no-user.png";
				  			}else{
				  				$img = $row['SM_photo'];
				  			}

			  			$arr = array(
					  		"photo" => $img,
							"url" => base_url('profile/member/').$this->url_b64encode($row['do_SM_key']),
							"name" => $row['SM_name'],
							"date" => $row['PC_time'],
							"content" => $row['PC_content'],
							"button" => $a
		  					);
			  		array_push($array['message'], $arr);
  				}
  			}	
			// $returnArray['message']=array(
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     => base_url("profile/member/").$this->url_b64encode(32/*32是SMKEY*/),//留言者主頁網址
			// 		"name"    =>"吳孟賢",//留言者名子
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => " 很棒很棒好想參加ㄛ",//內容
			// 		"button" => ''//直接為空
			// 	),
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     =>base_url("profile/member/")."MzI",//回覆者主頁網址
			// 		"name"    =>"小花",//回覆者名
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => "好棒好棒<br>好棒喔喔喔喔喔喔喔",//活動主旨
			// 		"button" => ''//直接為空
			// 	)
			// );
			$array['count'] = $this->profile_model->append_count($member_id,$startNum);//本次總共筆數，不需要做加減
			echo json_encode($array);
		}
  	}

  	/***
	傳入值為：$_Post['key'] 
			  key="留言主鍵"，要做判斷
	傳入驗證：刪除(假刪除)
	成功echo 1; 其他錯誤(如果有) echo 0; key解密失敗 echo 444;
	***/
	public function delMessage(){
		if($this->getlogin() == 1){
			$PC_key = $_POST['key'];
			// print_r($PC_key);
			$pckey = $this->primaryKeyDecrypt($PC_key);
			// echo $pckey['key'];	
			if($pckey['check']){
				$this->profile_model->del_message($pckey['key']);
				echo "1";
			}else{
				echo "444";
			}
		}else{
			redirect("home");
		}
	}


	/***
		傳入值為：$_Post['token']
				  token="本次連線驗證用"
		回傳內容: 回傳目前登入帳號之個人資料
	***/
	public function getSettingInfo(){
		if($this->getlogin() == 1){
			if($this->tokenDecrypt($_POST['token'])){
				$SM_key = $this->getSMkey();
				$array = $this->profile_model->get_SettingInfo($SM_key);


	  			$array = array('name' => $array[0]['SM_name'],
	  						   'job' => $array[0]['SM_job'],
	  						   'school' => $array[0]['SM_school'],
	  						   'page' => $array[0]['SM_web'],);

	  			echo json_encode($array);

			}else{
				echo json_encode(array(444));
			}
		}else{
			redirect("home");
		}
	}

	/***
		傳入值為：$_Post['name','job','school','page','token']
				  name="姓名"，暱稱必須介於2到10個字符之間。不允許特殊字符。/^[\w\s\u4e00-\u9fa5]{2,10}$/
				  job=職業，不可為空值
				  school="學校或單位"，不可為空值
				  page="個人主頁"，必須判斷是否為網址 /(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])?/
				  token="本次連線驗證用"
		傳入驗證：判斷輸入數值是否正確。
		成功echo 1; 任何一個數值不正確 echo 0; 無權限 echo 444
	***/
	public function editMemberInfo(){
		if($this->getlogin() == 1){
			
			if($this->tokenDecrypt($_POST['token'])){
				$post = $this->xss($_POST);
				$SM_key = $this->getSMkey();
				$name = $post['name'];
				$job = $post['job'];
				$str_job = trim($job);
				$school = $post['school'];
				$str_school = trim($school);
				$page = $post['page'];
				if(!preg_match("/^[\w\x{4e00}-\x{9fa5}]+$/u",$name)){
					echo "0";
				}else if($job == ""){
					echo "0";
				}else if($school == ""){
					echo "0";
				}else if(!preg_match("/\b(?:(?:https?|http|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $page)){
					echo "0";
				}else{
					$this->profile_model->update_info($SM_key,$name,$job,$school,$page);
					echo "1";
				}

			}else{
				echo "444";
			}
		}else{
			redirect("home");
		}
	}


}
