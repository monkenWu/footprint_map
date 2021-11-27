<?php

class Recover_model extends CI_Model{

	
	public function __destruct() {  
	    $this->db->close();  
	}

	public function email_exists($email){
		// $query = $this->db->get_where('system_member',array('SM_email'=>$email));

		// if(empty($query->row_array())){	//判斷這一筆是否為空
		// 	return true;
		// }
		// else{
		// 	return false;
		// }
		$this->db->select('SM_name,SM_email');
		$query = $this->db->get_where('system_member',array('SM_email' =>$email));
		$row = $query->row();

		return ($query->num_rows()===1 && $row->SM_email) ? $row->SM_name :false ;


	}

	//發送驗證碼
	public function send_code($email,$number,$SM_key){
		$data = array(
			'SM_key' =>$SM_key,
			'SM_email' => $email,
			'SRE_number' =>$number
		);

		return $this->db->insert('system_recover',$data);

	}

	//更新驗證碼
	public function send_code_update($email,$number){
		$data = array(
			'SRE_number' =>$number
		);

		$this->db->where('SM_email',$email);
		return $this->db->update('system_recover',$data);

	}

	public function delete_code($SM_key){
		$this->db->where('SM_key',$SM_key);
		$this->db->delete('system_recover');
		return true;
	}


	//確認驗證碼是否存在
	public function check_code($email,$number){
		//把該email和驗證碼選出來才能去確認是否為該筆email的驗證碼
		$query = $this->db->get_where('system_recover',array('SRE_number' => $number,'SM_email' => $email));

		if(empty($query->row_array())){ //判斷這一筆是否為空
			return true;
		}
		else{
			return false;
		}
	}

	public function get_time($email){
		$this->db->select('SRE_dateTime');
		$query = $this->db->get_where('system_recover',array('SM_email' =>$email));
		$row = $query->row();
		return ($query->num_rows()===1) ? $row->SRE_dateTime :false ;
	}


	public function get_time_check($email){
		$this->db->select("SRE_dateTime");
		$this->db->from("system_recover");
		$this->db->where("SM_email",$email);

		$result = $this->db->get();

		return $result;
	}



	public function get_SMkey($email){
		//取出會員資料
		$this->db->select("SM_key");
		$this->db->from("system_member");
		$this->db->where("SM_email",$email);

		$result = $this->db->get();

		return $result;
	}

	public function reset_password($password,$SM_key){
		$data = array(
			'SM_password' => $password
		);
		$this->db->where('SM_key',$SM_key);
		return $this->db->update('system_member',$data);
	}

	public function check_email($email){
		$query = $this->db->get_where("system_member",array("SM_email" => $email));

		if(empty($query->row_array())){
			return true;
		}else{
			return false;
		}
	}



}