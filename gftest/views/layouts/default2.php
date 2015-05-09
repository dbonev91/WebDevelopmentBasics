<html>
	<head>
		<title><?= $this->title; ?></title>
	</head>
	<body>
		<?= $this->getLayoutData('body2'); ?>
		<hr>
		<?= $this->getLayoutData('body'); ?>
		
		<?php
			foreach ($this->c as $v) {
				echo $v . '<br />';
			}
		?>
	</body>
</html>