<?php
// this file post.php is for displaying a post in the single-page-application


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
	
?>


<!-- start view's code -->

<?php if($type == "challenge"):  ?>
	<div class="compete">
		
		<h6 title="<?=$by?>'s profile" link="profile/<?=$by?>" onclick="go(this)" class="pl-2 font-bold text-primary d-block  hv"> <?=$by?> </h6>
		
		<span class="p-1"><?=$body?></span> <!-- post body  -->
		<p class="vs" >  <span class="blue">vs</span> </p>
		
		<!--  post usernames -->
		<div class="contest d-flex justify-content-around">
			<span class="blue-text"> <?=$con1_user?> </span>
			<span class="blue-text"> <?=$con2_user?> </span>
		</div>
		
		<!-- images -->
		<div class="d-flex imgs"> <!-- image box  -->
			<img onclick="goImage(this)" src="<?=$cha_image.$con1_image?>" class="" >
			<img onclick="goImage(this)"  src="<?=$cha_image.$con2_image?>" class="" >
		</div>
		
	</div>
<?php  else: ?>

	<!-- post -->
	<div class="compete">
	
		<h6 title="<?=$by?>'s profile" link="profile/<?=$by?>" onclick="go(this)" class="pl-2 font-bold text-primary d-block  hv"> <?=$by?> </h6>
		
		<div class="p-2">
			<span class=""><?=$body?></span>
		</div>
		
		<!-- images  -->
		<?php  if($images): ?>
		<div class="d-flex flex-wrap">
			<?php   
				$im_arr = explode(",", $images);
				$l = count($im_arr);
				
				if($l == 1) $width ="width:100%; height:200px;";
				else $width = "width:50%; height:200px; ";
		
				
				
				for($i = 0; $i < $l; $i++){
					$link = $post_image.$im_arr[$i];
					echo "<img onclick='goImage(this)'  style='$width object-fit:cover; object-position:50% 50%;' class='img-fluid' src='$link'>"; 
				}
			?>
		</div>
		<?php  endif; ?>
		

	</div> <!-- end post's code -->

<?php endif;  ?>


<!-- comments section -->
<h5 class=" pl-3 text-muted grey lighten-3" >Comments:</h5>



<!-- list comments -->
<div id="post-comment" class="list-group">
	<?php  foreach($comments as $com):?>
		<li class="list-group-item d-flex flex-column">
			<span title="<?=$com->comment_by?>' profile" link="profile/<?=$com->comment_by?>" onclick="go(this)" class="hv text-primary"> <?=ucfirst($com->comment_by)?> </span>
			<span class=""> <?=nl2br($com->body)?> </span>
		</li>
	<?php  endforeach; ?>
</div>



<!-- comment textarea box -->
<?php if(isset($_SESSION["user"])):  ?>

	<div class="comment-div ">
		<textarea rows="1" id="comment-body" placeholder="Comment..." ></textarea>
		<button post-id="<?=$id?>" onclick="comment(this)" class=" float-right d-block w-50 btn btn-block text-primary hb">SEND</button>
	</div>


<?php  else: ?>
	<div class="w-70 text-center mx-auto ">
		<a href="/signin" class="d-block w-100">Login to   comment on this post</a>
		<a href="/signup" class="">Create an account</a>
	</div>
<?php  endif; ?>

<div style="height:50px" class="">
</div>