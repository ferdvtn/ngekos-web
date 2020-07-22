<div class="container">
	<h3 class='mb-4' style="font-weight: lighter; ">Pemberitahuan</h3>
	<div class="row">
		<?php
		if (isset($notif) && count($notif) > 0) {
		foreach ($notif as $idx => $ntf) {
			?>
			<div class="col-md-4">
				<div class="notif-item">
					<?php
					$ntf_status = '';
					$ntf_title = '';
					$ntf_class = 'bg-primary text-white';
					$ntf_info = 'To : <b>' . $this->user_model->get_by_id($ntf->id_user_pemilik)['nama']. '</b>';
					$ntf->title = "Approval tersampaikan";

					// jika ada request pengajuan
					if ($ntf->id_user_pemilik == $this->session->userdata('id_user')) {
						$ntf_title = "<h4 class='text-right text-primary border-bottom border-primary pb-1'>New Approval</h4>";
						$ntf_class = 'bg-light border border-primary';
						$ntf_info = 'From : <b>'.$ntf->pengaju . '</b>';
						$ntf->title = "";
						if (isset($ntf->status) AND $ntf->status == 'disetujui') {
						$ntf_status = "<p class='float-left badge badge-success py-1 px-2 mt-2'>Disetujui</p>";
						$ntf_title = "<h4 class='text-right text-success border-bottom border-success pb-1'>Approval</h4>";
						$ntf_class = 'bg-light border border-success';
						} elseif (isset($ntf->status) AND $ntf->status == 'ditolak') {
							$ntf_status = "<p class='float-left badge badge-danger py-1 px-2 mt-2'>Ditolak</p>";
							$ntf_title = "<h4 class='text-right text-danger border-bottom border-danger pb-1'>Approval</h4>";
							$ntf_class = 'bg-light border border-danger';
						}
					}
					?>

					<?php if ($ntf->id_user_pemilik == $this->session->userdata('id_user')) {
						if (isset($ntf->status) AND $ntf->status == 'disetujui' || $ntf->status == 'ditolak') { ?>
						<a onclick='editNotif(<?= json_encode($ntf) ?>)' class="<?=$ntf_class?> notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0"> <?php
						} else { ?>
						<a onclick='showNotif(<?= json_encode($ntf) ?>)' class="<?=$ntf_class?> notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0"> <?php
						}?>
					<?php } else { ?>
						<a class="<?=$ntf_class?> notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0">
					<?php } ?>
						<div class="clearfix">
							<?= $ntf_status ?>
							<?= $ntf_title ?>
						</div>
						<img class='float-left mr-2' style="height:20px" src=<?= $user_pic ?> alt="user picture">
						<div>
							<p class='m-0 overflow-hidden '><b><?=$ntf_info?></b> | <?= $ntf->nama_kos ?></p>
							<small>"<?php
							echo substr(ucfirst($ntf->keterangan),0,45);
							if(strlen($ntf->keterangan) > 45) echo '...';
							?>"</small>
						</div>
						</a>
						<?php
						if ($idx == 2) {
						break;
					}
				?>
				</div>
			</div>
		<?php }} else { ?>
			<div>Anda tidak memiliki pemberitahuan status terbaru !</div>
		<?php } ?>
	</div>
</div>

<!-- REKOMENDASI KOS TERBARU -->
<div class="container">
	<div class="rec-kos"><span>Rekomendasi Terbaru</span></div>
	<div class="row my-4 kos">
		<?php if (!empty($kos_terbaru)) { ?>
			<?php foreach ($kos_terbaru as $kos) { ?>
				<div class="col-md-3 col-6 kos-item mb-5 p-1">
					<a class="text-decoration-none" style="color: rgba(0,0,0,.65);" href="<?= BASE_URL("/kos/d/$kos->id_kos") ?>">
						<div class="bg-white overflow-hidden p-2">
							<div>
							<!-- TODO : belum menampilkan gambar  -->
							<?php if (!empty($kos->title)) { ?>
								<img  src="<?= BASE_URL("assets/img/kos/$kos->id/") . $kos->title[0] ?>" alt="tampilan rumah" class='thumbnail'>
							<?php } else {?>
								<img  src="<?= BASE_URL('assets/img/home-default.jpg') ?>" alt="tampilan rumah" class='thumbnail'>
							<?php } ?>
							</div>
							<div style='font-size:.8em'>
								<span class='text-info font-weight-bold'><?= $kos->pemilik ?></span>
								<span class='badge badge-primary' style='font-family:Roboto, sans-serif'><?= $kos->no_handphone ?></span>
							</div>
							<div style='font-size:.9em; font-family:monospace' class='font-weight-bold mb-1'><?= $kos->harga ?> /bulan</div>
							<div style='font-size:.9em'>
								<div style='font-weight: 600; font-family:Roboto, sans-serif'><?= $kos->judul ?></div>
								<div style='font-size:.8em; font-family:Roboto, sans-serif'><?= $kos->alamat ?></div>
							</div>
						</div>
					</a>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
</div>