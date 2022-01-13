<?php namespace App\Controllers;

use App\Models\PostModel;
use App\Models\VoteModel;
use App\Models\FollowingModel;
use App\Models\CommentModel;
use App\Models\NotificationModel;

class Post extends BaseController
{
	
	function __construct(){
		$this->postmodel = new PostModel();
		$this->votemodel = new VoteModel();
		$this->followingmodel = new FollowingModel();
		$this->notificationmodel = new NotificationModel();
		$this->commentmodel = new CommentModel();
	}
	
	public function add_form()
	{
		return view('post/add');
	}
	
	function clean($in){
		$i = trim($in);
		return $i;
	}
	
	//Noty method
	//register user for notification by calling following post model
	// it insert if  user is not following before
	
	function Noty($type = null, $post_id){
		
		//register user for notification in following_posts table
		$this->followingmodel->save_for_noty($this->session->user, $post_id);
		
		//if call to this function was from add_post or add_challenge, then stop function
		if($type == null){
			return;
		}
		
		//to be used in message
		$u = ucfirst($this->session->user);
		$post_title = $this->postmodel->get_post_title($post_id);
		
		//all users following a post
		$all = $this->followingmodel->get_post_followers($post_id);
		
		foreach($all as $us){ //$us is username of all users following the post
			$is_user_post = $this->postmodel->is_user_post($us, $post_id); //check whether user is the owner of the post
			
			//if it is current user then skip
			if($us == $this->session->user){
				continue;
			}
			
			if($is_user_post && $type == "like"){
				$i["message"]= "$u liked a photo under a post you shared.";
				$i["username"] = $us;
				$i["post_title"] = $post_title;
				$i["post_id"] = $post_id;
				//insert
				$this->notificationmodel->insert_noty($i);
			}
			else if ($is_user_post && $type == "comment"){
				$i["message"]= "$u commented on your post.";
				$i["username"] = $us;
				$i["post_title"] = $post_title;
				$i["post_id"] = $post_id;
				//insert
				$this->notificationmodel->insert_noty($i);
			}
			else if (! $is_user_post && $type == "like"){
			$i["message"]= "$u liked a photo under a post you are following.";
			$i["username"] = $us;
			$i["post_title"] = $post_title;
			$i["post_id"] = $post_id;
			//insert
			$this->notificationmodel->insert_noty($i);
			}
			else{
				$i["message"]= "$u commented under a post you are following.";
				$i["username"] = $us;
				$i["post_title"] = $post_title;
				$i["post_id"] = $post_id;
				//insert
				$this->notificationmodel->insert_noty($i);
			}
			
	
		} //end foreach loop
	
	}
	

	
	
