<section class="login-container">
	<h2>Login</h2>
	<form class="login-form">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" />
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" />
		<input type="submit" name="submit" id="submit" value="Login" />
		<input type="hidden" name="CSRF" id="CSRF" value="<?= $this->csrf->csrfProtectGenerator(); ?>" />
	</form>
</section>