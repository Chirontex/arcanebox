<?php

$title = 'Войти — Arcanebox';

?>

<main role="main" class="container">
	<div class="container-custom-center">
		<form action="index.php?r=auth" method="POST" class="form-signin">
  			<h1>Войти</h1><br>
        <?php 

          if ($aspects['auth'] == 'fail') echo '<p style="color: red">Логин/пароль неверен.</p>';

        ?>
  			<label for="inputLogin" class="sr-only">Логин</label>
  			<input type="text" id="inputLogin" name="login" class="form-control" placeholder="Логин" required autofocus>
  			<label for="inputPassword" class="sr-only">Пароль</label>
  			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Пароль" required>
  			<div class="checkbox mb-3">
    			<label>
      				<input type="checkbox" name="remember" value="remember-me"> Запомнить меня
    			</label>
  			</div>
  			<button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
		</form>
	</div>
</main>