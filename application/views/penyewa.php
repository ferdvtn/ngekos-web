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
	<div class="mb-5">
		<div class="mx-auto" style='width:700px'>
			<a href="<?= BASE_URL('profile') ?>" class="btn btn-success btn-sm mb-4"><span class="fa fa-warehouse"></span> Daftar Kos</a>
			<table id="example" class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Title</th>
						<th>Penyewa</th>
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
							<a href="<?= BASE_URL('kos?id='.$kos_item->id) ?>"><?= $kos_item->judul ?></a>
						</td>
						<td><?= $kos_item->nama_penyewa ?></td>
						<td>
							<a class='btn btn-sm btn-pink delete-kos' href="<?= BASE_URL('home/delete_penyewa?id='.$kos_item->id_tersewa) ?>"><span class="fa fa-trash"></span> delete</a>
						</td>
					</tr>
				<?php $i++; } }?>
				</tbody>
				<tfoot>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Penyewa</th>
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

    $('.delete-kos').on('click', function () {
        return confirm('Konfirmasi! Ingin menghapus data kos ?');
	});

</script>