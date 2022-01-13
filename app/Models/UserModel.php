<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table = "users";
	protected $returnType = "object";
	protected $primaryKey = "username";
	protected $allowedFields = ["name", "username", "password", "email", "department", "faculty", "reg_date", "profile_pic"];
	
	
	//save new user
	public function save_user($d)
	{
		if($this->insert($d))
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	
	function is_a_user($u){
		$n = $this->where($u)->countAllResults();
		if($n == 1) return TRUE;
		else return FALSE;
	}
	
	
	function get_user($username){
		return $this->find(strtolower($username));
	}
	
		
	
}