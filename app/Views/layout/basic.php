<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"  >
<link rel="stylesheet" href="/inc/bootstrap44.min.css" >
<link rel="stylesheet" href="/inc/basic.css" >
<link rel="stylesheet" href="/inc/color.css" >
<link rel="stylesheet" href="/inc/ionicons/css/ionicons.min.css" >
<?php $this->renderSection("css")  ?>
<script type="text/javascript" src="/inc/jquery.js"></script>
<title><?php $this->renderSection("title")  ?></title>
</head>
<body class="" >
<!-- page wrapper -->
<div class="wrapper">
	
	<!-- sidebar -->
	<nav class="sidebar shadow white ">
		<br>
		<br>
		<br>
		
		<?php  if(isset($_SESSION["user"])):  ?>
		<ul class="list-group list-group-flush">
			<li class="list-group-item font-weight-bold">User</li>
			
			<li class="hv list-group-item">
				<a href="/" class="text-primary">Home</a>
			</li>
			
			<li class="hv list-group-item">
				<a href="javascript:void(0)" title="My profile" link="profile/<?=$_SESSION['user']?>" onclick="go(this)" class="text-primary">My profile</a>
			</li>
			
			<li class="hv list-group-item">
			<a href="javascript:void(0)" title="My Notifications" link="notifications/<?=$_SESSION['user']?>" onclick="go(this)" class="text-primary">My Notifications <span class="noty-num badge badge-danger badge-pill float-right"><?= $noty ?></span> </a>
			</li>
			
			<li class="hv list-group-item">
				<a href="/logout" class="text-danger">Log Out</a>
			</li>
			
		</ul><br>
		<?php  else: ?>
		
		<ul class="list-group list-group-flush">
			<li class="list-group-item font-weight-bold">User</li>
			
			<li class="hv list-group-item">
				<a href="/" class="text-primary">Home</a>
			</li>
			
			<li class="h list-group-item">
				<a href="/signin" class="text-primary">Sign In</a>
			</li>
			
			<li class="hv list-group-item">
				<a href="/signup" class="text-primary">Sign Up</a>
			</li>
		</ul>
		<?php  endif; ?>
		
		<ul class="list-group list-group-flush">
			<li  onclick="history.back(-1)" class="hv brown-text list-group-item">
			<i class="ion-md-undo"></i>	Go back
			</li>
		</ul>
		
	</nav> <!-- end of sidebar -->
	
	
	<!-- page content  -->
	<div class="content">
	
		<!-- header -->
		<nav class="clearfix blue shadow-sm   navbar navbar-expand-md ">
			
			<button id="side-bar-closer" style="outline:none; font-size:20px" class="text-white hb navbar-toggler"> 
				<span class="ion-md-menu"></span>
			</button>
			
			<a href="" class="flex-grow-1 pl-2 navbar-brand text-white cur">Face Blast</a>
			
			<button  id="top-clicker" class="btn hb navbar-btn text-white shadow-sm"> <i class="ion-md-options"></i> </button>
		
		</nav> <!-- end of header  --> 
		
		
		
		<!-- CONTENT STARTS -->
		<br>
		<div class="inner container-flui mb-1">
			<?php $this->renderSection("content")  ?>
		</div>
		<!-- CONTENTS ENDS -->
		
		
		
	</div> <!--  end of page content-->
	
	
	<div onclick="op()" class="overlay"> </div>
	
</div> <!-- end of page wrapper -->





<!-- fixed up -->
<div id="top"  class="cur top blue text-center text-dark fixed-top font-weight-bold  nav nav-justified" >
	<span onclick="op()" class=" py-2 nav-item d-block text-center" > <i class="ion-md-menu"></i> <br>menu </span>
	<?php if(isset($_SESSION["user"])):  ?>
		<span title="My profile" link="profile/<?=$_SESSION["user"]?>" onclick="go(this)" class="nav-item py-2 d-block text-center" > <i class="ion-md-person"></i> <br> profile </span> 
		<span title="My Notifications" link="notifications/<?=$_SESSION["user"]?>" onclick="go(this)" class="nav-item  py-2 d-block text-center"  >
			<i class="ion-md-notifications"></i> 
			<sup class="noty-num badge badge-danger badge-pill text-white"><?=$noty?></sup>  
			<br>notifi...
		</span>
	<?php else:  ?>
		<a href="/signin" style="text-decoration:none" class=" nav-item py-2 text-dark"> <i class="ion-md-log-in"></i> <br>sign in </a>
		<a href="/signup" style="text-decoration:none" class=" nav-item py-2 text-dark"> <i class="ion-md-add-circle"></i> <br>sign up </a>
	<?php endif; ?>
		<a  href="" style="text-decoration:none" class=" py-2 nav-item  d-block text-center text-dark"  > <i class="ion-md-refresh"></i> <br>refresh </a>
</div>


<!-- toast -->
<div  id="tst" >
	<div class="text-wrap toast-message">hello</div>
	<p onclick="ctoast()" style="color:blue;" class="hv m-1 mr-2">ok</p>
</div>


<!-- spa  -->
<div id="spa" class="spa pb-5">
	
	<div class="header fixed-top blue text-white ">
		<span id="spa-closer"  class="hb p-3 "> <i class="ion-md-arrow-back"></i> </span>
		<h5 id="spa-title" class="flex-grow-1 ml-4 ">welcome</h5>
	</div>
	
	<div class="page">
		<p class="mt-4 text-center spa-loading">
			<span class="spinner spinner-border text-primary"></span>
		</p>
	</div>
	
</div>

<!-- image spa spa  -->
<div class="image-spa pb-5">
	
	<div class="header fixed-top blue text-white ">
		<span onclick="closeImageSpa()" id="image-spa-closer"  class="hb p-3 "> <i class="ion-md-arrow-back"></i> </span>
		<h5 class="flex-grow-1 ml-4 ">Image</h5>
	</div>
	
	<div class="page">
		
	</div>
	
</div>

<div class="m-backdrop">

</div>



<script type="text/javascript" src="/inc/bootstrap44.min.js"></script>
<script type="text/javascript" src="/inc/localforage.min.js"></script>
<script type="text/javascript" src="/inc/basic.js?v=897"></script>
<?php $this->renderSection("js")  ?>
</body>
</html>