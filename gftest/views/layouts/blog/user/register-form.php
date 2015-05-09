<section class="register-section">
	<h2>Register</h2>
	<form class="registration-form">
		<label for="username">Username: </label>
		<input type="text" name="username" id="username" />
		<label for="email">Email: </label>
		<input type="text" name="email" id="email" />
		<label for="password">Password: </label>
		<input type="password" name="password" id="password" />
		<label for="repeat-password">Repeat password: </label>
		<input type="password" name="repeat-password" id="repeat-password" />
		<input type="submit" class="submitRegister" />
		<input type="hidden" name="CSRF" id="CSRF" value="<?= $this->csrf->csrfProtectGenerator(); ?>" />
	</form>
</section>