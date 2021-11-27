<?php

class SqlFunction_model extends CI_Model{
	/*
	function check_member($mm_id = "", $mm_password = ""){

		$this->db->select("mm_key, club_key , permission_key , mm_id , mm_password , mm_name , mm_type");
		$this->db->from("meg_member");
		$this->db->where("mm_id" ,$mm_id);
		$this->db->where("mm_password" , $mm_password);

		$result = $this->db->get();

		return $result;
	}
	*/

	
	public function __destruct() {  
	    $this->db->close();  
	}

	function check_member($SM_account = "", $SM_password = ""){
		//取出會員資料
		$this->db->select("SM_key,SM_name,SM_account,SM_password,SM_photo");
		$this->db->from("system_member");
		$this->db->where("SM_account",$SM_account);
		$this->db->where("SM_password",$SM_password);

		$result = $this->db->get();

		return $result;
	}

	function get_privateKey($SM_key,$type){
		//取出會員密鑰
		$this->db->select("SM_privateKey,SM_dateTime");
		$this->db->from("system_member");
		$this->db->where("SM_key",$SM_key);
		$result = $this->db->get()->row();
		return $type == "SM_privateKey" ? $result->SM_privateKey : $result->SM_dateTime;		
	}

	function set_privateKey($SM_key,$SM_privateKey){
		//更新密鑰
		$data = array(
				'SM_privateKey' => $SM_privateKey,
	            'SM_dateTime' => date("Y-m-d H:i:s")
            );
		$this->db->where('SM_key', $SM_key);
		$this->db->update('system_member', $data);
	}


	// function getImgExist($groupid){
	// 	$this->db->select('SG_name');
	// 	$query = $this->db->get_where('system_group',array('SG_key' =>$groupid));
	// 	$row = $query->row();
	// 	return ($query->num_rows()===1) ? $row->SG_name :false ;
	// }

}