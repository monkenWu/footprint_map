<?php

class School_model extends CI_Model{

  public function __destruct() {  
      $this->db->close();  
  }

	public function schoolInfo($data){
    $school = $data["school"];
    $school_id = $data["id"];
    $array = Array();
    $service = "service_score.";
    $service_footprint = "service_footprint.";



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

    $this->db->select("DISTINCT ".$select."_name,".$type."_computer.".$type1."C_city,".$type."_computer.".$type1."C_CNT",false);
    $this->db->select($type1."B_area,".$type1."B_hall,".$type1."B_classroom",false);
    $this->db->from($type."_school,".$type."_computer");
    $this->db->join($type."_building",$type."_building.".$select."_key =".$type."_school.".$select."_key");
    $this->db->where("SUBSTRING(".$type."_school.".$select."_name,-4) =",$type."_computer.".$type1."C_school",FALSE);
    $this->db->where("SUBSTRING(".$type."_school.".$select."_city,5,6) =",$type."_computer.".$type1."C_city",FALSE);
    $this->db->where("SUBSTRING(".$type."_school.".$select."_city,5) =",$type."_computer.".$type1."C_city",FALSE);
    $this->db->where($type."_school.".$select."_key =",$school_id,false);

      //school
    $this->db->select($select."_longitude,".$select."_latitude,".$select."_address,".$select."_name,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);

      //studentClass

    if($school == "elementary"){
      $this->db->select($type1."SN_CNT_11,".$type1."SN_CNT_10,".$type1."SN_CNT_21,".$type1."SN_CNT_20,".$type1."SN_CNT_31,".$type1."SN_CNT_30,".$type1."SN_CNT_41,".$type1."SN_CNT_40,".$type1."SN_CNT_51,".$type1."SN_CNT_50,".$type1."SN_CNT_61,".$type1."SN_CNT_60");
      $this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3,".$type1."CN_CNT_4,".$type1."CN_CNT_5,".$type1."CN_CNT_6");
    }else{
      $this->db->select($type1."SN_CNT_11,".$type1."SN_CNT_10,".$type1."SN_CNT_21,".$type1."SN_CNT_20,".$type1."SN_CNT_31,".$type1."SN_CNT_30");
      $this->db->select($type1."CN_CNT_1,".$type1."CN_CNT_2,".$type1."CN_CNT_3");
    }





    $this->db->join($type."_student_number",$type."_student_number.".$select."_key =".$type."_school.".$select."_key");
    $this->db->join($type."_class_number",$type."_class_number.".$select."_key =" .$type."_school.".$select."_key");

      //studentPart
    $this->db->select($type1."ST_CNT_1,".$type1."ST_CNT_0,".$type1."NA_CNT_1,".$type1."NA_CNT_0,".$type1."NI_CNT_1,".$type1."NI_CNT_0");
    $this->db->join($type."_student_total",$type."_student_total.".$select."_key =".$type."_school.".$select."_key");

      //teacherPart
    $this->db->select($type1."TN_CNT,".$type1."TN_CNT_1,".$type1."TN_CNT_0,".$type1."SN_CNT,".$type1."SN_CNT_1,".$type1."SN_CNT_0");
    $this->db->join($type."_teacher_number",$type."_teacher_number.".$select."_key =".$type."_school.".$select."_key");


      //source      
    $result = $this->db->get()->result_array();

    if($school == "elementary"){
      foreach ($result as $row) {
        $array = array
        (
         "school" =>[
         	"name" => $row[$select."_name"],
         	"phone"=>$row[$select."_phone"],
           "addr"=> $row[$select."_address"],
           "url"=> $row[$select."_url"],
           "position" =>$row[$select."_longitude"].",".$row[$select."_latitude"]
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
    }else{
      foreach ($result as $key => $row) {
        $array = array
        (
         "school" =>[
          "name" => $row[$select."_name"],
          "phone"=>$row[$select."_phone"],
          "addr"=> $row[$select."_address"],
          "url"=> $row[$select."_url"],
          "position" =>$row[$select."_longitude"].",".$row[$select."_latitude"]
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
    }
    if($this->check_source($school_id)){
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
    $array1 = array
    (
      "source" => [
        "schoolCooperate"  =>$StudentCooper,
        "studentCooperate" =>$SchoolCooper,
        "traffic"          =>$traffic,
        "around"           =>$around
      ]
    );
    $array=array_merge($array,$array1);
    return $array;
  }
  public function check_source($school_id){
    $query = $this->db->get_where("service_score",array("SF_school_key" => $school_id));

    if(empty($query->row_array())){
      return false;
    }else{
      return true;
    }
  }


  public function search_school($school_id,$school){
  	
  	if($school == '"elementary"'){
  		$type = "ES";
  		$from = "elementary_school";
  		$name = "ES_name";
  	}else{
  		$type = "JS";
  		$from = "junior_school";
  		$name = "JS_name";
  	}



  	$this->db->select($type."_name");
  	$this->db->where($type."_key",$school_id,false);

  	$query = $this->db->get($from);

  	if($query->num_rows()==1){
  		return $query->row(0)->$name;
  	}else{
  		return false;
  	}


  	return $query;


  }

}

//無條件捨去
function floor_dec($v, $precision){
    $c = pow(10, $precision);
    return floor($v*$c)/$c;
}