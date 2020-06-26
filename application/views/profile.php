<div class="container">
	<div class="mx-auto profile mb-5" style='max-width:700px'>
		<div class="profile m-3">
			<p><b><?= $user['nama'] ?></b></p>
			<p><?= $user['email'] ?></p>
			<p><?= $user['no_handphone'] ?></p>
			<p><?= !empty($user['alamat']) ? $user['alamat'] : '<i>alamat belum didaftarkan</i>' ?></p>
		</div>
		<form action="<?= BASE_URL('profile/edit') ?>" method="post" >
			<?php if (!empty($user['alamat'])) { ?>
				<input class='form-control btn btn-dark' type="submit" name="submit" id="submit" value="Edit Profile">
			<?php } else { ?>
				<input class='form-control btn btn-dark' type="submit" name="submit" id="submit" value="Lengkapi Profile">
			<?php } ?>
		<form>
	</div>

	<!-- CONTENT -->
	<div class="row mb-5">
		<div class="mx-auto">
			<a href="<?= BASE_URL('profile/add-kos') ?>" class="btn btn-success btn-sm mb-4"><span class="fa fa-list"></span> Tambah data kos</a>
			<a href="<?= BASE_URL('profile/penyewa') ?>" class="btn btn-primary btn-sm mb-4"><span class="fa fa-address-card"></span> Daftar penyewa</a>
			<table id="example" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Luas (m2)</th>
						<th>Harga</th>
						<th>Tersedia</th>
						<th>Opsi</th>
					</tr>
				</thead>
				<tbody>
				<?php if (!empty($kos)) {
				$i = 1 ?>
				<?php foreach ($kos as $kos_item) { ?>
					<tr>
						<td><?= $i ?></td>
						<td>
							<a href="<?= BASE_URL('kos/d/'.$kos_item->id) ?>"><?= $kos_item->judul ?></a>
						</td>
						<td><?= $kos_item->luas ?> m2</td>
						<td><?= $kos_item->harga ?> / bulan</td>
						<td><?= $this->lib_kos->hitungsisa($kos_item->id, $kos_item->pintu) ?></td>
						<td>
							<a class='btn btn-sm btn-success' href="<?= BASE_URL('kos/update?id='.$kos_item->id) ?>"><span class="fa fa-pen"></span> edit</a>
							<a class='btn btn-sm btn-pink delete-kos' href="<?= BASE_URL('kos/delete?id='.$kos_item->id) ?>"><span class="fa fa-trash"></span> delete</a>
						</td>
					</tr>
				<?php $i++; } }?>
				</tbody>
				<tfoot>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Luas (m2)</th>
						<th>Harga</th>
						<th>Tersedia</th>
						<th>Opsi</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

<script type='text/javascript'>

	$(document).ready(function() {
		$('#example').DataTable();
	} );

    $('.delete-kos').on('click', function (e) {
		e.preventDefault();
		var href = $(this).attr('href');

		Swal.fire({
		title: 'Anda yakin?',
		text: "Ingin menghapus data kos",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#007bff',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		})
	});

</script>