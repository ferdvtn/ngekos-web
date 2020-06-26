<div class="container">
	<div class="row">
		<div class="my-5 mx-auto">
			<a class='btn btn-dark mb-4' href="<?= BASE_URL('profile') ?>">back</a>
			<h1>Edit Profile</h1>
			<hr>
			<form class='bg-white p-3 shadow' action="<?= BASE_URL('user/edit') ?>" method="post" >
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="nama">Nama</label>
							<input class='form-control' type="text" name="nama" id="nama" value=<?= $user['nama'] ?>>
							<small><?= form_error('nama') ?></small>
						</div>
					</div>
					<div class="col">
						<div class="form-group">
							<label for="no_handphone">No Handphone</label>
							<input class='form-control' type="text" name="no_handphone" id="no_handphone" value=<?= $user['no_handphone'] ?>>
							<small><?= form_error('no_handphone') ?></small>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input class='form-control' type="email" name="email" id="email" value=<?= $user['email'] ?>>
					<small><?= form_error('email') ?></small>
				</div>

				<div class="form-group">
				<label for="alamat">Alamat</label>
					<textarea class='form-control' name="alamat" id="alamat" cols="30" rows="10"><?= $user['alamat'] ?></textarea>
					<small><?= form_error('alamat') ?></small>
				</div>
				<div class="form-group">
					<button class='form-control btn btn-primary' type="submit" name="submit">Update</button>
				</div>
			<form>
		</div>
	</div>
</div>