<?php namespace App\Controllers;

use App\Models\PostModel;
use App\Models\NotificationModel;

class Home extends BaseController
{

	function __construct(){
		$this->postmodel = new PostModel();
		$this->notificationmodel = new NotificationModel();
	}
	
	public function index()
	{
		$d["posts"] = $this->postmodel->get_all_post();
		
		if($this->session->user){
			
			$n = $this->notificationmodel->get_notifications_num($this->session->user);
			$d["noty"] = ($n == 0) ? '' : $n;
		} //end if
		
		return view('home', $d);
	}
	
	
	
	
	function f(){
		$d = db_connect();
		$b = $d->table("posts");
		$b->truncate();
	}
	

}