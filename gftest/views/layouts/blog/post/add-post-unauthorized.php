<section class="add-post-section">
	<!--<h2>Add post</h2>
	<form class="add-post-form-unauthorized">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" />
		<label for="email">Email (optional):</label>
		<input type="text" name="email" id="email" />
		<label for="title">Title:</label>
		<input type="text" name="title" id="title" />
		<label for="content">Content:</label>
		<textarea id="content" name="content"></textarea>
		<label for="tags">Tags (separate with comma):</label>
		<textarea id="tags" name="tags"></textarea>
		<input type="submit" id="submit" value="Add Post" />
		<input type="hidden" id="CSRF" name="CSRF" value="<?= $this->csrf->csrfProtectGenerator(); ?>" />
	</form>-->
	<span>You have to be logged in to publish a post!</span>
</section>