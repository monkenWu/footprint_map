<?php

class Api extends MY_SqlFunction{
	public function __construct() {
		parent::__construct();
		header('Access-Control-Allow-Origin:*');
		$this->load->model("api_model","",TRUE);
	}

	public function search(){
		$get = $this->xss($_GET);
		if(isset($get["school"]) && isset($get["country"])){
			$school = $get["school"];
			$county = $get["country"];
			// print_r($get);
			// echo $school;
			// echo $country;

			$returnArray = $this->api_model->catch_api($school,$county,$get);

			
			
			echo json_encode($returnArray);
			// redirect();
		}
	}


	public function addrSearch(){
		// $country = $_GET['country'];
		$str = str_replace('台','臺',preg_replace('/\s(?=)/', '', $_POST['addr']));
		$result = $this->api_model->get_CountryArea();
		$result2 = $this->api_model->get_middle_income();
		$result3 = $this->api_model->get_low_income();
		$areaId = false;
		$LMIH_CNT = 0; //中低收入戶
		$LMIH_CNT_rlp = 0; //中低收入戶戶內人數
		$LIH_CNT = 0; //低收入戶
		$LIH_CNT_rlp = 0; //低收入戶戶內人數

		
		foreach ($result as $row) {
			if(strpos($str,$row->city.$row->area)!==false){
				$areaId = $row->id;
				break;
			}
		}

		//中低收
		foreach ($result2 as $row) {
			if(strpos($str,$row->LMIH_city.$row->LMIH_town)!==false){
				$LMIH_CNT = $row->LMIH_CNT;
				$LMIH_CNT_rlp = $row->LMIH_CNT_rlp;
				break;
			}
		}

		//低收
		foreach ($result3 as $row) {
			if(strpos($str,$row->LIH_city.$row->LIH_town)!==false){
				$LIH_CNT = $row->LIH_CNT;
				$LIH_CNT_rlp = $row->LIH_CNT_rlp;
				break;
			}
		}


		if($areaId){		
			//跟areaData方法取資料
			$a = $this->areaData($areaId);

			//年齡資料
			$Data = $this->api_model->get_otherAreaData($areaId);



			//區域人口數
			$total =$a[0]['man']+$a[0]['woman'];

			//犯罪人口數
			$crime_cnt = $a[0]['crimeData'];

			//生活公式
			$x = $crime_cnt/$total; //x = 犯罪數量/人口總數
			$x = number_format($x,4);

			//犯罪最大值
			$crime_max = $this->api_model->get_crimeMax();

			//犯罪最小值
			$crime_min = $this->api_model->get_crimeMin();

			//交通車禍發生次數
			$traffic_cnt = $a[0]['trafficData'];

			//交通公式
			$y = $traffic_cnt/$total; // y = 車禍數量/人口總數
			$y = number_format($y,4);

			//交通車禍最大值
			$traffic_max = $this->api_model->get_trafficMax();

			//交通車禍最小值
			$traffic_min = $this->api_model->get_trafficMin();


			$returnArray = array(
				[
					'lifeindex' => number_format(100-((($x-$crime_min)/($crime_max-$crime_min))*100),0), // (0.1-(3368/386144))*1000 
					'accident' => number_format(100-((($y-$traffic_min)/($traffic_max-$traffic_min))*100),0),//(0.1-(1398/386144)+(12/386144*10))*1000
					'age' => $Data[0],
					'areaid' => $areaId,
				]
			);

			$returnArray2 = array(
				[
					'crimeData' => $a[0]['crimeData'],
					'policeData' => $a[0]['policeData'],
					'trafficData' => $a[0]['trafficData'],
					'0to14' => $a[0]['0to14'],
					'15to64' => $a[0]['15to64'],
					'65up' => $a[0]['65up'],
					'unknow_age' => $a[0]['unknow_age']
				]
			);

			$returnArray3 = array(
				[
					'LMIH_CNT' => $LMIH_CNT,
					'LMIH_CNT_rlp' => $LMIH_CNT_rlp,
					'LIH_CNT' => $LIH_CNT,
					'LIH_CNT_rlp' => $LIH_CNT_rlp
				]
			);

			$array = array_merge($returnArray,$returnArray2);
			$array2 = array_merge($array,$returnArray3);
			echo json_encode($array2);
		}else{
			echo "444";
		}
	}



