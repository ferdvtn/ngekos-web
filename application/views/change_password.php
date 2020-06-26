<div class="row">
  <div class="my-5 mx-auto">
    <h1>Change Password</h1>
    <hr>
    <form class="px-4 py-3 border rounded shadow bg-white " action=<?= BASE_URL('auth/change_password') ?> method="post">
      <?php if (!empty($this->session->flashdata('flashError'))) { ?>
        <div class='alert alert-danger'>
            <?= $this->session->flashdata('flashError'); ?>
        </div>
      <?php } ?>
      <div class="form-group">
        <label for="current_password">Password</label>
        <input type="password" class="form-control" name="current_password" placeholder="Current Password..">
        <small><?= form_error('current_password') ?></small>
      </div>
      <div class="form-group">
        <label for="new_password1">New Password</label>
        <input type="password" class="form-control" name="new_password1" placeholder="New Password..">
        <small><?= form_error('new_password1') ?></small>
      </div>
      <div class="form-group">
        <label for="new_password2">Password Verify</label>
        <input type="password" class="form-control" name="new_password2" placeholder="Password Verify..">
      </div>
      <div class="form-group text-center">
        <input type="submit" class="btn btn-info shadow" name="submit" value="Process">
      </div>
      <hr>
      <small><a href=<?= go_back() ?>>Back to Home</a></small>
    </form>
  </div>
</div>