	function add_challenge(){
	
		$d["type"] = $this->request->getPost("type");
		$d["body"] = htmlspecialchars($this->clean($this->request->getPost("body")));
		$d["post_by"] = $this->session->user;
		
		$f1 = $this->request->getFile("contestant1_image");
		$nm = $f1->getRandomName();
		$f1->store("challenge-image/", $nm);
		//add to array
		$d["contestant1"] = "{$this->clean($this->request->getPost('contestant1'))}," . "$nm";
		
		$f2 = $this->request->getFile("contestant2_image");
		$nm2 = $f2->getRandomName();
		$f2->store("challenge-image/", $nm2);
		//add to array
		$d["contestant2"] = "{$this->clean($this->request->getPost('contestant2'))}," . "$nm2";
		
		//insert
		if($this->postmodel->insert_challenge($d)){
			
			//Noty method above
			//$idd = last id in the table
			$idd = $this->postmodel->get_last_id(); //when I was unable to get the insertId,  I used the largest id  in the table instead
			$this->Noty(null, $idd);
			
			return redirect()->to("/");
		}else{
			return view("errors/html/none");
		}
		
	}
	
	
	function add_post(){
		$dt["type"] = $this->request->getPost("type");
		$dt["body"] = $this->request->getPost("body");
		$dt["post_by"] = $this->session->user;
		
		$files = $this->request->getFiles();  //get files
		
		if($files){ //if there are files
			$arr = []; //to save name of images name
			foreach($files["image"] as $fi)
			{
				$na = $fi->getRandomName(); //get random name
				$fi->store("post-image/", $na); //store in post-image folder
				$arr[] = $na; //insert name into $arr
			}
			
			$dt["images"] = implode(",", $arr); //put images name in $dt array to be sent to model
		} 
		//endif
		
		if($this->postmodel->insert_post($dt)){
			
			//Noty method above
			$idd = $this->postmodel->get_last_id(); //when I was unable to get the insertId,  I used the largest id  in the table instead
			$this->Noty(null, $idd);
			
			
			echo "ok"; //used by javascript
		}else{
			echo "An error occurred. Try again.";
		}
		
	} // end add post
	
	
	//place user vote and return the post
	function vote(){
		$post_id = $this->request->getPost("post_id");
		$con = $this->request->getPost("contestant"); // 1 or 2
		
		if($con == 1) $contestant = "contestant1_likes";
		if($con == 2) $contestant = "contestant2_likes";
		
		//check if user has voted 4 a contestant b4 
		$b = $this->votemodel->builder();
		$nn = $b->where(["vote_by" => $this->session->user, "post_id" => $post_id])->countAllresults();
		if($nn > 0){ //if 1 or greater than 0 return an empty string to terminate the function
			return "";
		}
		
		//postModel method that increments contestant's likes
		if($this->postmodel->vote($post_id, $contestant)){ 
			
			//insert user's username into votes table
			$v["contestant"] = $con;
			$v["vote_by"] = $this->session->user;
			$v["post_id"] = $post_id;
			$this->votemodel->insert_vote($v);
			 //end insert
			 
			 
			//Noty method above, insert follow and noty
			$this->Noty("like", $this->request->getPost("post_id"));
					
			 
			//get single challenge post to update the post
			//to be used by javascript to update view after loading with grey background
			$p["post"] = $this->postmodel->get_single_post($post_id);
			$p["voted_for"] = $this->votemodel->voted_for($post_id, $this->session->user); //voted_for is a voteModel method that returns the contestant a user voted for with 1 or 2,  also return none in place of none
			return view("post/single_post", $p);
			
		}
		else{
			echo "Something went wrong.";
		}
		
		
	} //end vote function
	
	
	//like post
	function like(){
		$id = $this->request->getPost("post-id");
		$this->postmodel->builder()->where("id", $id)->increment("likes");
	}
	
	//I used posts because the controller name is post, used in spa
	function posts($id){
		$d["post"] = $this->postmodel->get_single_post($id);
		$d["comments"] = $this->commentmodel->get_post_comments($id);
		
		return view("post/post", $d);
	}
	
	
	
	//comment on post
	function comment(){
		$d["post_id"] = $this->request->getPost("post_id");
		$d["body"] = $this->request->getPost("body");
		$d["comment_by"] = $this->session->user;
		
		//insert by calling commentmodel's method
		$this->commentmodel->insert_comment($d);
		
		//Noty method above
		$this->Noty("comment", $this->request->getPost("post_id"));
		
		//return user's username . To be used by javascript to insert comment on client side
		echo $this->session->user;
	}
	
	
	function osco_post($id){
	
		$d["post"] = $this->postmodel->get_single_post($id);
		
		
		if($this->session->user){
		
			//delete notification if any
			$b = $this->notificationmodel->builder();
			$b->where(["username" => $this->session->user, "post_id" => $id])->delete();
			
			$n = $this->notificationmodel->get_notifications_num($this->session->user);
			$d["noty"] = ($n == 0) ? "" : $n;
		} //endif
		
		
		if(is_null($d["post"])){
			return view("errors/html/none");
		}
		
		$d["comments"] = $this->commentmodel->get_post_comments($id);
		
		return view("post/osco-post", $d);
	}
	
	
	
	function delete_post($id){
		//delete comment
		$this->commentmodel->delete_comment($id);
		
		//delete votes
		$this->votemodel->delete_vote($id);
		
		//delete post
		$this->postmodel->delete_post($id);
		
		//delete from following table
		$this->followingmodel->delete_follow($id);
		
		//delete from notificationtable
		$this->notificationmodel->delete_noty($id);
		
		
	} //end delete post code
	
	
	
	function f(){
			date_default_timezone_set("Asia/Kuwait");
		echo date("h-i-s");
	}
	
	
}