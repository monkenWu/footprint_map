<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Home extends MY_SqlFunction {

	//建構預載入需要執行的model
	public function __construct() {
		parent::__construct();
		$this->load->model("home_model","",TRUE);
		$this->load->helper('cookie');
	}

	/****
		每次load->View必須一同傳出頁面資訊：使	用者名稱、目前登入權限、頁面名稱。
		呼叫規則如下viewItem("頁面標題");
		viewItem()將會返回一個陣列
		$data["title" => "頁面標題",
			  "memberName" => "用戶名稱"
			  "login" => "登入狀態"]
		而 viewItem()，為MY_SqlFunction內需定義的項目。
		****/
	public function index() {
		$data = $this->viewItem("Footprint - 服務地圖");

		$this->load->view("home_view",$data);
	
	//$this->load->view("home_view",$data);
	} 

	//登出 清掉session 重新導向home頁面
	public function logout(){
		session_destroy();
		set_cookie("account",'',time()-7200);
		set_cookie("password",'',time()-7200);
		redirect("home");
	}
	/**** 
		傳入值：$_POST['school','county','district','searchJson']
				school：String [elementary,junior]
				county：String [城市名稱]
				district ：String [區名稱,'false(未選擇時傳入)']
				searchJson(搜索)	：Json {  "faraway":1, 						(1為只搜索偏鄉小學)
										  	  "total":1, 						(學生總數是否搜索)
										  	  "total_value":"<=,0",				(搜索數值,total為1才存在)
											  "aboriginal":1,					(原住民學生數是否搜索)
											  "aboriginal_value":"<=,0",		(搜索數值,aboriginal為1才存在)
											  "immigrants":1,					(新住民家庭學生數是否搜索)
											  "immigrants_value":"<=,0",		(搜索數值,immigrants為1才存在)
											  "service":1,						(被服務次數是否搜索)
											  "service_value":"<=,0",			(搜索數值,service為1才存在)
											  "score":1,						(服務評價是否搜索)
											  "score_value":">=,3",				(搜索數值,score為1才存在)
											  "EPA":1}							(1為搜索教育優先區) #NEW

				searchJson(不搜索)　：Json {  "faraway":0,
											  "total":0,
											  "aboriginal":0,
											  "immigrants":0,
											  "service":0,
											  "score":0,
											  "EPA":0}
		回傳值：Json{'position':'經緯度',addr':'地址','name':'學校名稱','number':'學校代碼','phone':'學校電話','type':'國小或國中'}
		需求：串接正確的SQL查詢，並且echo正確的JSON。
		****/
	public function areaSearch(){

		$data1 = array(
		'school'=>$_POST['school'],
		'county'=>$_POST['county'],
		'district'=>$_POST['district'],
		'searchJson'=>$_POST['searchJson']
		);

		$returnArray=$this->home_model->area($data1);
		// $returnArray=array(
		// 	["position"=>"22.7910952,120.29378569999994" ,"addr"=>"[820]高雄市岡山區平安里柳橋東路36號",
		// 	"name"=>"市立岡山國小","number"=>"124643","url"=>"http://www.gsn.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],
		
		// 	["position"=>"22.7923429,120.28310829999998" ,"addr"=>"[820]高雄市岡山區仁壽里育英路35號"  ,
		// 	 "name"=>"市立前峰國小","number"=>"124644","url"=>"http://www.qfp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.8218934,120.30529060000003" ,"addr"=>"[820]高雄市岡山區嘉興里嘉興路322號" ,
		// 	"name"=>"市立嘉興國小","number"=>"124645","url"=>"http://web.jsp.ks.edu.tw/school/web/index.php","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.7845645,120.28687330000002" ,"addr"=>"[820]高雄市岡山區介壽路60號"        ,
		// 	"name"=>"市立兆湘國小","number"=>"124646","url"=>"http://www.zxn.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.7927448,120.30338970000003" ,"addr"=>"[820]高雄市岡山區碧紅里岡燕路2巷88號",
		// 	"name"=>"市立後紅國小","number"=>"124647","url"=>"http://www.hfp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.7816003,120.30350909999993" ,"addr"=>"[820]高雄市岡山區和平里和平路1號"    ,
		// 	"name"=>"市立和平國小","number"=>"124648","url"=>"http://www.hpp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.8027494,120.30286760000001" ,"addr"=>"[820]高雄市岡山區竹圍里大仁北路1號"  ,
		// 	"name"=>"市立竹圍國小","number"=>"124745","url"=>"http://www.zw.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.798857,120.29248099999995" ,"addr"=>"[820]高雄市岡山區公園東路55號"       ,
		// 	"name"=>"市立壽天國小","number"=>"124758","url"=>"http://www.stp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"]);
		echo json_encode($returnArray);
	}


	/**** 
		傳入值：$_POST['school','county','keywords']
				school：String [elementary,junior]
				county：String [城市名稱,''(為空時表示不增加城市為搜索條件)]
				keywordsSchool : String [學校名稱，可能為空(若以空白鍵分割字串，則為多條件搜索)]
				keywordsAddr : String [地址內容，可能為空(若以空白鍵分割字串，則為多條件搜索)]
		回傳值：Json{'position':'經緯度',addr':'地址','name':'學校名稱','number':'學校代碼','phone':'學校電話','type':'國小或國中'}
		需求：串接正確的SQL查詢，並且echo正確的JSON，keywords like 地址 以及 校名。
	****/
	public function keywordsSearch(){

		$data = array(
			'school' => $_POST['school'],
			'county' => $_POST['county'],
			'keywordsSchool' => $_POST['keywordsSchool'],
			'keywordsAddr' => $_POST['keywordsAddr']
		);

		$returnArray = $this->home_model->keywordsSearch($data);
		echo json_encode($returnArray);
		// $returnArray=array(
		// 	["position"=>"22.798857,120.29248099999995" ,"addr"=>"[820]高雄市岡山區公園東路55號"       ,
		// 	"name"=>"市立壽天國小","number"=>"124758","url"=>"http://www.stp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"]);
		// echo json_encode($returnArray);
	}

	/**** 
	{"faraway":1,"total":1,"total_value":"<=,0","aboriginal":1,"aboriginal_value":"<=,0","immigrants":1,"immigrants_value":"<=,0","service":1,"service_value":"<=,0","source":1,"source_value":{"schoolCooperate_value":">=,3","studentCooperate_value":">=,3","traffic_value":">=,3","around_value":">=,3"},"schoolArea":1,"schoolArea_value":">=,1000","hall":1,"hall_value":">=,0","schoolClass":1,"schoolClass_value":">=,0","schoolComputer":1,"schoolComputer_value":">=,0","needService":1,"teacher":1,"teacher_value":"<=,0"}
		傳入值：傳入值：$_POST['school','county','searchJson']
				school：String [elementary,junior]
				county：String [城市名稱,''(為空時表示不增加城市為搜索條件)]
				district ：String [區名稱,'false(未選擇時傳入)']
				//searchJson一定會傳入最少2個搜索條件
				searchJson(搜索)	：Json {  "faraway":1,				(1為只搜索偏鄉小學)
											  "total":1,				(學生總數是否搜索)
											  "total_value":"<=,0",		(搜索數值,total為1才存在)

											  "aboriginal":1,			(原住民學生數是否搜索)
											  "aboriginal_value":"<=,0",(搜索數值,aboriginal為1才存在)

											  "immigrants":1,			(新住民家庭學生數是否搜索)
											  "immigrants_value":"<=,0",(搜索數值,immigrants為1才存在)

											  "service":1,				(被服務次數是否搜索)
											  "service_value":"<=,0",	(搜索數值,service為1才存在)

											  "source":1,				(服務評價是否搜索) (source_value為雙層陣列)
											  "source_value":{"schoolCooperate_value":">=,3", (校方配合度)
											  				  "studentCooperate_value":">=,3",(學生配合度)
											  				  "traffic_value":">=,3",		  (交通方便性)
											  				  "around_value":">=,3"},		  (周邊機能性)

											  "schoolArea":1,				(校地面積是否搜索)
											  "schoolArea_value":">=,1000",	(搜索數值,schoolArea為1才存在)

											  "hall":1,						(禮堂數量是否搜索)
											  "hall_value":">=,0",			(搜索數值,hall為1才存在)

											  "schoolClass":1,				(班級數量是否搜索)
											  "schoolClass_value":">=,0",	(搜索數值,schoolClass為1才存在)

											  "schoolComputer":1,			(可上網電腦數是否搜索)
											  "schoolComputer_value":">=,0",(搜索數值,schoolComputer為1才存在)

											  "needService":1,				(1為學校註記需要服務)

											  "teacher":1,					(職員總數是否搜索)
											  "teacher_value":"<=,0",		(搜索數值,teacher為1才存在)

											  "EPA":1}						(1為搜索教育優先區) #NEW

				searchJson(不搜索)　：Json {  "faraway":0,
											  "total":0,
											  "aboriginal":0,
											  "immigrants":0,
											  "service":0,
											  "source":0,
											  "schoolArea":0,
											  "hall":0,
											  "schoolClass":0,
											  "schoolComputer":0,
											  "needService":0,
											  "teacher":0,
											  "EPA":0}
		回傳值：Json{'position':'經緯度',addr':'地址','name':'學校名稱','number':'學校代碼','phone':'學校電話','type':'國小或國中'}
		需求：串接正確的SQL查詢，並且echo正確的JSON。
	****/
	public function attributesSearch(){

	$data = array(
		'school'=>$_POST['school'],
		'county'=>$_POST['county'],
		'searchJson'=>$_POST['searchJson']
		);

		$returnArray=$this->home_model->attributesSearch($data);
		// $returnArray=array(
		// 	["position"=>"22.7910952,120.29378569999994" ,"addr"=>"[820]高雄市岡山區平安里柳橋東路36號",
		// 	"name"=>"市立岡山國小","number"=>"124643","url"=>"http://www.gsn.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],
		
		// 	["position"=>"22.7923429,120.28310829999998" ,"addr"=>"[820]高雄市岡山區仁壽里育英路35號"  ,
		// 	 "name"=>"市立前峰國小","number"=>"124644","url"=>"http://www.qfp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.8218934,120.30529060000003" ,"addr"=>"[820]高雄市岡山區嘉興里嘉興路322號" ,
		// 	"name"=>"市立嘉興國小","number"=>"124645","url"=>"http://web.jsp.ks.edu.tw/school/web/index.php","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.7845645,120.28687330000002" ,"addr"=>"[820]高雄市岡山區介壽路60號"        ,
		// 	"name"=>"市立兆湘國小","number"=>"124646","url"=>"http://www.zxn.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.7927448,120.30338970000003" ,"addr"=>"[820]高雄市岡山區碧紅里岡燕路2巷88號",
		// 	"name"=>"市立後紅國小","number"=>"124647","url"=>"http://www.hfp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.7816003,120.30350909999993" ,"addr"=>"[820]高雄市岡山區和平里和平路1號"    ,
		// 	"name"=>"市立和平國小","number"=>"124648","url"=>"http://www.hpp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.8027494,120.30286760000001" ,"addr"=>"[820]高雄市岡山區竹圍里大仁北路1號"  ,
		// 	"name"=>"市立竹圍國小","number"=>"124745","url"=>"http://www.zw.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"],

		// 	["position"=>"22.798857,120.29248099999995" ,"addr"=>"[820]高雄市岡山區公園東路55號"       ,
		// 	"name"=>"市立壽天國小","number"=>"124758","url"=>"http://www.stp.ks.edu.tw","phone"=>"07-6666666","type"=>"elementary"]);
		echo json_encode($returnArray);
	}



	/*傳入值：$_POST['school','id']
				school：String [elementary,junior]
				id：String [學校id]
	  回傳值：如下列JSON，必須判斷是否為國中、國小生。*/
	  //參考如上，孟孟累了
	public function schoolInfo(){
		$post = $_POST;
		$data = array(
			"school" => $post["school"],
			"id" => $post["id"]
		);
		$returnArray = $this->home_model->schoolInfo($data);
		echo json_encode($returnArray);


			// if($this->home_model->check_source($post["id"])){ 
			// 		$returnArray = $this->home_model->schoolInfo($data);
			// 	}else{
			// 		$returnArray = $this->home_model->schoolInfo_NoScore($data);
			// 	}

			// $returnArray=array(
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
			
			
		

			// $returnArray=array(
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
		
	}
}