	public function placeRadar(){
		// $country = $_GET['country'];
		//暫時改為GET 

		$str = str_replace('台','臺',preg_replace('/\s(?=)/', '', $_GET['addr']));
		$result = $this->api_model->get_CountryArea();
		$areaId = false;

		foreach ($result as $row) {
			if(strpos($str,$row->city.$row->area)!==false){
				$areaId = $row->id;
				break;
			}
		}

		if($areaId){		
			//跟areaData方法取資料
			$a = $this->areaData($areaId);
			if(gettype($a) != "NULL"){


			//年齡資料
				$Data = $this->api_model->get_otherAreaData($areaId);



			//區域人口數
				$total =$a[0]['man']+$a[0]['woman'];

			//犯罪人口數
				$crime_cnt = $a[0]['crimeData'];

			//生活公式
			$x = $crime_cnt/$total; //x = 犯罪數量/人口總數
			$x = number_format($x,4);

			//犯罪最大值
			$crime_max = $this->api_model->get_crimeMax();

			//犯罪最小值
			$crime_min = $this->api_model->get_crimeMin();

			//交通車禍發生次數
			$traffic_cnt = $a[0]['trafficData'];

			//交通公式
			$y = $traffic_cnt/$total; // y = 車禍數量/人口總數
			$y = number_format($y,4);

			//交通車禍最大值
			$traffic_max = $this->api_model->get_trafficMax();

			//交通車禍最小值
			$traffic_min = $this->api_model->get_trafficMin();


			$returnArray = array(
				[
					'lifeindex' => number_format(100-((($x-$crime_min)/($crime_max-$crime_min))*100),0), // (0.1-(3368/386144))*1000 
					'accident' => number_format(100-((($y-$traffic_min)/($traffic_max-$traffic_min))*100),0),//(0.1-(1398/386144)+(12/386144*10))*1000
					// 'age' => $Data[0],
					// 'areaid' => $areaId,
				]
			);

			// $returnArray2 = array(
			// 	[
			// 		'crimeData' => $a[0]['crimeData'],
			// 		'policeData' => $a[0]['policeData'],
			// 		'trafficData' => $a[0]['trafficData'],
			// 		'0to14' => $a[0]['0to14'],
			// 		'15to64' => $a[0]['15to64'],
			// 		'65up' => $a[0]['65up'],
			// 		'unknow_age' => $a[0]['unknow_age']
			// 	]
			// );

			// $array = array_merge($returnArray,$returnArray2);
			
			echo json_encode($returnArray);
		}else{
			echo "本系統尚未收納此地區資料";
		}
	}else{
		echo "444";
	}

}


	// *** 
	// 	傳入值：$_POST['areaid']

	// 		crimeData : 犯罪數量
	// 		policeData : 警局數量
	// 		trafficData : 車禍數量
	// 		man : 男人數量
	// 		woman : 女人數量
	// ***


public function areaData($areaId=null){
		// $areaId= "13";
	if(isset($_GET['areaId']) && $_GET['areaId']){
		$returnArray = $this->api_model->get_AreaData($_GET['areaId']);
		echo json_encode($returnArray);
	}else if($areaId){
		$returnArray = $this->api_model->get_AreaData($areaId);
		return $returnArray;
	}else{
		echo "請使用正確API方式";
	}

}

public function getSearchJson(){
	$url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query='.preg_replace('/\s(?=)/', '', $_POST['searchText']).'&key=AIzaSyDXdusGmRw8Jk-mvzTy220ilPkjDcbDrVg&language='.'Taiwan';
		//echo $url;
	$text = "";
	$lines_array = file($url);
	for($i=0;$i<count($lines_array);$i++){
		$text .= $lines_array[$i];
	}
		//print_r($lines_array);
	echo $text;
		//echo $lines_array;
}

public function getWikiSearch(){
	$url = 'http://signalr.tn.edu.tw/OWikipedia/api/abstract/'.urlencode($_POST['searchText']);
	$text = "";
	$lines_array = file($url);
		// $lines_string = implode('', $lines_array);
		// eregi("<pre(.*)</pre>", $ine_string, $text);
	for($i=0;$i<count($lines_array);$i++){
		$text .= $lines_array[$i];
	}
	echo $lines_array[0];
}


}


?>