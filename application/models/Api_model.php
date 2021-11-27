<?php 
class Api_model extends CI_Model{
	
	public function __destruct() {  
		$this->db->close();  
	}

	public function catch_api($school,$county,$get){
		$array = Array();


		

      //接入資料

      // $searchJson=json_decode($data['searchJson'],true);
      // $service = "service_score.";
      // $service_footprint = "service_footprint.";

		if(strcmp($school,'"elementary"')==0){
			$select="ES";
			$from="elementary_school";
			$computer = "elementary_computer";
			$type="elementary";
			$type1="E";
		}else{
			$select="JS";
			$from="junior_school"; 
			$computer = "junior_computer";
			$type="junior";
			$type1="J";
		}

		$this->db->select("DISTINCT ".$select."_name,".$type."_computer.".$type1."C_city,".$select."_longitude,".$select."_latitude,".$select."_address,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);
		$this->db->select($type."_computer.".$type1."C_CNT",false);
		$this->db->select($type1."B_area,".$type1."B_hall,".$type1."B_classroom",false);
		$this->db->select($type1."ST_CNT_1,".$type1."ST_CNT_0,".$type1."NA_CNT_1,".$type1."NA_CNT_0,".$type1."NI_CNT_1,".$type1."NI_CNT_0");
		$this->db->select($type1."TN_CNT,".$type1."TN_CNT_1,".$type1."TN_CNT_0,".$type1."SN_CNT,".$type1."SN_CNT_1,".$type1."SN_CNT_0");
		
		$this->db->from($type."_school,".$type."_computer");
		$this->db->where("SUBSTRING(".$type."_school.".$select."_name,-4) =",$type."_computer.".$type1."C_school",FALSE);
		$this->db->where("SUBSTRING(".$type."_school.".$select."_city,5,6) =",$type."_computer.".$type1."C_city",FALSE);
		$this->db->where("SUBSTRING(".$type."_school.".$select."_city,5) =",$type."_computer.".$type1."C_city",FALSE);	
		$this->db->like($select."_city",substr($county,1,strlen($county)-2));
		$this->db->join($type."_student_total",$type."_school.".$select."_key=".$type."_student_total.".$select."_key");
		$this->db->join($type."_building",$type."_school.".$select."_key=".$type."_building.".$select."_key");
		$this->db->join($type."_teacher_number",$type."_school.".$select."_key=".$type."_teacher_number.".$select."_key");
		$this->db->join($type."_student_number",$type."_student_number.".$select."_key =".$type."_school.".$select."_key");
		$this->db->join($type."_class_number",$type."_class_number.".$select."_key =" .$type."_school.".$select."_key");





		if($school == '"elementary"'){
			$this->db->select($type1."SN_CNT_11,".$type1."SN_CNT_10,".$type1."SN_CNT_21,".$type1."SN_CNT_20,".$type1."SN_CNT_31,".$type1."SN_CNT_30,".$type1."SN_CNT_41,".$type1."SN_CNT_40,".$type1."SN_CNT_51,".$type1."SN_CNT_50,".$type1."SN_CNT_61,".$type1."SN_CNT_60");
			$this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3,".$type1."CN_CNT_4,".$type1."CN_CNT_5,".$type1."CN_CNT_6");
		}else{
			$this->db->select($type1."SN_CNT_11,".$type1."SN_CNT_10,".$type1."SN_CNT_21,".$type1."SN_CNT_20,".$type1."SN_CNT_31,".$type1."SN_CNT_30");
			$this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3");
		}

		// if($school == '"elementary"'){
		// 	$this->db->select($type1."SN_CNT_11,".$type1."SN_CNT_10,".$type1."SN_CNT_21,".$type1."SN_CNT_20,".$type1."SN_CNT_31,".$type1."SN_CNT_30,".$type1."SN_CNT_41,".$type1."SN_CNT_40,".$type1."SN_CNT_51,".$type1."SN_CNT_50,".$type1."SN_CNT_61,".$type1."SN_CNT_60");
		// 	$this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3,".$type1."CN_CNT_4,".$type1."CN_CNT_5,".$type1."CN_CNT_6");
		// }else{
		// 	$this->db->select($type1."SN_CNT_11,".$type1."SN_CNT_10,".$type1."SN_CNT_21,".$type1."SN_CNT_20,".$type1."SN_CNT_31,".$type1."SN_CNT_30");
		// 	$this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3");
		// }


		if(isset($get["schoolComputer_value"])){
        // $this->db->join($type."_computer",$type."_school.".$select."_city=".$type."_computer.".$type1."C_city");

			$schoolComputer_value = explode(",", $get["schoolComputer_value"]);
			if(substr($schoolComputer_value[0],1) == "less"){	
				$this->db->where($type."_computer.".$type1."C_CNT <=",substr($schoolComputer_value[1], 0,strlen($schoolComputer_value[1])-1),FALSE);

			}else if (substr($schoolComputer_value[0],1) == "more"){

				$this->db->where($type."_computer.".$type1."C_CNT >=",substr($schoolComputer_value[1], 0,strlen($schoolComputer_value[1])-1),FALSE);

			}else{
				return "[]";
			}

		}


       //學生總人數查詢
		if(isset($get["total_value"])){
			$total_value = explode(",",$get["total_value"]);
			

          // echo $total_value[0];
			if(substr($total_value[0], 1) == "less"){
				
				$this->db->where($type."_student_total.".$select."T_CNT_1 +".$type."_student_total.".$select."T_CNT_0 <=",substr($total_value[1], 0,strlen($total_value[1])-1),FALSE);
			}else if(substr($total_value[0], 1) == "more"){

				$this->db->where($type."_student_total.".$select."T_CNT_1 +".$type."_student_total.".$select."T_CNT_0 >=",substr($total_value[1], 0,strlen($total_value[1])-1),FALSE);
			}else{
				return "[]";
			}
		}

       //原住民學生數是否搜索
		if(isset($get["aboriginal_value"])){

			$aboriginal_value = explode(",",$get["aboriginal_value"]);

			if(substr($aboriginal_value[0], 1) == "less"){
				$this->db->where($type."_student_total.".$type1."NA_CNT <=",substr($aboriginal_value[1], 0,strlen($aboriginal_value[1])-1),FALSE);
			}else if(substr($aboriginal_value[0], 1) == "more"){      		
				$this->db->where($type."_student_total.".$type1."NA_CNT >=",substr($aboriginal_value[1], 0,strlen($aboriginal_value[1])-1),FALSE);
			}else{
				return "[]";
			}
		}

     //新住民家庭學生數是否搜索
		if(isset($get["immigrants_value"])){

			$immigrants_value = explode(",",$get["immigrants_value"]);

			if(substr($immigrants_value[0], 1)=="less"){

				$this->db->where($type."_student_total.".$type1."NI_CNT <=",substr($immigrants_value[1], 0,strlen($immigrants_value[1])-1),FALSE);
			}else if(substr($immigrants_value[0], 1)=="more"){

				$this->db->where($type."_student_total.".$type1."NI_CNT >=",substr($immigrants_value[1], 0,strlen($immigrants_value[1])-1),FALSE);
			}else{
				return "[]";
			}
		}


    //偏鄉學校是否搜尋
		if(isset($get["faraway"])){
			if($get["faraway"] == '"1"'){
				$this->db->join($type."_faraway",$type."_school.".$select."_key=".$type."_faraway.".$select."_key");
			}
		}
	//教育優先區搜尋
		if(isset($get["EPA"])){
			if($get["EPA"] == '"1"'){
				$this->db->join("educational_priority_areas",$type."_school.".$select."_key="."EP_key");
			}
		}

    // //職員總數是否搜尋
		if(isset($get["teacher_value"])){
			$teacher_value = explode(",", $get["teacher_value"]);

			if(substr($teacher_value[0], 1) == "less"){
				$this->db->where($type."_teacher_number.".$type1."TN_CNT +".$type."_teacher_number.".$type1."SN_CNT <=",substr($teacher_value[1], 0,strlen($teacher_value[1])-1),FALSE);
			}else if (substr($teacher_value[0], 1) == "more"){
				$this->db->where("`".$type."_teacher_number`.`".$type1."TN_CNT`+`".$type."_teacher_number`.`".$type1."SN_CNT` >=",substr($teacher_value[1], 0,strlen($teacher_value[1])-1),FALSE);  
			}else{
				return "[]";
			}
		}

    // //校地面積是否搜尋
		if(isset($get["schoolArea_value"])){
			$schoolArea_value = explode(",", $get["schoolArea_value"]);

			if(substr($schoolArea_value[0], 1)=="less"){
				$this->db->where($type."_building.".$type1."B_area <=",substr($schoolArea_value[1], 0,strlen($schoolArea_value[1])-1),FALSE);
			}else if (substr($schoolArea_value[0], 1)=="more"){
				$this->db->where($type."_building.".$type1."B_area >=",substr($schoolArea_value[1], 0,strlen($schoolArea_value[1])-1),FALSE);
			}else{
				return "[]";
			}
		}


    //禮堂座數是否搜索
		if(isset($get["hall_value"])){
			$hall_value = explode(",", $get["hall_value"]);

			if(substr($hall_value[0], 1)=="less"){

				$this->db->where($type."_building.".$type1."B_hall <=",substr($hall_value[1], 0,strlen($hall_value[1])-1),FALSE);
			}else if(substr($hall_value[0], 1)=="more"){

				$this->db->where($type."_building.".$type1."B_hall >=",substr($hall_value[1], 0,strlen($hall_value[1])-1),FALSE);
			}else{
				return "[]";
			}
		}

    //教室間數是否搜索
		if(isset($get["schoolClass_value"])){
			$schoolClass_value = explode(",", $get["schoolClass_value"]);
			if(substr($schoolClass_value[0], 1)=="less"){

				$this->db->where($type."_building.".$type1."B_classroom <=",substr($schoolClass_value[1], 0,strlen($schoolClass_value[1])-1),FALSE);
			}else if(substr($schoolClass_value[0], 1)=="more"){

				$this->db->where($type."_building.".$type1."B_classroom >=",substr($schoolClass_value[1], 0,strlen($schoolClass_value[1])-1),FALSE);
			}else{
				return "[]";
			}
		}






		$result=$this->db->get()->result_array();

      // print_r($result);

      // // if($searchJson["source"]==0){

		if(isset($get["schoolComputer_value"]) || isset($get["total_value"]) || isset($get["aboriginal_value"]) ||
			isset($get["immigrants_value"]) || isset($get["faraway"]) || isset($get["EPA"]) || isset($get["teacher_value"]) ||
			isset($get["schoolArea_value"]) || isset($get["hall_value"]) || isset($get["schoolClass_value"]) || isset($get["datatype"])){


			if($school == '"elementary"'){

				foreach ($result as $row) {
					//不使用datatype時 全部回傳
					if(!isset($get["datatype"])){
						$array[] = array
						(
							"school" => [
								"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
								"addr"=> $row[$select."_address"],
								"name"=> $row[$select."_name"],
								"number"=> $row[$select."_key"],
								"url"=> $row[$select."_url"],
								"phone"=>$row[$select."_phone"]
							],


							"building" => [
								"areaContent" => $row[$type1."B_area"],
								"computerContent" => $row[$type1."C_CNT"],
								"hallContent" => $row[$type1."B_hall"],
								"classContent" => $row[$type1."B_classroom"]       
							],

							"studentClass" =>[
								"1Male" => $row[$type1."SN_CNT_11"],
								"2Male" => $row[$type1."SN_CNT_21"],
								"3Male" => $row[$type1."SN_CNT_31"],
								"4Male" => $row[$type1."SN_CNT_41"],
								"5Male" => $row[$type1."SN_CNT_51"],
								"6Male" => $row[$type1."SN_CNT_61"],
								"1Female" => $row[$type1."SN_CNT_10"],
								"2Female" => $row[$type1."SN_CNT_20"],
								"3Female" => $row[$type1."SN_CNT_30"],
								"4Female" => $row[$type1."SN_CNT_40"],
								"5Female" => $row[$type1."SN_CNT_50"],
								"6Female" => $row[$type1."SN_CNT_60"],
								"1Class" => $row[$type1."CN_CNT_1"],
								"2Class" => $row[$type1."CN_CNT_2"],
								"3Class" => $row[$type1."CN_CNT_3"],
								"4Class" => $row[$type1."CN_CNT_4"],
								"5Class" => $row[$type1."CN_CNT_5"],
								"6Class" => $row[$type1."CN_CNT_6"],
								"allClass" => $row[$type1."CN_CNT_1"]+ $row[$type1."CN_CNT_2"]+ $row[$type1."CN_CNT_3"]+ $row[$type1."CN_CNT_4"]+ $row[$type1."CN_CNT_5"]+ $row[$type1."CN_CNT_6"]
							],

							"studentPart" =>[
								"aboriginalMale" => $row[$type1."NA_CNT_1"],
								"colonialMale" => $row[$type1."NI_CNT_1"],
								"ordinaryMale" => $row[$type1."ST_CNT_1"]-($row[$type1."NA_CNT_1"]+$row[$type1."NI_CNT_1"]),
								"aboriginalFemale" =>$row[$type1."NA_CNT_0"] ,
								"colonialFemale" =>$row[$type1."NI_CNT_0"],
								"ordinaryFemale" => $row[$type1."ST_CNT_0"]-($row[$type1."NA_CNT_0"]+$row[$type1."NI_CNT_0"]),
								"allStudent" => $row[$type1."ST_CNT_1"]+$row[$type1."ST_CNT_0"]

							],

							"teacherPart" =>[
								"regularMale" => $row[$type1."TN_CNT_1"],
								"regularFemale" => $row[$type1."TN_CNT_0"],
								"teacherMale" => $row[$type1."SN_CNT_1"],
								"teacherFemale" => $row[$type1."SN_CNT_0"],
								"regularAll" => $row[$type1."TN_CNT"],
								"teacherAll" => $row[$type1."SN_CNT"]
							]

						);

					}	
					//使用datatype 依照get值回傳相對應的資料
					if(isset($get["datatype"])){
						if(strcasecmp($get["datatype"], '"all"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],


								"building" => [
									"areaContent" => $row[$type1."B_area"],
									"computerContent" => $row[$type1."C_CNT"],
									"hallContent" => $row[$type1."B_hall"],
									"classContent" => $row[$type1."B_classroom"]       
								],

								"studentClass" =>[
									"1Male" => $row[$type1."SN_CNT_11"],
									"2Male" => $row[$type1."SN_CNT_21"],
									"3Male" => $row[$type1."SN_CNT_31"],
									"4Male" => $row[$type1."SN_CNT_41"],
									"5Male" => $row[$type1."SN_CNT_51"],
									"6Male" => $row[$type1."SN_CNT_61"],
									"1Female" => $row[$type1."SN_CNT_10"],
									"2Female" => $row[$type1."SN_CNT_20"],
									"3Female" => $row[$type1."SN_CNT_30"],
									"4Female" => $row[$type1."SN_CNT_40"],
									"5Female" => $row[$type1."SN_CNT_50"],
									"6Female" => $row[$type1."SN_CNT_60"],
									"1Class" => $row[$type1."CN_CNT_1"],
									"2Class" => $row[$type1."CN_CNT_2"],
									"3Class" => $row[$type1."CN_CNT_3"],
									"4Class" => $row[$type1."CN_CNT_4"],
									"5Class" => $row[$type1."CN_CNT_5"],
									"6Class" => $row[$type1."CN_CNT_6"],
									"allClass" => $row[$type1."CN_CNT_1"]+ $row[$type1."CN_CNT_2"]+ $row[$type1."CN_CNT_3"]+ $row[$type1."CN_CNT_4"]+ $row[$type1."CN_CNT_5"]+ $row[$type1."CN_CNT_6"]
								],

								"studentPart" =>[
									"aboriginalMale" => $row[$type1."NA_CNT_1"],
									"colonialMale" => $row[$type1."NI_CNT_1"],
									"ordinaryMale" => $row[$type1."ST_CNT_1"]-($row[$type1."NA_CNT_1"]+$row[$type1."NI_CNT_1"]),
									"aboriginalFemale" =>$row[$type1."NA_CNT_0"] ,
									"colonialFemale" =>$row[$type1."NI_CNT_0"],
									"ordinaryFemale" => $row[$type1."ST_CNT_0"]-($row[$type1."NA_CNT_0"]+$row[$type1."NI_CNT_0"]),
									"allStudent" => $row[$type1."ST_CNT_1"]+$row[$type1."ST_CNT_0"]

								],

								"teacherPart" =>[
									"regularMale" => $row[$type1."TN_CNT_1"],
									"regularFemale" => $row[$type1."TN_CNT_0"],
									"teacherMale" => $row[$type1."SN_CNT_1"],
									"teacherFemale" => $row[$type1."SN_CNT_0"],
									"regularAll" => $row[$type1."TN_CNT"],
									"teacherAll" => $row[$type1."SN_CNT"]
								]

							);
						}elseif(strcasecmp($get["datatype"], '"teacherPart"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"teacherPart" =>[
									"regularMale" => $row[$type1."TN_CNT_1"],
									"regularFemale" => $row[$type1."TN_CNT_0"],
									"teacherMale" => $row[$type1."SN_CNT_1"],
									"teacherFemale" => $row[$type1."SN_CNT_0"],
									"regularAll" => $row[$type1."TN_CNT"],
									"teacherAll" => $row[$type1."SN_CNT"]
								]
							);
						}elseif(strcasecmp($get["datatype"], '"studentPart"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"studentPart" =>[
									"aboriginalMale" => $row[$type1."NA_CNT_1"],
									"colonialMale" => $row[$type1."NI_CNT_1"],
									"ordinaryMale" => $row[$type1."ST_CNT_1"]-($row[$type1."NA_CNT_1"]+$row[$type1."NI_CNT_1"]),
									"aboriginalFemale" =>$row[$type1."NA_CNT_0"] ,
									"colonialFemale" =>$row[$type1."NI_CNT_0"],
									"ordinaryFemale" => $row[$type1."ST_CNT_0"]-($row[$type1."NA_CNT_0"]+$row[$type1."NI_CNT_0"]),
									"allStudent" => $row[$type1."ST_CNT_1"]+$row[$type1."ST_CNT_0"]

								],
							);
						}elseif(strcasecmp($get["datatype"], '"studentClass"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"studentClass" =>[
									"1Male" => $row[$type1."SN_CNT_11"],
									"2Male" => $row[$type1."SN_CNT_21"],
									"3Male" => $row[$type1."SN_CNT_31"],
									"4Male" => $row[$type1."SN_CNT_41"],
									"5Male" => $row[$type1."SN_CNT_51"],
									"6Male" => $row[$type1."SN_CNT_61"],
									"1Female" => $row[$type1."SN_CNT_10"],
									"2Female" => $row[$type1."SN_CNT_20"],
									"3Female" => $row[$type1."SN_CNT_30"],
									"4Female" => $row[$type1."SN_CNT_40"],
									"5Female" => $row[$type1."SN_CNT_50"],
									"6Female" => $row[$type1."SN_CNT_60"],
									"1Class" => $row[$type1."CN_CNT_1"],
									"2Class" => $row[$type1."CN_CNT_2"],
									"3Class" => $row[$type1."CN_CNT_3"],
									"4Class" => $row[$type1."CN_CNT_4"],
									"5Class" => $row[$type1."CN_CNT_5"],
									"6Class" => $row[$type1."CN_CNT_6"],
									"allClass" => $row[$type1."CN_CNT_1"]+ $row[$type1."CN_CNT_2"]+ $row[$type1."CN_CNT_3"]+ $row[$type1."CN_CNT_4"]+ $row[$type1."CN_CNT_5"]+ $row[$type1."CN_CNT_6"]
								],
							);
						}elseif(strcasecmp($get["datatype"], '"building"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"building" => [
									"areaContent" => $row[$type1."B_area"],
									"computerContent" => $row[$type1."C_CNT"],
									"hallContent" => $row[$type1."B_hall"],
									"classContent" => $row[$type1."B_classroom"]       
								],
							);
						}
					}

				}


			}else{
				foreach ($result as $row) {
					//不使用datatype時 全部回傳
					if(!isset($get["datatype"])){
						$array[] = array
						(
							"school" => [
								"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
								"addr"=> $row[$select."_address"],
								"name"=> $row[$select."_name"],
								"number"=> $row[$select."_key"],
								"url"=> $row[$select."_url"],
								"phone"=>$row[$select."_phone"]
							],

							"building" => [
								"areaContent" => $row[$type1."B_area"],
								"computerContent" => $row[$type1."C_CNT"],
								"hallContent" => $row[$type1."B_hall"],
								"classContent" => $row[$type1."B_classroom"]       
							],

							"studentClass" =>[
								"1Male" => $row[$type1."SN_CNT_11"],
								"2Male" => $row[$type1."SN_CNT_21"],
								"3Male" => $row[$type1."SN_CNT_31"],

								"1Female" => $row[$type1."SN_CNT_10"],
								"2Female" => $row[$type1."SN_CNT_20"],
								"3Female" => $row[$type1."SN_CNT_30"],

								"1Class" => $row[$type1."CN_CNT_1"],
								"2Class" => $row[$type1."CN_CNT_2"],
								"3Class" => $row[$type1."CN_CNT_3"],

								"allClass" => $row[$type1."CN_CNT_1"]+ $row[$type1."CN_CNT_2"]+ $row[$type1."CN_CNT_3"]
							],

							"studentPart" =>[
								"aboriginalMale" => $row[$type1."NA_CNT_1"],
								"colonialMale" => $row[$type1."NI_CNT_1"],
								"ordinaryMale" => $row[$type1."ST_CNT_1"],
								"aboriginalFemale" =>$row[$type1."NA_CNT_0"] ,
								"colonialFemale" =>$row[$type1."NI_CNT_0"],
								"ordinaryFemale" => $row[$type1."ST_CNT_0"],
								"allStudent" => $row[$type1."NA_CNT_1"]+$row[$type1."NI_CNT_1"]+$row[$type1."ST_CNT_1"]+$row[$type1."NA_CNT_0"]+$row[$type1."NI_CNT_0"]+ $row[$type1."ST_CNT_0"]
							],

							"teacherPart" =>[
								"regularMale" => $row[$type1."TN_CNT_1"],
								"regularFemale" => $row[$type1."TN_CNT_0"],
								"teacherMale" => $row[$type1."SN_CNT_1"],
								"teacherFemale" => $row[$type1."SN_CNT_0"],
								"regularAll" => $row[$type1."TN_CNT"],
								"teacherAll" => $row[$type1."SN_CNT"]
							]
						);
					}

					if(isset($get["datatype"])){
						if(strcasecmp($get["datatype"], '"all"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],

								"building" => [
									"areaContent" => $row[$type1."B_area"],
									"computerContent" => $row[$type1."C_CNT"],
									"hallContent" => $row[$type1."B_hall"],
									"classContent" => $row[$type1."B_classroom"]       
								],

								"studentClass" =>[
									"1Male" => $row[$type1."SN_CNT_11"],
									"2Male" => $row[$type1."SN_CNT_21"],
									"3Male" => $row[$type1."SN_CNT_31"],

									"1Female" => $row[$type1."SN_CNT_10"],
									"2Female" => $row[$type1."SN_CNT_20"],
									"3Female" => $row[$type1."SN_CNT_30"],

									"1Class" => $row[$type1."CN_CNT_1"],
									"2Class" => $row[$type1."CN_CNT_2"],
									"3Class" => $row[$type1."CN_CNT_3"],

									"allClass" => $row[$type1."CN_CNT_1"]+ $row[$type1."CN_CNT_2"]+ $row[$type1."CN_CNT_3"]
								],

								"studentPart" =>[
									"aboriginalMale" => $row[$type1."NA_CNT_1"],
									"colonialMale" => $row[$type1."NI_CNT_1"],
									"ordinaryMale" => $row[$type1."ST_CNT_1"],
									"aboriginalFemale" =>$row[$type1."NA_CNT_0"] ,
									"colonialFemale" =>$row[$type1."NI_CNT_0"],
									"ordinaryFemale" => $row[$type1."ST_CNT_0"],
									"allStudent" => $row[$type1."NA_CNT_1"]+$row[$type1."NI_CNT_1"]+$row[$type1."ST_CNT_1"]+$row[$type1."NA_CNT_0"]+$row[$type1."NI_CNT_0"]+ $row[$type1."ST_CNT_0"]
								],

								"teacherPart" =>[
									"regularMale" => $row[$type1."TN_CNT_1"],
									"regularFemale" => $row[$type1."TN_CNT_0"],
									"teacherMale" => $row[$type1."SN_CNT_1"],
									"teacherFemale" => $row[$type1."SN_CNT_0"],
									"regularAll" => $row[$type1."TN_CNT"],
									"teacherAll" => $row[$type1."SN_CNT"]
								]
							);
						}
						elseif(strcasecmp($get["datatype"], '"teacherPart"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"teacherPart" =>[
									"regularMale" => $row[$type1."TN_CNT_1"],
									"regularFemale" => $row[$type1."TN_CNT_0"],
									"teacherMale" => $row[$type1."SN_CNT_1"],
									"teacherFemale" => $row[$type1."SN_CNT_0"],
									"regularAll" => $row[$type1."TN_CNT"],
									"teacherAll" => $row[$type1."SN_CNT"]
								]
							);
						}elseif(strcasecmp($get["datatype"], '"studentPart"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"studentPart" =>[
									"aboriginalMale" => $row[$type1."NA_CNT_1"],
									"colonialMale" => $row[$type1."NI_CNT_1"],
									"ordinaryMale" => $row[$type1."ST_CNT_1"],
									"aboriginalFemale" =>$row[$type1."NA_CNT_0"] ,
									"colonialFemale" =>$row[$type1."NI_CNT_0"],
									"ordinaryFemale" => $row[$type1."ST_CNT_0"],
									"allStudent" => $row[$type1."NA_CNT_1"]+$row[$type1."NI_CNT_1"]+$row[$type1."ST_CNT_1"]+$row[$type1."NA_CNT_0"]+$row[$type1."NI_CNT_0"]+ $row[$type1."ST_CNT_0"]
								],
							);
						}elseif(strcasecmp($get["datatype"], '"studentClass"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"studentClass" =>[
									"1Male" => $row[$type1."SN_CNT_11"],
									"2Male" => $row[$type1."SN_CNT_21"],
									"3Male" => $row[$type1."SN_CNT_31"],

									"1Female" => $row[$type1."SN_CNT_10"],
									"2Female" => $row[$type1."SN_CNT_20"],
									"3Female" => $row[$type1."SN_CNT_30"],

									"1Class" => $row[$type1."CN_CNT_1"],
									"2Class" => $row[$type1."CN_CNT_2"],
									"3Class" => $row[$type1."CN_CNT_3"],

									"allClass" => $row[$type1."CN_CNT_1"]+ $row[$type1."CN_CNT_2"]+ $row[$type1."CN_CNT_3"]
								],
							);
						}elseif(strcasecmp($get["datatype"], '"building"') == 0){
							$array[] = array
							(
								"school" => [
									"position"=>$row[$select."_longitude"].",".$row[$select."_latitude"], 
									"addr"=> $row[$select."_address"],
									"name"=> $row[$select."_name"],
									"number"=> $row[$select."_key"],
									"url"=> $row[$select."_url"],
									"phone"=>$row[$select."_phone"]
								],
								"building" => [
									"areaContent" => $row[$type1."B_area"],
									"computerContent" => $row[$type1."C_CNT"],
									"hallContent" => $row[$type1."B_hall"],
									"classContent" => $row[$type1."B_classroom"]       
								],
							);
						}
					}
				}
			}
		}

		return $array;
	}


	/* 人口圖 */
	public function get_AreaData($areaId){
		$this->db->select("crime.crime_cnt,".
			"police_station.station_cnt,".
			"population_statistics.0to14,".
			"population_statistics.15to64,".
			"population_statistics.65up,".
			"population_statistics.unknow_age,".
			"population_statistics.t_men,".
			"population_statistics.t_women,".
			"traffic_accident.accident_cnt"
			,false);
		$this->db->from("country_area");
		$this->db->where("country_area.id = ", $areaId,false);
		$this->db->join("crime","country_area.id = crime.id");
		$this->db->join("police_station","country_area.id = police_station.id");
		$this->db->join("population_statistics","country_area.id = population_statistics.id");
		$this->db->join("traffic_accident","country_area.id = traffic_accident.id");
		$result = $this->db->get()->result();

		foreach ($result as $key => $row) {
			$array[] = array
			(
				'crimeData' => $row->{"crime_cnt"},
				'policeData' => $row->{"station_cnt"},
				'trafficData' => $row->{"accident_cnt"},
				'0to14' => $row->{"0to14"},
				'15to64' => $row->{"15to64"},
				'65up' => $row->{"65up"},
				'unknow_age' => $row->{"unknow_age"},
				'man' => $row->{"t_men"},
				'woman' => $row->{"t_women"}

			);
		}
		if(isset($array)){
			return $array;
		}
	}

	public function get_otherAreaData($areaId){
		$this->db->select("0to14,".
			"15to64,".
			"65up,".
			"unknow_age"
			,false);
		$this->db->from("population_statistics");
		$this->db->where("id = ", $areaId,false);
		$result = $this->db->get()->result();
		foreach ($result as $key => $row) {
			$str[0] = $row->{"0to14"}.",".$row->{"15to64"}.",".$row->{"65up"}.",".$row->{"unknow_age"};
		}

		// $this->db->select("season_one,".
		// 	"season_two,".
		// 	"season_three,".
		// 	"season_four"
		// 	,false);
		// $this->db->from("real_estate");
		// $this->db->where("id = ", $areaId,false);
		// $result = $this->db->get()->result();
		// $i=1;
		// foreach ($result as $key => $row) {
		// 	$str[$i] = $row->{"season_one"}.",".$row->{"season_two"}.",".$row->{"season_three"}.",".$row->{"season_four"};
		// 	$i++;
		// }
		return $str;
	}

	public function get_crimeMax(){

		$this->db->select("max(crime_cnt/(population_statistics.t_men+population_statistics.t_women)) as total",false);

		$this->db->join("population_statistics","population_statistics.id = crime.id");
		$this->db->join("country_area","country_area.id = crime.id");
		$result = $this->db->get("crime");
		if($result->num_rows()==1){
			return $result->row(0)->total;
		}else{
			return false;
		}

	}

	public function get_crimeMin(){

		$this->db->select("min(crime_cnt/(population_statistics.t_men+population_statistics.t_women)) as total",false);
		$this->db->join("population_statistics","population_statistics.id = crime.id");
		$this->db->join("country_area","country_area.id = crime.id");
		$result = $this->db->get("crime");
		if($result->num_rows()==1){
			return $result->row(0)->total;
		}else{
			return false;
		}

	}

	public function get_trafficMax(){

		$this->db->select("max(accident_cnt/(population_statistics.t_men+population_statistics.t_women)) as total",false);
		$this->db->join("population_statistics","population_statistics.id = traffic_accident.id");
		$this->db->join("country_area","country_area.id = traffic_accident.id");

		$result = $this->db->get("traffic_accident");
		if($result->num_rows()==1){
			return $result->row(0)->total;
		}else{
			return false;
		}

	}

	public function get_trafficMin(){
		$this->db->select("min(accident_cnt/(population_statistics.t_men+population_statistics.t_women)) as total",false);

		$this->db->join("population_statistics","population_statistics.id = traffic_accident.id");
		$this->db->join("country_area","country_area.id = traffic_accident.id");
		$result = $this->db->get("traffic_accident");
		if($result->num_rows()==1){
			return $result->row(0)->total;
		}else{
			return false;
		}

	}

	public function get_CountryArea(){
		$result = $this->db->get('country_area')->result();
		return $result;
	}

	public function get_middle_income(){
		$result = $this->db->get('low_middle_income_households')->result();
		return $result;
	}

	public function get_low_income(){
		$result = $this->db->get('low_income_households')->result();
		return $result;
	}




}

?>