<?php $title = 'Sign in — Arcanebox'; ?>

<main role="main" class="container">
	<div class="container-custom-center">
		<form action="index.php?r=auth" method="POST" class="form-signin">
  			<h1>Sign in</h1><br>
        <?php 

          if ($aspects['auth'] == 'fail') echo '<p style="color: red">Login/password is incorrect.</p>';

        ?>
  			<label for="inputLogin" class="sr-only">Login</label>
  			<input type="text" id="inputLogin" name="login" class="form-control" placeholder="Login" required autofocus>
  			<label for="inputPassword" class="sr-only">Password</label>
  			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
  			<div class="checkbox mb-3">
    			<label>
      				<input type="checkbox" name="remember" value="remember-me"> Remember me
    			</label>
  			</div>
  			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>
	</div>
</main>