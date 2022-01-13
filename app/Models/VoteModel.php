<?php namespace App\Models;

use CodeIgniter\Model;

class VoteModel extends Model
{

	protected $table = "votes";
	protected $returnType = "object";
	protected $primaryKey = "vote_id";
	protected $allowedFields = ["vote_by", "post_id", "contestant"];
	
	
	//this method inserts the username of the user that just voted, the post id & the contestant either 1 or 2
	function insert_vote($d){
		
		if($this->insert($d)){
			return TRUE;
		}else{
			return FALSE;
		}
		
	} //end insert
	
	
	//voted_for is a voteModel method that returns the contestant a user voted for with 1 or 2,  also return none in place of none
	function voted_for($post_id, $username){
		$w["post_id"] = $post_id;
		$w["vote_by"] = $username;
		$nu = $this->where($w)->countAllResults();
		
		if($nu == 0){
			return "none";
		}
		else{
			$this->resetQuery(); 
			
			$w["post_id"] = $post_id;
			$w["vote_by"] = $username;
			
			$q = $this->where($w)->get();
			return $q->getRow()->contestant;
		}
		
	}
	
	
	function delete_vote($id){
		$this->where("post_id", $id)->delete();
	}
	
	
}