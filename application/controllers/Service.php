<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Service extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("service_model","",TRUE);
	}

	public function index() {
		redirect("home");
	} 

	/***
		回傳目前登入會員「為管理員」的團體
		***/
		public function getGroupSelect(){
			if($this->getlogin() == 1){
				if($this->loginTest()==1){
					$id = $this->getSMkey();
					$array = array();
					$returnArray = $this->service_model->admin_group($id);
				//最多5筆
					foreach ($returnArray as $row) {
						$array2 = array(
							"name" => $row["SG_name"],
							"key"   => $this->primaryKeyEncrypt($row['SG_key'])
						);
						array_push($array,$array2);
					}
					echo json_encode($array);
				}
			}
		}

	/***
		傳入值為：$_Post['name','starDate','overDate','content','group','school','schoolNumber'] 
				  name="服務名稱"，必須判斷為大於3，並且小於20的字串
				  starDate="開始時間"
				  overDate="結束時間"
				  content="簡述服務內容放置在資料庫中subject欄位"
				  groupId="團隊key"
				  school="小學或中學"
				  schoolNumber="學號key"
		傳入驗證：資料消毒
		成功echo 1; 資料庫有相同名稱 echo 0; 數值不符合條件 echo 2 ; ID解密失敗 echo 444;
		***/
		public function addService(){
			if($this->getlogin() == 1){
				$groupKey = $_POST['groupId'];

				$groupCheckArray = $this->primaryKeyDecrypt($groupKey);
				if (!empty($_SERVER["HTTP_CLIENT_IP"])){
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}else{
					$ip = $_SERVER["REMOTE_ADDR"];
				}


				if($groupCheckArray['check']){
					$post = $this->xss($_POST);
					$schoolNumber = $post['schoolNumber'];
					$school = $post['school'];
					$name = $post['name'];
					$starDate = $post['starDate'];
					$overDate = $post['overDate'];
					$content = $post['content'];


					if(!$this->service_model->service_exist($name)){
					//檢查名稱是否重複
						echo "0";
					}elseif(!(mb_strlen($name,"utf-8") > 3 && mb_strlen($name,"utf-8") < 20)){
					//長度大於三 小於20的字串
						echo "2";	
					}
					elseif(strtotime($starDate) > strtotime($overDate)){
					//開始時間不能大於結束時間
						echo "2";
					}else{
					//成功
						$this->service_model->addfootprint($groupCheckArray['key'],$name,$starDate,$overDate,$content,$schoolNumber,$ip);
						echo "1";
					}

				}else{
					echo "444";
				}

			// print_r($post);

			// echo 1;

			}else{
				echo 2;
			//redirect("home");
			}
		}

	/***
		傳入值為：$_Post['schoolNumber'] 
				  schoolNumber="學校key"
		1.無登入狀態 不加密，公開key資訊
		2.有登入狀態 加密key
		***/
		public function getService(){
		// $key = "sdfiow3jrk12391209kopsdkf";
			$schoolNumber = $_POST['schoolNumber'];
			$returnArray = $this->service_model->getService_Information($schoolNumber);
			if($this->getlogin()==1){
				$array = array();
				foreach ($returnArray as $row) {
					if($row['type'] == 0){
						if($row["SF_type"] == 1){
							$arr = array(
								"type" => "已完成",
								"group" => $row["SG_name"],
								"name" => $row["SF_name"],
								"startDate" => $row['SF_startdate'],
								"endDate" => $row['SF_enddate'],
								"key" => $this->primaryKeyEncrypt($row["SF_key"])
							);
						}else{
							$arr = array(
								"type" => "待辦理",
								"group" => $row["SG_name"],
								"name" => $row["SF_name"],
								"startDate" => $row['SF_startdate'],
								"endDate" => $row['SF_enddate'],
								"key" => $this->primaryKeyEncrypt($row["SF_key"])
							);
						}
						array_push($array, $arr);
					}
				}
				echo json_encode($array);
			}else{

				$array = array();

				foreach ($returnArray as $row) {
					if($row['type'] == 0){
						if($row["SF_type"] == 1){
							$arr = array(
								"type" => "已完成",
								"group" => $row["SG_name"],
								"name" => $row["SF_name"],
								"startDate" => $row['SF_startdate'],
								"endDate" => $row['SF_enddate'],
								"key" => $row["SF_key"]
							);

						}else{
							$arr = array(
								"type" => "待辦理",
								"group" => $row["SG_name"],
								"name" => $row["SF_name"],
								"startDate" => $row['SF_startdate'],
								"endDate" => $row['SF_enddate'],
								"key" => $row["SF_key"]
							);
						}
						array_push($array, $arr);
					}
				}
				echo json_encode($array);
			}
		}

	/***
		傳入值為：$_Post['footprintKey'] 
				  footprintKey="活動ID" 有登入狀態會加密 無登入狀態不加密
		1.無登入狀態 不加密，公開key資訊
		2.有登入狀態 加密key
		3.主旨輸出必須要能將textarea換行符號換成<br>
		***/
		public function getOneService(){
		// $sfkey = "dsfokljmroegmo12";
		//未完成
			if($this->getlogin()==1){
				$sfkey=$_POST['footprintKey'];
				$footprintKey = $this->primaryKeyDecrypt($sfkey);
				$returnarray=$this->service_model->get_OneService($footprintKey['key']);
				foreach ($returnarray as $row) {
					if($row['SM_photo'] == null){
				  			$img = "no-user.png";
				  		}else{
				  			$img = $row['SM_photo'];
				  		}
					if($row['SF_type'] == 0){
						$returnArray=array(
							"photo" =>$img,
							"name" =>$row['SG_name']." - ".$row['SM_name'],
							"date" =>$row['SF_startdate']." ~ ".$row['SF_enddate'],
							"subject" =>nl2br($row['SF_subject'])/*str_replace(" ", "<br>", $row['SF_subject'])*/,
							"button" => '<button type="button" class="btn btn-outline-primary btn-sm " style="color: #28a745;background-color: transparent;background-image: none;border-color: #28a745;" data-toggle="modal" data-target="#overServiceModal" onclick="thisActivityOver(\''.$sfkey.'\')">活動結案</button> <button type="button" class="btn btn-outline-primary btn-sm " style="color: #FF8888;background-color: transparent;background-image: none;border-color: #FF8888;" data-toggle="modal" data-target="#editServiceModal" onclick="thisActivityEdit(\''.$sfkey.'\')">活動編輯</button>'//當帳號為隊長時按鈕
					);
					}elseif($row['SF_type'] == 1){
						$returncontent=$this->service_model->get_content($footprintKey['key']);
						$returnreason=$this->service_model->get_reason($footprintKey['key']);
						$arr = array("schoolCooperate","studentCooperate","traffic","around");
						$reasonarray=array();
						$i=0;
						foreach ($returnreason as $reason) {
							$reasonarray[$arr[$i]] = array($reason['SS_value'],$reason['SS_reason']);
							$i++;
						}

						$returnArray=array(
							"photo" =>$img,
							"name" =>$row['SG_name']." - ".$row['SM_name'],
							"date" =>$row['SF_startdate']." ~ ".$row['SF_enddate'],
							"subject" =>nl2br($row['SF_subject'])/*str_replace(" ", "<br>", $row['SF_subject'])*/,
							"content" =>nl2br($returncontent)/*str_replace(" ", "<br>", $returncontent)*/,
							"button" => '',
							"reason" => $reasonarray
						);
					}	
				}
			// $returnArray=array(
			// 	"photo"    => "no-user.png",   //發文者頭貼
			// 	"name"    =>"樹德科技大學國際同圓社 - 吳孟賢",//團體名稱 - 發文者名
			// 	"date"    =>"2017/07/03 ~ 2017/07/08",//活動時間
			// 	"subject" => "服務服務服務服務",//活動主旨
			// 	"button" => '<button type="button" class="btn btn-outline-primary btn-sm " style="color: #28a745;background-color: transparent;background-image: none;border-color: #28a745;" data-toggle="modal" data-target="#overServiceModal" onclick="thisActivityOver(\''.$sfkey.'\')">活動結案</button> <button type="button" class="btn btn-outline-primary btn-sm " style="color: #FF8888;background-color: transparent;background-image: none;border-color: #FF8888;" data-toggle="modal" data-target="#editServiceModal" onclick="thisActivityEdit(\''.$sfkey.'\')">活動編輯</button>'//當帳號為隊長時按鈕
			// );

			//已完成表示方式
			// $returnArray=array(
			// 	"photo"    => "no-user.png",   //發文者頭貼
			// 	"name"    =>"樹德科技大學國際同圓社",//發文者名
			// 	"date"    =>"2017/07/03 ~ 2017/07/08",//活動時間
			// 	"subject" => "sdfioj2i3w5jt9i0o23jriomiosjior23jroiwjmgi",//活動主旨
			// 	"content" => "活動內容活動內容活動內容活動內容活動內容<br>活動內容活動內容活動內容活動內容活動內容" ,//活動內容
			// 	"button" => ''//當帳號為隊長時按鈕
			// );
			}else{
				$returnarray=$this->service_model->get_OneService($_POST['footprintKey']);
				foreach ($returnarray as $row) {
					if($row['SF_type'] == 0){
						$returnArray=array(
						"photo"    => $row['SM_photo'],   //發文者頭貼
						"name"    =>$row['SG_name']." - ".$row['SM_name'],//團體名稱 - 發文者名
						"date"    =>$row['SF_startdate']." ~ ".$row['SF_enddate'],//活動時間
						"subject" => nl2br($row['SF_subject'])/*str_replace(" ", "<br>", $row['SF_subject'])*/,//活動主旨
						"button" => ''//當帳號為隊長時按鈕
					);
					}elseif($row['SF_type'] == 1){
						$returncontent=$this->service_model->get_content($_POST['footprintKey']);
						$returnreason=$this->service_model->get_reason($_POST['footprintKey']);
						$arr = array("schoolCooperate","studentCooperate","traffic","around");
						$reasonarray=array();
						$i=0;
						foreach ($returnreason as $reason) {
							$reasonarray[$arr[$i]] = array($reason['SS_value'],$reason['SS_reason']);
							$i++;
						}

						$returnArray=array(
						"photo"    => $row['SM_photo'],   //發文者頭貼
						"name"    =>$row['SG_name']." - ".$row['SM_name'],//團體名稱 - 發文者名
						"date"    =>$row['SF_startdate']." ~ ".$row['SF_enddate'],//活動時間
						"subject" => nl2br($row['SF_subject'])/*str_replace(" ", "<br>", $row['SF_subject'])*/,//活動主旨
						"content" => nl2br($returncontent)/*str_replace(" ", "<br>", $returncontent)*/,
						"button" => '',//當帳號為隊長時按鈕
						"reason" => $reasonarray
					);
					}
				}
			}

			echo json_encode($returnArray);
		}

	/***
		傳入值為：$_Post['schoolCooperate','studentCooperate','traffic','around','reason','content','key'] 
				  schoolCooperate="學校配合度"，必大於零，為浮點數(有小數點)
				  studentCooperate="學生配合度"，必大於零，為浮點數(有小數點)
				  traffic="交通方便性"，必大於零，為浮點數(有小數點)
				  around="周邊機能性"，必大於零，為浮點數(有小數點)
				  reason[]="為一陣列，長度4，依序為學校配合度、學生配合度、交通、周邊的給分原因"
				  content="評論內容"，必須做資料消毒
				  key="服務key(service_footprint : SF_key)"
		傳入驗證：資料消毒
		成功echo 1; 資料格式有誤 echo 0; key解密失敗 echo 444;
		***/
		public function overOneService(){
			if($this->getlogin() == 1){
				$post= $this->xss($_POST);
				$SF_key = $post['sfkey'];
				$sfkey = $this->primaryKeyDecrypt($SF_key);
				$content = $post['content'];
				$reason = $post['reason'];
				$schoolCooperate = $post['schoolCooperate'];
				$studentCooperate = $post['studentCooperate'];
				$traffic = $post['traffic'];
				$around = $post['around'];
				$volunteer = $post['volunteer'];
				$student = $post['student'];
				// print_r($_POST);
				if (!empty($_SERVER["HTTP_CLIENT_IP"])){
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}else{
					$ip = $_SERVER["REMOTE_ADDR"];
				}

				if($sfkey['check']){
					if(!($schoolCooperate>0 && $studentCooperate>0 && $traffic>0 && $around>0)){
						echo "0";
					}else if($volunteer > 0 && $student > 0 && is_numeric($volunteer) && is_numeric($student)){
						$this->service_model->addOneService($sfkey['key'],$content,$reason,$schoolCooperate,$studentCooperate,$traffic,$around,$ip,$volunteer,$student);
						echo "1";
					}else{
						echo "0";
					}
			//$groupCheckArray = $this->primaryKeyDecrypt($groupKey);
				}else{
					echo "444";
				}
			}else{
				redirect("home");
			}
		}

	/***
		傳入值為：$_POST['SFKey'] 
				  SFKey="活動ID"為加密KEY
		回傳一筆活動基本資訊。
		***/
		public function getOneEditInfo(){
			$key = $_POST['SFKey'];
			if($this->getlogin()==1){
				$checkArray = $this->primaryKeyDecrypt($key);
				if($checkArray['check']){
					$post = $this->xss($_POST);
					$SFKey = $checkArray['key'];

					$returnArray = $this->service_model->getOneEdit($SFKey);

					foreach ($returnArray as $row) {
						$returnArray=array(
							"name" => $row['SF_name'],
							"starDate" => $row['SF_startdate'],
							"endDate" => $row['SF_enddate'],
							"subject" => $row['SF_subject']
						);
					}

	  	// 		$returnArray=array(
				// 	"name"    => "飢餓三十",   //服務名稱
				// 	"starDate"    =>"2017/07/03",//開始時間
				// 	"endDate"    =>"2017/07/08",//結束時間
				// 	"subject" => "sdfioj2i3w5jt9i0o23jriomiosjior23jroiwjmgi"//活動主旨
				// );

					echo json_encode($returnArray);

				}else{
  				//不符合 回傳444
					echo json_encode(array(444));
				}	

			}else{
				redirect("home");
			}
		} 

	/***
		傳入值為：$_Post['name','starDate','overDate','content','sfKey'] 
				  name="服務名稱"，必須判斷為大於3，並且小於20的字串
				  starDate="開始時間"
				  overDate="結束時間"
				  content="簡述服務內容放置在資料庫中subject欄位"
				  sfKey="活動key"
		傳入驗證：資料消毒
		成功echo 1; 資料庫有相同名稱 echo 0; 數值不符合條件 echo 2 ; ID解密失敗 echo 444;
		***/
		public function editService(){
			if($this->getlogin() == 1){
				$Key = $_POST['sfKey'];

				$checkArray = $this->primaryKeyDecrypt($Key);

				if($checkArray['check']){
					$post = $this->xss($_POST);
					$name = $post['name'];
					$starDate = $post['starDate'];
					$overDate = $post['overDate'];
					$content = $post['content'];
					$sfKey = $checkArray['key'];
					$ServiceName = $this->service_model->getServiceName($sfKey);
					if($ServiceName == $name){
						$this->service_model->edit_Service($sfKey,$name,$starDate,$overDate,$content);
						echo "1";
					}elseif(!$this->service_model->service_exist($name)){
					//檢查名稱是否重複
						echo "0";
					}elseif(!(mb_strlen($name,"utf-8") > 3 && mb_strlen($name,"utf-8") < 20)){
					//長度大於三 小於20的字串
						echo "2";	
					}elseif(strtotime($starDate) > strtotime($overDate)){
					//開始時間不能大於結束時間
						echo "2";
					}else{
						$this->service_model->edit_Service($sfKey,$name,$starDate,$overDate,$content);
						echo "1";				
					}
				}else{
					echo "444";
				}

			// print_r($post);

			// echo 1;
			}else{
				echo 2;
			//redirect("home");
			}
		}

	/***
		傳入值為：$_Post['sfKey'] 
				  sfKey="活動key，有加密"
		刪除成功echo 1; ID解密失敗 echo 444;
		***/
		public function delOneService(){
			if($this->getlogin() == 1){
				$Key = $_POST['SFKey'];
				$checkArray = $this->primaryKeyDecrypt($Key);
				if($checkArray['check']){
					$sfkey = $checkArray['key'];
					$this->service_model->del_Service($sfkey);
					echo "1";
				}else{
					echo "444";
				}
			}else{
				redirect("home");
			}
		}

	/***
		傳入值為：$_Post['footprintKey','viewControll'] 
				  footprintKey="活動key，有加密"
				  viewControll="留言組前端專屬控制碼，消毒後串接"
		驗證：若為登入狀態，則key有加密，若為登出狀態則key不加密
		輸出：依照程式內格式，按鈕的部分取決於是否是留言者。
		***/
		public function getAllComment(){
			if($this->getlogin()==1){
				$key=$_POST['footprintKey'];
				$footprintKey = $this->primaryKeyDecrypt($key);
				if($footprintKey['check']){
					$sfkey = $footprintKey['key'];
				$scKey = "lsdgkopewkpaomgpomasfop/+dsfsfds";//假裝有一個加密ㄉcommend key
				$SM_key = $this->getSMkey();
				$returnArray = $this->service_model->get_AllComment($sfkey);
				// print_r($returnArray);
				$array = array();
				// $deID = $this->url_b64decode($SM_key);
				$view = $this->security->xss_clean($_POST['viewControll']);

				foreach ($returnArray as $row) {
					if($row['type'] == 0){
						if($SM_key == $row['SM_key']){
							if($row["SM_photo"] != null){
								$returnArray = 
								array(
									"photo" => $row['SM_photo'],
									"url" => base_url('profile/member/').$this->url_b64encode($SM_key),
									"name" => $row['SM_name'],
									"date" => $row['SC_dateTime'],
									"content" => nl2br($row['SC_content']),
									"button" => '<button type="button" class="comment-row-item-action edit" data-key="'.$key.'"  data-num="'.$view.'"  onclick="commentEdit(\''.$this->primaryKeyEncrypt($row['SC_key']).'\',this)"><i class="font-icon font-icon-pencil"></i></button><button type="button" class="comment-row-item-action del" data-key="'.$key.'" data-num="'.$view.'"  onclick="commentDel(\''.$this->primaryKeyEncrypt($row['SC_key']).'\',this)"><i class="font-icon font-icon-trash"></i></button>'
								);
							}else{
								$returnArray = 
								array(
									"photo" => "no-user.png",
									"url" => base_url('profile/member/').$this->url_b64encode($SM_key),
									"name" => $row['SM_name'],
									"date" => $row['SC_dateTime'],
									"content" => nl2br($row['SC_content']),
									"button" => '<button type="button" class="comment-row-item-action edit" data-key="'.$key.'" data-num="'.$view.'" onclick="commentEdit(\''.$this->primaryKeyEncrypt($row['SC_key']).'\',this)"><i class="font-icon font-icon-pencil"></i></button><button type="button" class="comment-row-item-action del" data-key="'.$key.'"  data-num="'.$view.'"  onclick="commentDel(\''.$this->primaryKeyEncrypt($row['SC_key']).'\',this)"><i class="font-icon font-icon-trash"></i></button>'
								);
							}
						}else{
							if($row["SM_photo"] != null){
								$returnArray = 
								array(
									"photo" => $row['SM_photo'],
									"url" => base_url('profile/member/').$this->url_b64encode($row['SM_key']),
									"name" => $row['SM_name'],
									"date" => $row['SC_dateTime'],
									"content" => nl2br($row['SC_content']),
									"button" => ''
								);
							}else{
								$returnArray = 
								array(
									"photo" =>  "no-user.png",
									"url" => base_url('profile/member/').$this->url_b64encode($row['SM_key']),
									"name" => $row['SM_name'],
									"date" => $row['SC_dateTime'],
									"content" => nl2br($row['SC_content']),
									"button" => ''
								);
							}
						}
						array_push($array,$returnArray);
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
				echo json_encode($array);
			}else{
				echo json_encode(array(444));
			}
		}else{
			//這邊是沒有登入的時候，key不會加密
			$sfkey=$_POST['footprintKey'];
			$returnArray = $this->service_model->get_AllComment($sfkey);
			$array = array();
			foreach ($returnArray as $row) {
				if($row['type'] == 0){
					if($row["SM_photo"] != null){
						$returnArray = 
						array(
							"photo" => $row['SM_photo'],
							"url" => base_url('profile/member/').$this->url_b64encode($row['SM_key']),
							"name" => $row['SM_name'],
							"date" => $row['SC_dateTime'],
							"content" => nl2br($row['SC_content']),
							"button" => ''
						);
					}else{
						$returnArray = 
						array(
							"photo" =>  "no-user.png",
							"url" => base_url('profile/member/').$this->url_b64encode($row['SM_key']),
							"name" => $row['SM_name'],
							"date" => $row['SC_dateTime'],
							"content" => nl2br($row['SC_content']),
							"button" => ''
						);
					}
					array_push($array,$returnArray);
				}
			}
			// $returnArray=array(
			// 	array(
			// 		"photo"    => "no-user.png",   //回覆者頭貼
			// 		"url"     => base_url("profile/member/").$this->url_b64encode(32/*32是SMKEY*/),//回覆者主頁網址
			// 		"name"    =>"吳孟賢",//回覆者名
			// 		"date"    =>"2017/07/15 19:00:00",//留言時間
			// 		"content" => " 很棒很棒好想參加ㄛ",//活動主旨
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
			echo json_encode($array);
		}
	}

		/***
		傳入值為：$_Post['content','footprintKey'] 
				  content="學校配合度"，必大於零，為浮點數(有小數點)
				  footprintKey="服務key(service_footprint : SF_key)"
		傳入驗證：資料消毒
		成功echo 1; 留言不可為空 echo 0;其他錯誤(如果有) echo 2; key解密失敗 echo 444;
		***/
		public function addComment(){
			if($this->getlogin() == 1){
				$post= $this->xss($_POST);
				$content = $post['content'];

				$SF_key = $_POST['footprintKey'];
				$sfkey = $this->primaryKeyDecrypt($SF_key);
				$SM_key = $this->getSMkey();
				if (!empty($_SERVER["HTTP_CLIENT_IP"])){
					$ip = $_SERVER["HTTP_CLIENT_IP"];
				}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
					$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				}else{
					$ip = $_SERVER["REMOTE_ADDR"];
				}

				if($sfkey['check']){

					$str = trim($content);

					if(empty($str)){
						echo "0";
					}else{
						$this->service_model->add_comment($content,$sfkey['key'],$SM_key,$ip);
						echo "1";
					}

			//$groupCheckArray = $this->primaryKeyDecrypt($groupKey);
				}else{
					echo "444";
				}
			}else{
				redirect("home");
			}
		}

		/***
		傳入值為：$_Post['comentKey'] 
				  comentKey="留言主鍵"
		傳入驗證：請新增資料庫的欄位，刪除並非將訊息從資料庫中刪除，而是type改變而搜索不到
		成功echo 1; 其他錯誤(如果有) echo 0; key解密失敗 echo 444;
		***/
		public function delComment(){
			if($this->getlogin() == 1){
				$SC_key = $_POST['comentKey'];
				$sckey = $this->primaryKeyDecrypt($SC_key);

				if($sckey['check']){
					$this->service_model->del_comment($sckey['key']);
					echo "1";
				}else{
					echo "444";
				}
			}else{
				redirect("home");
			}
		}


		/***
		傳入值為：$_POST['comentKey'] 
				  comentKey="活動ID"為加密KEY
		回傳一筆留言，回傳格式如程式內。
		***/
		public function getOneComment(){
			$key = $_POST['comentKey'];
			if($this->getlogin()==1){
				$checkArray = $this->primaryKeyDecrypt($key);
				if($checkArray['check']){
					$SCKey = $checkArray['key'];
					$content = $this->service_model->get_OneComment($SCKey);

					$returnArray = array(
						"text" => $content
					);
					
					// $returnArray=array(
					// 	"text" => "哈哈哈哈哈哈哈哈哈哈"
					// );

					echo json_encode($returnArray);

				}else{
  				//不符合 回傳444
					echo json_encode(array(444));
				}	

			}else{
				redirect("home");
			}
		} 

		/***
		傳入值為：$_Post['text','comentKey'] 
				  text="留言內容，必須判斷為大於0"
				  comentKey="留言key"
		傳入驗證：text 資料消毒
		成功echo 1; text數值等於0 echo 0; ID解密失敗 echo 444;
		***/
		public function editComment(){
			if($this->getlogin() == 1){
				$Key = $_POST['comentKey'];
				$checkArray = $this->primaryKeyDecrypt($Key);

				if($checkArray['check']){
					$post = $this->xss($_POST);
					$text = $post['text'];
					$scKey = $checkArray['key'];
					$str = trim($text);
					if($str == ""){
						echo "0";
					}else{
						$this->service_model->edit_comment($text,$scKey);
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
