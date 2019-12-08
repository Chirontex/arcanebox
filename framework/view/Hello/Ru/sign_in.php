<?php

$title = 'Войти — Arcanebox';

?>

<main role="main" class="container">
	<div class="container-custom-center">
		<form class="form-signin">
  			<h1>Войти</h1><br>
  			<label for="inputLogin" class="sr-only">Логин</label>
  			<input type="text" id="inputLogin" class="form-control" placeholder="Логин" required autofocus>
  			<label for="inputPassword" class="sr-only">Пароль</label>
  			<input type="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
  			<div class="checkbox mb-3">
    			<label>
      				<input type="checkbox" value="remember-me"> Запомнить меня
    			</label>
  			</div>
  			<button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
		</form>
	</div>
</main>