
<div class="clearfix text-center">
	<button onclick="toast('Currently not available.')" class=" w-75 btn btn-danger clearfix"> <i class="ion-md-trash"></i> clear all </button>
</div>

<br>
	
	
<div class="list-group clearfix">

	<?php foreach($notys as $noty):  ?>

		<li class="list-group-item hv">
			<a style="text-decoration:none" href="/osco-post/<?=$noty->post_id?>" class="text-info"> <?=$noty->message ; ?> </a>
		</li>
	
	<?php endforeach;  ?>

</div>