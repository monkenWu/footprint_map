<?php

class Signup_model extends CI_Model{

	public function __destruct() {  
	    $this->db->close();  
	}

	public function  register($post,$enc_password,$email){
		$data = array(
			'SM_name' => $post['username'],
			'SM_sex' => $post['sex'],
			'SM_account' => $post['account'],
			'SM_password' => $enc_password,
			'SM_email' => $email
		);

		return $this->db->insert('system_member',$data);
	}


	public function account_isreapet($account){
		$query = $this->db->get_where('system_member',array('SM_account' => $account));

		if(empty($query->row_array())){ //判斷這一筆是否為空
			return true;
		}
		else{
			return false;
		}
	}

	public function email_isreapet($email){
		$query = $this->db->get_where('system_member',array('SM_email'=>$email));

		if(empty($query->row_array())){	//判斷這一筆是否為空
			return true;
		}
		else{
			return false;
		}
	}

}