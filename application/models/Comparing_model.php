<?php

class Comparing_model extends CI_Model{

	public function __destruct() {  
	    $this->db->close();  
	}

	public function compare($data){
		$school = $data["school"];
		// $school_id = $data["id"];
		$school_id = explode(",", $data["id"]);
		// print_r($school_id);
		$array = Array();
		// print_r($_POST);
		if(strcmp($school,"elementary")==0){
        $select="ES";
        $from="elementary_school";
        $type="elementary";
        $type1="E";
      	}else{
          $select="JS";
          $from="junior_school"; 
          $type="junior";
          $type1="J";
      	}
		
 	    //building
		$this->db->select("DISTINCT ".$from.".".$type1."S_key,".$select."_name,".$type."_computer.".$type1."C_city,".$type."_computer.".$type1."C_CNT",false);
		$this->db->select($type1."B_area,".$type1."B_hall,".$type1."B_classroom",false);
		$this->db->join($type."_building",$type."_building.".$select."_key =".$type."_school.".$select."_key");
		$this->db->from($type."_school,".$type."_computer");
		
		$this->db->where("SUBSTRING(".$type."_school.".$select."_name,-4) =",$type."_computer.".$type1."C_school",FALSE);
		$this->db->where("SUBSTRING(".$type."_school.".$select."_city,5,6) =",$type."_computer.".$type1."C_city",FALSE);
		$this->db->where("SUBSTRING(".$type."_school.".$select."_city,5) =",$type."_computer.".$type1."C_city",FALSE);
		//school
		$this->db->select($select."_longitude,".$select."_latitude,".$select."_address,".$select."_name,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);

		//studentPart
		$this->db->select($type1."ST_CNT_1,".$type1."ST_CNT_0,".$type1."NA_CNT,".$type1."NI_CNT,".$type1."ST_CNT_1,".$type1."ST_CNT_0");
		$this->db->join($type."_student_total",$type."_student_total.".$select."_key =".$type."_school.".$select."_key");

   		 //studentClass

		if($school == "elementary"){

			$this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3,".$type1."CN_CNT_4,".$type1."CN_CNT_5,".$type1."CN_CNT_6");
		}else{

			$this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3");
		}

		$this->db->join($type."_class_number",$type."_class_number.".$select."_key =" .$type."_school.".$select."_key");

		//teacherPart
		$this->db->select($type1."TN_CNT,".$type1."SN_CNT");
		$this->db->join($type."_teacher_number",$type."_teacher_number.".$select."_key =".$type."_school.".$select."_key");
		for($i=0;$i<count($school_id);$i++){
			if($i==0){
				$this->db->where("(".$type."_school.".$select."_key =",$school_id[$i],false);
			}else if($i==count($school_id)-1){
				$this->db->or_where($type."_school.".$select."_key =",$school_id[$i].")",false);
			}else{
				$this->db->or_where($type."_school.".$select."_key =",$school_id[$i],false);
			}
		}		
		$result=$this->db->get()->result_array();

		$i = 0;
		// print_r($result);
		if($school == "elementary"){
			foreach ($result as $row) {
				// print_r($result[$i][$select."_name"]);
				$sorcedata=$this->comparing_model->checksource($result[$i][$select."_key"]);
				$array=array(
					array("school" =>
						[
							"name"=> $result[$i][$select."_name"],
							"phone"=>$result[$i][$select."_phone"],
							"addr"=> $result[$i][$select."_address"],
							"url"=> $result[$i][$select."_url"],
							"position"=>$result[$i][$select."_longitude"].",".$result[$i][$select."_latitude"],
						],


						"building" =>[
							"areaContent" => $result[$i][$type1."B_area"],
							"computerContent" => $result[$i][$type1."C_CNT"],
							"hallContent" => $result[$i][$type1."B_hall"],
							"classContent" => $result[$i][$type1."B_classroom"]    
						],

						"studentPart" =>[
							"aboriginal"  =>$result[$i][$type1."NA_CNT"], 
							"colonial"    =>$result[$i][$type1."NI_CNT"], 
							"ordinary"    =>$result[$i][$type1."ST_CNT_1"]+$result[$i][$type1."ST_CNT_0"]-($result[$i][$type1."NA_CNT"]+$result[$i][$type1."NI_CNT"]),
							"allClass"    =>$result[$i][$type1."CN_CNT_1"]+ $result[$i][$type1."CN_CNT_2"]+ $result[$i][$type1."CN_CNT_3"]+ $result[$i][$type1."CN_CNT_4"]+ $result[$i][$type1."CN_CNT_5"]+ $result[$i][$type1."CN_CNT_6"],
						"allStudent"  =>$result[$i][$type1."ST_CNT_1"]+$result[$i][$type1."ST_CNT_0"]//學生總數
					],

					"teacherPart"   =>[
						"regularAll"   =>$result[$i][$type1."TN_CNT"], 
						"teacherAll"   =>$result[$i][$type1."SN_CNT"]
					],

					"source"        => [
						"schoolCooperate"  =>floor_dec($sorcedata[0],2), //學校配合度
			            "studentCooperate" =>floor_dec($sorcedata[1],2), //學生配合度
			            "traffic"          =>floor_dec($sorcedata[2],2), //交通方便性
			            "around"           =>floor_dec($sorcedata[3],2)
			        ]
					)
					
				);
				if($i==0){
					$array1=$array;
				}else{
				$array1=array_merge($array1,$array);
				}
				$i++;
			}

		}else{
			foreach ($result as $row) {
				// print_r($result[$i][$select."_name"]);
				$sorcedata=$this->comparing_model->checksource($result[$i][$select."_key"]);
				$array=array(
					array("school" =>
						[
							"name"=> $result[$i][$select."_name"],
							"phone"=>$result[$i][$select."_phone"],
							"addr"=> $result[$i][$select."_address"],
							"url"=> $result[$i][$select."_url"],
							"position"=>$result[$i][$select."_longitude"].",".$result[$i][$select."_latitude"],
						],


						"building" =>[
							"areaContent" => $result[$i][$type1."B_area"],
							"computerContent" => $result[$i][$type1."C_CNT"],
							"hallContent" => $result[$i][$type1."B_hall"],
							"classContent" => $result[$i][$type1."B_classroom"]    
						],

						"studentPart" =>[
							"aboriginal"  =>$result[$i][$type1."NA_CNT"], 
							"colonial"    =>$result[$i][$type1."NI_CNT"], 
							"ordinary"    =>$result[$i][$type1."ST_CNT_1"]+$result[$i][$type1."ST_CNT_0"]-($result[$i][$type1."NA_CNT"]+$result[$i][$type1."NI_CNT"]),
							"allClass"    =>$result[$i][$type1."CN_CNT_1"]+ $result[$i][$type1."CN_CNT_2"]+ $result[$i][$type1."CN_CNT_3"],
						"allStudent"  =>$result[$i][$type1."ST_CNT_1"]+$result[$i][$type1."ST_CNT_0"]//學生總數
					],

					"teacherPart"   =>[
						"regularAll"   =>$result[$i][$type1."TN_CNT"], 
						"teacherAll"   =>$result[$i][$type1."SN_CNT"]
					],

					"source"        => [
						"schoolCooperate"  =>floor_dec($sorcedata[0],2), //學校配合度
			            "studentCooperate" =>floor_dec($sorcedata[1],2), //學生配合度
			            "traffic"          =>floor_dec($sorcedata[2],2), //交通方便性
			            "around"           =>floor_dec($sorcedata[3],2)
			        ]
					)
					
				);
				
				if($i==0){
					$array1=$array;
				}else{
				$array1=array_merge($array1,$array);
				}
				$i++;
			}
		}
		return $array1;
	}

	public function checksource($school_id){
    	$query = $this->db->get_where("service_score",array("SF_school_key" => $school_id));

    	if(!empty($query->row_array())){
      		$this->db->select("SS_value,"."SS_type,"."SUM(SS_value) / COUNT(SS_value) AS SS_AVG");
        	$this->db->from("service_score");
        	$this->db->where("SF_school_key",$school_id,FALSE);
        	$this->db->group_by("SF_school_key");
        	$this->db->group_by("SS_type");
        	$this->db->having("SS_type =",'1',FALSE);
        	$this->db->or_having("SS_type =",'2',FALSE);
        	$this->db->or_having("SS_type =",'3',FALSE);
        	$this->db->or_having("SS_type =",'4',FALSE);  
        	$result = $this->db->get()->result_array(); 

        	$StudentCooper = floor_dec($result[0]["SS_AVG"],2);
        	$SchoolCooper = floor_dec($result[1]["SS_AVG"],2);
        	$traffic = floor_dec($result[2]["SS_AVG"],2);
        	$around = floor_dec($result[3]["SS_AVG"],2);     
      	}else{
        	$StudentCooper = 5;
        	$SchoolCooper = 5;
        	$traffic = 5;
        	$around = 5;
      	}
      	$sorcedata1=array($StudentCooper,$SchoolCooper,$traffic,$around);
      	return $sorcedata1;		
  	}

}


//無條件捨去
function floor_dec($v, $precision){
    $c = pow(10, $precision);
    return floor($v*$c)/$c;
}