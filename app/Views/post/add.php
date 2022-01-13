<br>
<div class="container">
	
	<div class="nav nav-pills nav-justified">
		<a href="#challenge" data-toggle="tab"  class="active nav-item nav-link">Challenge</a>
		<a href="#post" data-toggle="tab" class="nav-item nav-link">Post</a>
	</div>
	
	
	<!-- tab content -->
	<div class="tab-content">
		
		<!-- challenge -->
		<div class="active fade show tab-pane" id="challenge" >
			<br>
			
			<form method="post" action="/add-challenge" onsubmit="return checkChallenge(this)" enctype="multipart/form-data"   >
				
				<!-- bosy -->
				<div class="form-group">
					<input type="hidden" name="type" value="challenge"   >
					<textarea class="form-control" name="body"  placeholder="Write here... " ></textarea>
				</div>
				
				<!-- cont 1 -->
				<div conestant 1 class="border p-2">
					
					<div class="form-group">
						<input  class="form-group form-control shadow-sm" type="text" name="contestant1" placeholder="First contestant"  >
					</div>
					
					<!-- input & image  -->
					<div class="form-group">
						<img id="im1" >
						<label for="con1" class="btn btn-primary">
							<input onchange="challengeImage(this, 'im1')" id="con1" type="file" name="contestant1_image" style="height:0.1px; width:0.1px"  >
							<i class="ion-ios-image"></i> add photo
						</label>
					</div>
					
				</div>
				
				<!--  vs -->
				<div class="my-3 bg-dark text-white text-center">vs</div>
				
				<!--  cont 2-->
				<div conestant 2 class="border p-2">
					
					<div class="form-group">
						<input class="form-group form-control shadow-sm" type="text" name="contestant2" placeholder="Second contestant"  >
					</div>
					
					<!--  input & image -->
					<div class="form-group">
						<img id="im2" >
						<label for="con2" class="btn btn-primary">
							<input  onchange="challengeImage(this, 'im2')" id="con2" type="file" name="contestant2_image" style="height:0.1px; width:0.1px"  >
							<i class="ion-ios-image"></i> add photo
						</label>
					</div>
					
				</div>
				
				<div class="mt-3 form-group">
					<input type="submit" value="POST"  class="form-control btn btn-primary btn-block" >
				</div>
			
			</form>
			
		</div>
		
		<!-- post-->
		<div class="tab-pane" id="post" >
			<br>
			
			<form id="post-form"   >
				<input type="hidden" name="type" value="post"   >
				
				<div class="form-group">
					<textarea rows="4" name="body" class="form-control" placeholder="write here..." ></textarea>
				</div>
				
				<div class="form-group">
					<div style="flex-wrap:wrap"  class="d-flex  post-image-prev">
					</div>
					<label for="post-image-input" class="btn btn-primary">
						<input style="height:0.1px; width:0.1px;" type="file" onchange="choosePostImage()" id="post-image-input">
						<i class="ion-ios-image"></i> add photos
					</label>
				</div>
				
				<div class="form-group">
					<button onclick="sendPostForm(this)"  class="btn btn-block btn-primary">POST</button>
				</div>
				
			</form>
			
		</div>
		
		
	</div>
	
</div>