<?php  $this->extend("layout/basic") ?> 

<?php  $this->section("title") ?>
Oscolite - Sign up
<?php $this->endSection() ?>

<?php  $this->section("content") ?>

<div class="m-3"> </div>


<div class="card m-2" style="overflow:scroll" >

	<div class="card-header">
		<span class="d-block text-center">Sign up</span>
	</div>

	<div class="card-body mono">
	
		<?=form_open("/signup", "onSubmit='return form()'")?>
		
			<!-- errors -->
			<?php if(isset($errors)) echo $errors ?>
			
			<input required="required" value="<?= set_value('name')?>" type="text" name="name" class="form-group form-control " placeholder="Name"  >
			
			<input required="required" type="text" value="<?= set_value('username')?>" name="username" id="uname" class="form-group form-control " placeholder="Username"  >
			
			<input required="required" type="password" value="<?= set_value('password')?>" name="password" class="form-group form-control " placeholder="Password"  >
			
			<input required="required" type="email" value="<?= set_value('email')?>" name="email" class="form-group form-control " placeholder="Email Address"  >
			
			<input required="required" type="text" value="<?= set_value('department')?>" name="department" class="form-group form-control " placeholder="Department"  >
			
			<div class="form-group">
				<select id="sel" class=" form-control custom-select" name="faculty" required="required" >
					<option value="no" >Select Your Faculty</option>
					<option value="Environmental Science" >Environmental Science</option>
					<option value="Applied Science" >AppliedScience</option>
					<option value="Management Science" >Management Science</option>
					<option value="Engineering" >Engineering</option>
					<option value="ICT" >ICT</option>
				</select>
			</div>
			
			<input type="submit" name="signup" class="btn btn-primary btn-block " value="SIGN UP"  >
		</form>
		
	</div>
	<div class="card-footer">
		<?= anchor("signin", "Sign in instead")?>
	</div>
</div>
<br>
<br>


<?php $this->endSection() ?>



<!-- JS -->
<?php  $this->section("js") ?>


<script type="text/javascript">
function form(){
	var se = document.querySelector("#sel")
	
	var u = $("#uname").toLowerCase()
	localStorage.user = u
	

	if(se.selectedIndex == 0){
		toast("Pleasse select a valid faculty.")
		return false;
	}else{
	return true;
	}
}
</script>


<?php $this->endSection() ?>