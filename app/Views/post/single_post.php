<?php

$post_image = "/writable/uploads/post-image/";
$cha_image = "/writable/uploads/challenge-image/";
$db = db_connect();
$comment_builder = $db->table("comments");
//=============


$type = $post->type;
$body = nl2br($post->body);
$by = ucfirst($post->post_by);
$id = $post->id;
$likes = ($post->likes > 0) ? $post->likes : "";
$images = $post->images;

//get comments by calling PostModel method
$num_of_comments = $comment_builder->where("post_id", $post->id)->countAllResults();
if($num_of_comments == 0){
	$num_of_comments = "";
}

//get comments
$comments = $comment_builder->where("post_id", $id)->get(3)->getResult();


// contestant 1
if($post->contestant1){
	$con1 = explode(",", $post->contestant1);
	$con1_user = ucfirst($con1[0]);
	$con1_image = $con1[1];
}

// contestant 2
if($post->contestant2){
	$con2 = explode(",", $post->contestant2);
	$con2_user = ucfirst($con2[0]);
	$con2_image = $con2[1];
}

// likes
$con1_likes = ($post->contestant1_likes > 0) ? $post->contestant1_likes : "";
$con2_likes = ($post->contestant2_likes > 0) ? $post->contestant2_likes : "";


//voted_for passed from controller
//turn the like button user clicked to blue color
$v_f = $voted_for;
	
	$blue1 = "";
	$blue2 = "";
	
	//for the first button
	if($v_f == 1) $blue1 = "bg-primary text-white";
	
	//for the second button
	if($v_f == 2) $blue2 = "bg-primary text-white";
	
?>

	<h6 title="<?=$by?>'s profile" link="profile/<?=$by?>" onclick="go(this)" class="pl-2 font-bold text-primary d-block  hv"> <?=$by?> </h6>

	<span class="p-1"><?=$body?></span> <!-- post body  -->
	
	<p class="vs mono" >  <span class="blue">vs</span> </p>
	
	<!--  post usernames -->
	<div class="contest d-flex justify-content-around">
		<span class="blue-text"> <?=$con1_user?> </span>
		<span class="blue-text"> <?=$con2_user?> </span>
	</div>
	
	<!-- images -->
	<div class="d-flex imgs"> <!-- image box  -->
		<img onclick="goImage(this)"  src="<?=$cha_image.$con1_image?>" class="" >
		<img onclick="goImage(this)" src="<?=$cha_image.$con2_image?>" class="" >
	</div>
	
	<!-- likes div 4 challenge -->
	<div like class="m-1 d-flex justify-content-around">
			<button  onclick="toast('You've choosed one earlier.')" class="hv ra <?=$blue1?>">
				<i class="ion-md-thumbs-up"></i> <?=$con1_likes?>
			</button>
			
			<button link="posts/<?=$id?>" post-id="<?=$id?>" title="<?=$con1_user?> vs <?=$con2_user?>" onclick="go(this)" class="ra hv">
				<i class="ion-ios-text"></i> <span id="num-of-comment-<?=$id?>" > <?=$num_of_comments?> </span>
			</button>
			
			<button  onclick="toast('You've choosed one earlier.')" class="hv ra <?=$blue2?>">
				<i class="ion-md-thumbs-up"></i> <?=$con2_likes?>
			</button>
	</div> <!--  end like div -->
	
	
	<!-- display 3 comments -->
	<div class="list-group">
		<?php   
			foreach($comments as $co){
				$bdd = nl2br($co->body);
				$b = ucfirst($co->comment_by);
				echo <<< _END
					<li class="grey lighten-3 list-group-item d-flex flex-column">
						<span title="$b's profile" link="profile/$by" onclick="go(this)" class="hb d-block text-primary">$b</span>
						<span class="">$bdd</span>
					</li>
				_END;
			}
		?>
	</div>
	
	