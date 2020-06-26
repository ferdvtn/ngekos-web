<div class="container">
	<div class="auth">
		<form class="register-form rounded-lg shadow-sm" action=<?= BASE_URL('register') ?> method="post">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" class="form-input" name="name" placeholder="Name.." value=<?=set_value('name')?>>
				<small><?= form_error('name') ?></small>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" class="form-input" name="email" placeholder="Email.." value=<?=set_value('email')?>>
				<small><?= form_error('email') ?></small>
			</div>
			<div class="form-group">
				<label for="no_handphone">No Handphone</label>
				<input type="text" class="form-input" name="no_handphone" placeholder="No Handphone.." value=<?=set_value('no_handphone')?>>
				<small><?= form_error('no_handphone') ?></small>
			</div>
			<div class="row">
				<div class="form-group col-6">
				<label for="password">Password</label>
				<input type="password" class="form-input" name="password" placeholder="Password..">
				<small><?= form_error('password') ?></small>
				</div>
				<div class="form-group col-6">
				<label for="password1">Confirm Password</label>
				<input type="password" class="form-input" name="password1" placeholder="Confirm Your Password..">
				</div>
			</div>
			<div class="form-group text-center mt-2">
				<input type="submit" class="mt-4 btn btn-auth form-control shadow" name="submit" value="register">
			</div>
			<hr>
			<small><a href=<?= BASE_URL('login') ?>>Have an account ?</a></small>
		</form>
	</div>
</div>