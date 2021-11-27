<?php

class Login_model extends CI_Model{
	
	public function __destruct() {  
	    $this->db->close();  
	}

	public function login($account,$password){

		$this->db->where("SM_account",$account);
		$this->db->where("SM_password",$password);

		$result = $this->db->get('system_member');

		if($result->num_rows()==1){ //假如有一筆資料存在
			return $result->row(0)->SM_key; //抓到該資料表第0列的資料(KEY)
		}else{
			return false;
		}

	}
		public function loginid($account,$user_id){

		$this->db->where("SM_account",$account);
		// $this->db->where("SM_key",$user_id);

		$result = $this->db->get('system_member');

		if($result->num_rows()==1){ //假如有一筆資料存在
			return $user_id==md5($result->row(0)->SM_key) ? $result->row(0)->SM_password : $result->row(0)->SM_key ;
		}else{
			return false;
		}

	}
}