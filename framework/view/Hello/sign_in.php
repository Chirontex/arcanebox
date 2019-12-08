<?php

$title = 'Sign in — Arcanebox';

?>

<main role="main" class="container">
	<div class="container-custom-center">
		<form class="form-signin">
  			<h1>Sign in</h1><br>
  			<label for="inputLogin" class="sr-only">Login</label>
  			<input type="text" id="inputLogin" class="form-control" placeholder="Login" required autofocus>
  			<label for="inputPassword" class="sr-only">Password</label>
  			<input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
  			<div class="checkbox mb-3">
    			<label>
      				<input type="checkbox" value="remember-me"> Remember me
    			</label>
  			</div>
  			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>
	</div>
</main>