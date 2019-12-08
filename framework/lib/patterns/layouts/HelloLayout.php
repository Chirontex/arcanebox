<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $title ?></title>
	<?= '<link rel="stylesheet" type="text/css" href="'.$this->configs['Domain']['framework_folder'].'/lib/external/css/bootstrap/bootstrap.min.css">' ?>
	<?= '<link rel="stylesheet" type="text/css" href="'.$this->configs['Domain']['framework_folder'].'/lib/patterns/layouts/css/Hello/style.css">' ?>

	<?php

		if ($aspects['view'] === 'sign_in') {

			echo '<link rel="stylesheet" type="text/css" href="'.$this->configs['Domain']['framework_folder'].'/lib/patterns/layouts/css/Hello/sign_in.css">';

		}

	?>

	<?= '<script src="'.$this->configs['Domain']['framework_folder'].'/lib/external/js/jquery-3.4.1.min.js"></script>' ?>

	<?= '<script src="'.$this->configs['Domain']['framework_folder'].'/lib/external/js/popper.min.js"></script>' ?>

	<?= '<script src="'.$this->configs['Domain']['framework_folder'].'/lib/external/js/bootstrap/bootstrap.min.js"></script>' ?>

</head>
<body>

	<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
		<a href="https://github.com/dmitryshumilin/arcanebox" target="_blank" class="navbar-brand">Arcanebox</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<?php

				if ($aspects['view'] === 'index') {

					echo '<li class="nav-item active">
							<a class="nav-link" href="'.$this->configs['Domain']['domain_name'].'">Home<span class="sr-only">(current)</span></a>
						</li>';

				}

				else {

					echo '<li class="nav-item">
							<a class="nav-link" href="'.$this->configs['Domain']['domain_name'].'">Home</a>
						</li>';

				}

				if ($aspects['view'] === 'sign_in') {

					echo '<li class="nav-item active">
							<a class="nav-link" href="'.$this->configs['Domain']['domain_name'].'/index.php?r=sign_in">Sign in<span class="sr-only">(current)</span></a>
						</li>';

				}

				else {

					echo '<li class="nav-item">
							<a class="nav-link" href="'.$this->configs['Domain']['domain_name'].'/index.php?r=sign_in">Sign in</a>
						</li>';

				}

				if ($aspects['view'] === 'documentation') {

					echo '<li class="nav-item active">
							<a class="nav-link" href="'.$this->configs['Domain']['domain_name'].'/index.php?r=documentation">Documentation<span class="sr-only">(current)</span></a>
						</li>';

				}

				else {

					echo '<li class="nav-item">
							<a class="nav-link" href="'.$this->configs['Domain']['domain_name'].'/index.php?r=documentation">Documentation</a>
						</li>';

				}

				?>

				<li class="nav-item dropdown">
        			<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language</a>
        			<div class="dropdown-menu" aria-labelledby="dropdown01">
        				<?= '<a class="dropdown-item" href="'.$this->configs['Domain']['domain_name'].'/index.php?r='.$aspects['view'].'&l=Ru">Русский</a>' ?>

          				<a class="dropdown-item active" href="javascript:void(0)">English</a>
        			</div>
      			</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
    			<input class="form-control mr-sm-2" type="text" placeholder="Search in documentation" aria-label="Search">
      			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    		</form>
		</div>
	</nav>

	<?php require_once $view ?>

	<footer class="footer mt-auto py-3">
  		<nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
  			<div class="container-fluid">
    			<p class="text-muted">&copy; Dmitry Shumilin, 2019</p>
 			</div>
  		</nav>
	</footer>

	<?= '<script type="text/javascript">' ?>

	<?= 'document.title = "'.$title.'"' ?>

	<?= '</script>' ?>

</body>
</html>