<section class="add-comment-section">
	<h1>Add comment</h1>
	<form class="add-comment-form-authorized">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" />
		<label for="email">Email (optional):</label>
		<input type="text" id="email" name="email" />
		<label for="comment">Comment:</label>
		<textarea id="comment" name="comment"></textarea>
		<input type="submit" id="submit" value="Add Post" />
		<input type="hidden" id="CSRF" name="CSRF" value="<?= $this->csrf->csrfProtectGenerator(); ?>" />
		<input type="hidden" id="postId" class="postId" name="postId" value="<?= $this->postId ?>" />
	</form>
</section>