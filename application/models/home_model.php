<?php

class Home_model extends CI_Model{

    public function __destruct() {  
        $this->db->close();  
    }

    public function area($data){
      $array = Array();
      $user_searchp['search_type']='0';
      //接入資料
      $school=$data['school'];
      $county=$data['county'];
      $district=$data['district'];
      $searchJson=json_decode($data['searchJson'],true);
      $service_footprint = "service_footprint.";
      $service = "service_score.";

      //判斷是國小或國中, 
      //國小$select=ES,$from=elementary_school
      //國中$select=JS,$from=junior_school
      //$type 國小(elementary)或是國中(junior)
      if(strcmp($school,"elementary")==0){
          $select="ES";
        $from="elementary_school";
        $type="elementary";
        $type1="E";
        $user_search['school'] = '0' ;
      }else{
          $select="JS";
        $from="junior_school"; 
          $type="junior";
          $type1="J";
          $user_search['school'] = '1' ;
      }
      //select...from...where

      $this->db->select($select."_longitude,".$select."_latitude,".$select."_address,".$select."_name,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);
      $this->db->from($from);
      $this->db->like($select."_city",$county);
      //是否有區域
      if($district!="false"){
          $this->db->like($select."_address",$district);
          $user_search['country']='1' ;
          $user_search['area']='1' ;
      }
      //是否偏遠
      if($searchJson["faraway"]==1){
          $user_search['faraway']='1' ;
          $this->db->join($type."_faraway",$type."_school.".$select."_key=".$type."_faraway.".$select."_key");
      }

      if($searchJson["total"]==1 || $searchJson["aboriginal"]==1 || $searchJson["immigrants"]){
        $this->db->join($type."_student_total",$type."_school.".$select."_key=".$type."_student_total.".$select."_key");
      }
      if($searchJson["service"]==1){
        $user_search['service_total']='1' ;
        $this->db->join("service_footprint",$type."_school.".$select."_key=".$service_footprint."SF_school_key");
      }

      if($searchJson["score"]==1){
        $this->db->select("SS_value,"."SUM(SS_value) / COUNT(SS_value) as SS_AVG");
    
        $this->db->join("service_score",$type."_school.".$select."_key=".$service."SF_school_key");
      }

      if($searchJson["EPA"] == 1){
        $this->db->join("educational_priority_areas",$type."_school.".$select."_key="."EP_key");
      }



      //學生總數是否搜索
      if($searchJson["total"]==1){
          $user_search['student_total']='1' ;
          $total_value = explode(",",$searchJson["total_value"]);
          // echo $total_value[0];
          if($total_value[0] == "<="){
           $this->db->where("`".$type."_student_total`.`".$select."T_CNT_1`+`".$type."_student_total`.`".$select."T_CNT_0` <=",$total_value[1],FALSE);

          }else{
            $this->db->where("`".$type."_student_total`.`".$select."T_CNT_1`+`".$type."_student_total`.`".$select."T_CNT_0` >=",$total_value[1],FALSE);
           
          }
      }

    //原住民學生數是否搜索
    if($searchJson["aboriginal"]==1){
      $user_search['aboriginal_total']='1' ;
          $aboriginal_value = explode(",",$searchJson["aboriginal_value"]);
          if($aboriginal_value[0]=="<="){
        $this->db->where("`".$type."_student_total`.`".$type1."NA_CNT` <=",$aboriginal_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_student_total`.`".$type1."NA_CNT` >=",$aboriginal_value[1],FALSE);
      }
    }
    //新住民家庭學生數是否搜索
    if($searchJson["immigrants"]==1){
      $user_search['immigrants_total']='1' ;
          $immigrants_value = explode(",",$searchJson["immigrants_value"]);
          if($immigrants_value[0]=="<="){
        $this->db->where("`".$type."_student_total`.`".$type1."NI_CNT` <=",$immigrants_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_student_total`.`".$type1."NI_CNT` >=",$immigrants_value[1],FALSE);
      }
    }


    //被服務次數是否搜索
    if($searchJson["service"]==1){
      $user_search['service_total']='1' ;
        $service_value = explode(",",$searchJson["service_value"]);
        if($service_value[0]==">="){
          $this->db->select("COUNT(".$service_footprint."SF_name) as NumOftime");
          $this->db->group_by($service_footprint."SF_school_key");
          $this->db->having("NumOftime >=",1,FALSE);
        }else{
          $this->db->select("COUNT(".$service_footprint."SF_name) as NumOftime");
          $this->db->group_by($service_footprint."SF_school_key");
          $this->db->having("NumOftime <=",1,FALSE);
        }
    }

    //服務評價是否搜索
    if($searchJson["score"]==1){
      $user_search['service_score']='1' ;
      if($searchJson["service"]!=1){
        $this->db->group_by("SF_school_key");
      }
      $score_value=explode(",",$searchJson["score_value"]);
      $this->db->having("SS_AVG >",$score_value[1],false);
    }

    //教育優先是否搜尋
    if($searchJson["EPA"] == 1){
      $user_search['epa']='1' ;
    }


      $result=$this->db->get()->result();

      //將資料放入陣列
      foreach ($result as $key => $row) {
        $array[]=array
          (
          "position"=>$row->{$select."_longitude"}.",".$row->{$select."_latitude"}, 
          "addr"=> $row->{$select."_address"},
          "name"=> $row->{$select."_name"},
          "number"=> $row->{$select."_key"},
          "url"=> $row->{$select."_url"},
          "phone"=>$row->{$select."_phone"},
          "type"=>$type
          );
      }
      $this->db->insert("user_search",$user_search);
    return $array;
  }


  public function keywordsSearch($data){
    $array = Array();

    //傳入值
    $school=$data['school'];
    $county=$data['county'];
    $keywordsSchool=$data['keywordsSchool'];
    $keywordsAddr=$data['keywordsAddr'];
    $user_search = array();
    //判斷值傳進來的字串是什麼
    $user_search['search_type'] = 1;
    if(strcmp($school,"elementary")==0){
        $select="ES";
        $from="elementary_school";
        $type="elementary";
        $type1="E";
        $user_search['school'] = 0;
      }else{
          $select="JS";
          $from="junior_school"; 
          $type="junior";
          $type1="J";
          $user_search['school'] = 1;
      }

      //select出資料
      $this->db->select($select."_longitude,".$select."_latitude,".$select."_address,".$select."_name,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);
      $this->db->from($from);
      // $this->db->like($select."_addssress",$keywords);

      $SchoolLike = mb_split("\s", $keywordsSchool);
      $AddrLike = mb_split("\s", $keywordsAddr);
     
      //學校名稱 要是市區不選擇的話
      if($county == ""){
         $user_search['country'] = 0;
        if($keywordsSchool!=""){
          $user_search['keywordsSchool'] = 1;
          foreach ($SchoolLike as $ScLk) {
            $this->db->or_like($select."_name",$ScLk);
            // $this->db->like($select."_address",$key);               
           }
         }else{
          $user_search['keywordsSchool'] = 0;
         }

        if($keywordsAddr!=""){
          $user_search['keywordsAddr'] = 1;
          foreach ($AddrLike as $AdlK) {
            $this->db->or_like($select."_address",$AdlK);
          }
         }else{
          $user_search['keywordsAddr'] = 0;
         }
       }
       else{
         $user_search['country'] = 1;
        if($keywordsSchool!=""){
           $user_search['keywordsSchool'] = 1;
          if(count($SchoolLike)==1){
          $this->db->like($select."_name",$SchoolLike[0]);
          $this->db->like($select."_city",$county);
         }else{
           $user_search['keywordsSchool'] = 1;
           foreach ($SchoolLike as $ScLk) {
            $this->db->or_like($select."_name",$ScLk);
            $this->db->like($select."_city",$county);
            // $this->db->like($select."_address",$key);               
           }
           
         }
         }

         if($keywordsAddr!=""){
           $user_search['keywordsAddr'] = 1;
          if(count($AddrLike)==1){
          $this->db->like($select."_address",$AddrLike[0]);
          $this->db->like($select."_city",$county);
         }else{
           $user_search['keywordsAddr'] = 0;
           foreach ($AddrLike as $AdLk) {
            $this->db->or_like($select."_address",$AdLk);
            $this->db->like($select."_city",$county);
               
           }
           
         }
         }
       }



        $result=$this->db->get()->result();


        foreach ($result as $key => $row) {
        $array[]=array
          (
          "position"=>$row->{$select."_longitude"}.",".$row->{$select."_latitude"}, 
          "addr"=> $row->{$select."_address"},
          "name"=> $row->{$select."_name"},
          "number"=> $row->{$select."_key"},
          "url"=> $row->{$select."_url"},
          "phone"=>$row->{$select."_phone"},
          "type"=>$type
          );
      }
      $this->db->insert("user_search",$user_search);   
    return $array;
  }

  public function attributesSearch($data){
      $array = Array();
      $user_search['search_type']='2';
      $user_search['country']='1';
      //接入資料
      $school=$data['school'];
      $county=$data['county'];
      $searchJson=json_decode($data['searchJson'],true);
      $service = "service_score.";
      $service_footprint = "service_footprint.";
      if(strcmp($school,"elementary")==0){
        $select="ES";
        $from="elementary_school";
        $type="elementary";
        $type1="E";
        $user_search['school'] = 0;
      }else{
        $select="JS";
        $from="junior_school"; 
        $type="junior";
        $type1="J";
        $user_search['school'] = 1;
      }

      if($searchJson["schoolComputer"]==1){
        $this->db->select("DISTINCT ".$select."_name,".$type."_computer.".$type1."C_city,".$select."_longitude,".$select."_latitude,".$select."_address,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);
        $this->db->from("elementary_computer");
        $this->db->where("SUBSTRING(".$type."_school.".$select."_name,-4) =",$type."_computer.".$type1."C_school",FALSE);
        $this->db->where("SUBSTRING(".$type."_school.".$select."_city,5,6) =",$type."_computer.".$type1."C_city",FALSE);
        $this->db->where("SUBSTRING(".$type."_school.".$select."_city,5) =",$type."_computer.".$type1."C_city",FALSE);
      }else{
      $this->db->select($select."_longitude,".$select."_latitude,".$select."_address,".$select."_name,".$type."_school.".$select."_key,".$select."_url,".$select."_phone",false);
      }
      $this->db->from($from);
      $this->db->like($select."_city",$county);

      if($searchJson["total"]==1 || $searchJson["aboriginal"]==1 || $searchJson["immigrants"]){
        $this->db->join($type."_student_total",$type."_school.".$select."_key=".$type."_student_total.".$select."_key");
      }
      if($searchJson["schoolArea"]==1 || $searchJson["hall"]==1 || $searchJson["schoolClass"]==1){
        $this->db->join($type."_building",$type."_school.".$select."_key=".$type."_building.".$select."_key");
      }

      if($searchJson["teacher"]==1){
        $this->db->join($type."_teacher_number",$type."_school.".$select."_key=".$type."_teacher_number.".$select."_key");
      }

      if($searchJson["service"]==1){
        $this->db->join("service_footprint",$type."_school.".$select."_key=".$service_footprint."SF_school_key");
      }

      if($searchJson["source"]==1){
        $this->db->select("SS_value,"."SUM(SS_value) / COUNT(SS_value) AS SS_AVG");
      
        $this->db->join("service_score",$type."_school.".$select."_key=".$service."SF_school_key");
      }

      if($searchJson["EPA"] == 1){
        $this->db->join("educational_priority_areas",$type."_school.".$select."_key="."EP_key");
      }

      //服務評價是否搜尋
      if($searchJson["source"] ==1){
        $user_search['service_score'] = 1;
        $service_schoolCooperate = explode(",", $searchJson["source_value"]["schoolCooperate_value"]);
        $service_studentCooperate = explode(",", $searchJson["source_value"]["studentCooperate_value"]);
        $service_traffic = explode(",", $searchJson["source_value"]["traffic_value"]);
        $service_around = explode(",", $searchJson["source_value"]["around_value"]);
        if($searchJson["service"]!=1){
        $this->db->group_by("SF_school_key");
        }
        $this->db->group_by("SS_type");
        if($service_schoolCooperate[0] == "<="){
          $this->db->or_having("SS_type =",1,FALSE);
          $this->db->having("SS_AVG <=",$service_schoolCooperate[1],FALSE);
        }else{
          $this->db->or_having("SS_type =",1,FALSE);
          $this->db->having("SS_AVG >=",$service_schoolCooperate[1],FALSE);
        }

        if($service_studentCooperate[0] == "<="){
          $this->db->or_having("SS_type =",2,FALSE);
          $this->db->having("SS_AVG <=",$service_studentCooperate[1],FALSE);
        }else{
          $this->db->or_having("SS_type =",2,FALSE);
          $this->db->having("SS_AVG >=",$service_studentCooperate[1],FALSE);
        }

        if($service_traffic[0] == "<="){
          $this->db->or_having("SS_type =",3,FALSE);
          $this->db->having("SS_AVG <=",$service_traffic[1],FALSE);
        }else{
          $this->db->or_having("SS_type =",3,FALSE);
          $this->db->having("SS_AVG >=",$service_traffic[1],FALSE);
        }

        if($service_around[0] == "<="){
          $this->db->or_having("SS_type =",4,FALSE);
          $this->db->having("SS_AVG <=",$service_around[1],FALSE);
        }else{
          $this->db->or_having("SS_type =",4,FALSE);
          $this->db->having("SS_AVG >=",$service_around[1],FALSE);
        }

    }


      if($searchJson["schoolComputer"]==1){
        $user_search['schoolComputer_total'] = 1;
        // $this->db->join($type."_computer",$type."_school.".$select."_city=".$type."_computewr.".$type1."C_city");
        $schoolComputer_value = explode(",", $searchJson["schoolComputer_value"]);
        if($schoolComputer_value[0] == "<="){
           $this->db->where("`".$type."_computer`.`".$type1."C_CNT` <=",$schoolComputer_value[1],FALSE);

          }else{
           $this->db->where("`".$type."_computer`.`".$type1."C_CNT` >=",$schoolComputer_value[1],FALSE);
           
          }

      }


      //學生總人數查詢
      if($searchJson["total"]==1){
          $user_search['student_total'] = 1;
          $total_value = explode(",",$searchJson["total_value"]);
          // echo $total_value[0];
          if($total_value[0] == "<="){
           $this->db->where("`".$type."_student_total`.`".$select."T_CNT_1`+`".$type."_student_total`.`".$select."T_CNT_0` <=",$total_value[1],FALSE);

          }else{
            $this->db->where("`".$type."_student_total`.`".$select."T_CNT_1`+`".$type."_student_total`.`".$select."T_CNT_0` >=",$total_value[1],FALSE);
           
          }
      }

      //原住民學生數是否搜索
      if($searchJson["aboriginal"]==1){
        $user_search['aboriginal_total'] = 1;
          $aboriginal_value = explode(",",$searchJson["aboriginal_value"]);
        if($aboriginal_value[0]=="<="){
          $this->db->where("`".$type."_student_total`.`".$type1."NA_CNT` <=",$aboriginal_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_student_total`.`".$type1."NA_CNT` >=",$aboriginal_value[1],FALSE);
      }
    }

     //新住民家庭學生數是否搜索
     if($searchJson["immigrants"]==1){
        $user_search['immigrants_total'] = 1;
          $immigrants_value = explode(",",$searchJson["immigrants_value"]);
        if($immigrants_value[0]=="<="){
          $this->db->where("`".$type."_student_total`.`".$type1."NI_CNT` <=",$immigrants_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_student_total`.`".$type1."NI_CNT` >=",$immigrants_value[1],FALSE);
      }
    }


    //偏鄉學校是否搜尋
    if($searchJson["faraway"]==1){
      $user_search['faraway'] = 1;
       $this->db->join($type."_faraway",$type."_school.".$select."_key=".$type."_faraway.".$select."_key");
    }

    //職員總數是否搜尋
    if($searchJson["teacher"]==1){
        $user_search['teacher_total'] = 1;
          $teacher_value = explode(",", $searchJson["teacher_value"]);
        if($teacher_value[0] == "<="){
          $this->db->where("`".$type."_teacher_number`.`".$type1."TN_CNT`+`".$type."_teacher_number`.`".$type1."SN_CNT` <=",$teacher_value[1],FALSE);
    }else{
          $this->db->where("`".$type."_teacher_number`.`".$type1."TN_CNT`+`".$type."_teacher_number`.`".$type1."SN_CNT` >=",$teacher_value[1],FALSE);  
          }
    }

    //校地面積是否搜尋
    if($searchJson["schoolArea"]==1){
      $user_search['school_area'] = 1;
      $schoolArea_value = explode(",", $searchJson["schoolArea_value"]);
      if($schoolArea_value[0]=="<="){
          $this->db->where("`".$type."_building`.`".$type1."B_area` <=",$schoolArea_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_building`.`".$type1."B_area` >=",$schoolArea_value[1],FALSE);
      }
    }


    //禮堂座數是否搜索
    if($searchJson["hall"]==1){
      $user_search['hall_total'] = 1;
      $hall_value = explode(",", $searchJson["hall_value"]);
      if($hall_value[0]=="<="){
          $this->db->where("`".$type."_building`.`".$type1."B_hall` <=",$hall_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_building`.`".$type1."B_hall` >=",$hall_value[1],FALSE);
      }
    }

    //教室間數是否搜索
    if($searchJson["schoolClass"]==1){
      $user_search['schoolClass_total'] = 1;
      $schoolClass_value = explode(",", $searchJson["schoolClass_value"]);
      if($schoolClass_value[0]=="<="){
          $this->db->where("`".$type."_building`.`".$type1."B_classroom` <=",$schoolClass_value[1],FALSE);
      }else{
        $this->db->where("`".$type."_building`.`".$type1."B_classroom` >=",$schoolClass_value[1],FALSE);
      }
    }

    //需要服務是否搜索
    if($searchJson["needService"]==1){
      $user_search['needService'] = 1; 
      $this->db->where($select."_needService",1,FALSE);
    }

    //服務次數是否搜尋
    if($searchJson["service"]==1){
      $user_search['service_total'] = 1; 
        $service_value = explode(",",$searchJson["service_value"]);
        if($service_value[0]==">="){
          $this->db->select("COUNT(".$service_footprint."SF_name) as NumOftime");
          $this->db->group_by($service_footprint."SF_school_key");
          $this->db->having("NumOftime >=",1,FALSE);
        }else{
          $this->db->select("COUNT(".$service_footprint."SF_name) as NumOftime");
          $this->db->group_by($service_footprint."SF_school_key");
          $this->db->having("NumOftime <=",1,FALSE);
        }
    }


    if($searchJson["EPA"] == 1){
      $user_search['epa']='1' ;
    }



      $result=$this->db->get()->result();

      $this->db->insert("user_search",$user_search);
      
      if($searchJson["source"]==0){
      foreach ($result as $key => $row) {
        $array[]=array
          (
          "position"=>$row->{$select."_longitude"}.",".$row->{$select."_latitude"}, 
          "addr"=> $row->{$select."_address"},
          "name"=> $row->{$select."_name"},
          "number"=> $row->{$select."_key"},
          "url"=> $row->{$select."_url"},
          "phone"=>$row->{$select."_phone"},
          "type"=>$type
          );
      }
      return $array;
  }else{
    $get_data = ""; //接收資料
    $compare_data = ""; //比對資料
    $count = 1;

     

     foreach ($result as $key => $row) {
      $compare_data = $row->{$select."_key"}; // 學校代碼
      
      //比對相同count++
      if($get_data==$compare_data){
          $count++;
        }else{
          $get_data=$compare_data; 
          $count = 1;          
        }
       
        if($count ==4){
        $array[]=array
          (
          "position"=>$row->{$select."_longitude"}.",".$row->{$select."_latitude"}, 
          "addr"=> $row->{$select."_address"},
          "name"=> $row->{$select."_name"},
          "number"=> $row->{$select."_key"},
          "url"=> $row->{$select."_url"},
          "phone"=>$row->{$select."_phone"},
          "type"=>$type
          );
      }

    }
       return $array;
  }
         
}


  public function schoolInfo($data){
      if($data['school'] == "elementary"){
      $this->db->select('ES_clickTotal',false);
      $query = $this->db->get_where('elementary_school', array('ES_key' => $data["id"]));
      if ($query->num_rows() > 0)
      {
         $row = $query->row(); 
         $click=$row->ES_clickTotal;
      }

      $this->db->where('ES_key', $data["id"]);
      $this->db->update('elementary_school',array('ES_clickTotal' => $click+1)); 
      }

      if($data['school'] == "junior"){
      $this->db->select('JS_clickTotal',false);
      $query = $this->db->get_where('junior_school', array('JS_key' => $data["id"]));
      if ($query->num_rows() > 0)
      {
         $row = $query->row(); 
         $click=$row->JS_clickTotal;
      }

      $this->db->where('JS_key', $data["id"]);
      $this->db->update('junior_school',array('JS_clickTotal' => $click+1)); 
      }


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
    }else{
      foreach ($result as $key => $row) {
        $array = array
        (
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
    if($this->home_model->check_source($school_id)){
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

        $StudentCooper = $result[0]["SS_AVG"];
        $SchoolCooper = $result[1]["SS_AVG"];
        $traffic = $result[2]["SS_AVG"];
        $around = $result[3]["SS_AVG"];     
      }else{
        $StudentCooper = 5;
        $SchoolCooper = 5;
        $traffic = 5;
        $around = 5;
      }
      $array1 = array
        (
          "source" => [
          "schoolCooperate"  =>floor_dec($StudentCooper,2),
          "studentCooperate" =>floor_dec($SchoolCooper,2),
          "traffic"          =>floor_dec($traffic,2),
          "around"           =>floor_dec($around,2)
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
}



//無條件捨去
function floor_dec($v, $precision){
    $c = pow(10, $precision);
    return floor($v*$c)/$c;
}