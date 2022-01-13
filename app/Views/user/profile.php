<?php  
 
$name = ucwords($profile->name);
$uname = ucfirst($profile->username);
$dep = ucfirst($profile->department);
$fac = ucfirst($profile->faculty);
$reg = date("d M, Y",$profile->reg_date);

?>


<div class="profile p-2">
	
	<div style="height:150px; width:150px" class="mx-auto border rounded-circle"> </div>
	
	
	<div class="list-group list-group-flush">
	
		<li class="hv d-flex flex-column list-group-item list-group-item ">
			<span class="text-primary">Name</span>
			<span class=""><?=$name?></span>
		</li>
		
		<li class="hv d-flex flex-column list-group-item">
			<span class="text-primary">Username</span>
			<span class=""><?=$uname?></span>
		</li>
		
		
		<li class="hv d-flex flex-column list-group-item">
			<span class="text-primary">Department</span>
			<span class=""><?=$dep?></span>
		</li>
		
		<li class="hv d-flex flex-column list-group-item">
			<span class="text-primary">Faculty</span>
			<span class=""><?=$fac?></span>
		</li>
		
		<li class="hv d-flex flex-column list-group-item">
			<span class="text-primary">Member since</span>
			<span class=""><?=$reg?></span>
		</li>
		
		
	</div>
	
</div>

<hr>

<?php   
	$post_image = "/writable/uploads/post-image/";
	$cha_image = "/writable/uploads/challenge-image/";
	$db = db_connect();
	$comment_builder = $db->table("comments");
?>

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



<!-- challenge -->
<?php  if($type == "challenge"): ?>
	<div class="compete compete-<?=$id?>">
				
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
			<img onclick="goImage(this)"  src="<?=$cha_image.$con1_image?>" class="" >
			<img onclick="goImage(this)"  src="<?=$cha_image.$con2_image?>" class="" >
		</div>
		
		<!-- likes div 4 challenge -->
		<div class="m-1 d-flex justify-content-around">
			
				<button  class=" hv ra">
					<i class="ion-md-thumbs-up"></i> <?=$con1_likes?>
				</button>
				
				<button  class="ra hv">
					<i class="ion-ios-text"></i> <span id="num-of-comment-<?=$id?>" ><?=$num_of_comments?></span>
				</button>
				
				<button class="hv ra ">
					<i class="ion-md-thumbs-up"></i> <?=$con2_likes?>
				</button>

		</div> <!-- end like div -->
		
		 <!-- delete & view post button -->
		<div class="text-right p-1">
			<?php if(isset($_SESSION["user"]) && $_SESSION["user"] == strtolower($by)) : ?>
				<button post-id="<?=$id?>" onclick="deletePost(this)" class="btn btn-danger">Delete Post</button>
			<?php  endif; ?>
			
			<a a href="/osco-post/<?=$id?>" class="btn btn-primary">View Post</a>
		</div>
		
	</div> <!-- end compete -->
	
<?php  else: ?>

<!-- post -->
<div class="compete compete-<?=$id?>">
	
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
				echo "<img onclick='goImage(this)'  style= '$width object-fit:cover; object-position:50% 50%;'  class='img-fluid' src='$link'>"; 
			}
		?>
	</div>
	<?php  endif; ?>
	
	<!-- like div -->
	<div class="m-1 d-flex  justify-content-around">
			<button   class="hv ra">
				<i class="ion-md-thumbs-up"></i> <span id="like-<?=$id?>" ><?=$likes?></span>
			</button>
			
			<button  class="hv ra">
				<i class="ion-ios-text"></i> <span id="num-of-comment-<?=$id?>"> <?=$num_of_comments?> </span>
			</button>
	</div>
	
	<div class="text-right p-1"> <!-- delete & view post button -->
		
		<?php if(isset($_SESSION["user"]) && $_SESSION["user"] == strtolower($by)) : ?>
			<button post-id="<?=$id?>" onclick="deletePost(this)" class="btn red btn-danger"> <i class="ion-md-trash"></i> Delete Post</button>
		<?php  endif; ?>
		
		<a a href="/osco-post/<?=$id?>" class="btn btn-primary blue">View Post</a>
	</div>
	
</div> <!-- end post div -->


<?php  endif; ?>



<?php endforeach; ?>