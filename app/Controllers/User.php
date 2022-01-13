<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\NotificationModel;

class User extends BaseController
{
	
	function __construct(){
		$this->usermodel = new UserModel();
		$this->postmodel = new PostModel();
		$this->notificationmodel = new NotificationModel();
	}
	
	public function signin_form()
	{	
		if($this->session->get("user")){
			return redirect()->to("/");
		}
		
		return view('user/signin');
	}
	
	
	function signin(){

		$e = [
			"username" => [
				"label" => "Username",
				"rules" => "required|alpha_dash"
			],
			"password" => [
				"label" => "Password",
				"rules" => "required"
			]
		];
		
		if($this->validate($e))
		{
			$u["username"] = $this->clean($this->request->getPost("username"));
			$u["password"] = $this->clean($this->request->getPost("password"));
			$this->usermodel->is_a_user($u);
			if($this->usermodel->is_a_user($u))
			{
				$this->session->set("user", $u["username"]);
				return redirect()->to("/");
			}else{ 
				$er = "<div class='alert alert-danger'>The credentials you submitted are wrong.</div>";
				return view("user/signin", ["user_err"=>$er]);
			} 
		}
		else{
			$d["errors"] = $this->validator->listErrors();
			return view("user/signin", $d);
		}
		
	}
	
	
	
	function signup_form(){
		if($this->session->get("user")){
			return redirect()->to("/");
		}
		return view("user/signup");
	}
	
	
	private function clean($inp){
		$inp = trim($inp);
		$inp = strtolower($inp);
		return $inp;
	}
	
	function signup(){
		$e = [
			"name" => [
				"label" => "Name",
				"rules" => "required|alpha_space"
			],
			"username" => [
				"label" => "Username",
				"rules" => "required|alpha_dash|is_unique[users.username]",
				"errors" => [
					"is_unique" => "The Username is already in use."
				]
			],
			"email" => [
				"label" => "Email Address",
				"rules" => "required|valid_email"
			],
			"department" => [
				"label" => "Department",
				"rules" => "required|alpha_space"
			],
			"faculty" => [
				"label" => "Faculty",
				"rules" => "required"
			],
			"password" => [
				"label" => "Password",
				"rules" => "required"
			],
		];
		
		
		if($this->validate($e)){
			
			$u["name"] = $this->clean($this->request->getPost("name"));
			$u["username"] = $this->clean($this->request->getPost("username"));
			$u["password"] = $this->clean($this->request->getPost("password"));
			$u["email"] = trim($this->request->getPost("email"));
			$u["department"] = $this->clean($this->request->getPost("department"));
			$u["faculty"] = $this->request->getPost("faculty");
			$u["reg_date"] = strtotime("now");
			$u["profile_pic"] = "default.png";
			
			//insert by calling model method
			if($this->usermodel->save_user($u))
			{
				$this->session->set("user", $u["username"]);
				return redirect()->to("/");
			}else{
				//error
				return view("errors/html/none");
			}

		}else{
			$d["errors"] = $this->validator->listErrors();
			return view("user/signup", $d);
		}
		
	}
	
	
	function logout(){
		unset($_SESSION["user"]);
		return redirect()->to("/signin");
	}
	
	
	function profile($username){
		$d["profile"] = $this->usermodel->get_user($username);
		$d["posts"] = $this->postmodel->get_user_post($username);
		
		return view("user/profile", $d);
		
	}
	
	//used in spa to display all notifications
	function user_notifications($user){
		$d["notys"] = $this->notificationmodel->get_user_noty($user);
		return view("user/notifications", $d);
	}
	
	// return user's number of notifications
	//called from client side by js
	//through routes: num-notifications
	function num_notifications(){
		$n = $this->notificationmodel->get_notifications_num($this->session->user);
		if($n == 0) echo "";
		else echo $n;
	}
	
	
}