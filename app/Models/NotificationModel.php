<?php namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
	
	protected $table = "Notifications";
	protected $allowedFields = ["post_id", "post_title", "username", "message"];
	protected $returnType = "object";
	protected $primaryKey = "post_id";
	
	
	public function insert_noty($i)
	{
		$this->insert($i);
	} //end insert_noty method
	
	//get number of user notifications
	function get_notifications_num($u){
		
		$this->where("username", $u);
		$n = $this->countAllResults();
		return $n;
	}
	
	
	function get_user_noty($user){
		$s = $this->where("username", $user)->findAll();
		return $s;
	}
	
	
	
	function delete_noty($p_id){
		$this->where("post_id", $p_id)->delete();
	}
	
}