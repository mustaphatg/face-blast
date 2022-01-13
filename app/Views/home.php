<?php  $this->extend("layout/basic") ?> -->

<?php  $this->section("css") ?>
<link rel="stylesheet" href="/inc/home.css" >
<?php $this->endSection() ?>



<?php  $this->section("content") ?>

<?php
	$post_image = "/writable/uploads/post-image/";
	$cha_image = "/writable/uploads/challenge-image/";
	$db = db_connect();
	$comment_builder = $db->table("comments");
	$vote_builder = $db->table("votes");
?>

<!-- foreach loop -->
<?php  foreach($posts as $post): ?>

<?php   
$type = $post->type;
$body = nl2br($post->body);
$by = ucfirst($post->post_by);
$id = $post->id;
$likes = ($post->likes > 0) ? $post->likes : "";
$images = $post->images;

//get comments by calling commentModel method, take note of line 15, it is a builder
$num_of_comments = $comment_builder->where("post_id", $id)->countAllResults();
if($num_of_comments == 0){
	$num_of_comments = NULL;
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


//$dis = disabled
//turn like button blue provided that user has voted
$blue1 = ""; 
$blue2 = ""; 
$dis = "";

if(isset($_SESSION["user"]))
{
	$w = ["vote_by" => $_SESSION["user"], "post_id" => $id];
	$vf = $vote_builder->where($w)->get()->getRow();
	
	if($vf) {
		$vf = $vf->contestant;
		if($vf > 0) { $dis = "disabled"; }
		if($vf == 1) { $blue1 = "bg-primary text-white";  }
		if($vf == 2) { $blue2 = "bg-primary text-white"; }
	}
}
?>

<!-- challenge -->
<?php  if($type == "challenge"): ?>
	<div class=" compete compete-<?=$id?>">
				
		<h6 title="<?=$by?>'s profile" link="profile/<?=$by?>" onclick="go(this)"  class="pl-2 font-bold text-primary d-block  hv"> <?=$by?> </h6>
		
		<div class="p-1">
			<span class=""><?=$body?></span> <!-- post body  -->
		</div>
		
		<p class="vs mono" >  <span class="blue">vs</span> </p>
		
		<!--  post usernames -->
		<div class="contest d-flex justify-content-around">
			<span class="blue-text"> <?=$con1_user?> </span>
			<span class="blue-text"> <?=$con2_user?> </span>
		</div>
		
		<!-- images -->
		<div class="d-flex imgs"> <!-- image box  -->
			<img onclick="goImage(this)" src="<?=$cha_image.$con1_image?>" class="" >
			<img onclick="goImage(this)" src="<?=$cha_image.$con2_image?>" class="" >
		</div>
		
		<!-- likes div 4 challenge -->
		<div class="m-1 d-flex justify-content-around">
			
			<?php  if(isset($_SESSION["user"])): ?>
				
				<button <?=$dis?> post-id="<?=$id?>" contestant="1" onclick="vote(this)" class=" hv ra <?=$blue1?>">
					<i class="ion-md-thumbs-up"></i> <?=$con1_likes?>
				</button>
				
				<button link="posts/<?=$id?>" post-id="<?=$id?>" title="<?=$con1_user?> vs <?=$con2_user?>" onclick="go(this)" class="ra hv">
					<i class="ion-ios-text"></i> <span id="num-of-comment-<?=$id?>" ><?=$num_of_comments?></span>
				</button>
				
				<button <?=$dis?> post-id="<?=$id?>" contestant="2" onclick="vote(this)" class="hv ra <?=$blue2?>"">
					<i class="ion-md-thumbs-up"></i> <?=$con2_likes?>
				</button>
				
			<?php  else: ?>
				
				<button onclick="toast('Login or sign-up to like.')" class="hv ra">
					<i class="ion-md-thumbs-up"></i> <?=$con1_likes?>
				</button>
				
				<button link="posts/<?=$id?>" title="<?=$con1_user?> vs <?=$con2_user?>" onclick="go(this)" class="ra hv">
					<i class="ion-ios-text"></i> <?=$num_of_comments?>
				</button>		
					
				<button onclick="toast('Login or sign-up to like.')" class="hv ra">
					<i class="ion-md-thumbs-up"></i> <?=$con2_likes?>
				</button>
				
			<?php endif;  ?>
		</div> <!--  end like div -->
		
		<!-- display 3 comments -->
		<div class="list-group">
			<?php   
				foreach($comments as $co){
					$bdd = nl2br($co->body);
					$b = ucfirst($co->comment_by);
					echo <<< _END
						<li class="grey lighten-3 list-group-item d-flex flex-column">
							<span title="$b's profile" link="profile/$co->comment_by" onclick="go(this)" class="hv d-block text-primary">$b</span>
							<span class="">$bdd</span>
						</li>
					_END;
				}
			?>
		</div>
		
	</div> <!-- end compete -->
	
<?php  else: ?>

	<!-- post -->
	<div class="compete">
		
		<h6 title="<?=$by?>'s profile" link="profile/<?=$by?>" onclick="go(this)" class="pl-2 font-bold text-primary d-block  hv"> <?=$by?> </h6>
		
		<div class="p-1">
			<span class=""><?=$body?></span>
		</div>
		
		<!-- images  -->
		<?php  if($images): ?>
		<div class="d-flex flex-wrap">
			<?php   
				$im_arr = explode(",", $images);
				$l = count($im_arr);
				
				if($l == 1) $width ="width:100%; height:200px;";
				else  $width ="width:50%; height:200px; ";

				
				for($i = 0; $i < $l; $i++){
					$link = $post_image.$im_arr[$i];
					echo "<img onclick='goImage(this)' style= '$width object-fit:cover; object-position:50% 50%;'  class='img-fluid' src='$link'>"; 
				}
			?>
		</div>
		<?php  endif; ?>
		
		<!-- like div -->
		<div class="m-1 d-flex  justify-content-around">
			
			<?php  if(isset($_SESSION["user"])): ?>
				
				<button post-id="<?=$id?>" onclick="like(this)" class="hv ra">
					<i class="ion-md-thumbs-up"></i> <span id="like-<?=$id?>" ><?=$likes?></span>
				</button>
				
				<button link="posts/<?=$id?>" title="<?=$by?>'s post" onclick="go(this)" class="hv ra">
					<i class="ion-ios-text"></i> <span id="num-of-comment-<?=$id?>"> <?=$num_of_comments?> </span>
				</button>
				
			<?php  else: ?>
			
				<button onclick="toast('Login or sign-up to like this post.')" class="hv ra">
					<i class="ion-md-thumbs-up"></i> <?=$likes?>
				</button>
				
				<button link="posts/<?=$id?>" title="<?=$by?>'s post" onclick="go(this)" class="hv ra">
					<i class="ion-ios-text"></i> <?=$num_of_comments?>
				</button>
				
			<?php  endif; ?>
		</div> <!-- end like div -->
		
		
		<!-- display 2 comments -->
		<div class="list-group ">
			<?php   
				foreach($comments as $co){
					$bdd = nl2br($co->body);
					$b = ucfirst($co->comment_by);
					echo <<< _END
						<li class="grey lighten-3 list-group-item d-flex flex-column">
							<span title="$b's profile" link="profile/$co->comment_by" onclick="go(this)" class="hv d-block text-primary">$b</span>
							<span class="">$bdd</span>
						</li>
					_END;
				}
			?>
		</div> <!-- comments -->
		
		
	</div>  <!-- end post -->

<?php endif;  ?> <!-- decide whether challenge or post -->

<?php  endforeach; ?>
<!-- end foreachloop -->





<?php  if(isset($_SESSION["user"])): ?>
<!-- fab add button -->
<button link="add" title="Add a post"  onclick="go(this)" class="fab btn btn-lg shadow-lg btn-primary rounded-circle "><span class="ion-md-add"></span></button>
<?php endif;  ?>




<?php $this->endSection() ?>



<?php  $this->section("js") ?>
<script type="text/javascript" src="/inc/home.js?ver=99.8"></script>
<?php $this->endSection() ?>