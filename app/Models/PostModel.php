<?php namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{

	protected $table = "posts";
	protected $returnType = "object";
	protected $primaryKey = "id";
	protected $allowedFields = ["post_by", "type", "body", "images", "likes", "contestant1", "contestant2", "contestant1_likes", "contestant2_likes"];
	
	
	function insert_post($d){
	
		if($this->insert($d)){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	
	function insert_challenge($d){
	
		if($this->insert($d)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function get_last_id(){
		return $this->selectMax("id")->get()->getResult()[0]->id;
	}
	
	
	function get_all_post(){
		return $this->orderBy("posts.id", "DESC")->findAll();
	}
	
	
	//increment the contestant likes column
	//param : post id and contestant whether contestant1_likes or contestant2_likes
	function vote($id, $contestant){

		if($this->where("id", $id)->increment($contestant)){
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	
	
	//profile.phpp
	function get_user_post($username){
		return $this->where("post_by", $username)->findAll();
	}
	
	
	//after a vote has been made or when comment button is clicked
	function get_single_post($id){
		return $this->find($id);
	}
	
	
	function delete_post($id){
		$po = $this->get_single_post($id);
		$type = $po->type;
		
		if($type == "challenge")
		{
			$con1 = explode("," , $po->contestant1);
			$con2 = explode(","  , $po->contestant2);
			
			$im1 = $con1[1];
			unlink(WRITEPATH."uploads/challenge-image/".$im1);
			
			$im2 = $con2[1];
			unlink(WRITEPATH."uploads/challenge-image/".$im2);
		
		}else
		{
			$ima = $po->images;
			
			if($ima){
				$image = explode(",", $ima);
			
				for($i = 0; $i < count($image); $i++){
					$im = $image[$i];
					unlink(WRITEPATH."uploads/post-image/".$im);
				}
			}
			
		} //end else
		
		$this->where("id", $id)->delete(); //delete
		
	}//end delete code
	
	
	//return post title used in soa
	function get_post_title($id){
		$s = $this->find($id);
		
		$ty = $s->type;
		$con1 = $s->contestant1;
		$con2 = $s->contestant2;
		$by = $s->post_by;
		
		if($ty == "post"){
			return ucfirst($by)."'s post";
		}else{
			
			$a = ucfirst(explode(",", $con1)[0]);
			$b = ucfirst(explode(",", $con2)[0]);
			
			return $a. " vs " . $b;
		
		}
	}
	
	
	//return true if it is user that created post
	function is_user_post($user, $id){
		//select post where post_by = $user and id = $id
		//if returned is 0, then not user
		//if returned is 1,  then it is user
		
		$this->where("post_by", $user);
		$this->where("id", $id);
		$g = $this->countAllResults();
		//return $g;
		
		if($g == 0){ return FALSE; }
		else { return TRUE; }
	}
	
	
}