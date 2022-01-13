<?php  $this->extend("layout/basic") ?> 

<?php  $this->section("title") ?>
Oscolite - Sign in
<?php $this->endSection() ?>


<?php  $this->section("content") ?>

<div class="m-4"> </div>


<div class="card m-2">
	
	<div class="card-header">
		<span class="d-block text-center">Sign in</span>
	</div>

	<div class="card-body mono">
	
		<form method="post" action="/signin" onsubmit="return ss()" >
			
			<!-- errors -->
			<?php if(isset($errors)) echo $errors ?>
			<?php if(isset($user_err)) echo $user_err ?>
			
			<div class="form-group">
				<label>Username:</label>
				<input id="uname"  value="<?= set_value('username')?>" type="text"   class=" form-control" name="username" >
			</div>
			
			<div class="form-group">
				<label>Password:</label>
				<input value="<?= set_value('password')?>" type="password" class=" form-control" name="password" >
			</div>
			
			<input type="submit" name="signin" class="btn btn-primary btn-block " value="SIGN IN"  >
			
		</form>
		
	</div>
	
	<div class="card-footer">
		<?= anchor("signup", "Not a member? Sign up")?>
	</div>
	
</div>


<?php $this->endSection() ?>


<?php  $this->section("js") ?>
<script type="text/javascript">

	function ss(){
		var u = $("#uname").toLowerCase()
		localStorage.user = u
		return true;
	}

</script>
<?php $this->endSection() ?>
