<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Comparing extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("comparing_model","",TRUE);
	}

	/****
		每次進入頁面都要判斷是否有GET的存在，若否則重新導向到HOME。
		傳入值：$_GET['school','id']
		school：String [elementary,junior] 學校類型
		id : String["key,key,key,key"] 傳入學校的KEY值，最多四個值，最少兩個值，以逗號分割
		
		需求：若是傳入school、id為空或有找不到的狀況，便傳送一變數$error="資料錯誤請重新再試"，至View。
		這邊不回傳任何JSON，僅是確認GET資料的真實性。
	****/
	public function index() {
		if(isset($_GET['school'])&&isset($_GET['id'])){
			$get = $this->xss($_GET);
			$data = $this->viewItem("Footprint - 比較學校");
			//在load前必須確認資料的真實性，若否則傳$data['error'] = "資料錯誤請重新再試"至view。
			$data['school'] = $get['school'];
			$data['id'] = $get['id'];
			$this->load->view("comparing_view",$data);
		}else{
			$data = $this->viewItem("Footprint - 比較學校");
			$data['error'] = "資料錯誤請重新再試";
			$this->load->view("comparing_view",$data);
			//redirect("home");
		}
	//$this->load->view("home_view",$data);
	} 

	/****
		每次進入頁面都要判斷是否有GET的存在，若否則重新導向到HOME。
		傳入值：$_POST['school','id']
		school：String [elementary,junior] 學校類型
		id : String["key,key,key,key"] 傳入學校的KEY值，最多四個值，最少兩個值，以逗號分割
		
		回傳值：如程式陣列。為三維陣列。
	****/
	public function getAllContent(){
		$post = $_POST;
		$data = array(
				"school" => $post["school"],
				"id" => $post["id"]
			);


		$returnArray = $this->comparing_model->compare($data);
		// $returnArray=array(
		// 	//學校資訊組
		// 	array("school"		=>["name"    =>"壽天國小",//校名
		// 					   "phone"   =>"(07)6246040",//電話
		// 					   "addr"    =>"[820]-高雄市岡山區公園東路55號",//地址
		// 					   "url"	 =>"http://www.stp.ks.edu.tw/",
		// 					   "position"=>"22.798857,120.29248099999995"],//網址
		// 	//建築資訊組
		// 	"building"		=>["areaContent"    =>"24488",//校地面積
		// 					   "hallContent"    =>"1",//禮堂數量
		// 					   "classContent"   =>"43",//教室間數
		// 					   "computerContent"=>"70"],//可上網電腦數
		// 	//學生總數資訊組
		// 	"studentPart"   =>["aboriginal"  =>"15", //原住民總數
		// 					   "colonial"    =>"26", //新住民總數
		// 					   "ordinary"    =>"503",//普通生總數
		// 					   "allClass"    =>"36",//總班級數
		// 					   "allStudent"  =>"1001"//學生總數
		// 					   ], 
		// 	//教師組成資訊組
		// 	"teacherPart"   =>["regularAll"  =>"16", //專任總數
		// 					   "teacherAll"   =>"4"],//總職員數
		// 	//分數評比資訊組 （若資料庫無資料，則回傳滿分五分）
		// 	"source"        => ["schoolCooperate"  =>"5", //學校配合度
		//                         "studentCooperate" =>"5", //學生配合度
		//                         "traffic"          =>"5", //交通方便性
		//                     	"around"           =>"4"]
		//     ),

		// 	//學校資訊組
		// 	array("school"		=>["name"    =>"前峰國小",//校名
		// 					   "phone"   =>"07-6666666",//電話
		// 					   "addr"    =>"[820]高雄市岡山區仁壽里育英路35號",//地址
		// 					   "url"	 =>"http://www.stp.ks.edu.tw/",
		// 					   "position"=>"22.7923429,120.28310829999998"],//網址
		// 	//建築資訊組
		// 	"building"		=>["areaContent"    =>"20000",//校地面積
		// 					   "hallContent"    =>"1",//禮堂數量
		// 					   "classContent"   =>"30",//教室間數
		// 					   "computerContent"=>"50"],//可上網電腦數
		// 	//學生總數資訊組
		// 	"studentPart"   =>["aboriginal"  =>"10", //原住民總數
		// 					   "colonial"    =>"30", //新住民總數
		// 					   "ordinary"    =>"500",//普通生總數
		// 					   "allClass"    =>"30",//總班級數
		// 					   "allStudent"  =>"1000"//學生總數
		// 						], 
		// 	//教師組成資訊組
		// 	"teacherPart"   =>["regularAll"  =>"20", //專任總數
		// 					   "teacherAll"   =>"3"],//總職員數
		// 	//分數評比資訊組 （若資料庫無資料，則回傳滿分五分）
		// 	"source"        => ["schoolCooperate"  =>"4", //學校配合度
		//                         "studentCooperate" =>"4", //學生配合度
		//                         "traffic"          =>"4", //交通方便性
		//                     	"around"           =>"4"]
		//     ),

		//     //學校資訊組
		// 	array("school"		=>["name"    =>"市立竹圍國小",//校名
		// 					   "phone"   =>"(07)6246040",//電話
		// 					   "addr"    =>"[820]高雄市岡山區竹圍里大仁北路1號",//地址
		// 					   "url"	 =>"http://www.stp.ks.edu.tw/",
		// 					   "position"=>"22.8027494,120.30286760000001"],//網址
		// 	//建築資訊組
		// 	"building"		=>["areaContent"    =>"19000",//校地面積
		// 					   "hallContent"    =>"1",//禮堂數量
		// 					   "classContent"   =>"50",//教室間數
		// 					   "computerContent"=>"50"],//可上網電腦數
		// 	//學生總數資訊組
		// 	"studentPart"   =>["aboriginal"  =>"12", //原住民總數
		// 					   "colonial"    =>"10", //新住民總數
		// 					   "ordinary"    =>"400",//普通生總數
		// 					   "allClass"    =>"50",//總班級數
		// 					   "allStudent"  =>"900"//學生總數
		// 					  ], 
		// 	//教師組成資訊組
		// 	"teacherPart"   =>["regularAll"  =>"15", //專任總數
		// 					   "teacherAll"   =>"3"],//總職員數
		// 	//分數評比資訊組 （若資料庫無資料，則回傳滿分五分）
		// 	"source"        => ["schoolCooperate"  =>"4.5", //學校配合度
		//                         "studentCooperate" =>"4.5", //學生配合度
		//                         "traffic"          =>"4", //交通方便性
		//                     	"around"           =>"4"]
		//     ),

		//     //學校資訊組
		// 	array("school"		=>["name"    =>"市立嘉興國小",//校名
		// 					   "phone"   =>"(07)6246040",//電話
		// 					   "addr"    =>"[820]高雄市岡山區嘉興里嘉興路322號",//地址
		// 					   "url"	 =>"http://www.stp.ks.edu.tw/",
		// 					   "position"=>"22.8218934,120.30529060000003"],//網址
		// 	//建築資訊組
		// 	"building"		=>["areaContent"    =>"30000",//校地面積
		// 					   "hallContent"    =>"1",//禮堂數量
		// 					   "classContent"   =>"43",//教室間數
		// 					   "computerContent"=>"70"],//可上網電腦數
		// 	//學生總數資訊組
		// 	"studentPart"   =>["aboriginal"  =>"15", //原住民總數
		// 					   "colonial"    =>"26", //新住民總數
		// 					   "ordinary"    =>"503",//普通生總數
		// 					   "allClass"    =>"36",//總班級數
		// 					   "allStudent"  =>"1001"//學生總數
		// 					   ], 
		// 	//教師組成資訊組
		// 	"teacherPart"   =>["regularAll"  =>"16", //專任總數
		// 					   "teacherAll"   =>"4"],//總職員數
		// 	//分數評比資訊組 （若資料庫無資料，則回傳滿分五分）
		// 	"source"        => ["schoolCooperate"  =>"5", //學校配合度
		//                         "studentCooperate" =>"5", //學生配合度
		//                         "traffic"          =>"5", //交通方便性
		//                     	"around"           =>"4"]
		//     )); //周邊機能性
		echo json_encode($returnArray);
	}

}
