<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class School extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("school_model","",TRUE);
	}

	/****
		每次進入頁面都要判斷是否有GET的存在，若否則重新導向到HOME。
		傳入值：$_GET['school','id']
		school：String [elementary,junior] 學校類型
		id : String["key"] 傳入學校的KEY值，只能是一個值
		
		需求：若是傳入school、id為空或有找不到的狀況，便傳送一變數$error="資料錯誤請重新再試"，至View。
		這邊不回傳任何JSON，僅是確認GET資料的真實性。
	****/
	public function index() {
		if(isset($_GET['school'])&&isset($_GET['id'])){
			$get = $this->xss($_GET);

			$schoolName = $this->school_model->search_school($get["id"],$get["school"]);//使用$_GET['id']搜索學校名稱，若有此校則串接頁面名，若否則傳遞錯誤給view。

			$data = $this->viewItem("Footprint - ".substr($schoolName, 6));
			//在load前必須確認資料的真實性，若否則傳$data['error'] = "資料錯誤請重新再試"至view。
			$data['school'] = $get['school'];
			$data['id'] = $get['id'];
			$this->load->view("school_view",$data);
		}else{
			$data = $this->viewItem("Footprint - 資料錯誤");
			$data['error'] = "資料錯誤請重新再試";
			$this->load->view("school_view",$data);
			//redirect("home");
		}
	//$this->load->view("home_view",$data);
	} 

	/*傳入值：$_POST['school','id']
				school：String [elementary,junior]
				id：String [學校id]
	回傳值：如下列JSON，必須判斷是否為國中、國小生，並且回傳該所學校經緯度。*/
	public function schoolInfo(){
		$post = $this->xss($_POST);
		if($post['school'] == "junior"){
			$post = $_POST;
			$data = array(
			"school" => $post["school"],
			"id" => $post["id"]
			);
			$returnArray = $this->school_model->schoolInfo($data);
			// $returnArray=array(
			// 	//校園名稱內容資訊組
			// 	"school"		=>["position"    =>"22.78867,120.2889786",//校地面積
			// 					   "name"        =>"前峰國中"],
			// 	//建物資訊組
			// 	"building"		=>["areaContent"    =>"24488",//校地面積
			// 					   "hallContent"    =>"1",//禮堂數量
			// 					   "classContent"   =>"43",//教室間數
			// 					   "computerContent"=>"70"],//可上網電腦數
			// 	//班級學生資訊組
			// 	"studentClass"  =>["1Male"=>"88",//一年級男性
			// 					   "2Male"=>"79",//二年級男性
			// 					   "3Male"=>"77",//三年級男性
			// 					   "1Female"=>"76",//一年級女性
			// 					   "2Female"=>"80",//二年級女性
			// 					   "3Female"=>"96",//三年級女性
			// 					   "1Class"=>"6",//一年級班級數
			// 					   "2Class"=>"6",//二年級班級數
			// 					   "3Class"=>"6",//三年級班級數
			// 					   "allClass"=>"36"],//總班級數
			// 	//學生組成資訊組
			// 	"studentPart"   =>["aboriginalMale"  =>"15", //原住民男性
			// 					   "colonialMale"    =>"26", //新住民男性
			// 					   "ordinaryMale"    =>"503",//普通男性
			// 					   "aboriginalFemale"=>"4",  //原住民女性
			// 					   "colonialFemale"  =>"30", //新住民女性
			// 					   "ordinaryFemale"  =>"423",//普通女性
			// 					   "allStudent"      =>"1001"],//總學生數
			// 	//教師組成資訊組
			// 	"teacherPart"   =>["regularMale"  =>"16", //專任男性
			// 					   "regularFemale"=>"1", //專任女性
			// 					   "teacherMale"  =>"41",//職員男性
			// 					   "teacherFemale"=>"3",//職員女性
			// 					   "regularAll"   =>"57",//總專任數
			// 					   "teacherAll"   =>"4"],//總職員數
			// 	//分數評比資訊組 （若資料庫無資料，則回傳滿分五分）
			// 	"source"        => ["schoolCooperate"  =>"5", //學校配合度
			//                         "studentCooperate" =>"5", //學生配合度
			//                         "traffic"          =>"5", //交通方便性
			//                     	"around"           =>"5"]); //周邊機能性
			
			echo json_encode($returnArray);
		}else if($post['school'] == "elementary"){
			$post = $_POST;
			$data = array(
			"school" => $post["school"],
			"id" => $post["id"]
			);
			$returnArray = $this->school_model->schoolInfo($data);
			// $returnArray=array(
			// 	//校園名稱內容資訊組
			// 	"school"		=>["position"    =>"22.798857,120.29248099999995",//校地面積
			// 					   "name"        =>"壽天國小"],
			// 	"building"		=>["areaContent"    =>"24488",
			// 					   "hallContent"    =>"1",
			// 					   "classContent"   =>"43",
			// 					   "computerContent"=>"70"],
			// 	"studentClass"  =>["1Male"=>"90",
			// 					   "2Male"=>"79",
			// 					   "3Male"=>"77",
			// 					   "4Male"=>"101",
			// 					   "5Male"=>"89",
			// 					   "6Male"=>"110",
			// 					   "1Female"=>"76",
			// 					   "2Female"=>"80",
			// 					   "3Female"=>"96",
			// 					   "4Female"=>"70",
			// 					   "5Female"=>"71",
			// 					   "6Female"=>"64",
			// 					   "1Class"=>"6",
			// 					   "2Class"=>"6",
			// 					   "3Class"=>"6",
			// 					   "4Class"=>"6",
			// 					   "5Class"=>"6",
			// 					   "6Class"=>"6",
			// 					   "allClass"=>"36"],
			// 	"studentPart"   =>["aboriginalMale"  =>"15",
			// 					   "colonialMale"    =>"26",
			// 					   "ordinaryMale"    =>"503",
			// 					   "aboriginalFemale"=>"4",
			// 					   "colonialFemale"  =>"30",
			// 					   "ordinaryFemale"  =>"423",
			// 					   "allStudent"      =>"1001"],
			// 	"teacherPart"   =>["regularMale"  =>"16",
			// 					   "regularFemale"=>"1",
			// 					   "teacherMale"  =>"41",
			// 					   "teacherFemale"=>"3",
			// 					   "regularAll"   =>"57",
			// 					   "teacherAll"   =>"4"],
			// 	"source"        => ["schoolCooperate"  =>"5",
			//                         "studentCooperate" =>"5",
			//                         "traffic"          =>"5",
			//                     	"around"           =>"5"]);
			echo json_encode($returnArray);
		}
	}

}
