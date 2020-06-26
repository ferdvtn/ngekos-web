<div class='main-img'>
	<!-- SEARCH -->
	<div class="search row mx-5">
		<div class="col-md-6 mx-auto my-auto">
			<form class="form-search" action=<?= BASE_URL('search') ?> method='get'>
				<h1 class="text-center text-white" style='font-family:raleway, cursive;font-weight: lighter;'>TEMUKAN TEMPAT IMPIANMU DISINI</h1>
				<div class="form-row">
					<div class="form-group col-md-5 col-sm-4 col-6">
						<input class="form-input-search" type="text" name="q"  placeholder="Search Home.." value="<?= !empty($this->input->get('q')) ? $this->input->get('q') : null ?>">
					</div>
					<div class="form-group col-md-4 col-sm-4 col-6">
						<input class="form-input-search" type="text" name="adr"  placeholder="Address.." value="<?= !empty($this->input->get('adr')) ? $this->input->get('adr') : null ?>">
					</div>
					<div class="form-group col-md-3 col-sm-4 col-12">
						<button class='btn form-btn-search' type='submit'>search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="container">
	<!-- CONTENT -->
	<div class="row my-4 kos">
		<?php if (!empty($kos)) { ?>
			<?php foreach ($kos as $kos) { ?>
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