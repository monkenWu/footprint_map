<?php

class profile_model extends CI_Model{

	public function __destruct() {  
	    $this->db->close();  
	}
	
	public function check_SMkey($id){
		if(!is_numeric($id)){
			$id = $this->db->escape($id);
		}
		$query = $this->db->get_where("system_member",array("SM_key" => $id));
		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}


	public function add_Group($groupName,$id){
		$data = array(
			"SM_key" => $id,
			"SG_name" => $groupName
		);
		$this->db->insert("system_group",$data);
		//回傳前一次Insert的 Primary key
		$SG_key = $this->db->insert_id();

		$data = array(
			"SM_key" => $id,
			"SG_key" => $SG_key
		);

		return $this->db->insert("system_class",$data);

	}


	public function check_groupName($groupName){
		$query = $this->db->get_where("system_group",array("SG_name" => $groupName));
		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}


	public function check_account($account){
		$query = $this->db->get_where("system_member",array("SM_account" => $account));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}


	public function get_memberId($account){
		$this->db->select("SM_key");
		$this->db->where("SM_account",$account);

		$query = $this->db->get("system_member");

		if($query->num_rows()==1){
			return $query->row(0)->SM_key;
		}else{
			return false;
		}
	}

	public function get_myselfAccount($id){
		$this->db->select("SM_account");
		$this->db->where("SM_key",$id);

		$query = $this->db->get("system_member");

		if($query->num_rows()==1){
			return $query->row(0)->SM_account;
		}else{
			return false;
		}
	}

	public function check_group($group_id,$member_id){
		
		$query = $this->db->get_where("system_class",array("SM_key" => $member_id , "SG_key" => $group_id));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}

	public function add_GroupMember($group_id,$member_id){
		$data = array(
			"SM_key" => $member_id,
			"SG_key" => $group_id
		);

		return $this->db->insert("system_class",$data);
	}

	public function getGroup($id){

		$this->db->select("SG_key,"."SG_name",false);
		$this->db->from("system_group");
		$this->db->where("system_group.SM_key = ",$id,false);


		$result = $this->db->get()->result_array();

		return $result;

	}

	public function getOneGroup($id){
		$this->db->select("system_group.SG_name",false);
		$this->db->from("system_group");
		$this->db->where("system_group.SG_key =",$id,false);

		$result = $this->db->get()->result_array();

		return $result;

	}

	public function getGroup_class($id){

		$this->db->select("system_class.SG_key as SG_key,"."system_group.SG_name as SG_name",false);
		$this->db->from("system_class,"."system_group");
		$this->db->where("system_group.SG_key = ","system_class.SG_key",false);
		$this->db->where("system_class.SM_key = ",$id,false);


		$result = $this->db->get()->result_array();


		return $result;

	}

