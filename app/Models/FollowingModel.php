<?php namespace App\Models;

use CodeIgniter\Model;

class FollowingModel extends Model
{
	
	protected $table = "following_posts";
	protected $allowedFields = ["post_id", "username"];
	protected $returnType = "object";
	protected $primaryKey = "post_id";
	
	
	public function save_for_noty($username, $id)
	{
		$w = ["username" => $username, "post_id" => $id];
		
		$n = $this->where($w)->countAllResults();
		
		//if user is not following.bEfore, then insert
		if($n == 0){
			$i = $w;
			$this->insert($i);
		}
		
	} //end insert_noty method
	
	
	
	function delete_follow($p_id){
		$this->where("post_id", $p_id)->delete();
	}
	
	
	//return all users following a post in an array
	function get_post_followers($id){
		$s = $this->select("username")->where("post_id", $id)->get()->getResult();
		
		$arr = [];
		foreach($s as $e){
			$arr[] = $e->username;
		}
		
		return $arr;
	}
	
	
	
}