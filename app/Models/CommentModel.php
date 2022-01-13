<?php namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{

	protected $table = "comments";
	protected $returnType = "object";
	protected $primaryKey = "id";
	protected $allowedFields = ["comment_by", "body", "post_id"];
	
	
	function get_num_of_comments($id){
		$d = $this->where("id",$id)->countAllResults();
		return $d;
	}
	
	
	function insert_comment($d){
		$this->insert($d);
	}
	
	
	function get_post_comments($id){
		return $this->where("post_id", $id)->findAll();
	}
	
	
	function delete_comment($id){
		$this->where("post_id", $id)->delete();
	}
	
}