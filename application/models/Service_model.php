<?php

class service_model extends CI_Model{

	public function __destruct() {  
	    $this->db->close();  
	}
	
	public function admin_group($id){
		$this->db->select("SG_key,"."SG_name",false);
		$this->db->from('system_group');
		$this->db->where('SM_key = ',$id,false);
		$result = $this->db->get()->result_array();

		return $result;


	}

	public function service_exist($name){
		$query = $this->db->get_where("service_footprint",array("SF_name" => $name));
		
		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}


	public function addfootprint($key,$name,$starDate,$overDate,$content,$schoolNumber,$ip){
		$data = array(
			"SG_key" => $key,
			"SF_school_key" => $schoolNumber,
			"SF_name" => $name,
			"SF_startdate" => $starDate,
			"SF_enddate" => $overDate,
			"SF_subject" => $content,
			"user_ip" => $ip
		);

		return $this->db->insert("service_footprint",$data);


	}

	public function getService_Information($schoolNumber){
		$this->db->select("system_group.SG_name,"."SF_key,"."SF_name,"."SF_startdate,"."SF_enddate,"."SF_subject,"."SF_type,"."type",false);
		$this->db->from("service_footprint,"."system_group"); 
		$this->db->where("SF_school_key = ",$schoolNumber,false);
		$this->db->where("system_group.SG_key = ","service_footprint.SG_key",false);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_OneService($footprintKey){
		$this->db->select("SM_name,SM_photo,SG_name,SF_startdate,SF_enddate,SF_subject,SF_type",false);
		$this->db->from("system_group");
		$this->db->join("service_footprint","service_footprint.SG_key=system_group.SG_key",false);
		$this->db->join("system_member","system_member.SM_key=system_group.SM_key",false);
		$this->db->where("SF_key=".$footprintKey);
		$result=$this->db->get()->result_array();
		return $result;

	}

	public function addOneService($sfkey,$content,$reason,$schoolCooperate,$studentCooperate,$traffic,$around,$ip,$volunteer,$student){
		$this->db->select("system_member.SM_key,SF_school_key",false);
		$this->db->from("system_group");
		$this->db->join("service_footprint","service_footprint.SG_key=system_group.SG_key",false);
		$this->db->join("system_member","system_member.SM_key=system_group.SM_key",false);
		$this->db->where("SF_key=".$sfkey);
		$result=$this->db->get()->result_array();
		foreach ($result as $row) {
			$SMkey = $row['SM_key'];
			$SFschoolkey = $row['SF_school_key'];
		}
		$data = array(
			"SM_key" => $SMkey,
			"SF_school_key" => $SFschoolkey,
			"SF_key" => $sfkey,
			"SS_type" => "1",
			"SS_value" => $schoolCooperate,
			"SS_reason" => $reason[0]
		);
		$this->db->insert("service_score",$data);

		$data = array(
			"SM_key" => $SMkey,
			"SF_school_key" => $SFschoolkey,
			"SF_key" => $sfkey,
			"SS_type" => "2",
			"SS_value" => $studentCooperate,
			"SS_reason" => $reason[1]
		);
		$this->db->insert("service_score",$data);

		$data = array(
			"SM_key" => $SMkey,
			"SF_school_key" => $SFschoolkey,
			"SF_key" => $sfkey,
			"SS_type" => "3",
			"SS_value" => $traffic,
			"SS_reason" => $reason[2]
		);
		$this->db->insert("service_score",$data);


		$data = array(
			"SM_key" => $SMkey,
			"SF_school_key" => $SFschoolkey,
			"SF_key" => $sfkey,
			"SS_type" => "4",
			"SS_value" => $around,
			"SS_reason" => $reason[3]
		);
		$this->db->insert("service_score",$data);


		$data = array(
			"SM_key" => $SMkey,
			"SF_key" => $sfkey,
			"SC_content" => $content,
			"user_ip" => $ip,
			"type" => "2"
		);
		$this->db->insert("service_comments",$data);

		$data=array(
			"SF_volunteer" => $volunteer,
			"SF_student" => $student,
			"SF_type" => "1",
		);
		$this->db->where("SF_key=".$sfkey);
		$this->db->update("service_footprint",$data);

	}

	public function get_content($sfkey){
		$data = array(
			"SF_key" => $sfkey
		);
		$result = $this->db->get_where("service_comments",$data);
		if ($result->num_rows() > 0)
		{
			$row = $result->row(); 
			return $row->SC_content;
		}
	}

	public function get_reason($sfkey){
		$data = array(
			"SF_key" => $sfkey
		);
		$this->db->order_by("SS_type","ASC");
		$result = $this->db->get_where("service_score",$data);
		if ($result->result_array() > 0)
		{ 
			return $result->result_array();
		}

	}

	public function getOneEdit($sfkey){
		$this->db->select("SF_name,"."SF_startdate,"."SF_enddate,"."SF_subject",false);
		$this->db->from("service_footprint");
		$this->db->where("SF_key = ",$sfkey,false);
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function edit_Service($sfkey,$name,$starDate,$overDate,$content){
		$data = array(
			"SF_name" => $name,
			"SF_startdate" => $starDate,
			"SF_enddate" => $overDate,
			"SF_subject" => $content
		);
		$this->db->where("SF_key = ",$sfkey,false);
		$this->db->update("service_footprint",$data);
	}


	public function getServiceName($sfkey){
		$this->db->select('SF_name');
		$query = $this->db->get_where('service_footprint',array('SF_key' =>$sfkey));
		$row = $query->row();
		return ($query->num_rows()===1) ? $row->SF_name :false ;
	}

	public function del_Service($sfkey){
		$data = array(
			"type" => 1
		);
		$this->db->where("SF_key = ",$sfkey,false);
		$this->db->update("service_footprint",$data);
		return true;
	}

	public function add_comment($content,$sfkey,$SM_key,$ip){
		$data = array(
			'SF_key' => $sfkey,
			'SM_key' => $SM_key,
			'SC_content' => $content,
			"user_ip" => $ip
		);

		return $this->db->insert('service_comments',$data);

	}


	public function get_AllComment($sfkey){
		$this->db->select("service_comments.SC_key,"."service_comments.SM_key,"."service_comments.SC_content,"."service_comments.SC_dateTime,"."service_comments.type,"."system_member.SM_photo,"."system_member.SM_web,"."system_member.SM_name",false);
		$this->db->from("system_member");
		$this->db->join("service_comments","service_comments.SM_key=system_member.SM_key",false);
		$this->db->where("SF_key = ",$sfkey,false);
		$result = $this->db->get()->result_array();
		

		return $result;


	}

	public function del_comment($key){
		$data = array(
			"type" => 1
		);
		$this->db->where("SC_key = ",$key,false);
		$this->db->update("service_comments",$data);
		return true;
	}

	public function get_OneComment($SC_Key){
		$this->db->select("SC_content");
		$this->db->where("SC_key = ",$SC_Key,false);

		$query = $this->db->get("service_comments");

		if($query->num_rows()==1){
			return $query->row(0)->SC_content;
		}else{
			return false;
		}
	}

	public function edit_comment($text,$scKey){
		$data = array(
			"SC_content" => $text
		);
		$this->db->where("SC_key =",$scKey,false);
		$this->db->update("service_comments",$data);
		return true;
	}


}