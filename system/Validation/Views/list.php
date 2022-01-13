<?php if (! empty($errors)) : ?>
	<ul class="list-group mb-3 ">
	<?php foreach ($errors as $error) : ?>
		<li class="bg-light p-2 text-danger list-group-item"><?= esc($error) ?></li>
	<?php endforeach ?>
	</ul>
<?php endif ?>