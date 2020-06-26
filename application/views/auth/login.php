<div class="container">
  <div class="auth">
	<form class="login-form rounded-lg shadow-sm" action=<?= BASE_URL('login') ?> method="post">
	<?php if (!empty($this->session->flashdata('flashError'))) { ?>
		<div class='alert alert-danger'>
			<?= $this->session->flashdata('flashError'); ?>
		</div>
	<?php } ?>
	<?php if (!empty($this->session->flashdata('flashSuccess'))) { ?>
		<div class='alert alert-success'>
			<?= $this->session->flashdata('flashSuccess'); ?>
		</div>
	<?php } ?>
	<div class="form-group">
		<label for="email">Email</label>
		<input type="text" class="form-input" name="email" placeholder="Masukan Email..">
		<small><?= form_error('email') ?></small>
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" class="form-input" name="password" placeholder="Masukan Password..">
		<small><?= form_error('password') ?></small>
	</div>
	<div class="form-group text-center">
		<input type="submit" class="mt-4 btn btn-auth form-control shadow" name="submit" value="login">
	</div>
	<hr>
	<small><a href=<?= BASE_URL('register') ?>>Create an account ?</a></small>
	</form>
  </div>
</div>