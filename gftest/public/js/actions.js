$(document).ready(function () {
	(function () {
		$(document).on('submit', '.registration-form', function (event) {
			event.preventDefault();
			
			$.ajax({
				url: 'http://dbonev.com/blog/registration/doReg',
				type: 'post',
				data: {
					username: $('.registration-form #username').val(),
					password: $('.registration-form #password').val(),
					repeatPassword: $('.registration-form #repeat-password').val(),
					email: $('.registration-form #email').val(),
					csrf: $('.registration-form #CSRF').val()
				},
				success: function (success) {
					console.log(success);
					location.href = 'http://dbonev.com/blog/post/all';
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			});
		}).on('submit', '.login-form', function (event) {
			event.preventDefault();
			
			$.ajax({
				url: 'http://dbonev.com/blog/login/doLog',
				type: 'post',
				data: {
					username: $('.login-form #username').val(),
					password: $('.login-form #password').val(),
					csrf: $('.login-form #CSRF').val()
				},
				success: function (success) {
					console.log(success);
					location.href = 'http://dbonev.com/blog/post/all';
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			});
		}).on('click', '.logout-button', function (event) {
			$.ajax({
				url: 'http://dbonev.com/blog/logout/logout',
				type: 'post',
				success: function (success) {
					console.log(success);
					location.href = 'http://dbonev.com/blog/post/all';
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			});
		}).on('submit', '.add-post-form-authorized', function (event) {
			event.preventDefault();
			
			$.ajax({
				url: 'http://dbonev.com/blog/post/add',
				type: 'post',
				data: {
					title: $('.add-post-form-authorized #title').val(),
					content: $('.add-post-form-authorized #content').val(),
					tags: $('.add-post-form-authorized #tags').val(),
					csrf: $('.add-post-form-authorized #CSRF').val()
				},
				success: function (success) {
					console.log(success);
					location.href = 'http://dbonev.com/blog/post/all';
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			});
		}).on('submit', '.add-post-form-unauthorized', function (event) {
			event.preventDefault();
			
			$.ajax({
				url: 'http://dbonev.com/blog/post/add',
				type: 'post',
				data: {
					title: $('.add-post-form-unauthorized #title').val(),
					content: $('.add-post-form-unauthorized #content').val(),
					username: $('.add-post-form-unauthorized #username').val(),
					email: $('.add-post-form-unauthorized #email').val(),
					tags: $('.add-post-form-unauthorized #tags').val(),
					csrf: $('.add-post-form-authorized #CSRF').val()
				},
				success: function (success) {
					console.log(success);
					location.href = 'http://dbonev.com/blog/post/all';
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			});
		}).on('submit', '.add-comment-form-authorized', function (event) {
			event.preventDefault();
			
			$.ajax({
				url: 'http://dbonev.com/blog/comment/add',
				type: 'post',
				data: {
					comment: $('.add-comment-form-authorized #comment').val(),
					name: $('.add-comment-form-authorized #name').val(),
					email: $('.add-comment-form-authorized #email').val(),
					postid: $('.add-comment-form-authorized #postId').val(),
					csrf: $('.add-comment-form-authorized #CSRF').val()
				},
				success: function (success) {
					console.log(success);
					location.href = 'http://dbonev.com/blog/post/view/' + '' + $('.add-comment-form-authorized #postId').val();
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			});
		}).on('submit', '.searchForm', function (event) {
			event.preventDefault();
			
			location.href = 'http://dbonev.com/blog/post/search/' + $('.searchForm #search').val();
		}).on('click', '.seemore', function () {
			var projectId = $(this).attr('class').split(' ')[1];
			
			$.ajax({
				url: 'http://dbonev.com/portfolio/modal/getProject/',
				data: {
					projectId: projectId
				},
				type: 'post',
				success: function (result) {
					var JSONResult = JSON.parse(result)[0];
					console.log(JSONResult);
					$('.modal .modal-title').text(JSONResult.title);
					$('.modal .modal-body img')
						.attr('src', '/gftest/public/img/projects/images/' + JSONResult.projectimage + '.jpg');
					$('.modal p').text(JSONResult.content);
					$('.modal .modal-footer a').attr('href', JSONResult.demo);
						
					$('.clickedProjectData').val(result);
				},
				error: function (error) {
					console.log(error);
					console.log(error.responseText);
				}
			})
		});
	})();
});