	public function check_admin($group_id,$member_id){
		$query = $this->db->get_where("system_group",array("SM_key" => $member_id , "SG_key" => $group_id));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}

	}


	public function getTable_admin($group_id){
		$this->db->select("system_member.SM_name as SM_name,"."system_member.SM_email as SM_email,system_member.SM_key as SM_key");
		$this->db->from("system_group,"."system_member");
		$this->db->where("system_group.SM_key = ","system_member.SM_key",false);
		$this->db->where("system_group.SG_key =",$group_id);

		$result = $this->db->get()->result_array();
		return $result;
	}

	


	public function getTable($group_id,$admin_id){
		$this->db->select("system_member.SM_key as SM_key,"."SM_name,"."SM_email");
		$this->db->from("system_class");
		$this->db->join("system_member","system_member.SM_key = system_class.SM_key");
		$this->db->where("system_class.SG_key = ",$group_id,FALSE);
		$this->db->where("system_class.SM_key !=",$admin_id,FALSE);
		$result = $this->db->get()->result_array();


		return $result;
	}




	public function getTable_noadmin($group_id,$admin_id){
		$this->db->select("system_member.SM_key as SM_key,"."SM_name,"."SM_email");
		$this->db->from("system_class");
		$this->db->join("system_member","system_member.SM_key = system_class.SM_key");
		$this->db->where("system_class.SG_key = ",$group_id,FALSE);
		$this->db->where("system_class.SM_key !=",$admin_id,FALSE);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function delMember($delId,$groupid){
		$this->db->where("SM_key = ",$delId,false);
		$this->db->where("SG_key = ",$groupid,false);
		$this->db->delete("system_class");
		return true;
	}


	public function isExist_group($id){
		$query = $this->db->get_where("system_group",array("SM_key" => $id));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}

	}

	public function isExist_class($id){
		$query = $this->db->get_where("system_class",array("SM_key" => $id));
		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}



	public function update_group($group_id,$member_id,$groupName){
		$data = array(
			'SM_key' => $member_id,
			'SG_name' => $groupName
		);
		$this->db->where('SG_key =',$group_id,false);
		$this->db->update('system_group',$data);

		return true;
	}

	public function update_class($group_id,$member_id,$id){
		$data = array(
			'SM_key' => $id
		);

		$this->db->where('SG_key =',$group_id,false);
		$this->db->where('SM_key =',$member_id,false);
		$this->db->update('system_class',$data);

	}


	public function getadminId($groupid){
		$this->db->select('SM_key');
		$query = $this->db->get_where('system_group',array('SG_key' =>$groupid));
		$row = $query->row();
		return ($query->num_rows()===1) ? $row->SM_key :false ;
	}

	public function getgroupName($groupid){
		$this->db->select('SG_name');
		$query = $this->db->get_where('system_group',array('SG_key' =>$groupid));
		$row = $query->row();
		return ($query->num_rows()===1) ? $row->SG_name :false ;
	}

	public function getMemberGroup($member_id){
		$this->db->select("SG_name",false);
		$this->db->from("system_group");
		$this->db->where("system_group.SM_key = ",$member_id,false);
		$this->db->limit(5);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getMemberGroupClass($member_id){
		$this->db->select("system_group.SG_name as SG_name",false);
		$this->db->from("system_class,"."system_group");
		$this->db->where("system_group.SG_key = ","system_class.SG_key",false);
		$this->db->where("system_class.SM_key = ",$member_id,false);
		$this->db->limit(5);
		$result = $this->db->get()->result_array();
		return $result;


	}

	public function getService($member_id){
		$this->db->select("service_footprint.SF_name",false);
		$this->db->from("service_footprint,"."system_class");
		$this->db->where("system_class.SG_key = ","service_footprint.SG_key",false);
		$this->db->where("system_class.SM_key = ",$member_id,false);
		$this->db->order_by("SF_startdate","desc");
		$this->db->limit(5);
		$result = $this->db->get()->result_array();
		return $result;

	}

	public function getMemberProfile($member_id){
		$this->db->select("system_member.SM_job,"."system_member.SM_school,"."system_member.SM_web,"."system_member.SM_name",false);
		$this->db->from("system_member");
		$this->db->where("system_member.SM_key = ",$member_id,false);
		
		$result = $this->db->get()->result_array();

		return $result;

	}

	public function updateImage($id,$fileName){
		$data = array(
			"SM_photo" => $fileName
		);
		$this->db->where("SM_key = ",$id,false);
		$this->db->update("system_member",$data);
		return true;
	}

	public function getImg($member_id){
		$this->db->select("SM_photo",false);
		$this->db->from("system_member");
		$this->db->where("SM_key = ",$member_id,false);

		$result = $this->db->get()->result_array();

		return $result;
	}	

	public function getFootprint_Count($id){
		$this->db->select("count(SF_key) as SF_key",false);
		$this->db->where("system_class.SG_key = ","service_footprint.SG_key",false);
		$this->db->where("system_class.SM_key = ",$id,false);
		$this->db->where("SF_type = ",1,false);
		$query = $this->db->get("system_class,"."service_footprint");

		if($query->num_rows()==1){
			return $query->row(0)->SF_key;
		}else{
			return false;
		}
	}


	public function getComment_Count($id){
		$this->db->select("count(SC_content) AS SC_content",false);
		$this->db->where("SM_key = ",$id,false);
		$this->db->where("type = ",0,false);
		$query = $this->db->get("service_comments");

		if($query->num_rows()==1){
			return $query->row(0)->SC_content;
		}else{
			return false;
		}
	}

	public function check_member($id){
		$query = $this->db->get_where("system_member",array("SM_key" => $id));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}

	}

	public function add_Message($member_id,$SM_key,$ip,$content){
		$data = array(
			"SM_key" => $member_id,
			"do_SM_key" => $SM_key,
			"PC_content" => $content,
			"user_ip" => $ip
		);
		return $this->db->insert("profile_comments",$data);
	}

	public function get_message($member_id){
		$this->db->select("system_member.SM_photo,"."system_member.SM_web,"."system_member.SM_name,"."profile_comments.PC_time,"."profile_comments.PC_content,"."profile_comments.PC_key,"."profile_comments.do_SM_key",false);
		$this->db->from("system_member");
		$this->db->join("profile_comments","profile_comments.do_SM_key=system_member.SM_key",false);
		$this->db->where("profile_comments.SM_key = ",$member_id,false);
		$this->db->where("type",0,false);
		$this->db->order_by("PC_time","DESC");
		$this->db->limit(10);
		$result = $this->db->get()->result_array();
		

		return $result;
	}

	public function get_message_append($member_id,$startNum){
		$startNum-=1;
		$this->db->select("system_member.SM_photo,"."system_member.SM_web,"."system_member.SM_name,"."profile_comments.PC_time,"."profile_comments.PC_content,"."profile_comments.PC_key,"."profile_comments.do_SM_key",false);
		$this->db->from("system_member");
		$this->db->join("profile_comments","profile_comments.do_SM_key=system_member.SM_key",false);
		$this->db->where("profile_comments.SM_key = ",$member_id,false);
		$this->db->where("type",0,false);
		$this->db->order_by("PC_time","DESC");
		$this->db->limit(10,$startNum);
		$result = $this->db->get()->result_array();
		

		return $result;
	}


	public function message_count($member_id){
		$this->db->select("count(PC_key) AS PC_key",false);
		$this->db->where("SM_key",$member_id,false);
		$this->db->where("type",0,false);
		$query = $this->db->get("profile_comments");

		if($query->num_rows()==1){
			return $query->row(0)->PC_key;
		}else{
			return false;
		}
	}

	public function append_count($member_id,$startNum){
		$startNum -=1;
		$allCount = ($this->message_count($member_id))-$startNum;
		// echo $startNum.",";
		// echo $allCount;
		$sql = "SELECT COUNT(*) AS PC_key
		FROM (SELECT `PC_key` FROM `system_member`,`profile_comments` WHERE profile_comments.do_SM_key = system_member.SM_key AND  profile_comments.SM_key = $member_id AND type = 0 LIMIT $startNum,$allCount) AS A";
		$query = $this->db->query($sql);
		if($query->num_rows()==1){
			return $query->row(0)->PC_key;
		}else{
			return false;
		}

	}


	public function del_message($key){
		$data = array(
			"type" => 1
		);
		$this->db->where("PC_key = ",$key,false);
		$this->db->update("profile_comments",$data);
		return true;
	}


	public function get_SettingInfo($SM_key){
		$this->db->select("SM_name,"."SM_job,"."SM_school,"."SM_web",false);
		$this->db->from("system_member");
		$this->db->where("SM_key = ",$SM_key,false);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function update_info($SM_key,$name,$job,$school,$page){
		$data = array(
			'SM_name' => $name,
			'SM_job' => $job,
			"SM_school" =>$school,
			"SM_web" => $page
		);
		$this->db->where('SM_key =',$SM_key,false);
		$this->db->update('system_member',$data);

		return true;
	}

}