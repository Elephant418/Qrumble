<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $resource->title; ?></title>
</head>
<body>
	<div class="container">
		<div class="header">
		</div>
		<div class="nav">
		</div>
		<div class="content">
		<?php
			echo $resource->display();
		?>
		</div>
		<div class="footer">
		</div>
	</div>
</body>
</html>

