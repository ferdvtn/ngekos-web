<div class="container">
	<h3 class='mb-4' style="font-weight: lighter; ">Status pengajuan terbaru</h3>
	<?php if (!empty($status)) { ?>
		<div class="row">
			<?php foreach ($status as $s_item) { ?>
			<div class="col-md-4">
				<div class="status-item">
				<?php
				$border_bottom = 'border-bottom pb-1';
				if ($s_item->status == 1) {
					$title = 'Approve';
					$class = 'bg-primary text-white';
				} else {
					$title = 'Reject';
					$class = 'border border-danger bg-light text-danger';
					$border_bottom = 'border-bottom border-danger pb-1';
				}
				$s_item->title = $title;
				?>
					<a class="<?= $class ?> notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0">
						<h4 class="text-right<?= $border_bottom ?>"><?= $title ?></h4>
						<img class='float-left mr-2' style="height:20px" src=<?= base_url("assets/img/user/$s_item->id_pemilik/" . $this->lib_user->gpp($s_item->id_pemilik)) ?> alt="user picture">
						<div>
							<p class='m-0 overflow-hidden'><b><?= ucfirst($s_item->pemilik) ?></b> | <?= $s_item->nama_kos ?></p>
							<small>"<?php
							echo substr(ucfirst($s_item->keterangan),0,45);
							if(strlen($s_item->keterangan) > 45) echo '...';
							?>"</small>
						</div>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<div>Anda tidak memiliki pemberitahuan status terbaru !</div>
	<?php } ?>
</div>

<!-- REKOMENDASI KOS TERBARU -->
<div class="container">
	<div class="rec-kos"><span>Rekomendasi Terbaru</span></div>
	<div class="row my-4 kos">
		<?php if (!empty($kos_terbaru)) { ?>
			<?php foreach ($kos_terbaru as $kos) { ?>
				<div class="col-md-3 col-6 kos-item mb-5 p-1">
					<a class="text-decoration-none" style="color: rgba(0,0,0,.65);" href="<?= BASE_URL("/kos/d/$kos->id") ?>">
						<div class="bg-white overflow-hidden p-2">
							<div>
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