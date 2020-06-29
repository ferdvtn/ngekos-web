<!-- Leaflet and esri -->
<script src=<?= BASE_URL("assets/vendor/leaflet/leaflet.js") ?>></script>
<link rel="stylesheet" href=<?= BASE_URL("assets/vendor/leaflet/leaflet.css") ?>>
<style type="text/css">
	#mapid {
		height: 300px;
		width: -webkit-fill-available;
	}
	.fasilitas {
		margin : 60px auto 12px;
	}
	.fasilitas img{
		width : 40px;
	}
	 .swiper-container {
		width: 100%;
		height: 400px;
		margin-left: auto;
		margin-right: auto;
	}

	@media (max-width: 590px) {
		.swiper-container {
			max-width: 340px;
		}
	}

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;

      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }
</style>

<div class="container">
	<div class="row mb-3">
		<div class="col-md-8 mb-5">
			<!-- Swiper -->
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<?php if (!empty($kos->title)) { ?>
						<?php foreach ($kos->title as $img) { ?>
								<img class='swiper-slide' src="<?= BASE_URL("assets/img/kos/$kos->id/$img") ?>" alt="<?= $img ?>">
						<?php } ?>
					<?php } else { ?>
						<div class="swiper-slide"><img src="<?= BASE_URL("assets/img/no-photo.png") ?>" alt="<?= 'no-photo-available' ?>"></div>
					<?php } ?>
				</div>

				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>

				<!-- Add Arrows -->
				<?php if (!empty($kos->title)) { ?>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				<?php } ?>

			</div>
			<br>
			<hr>
			<div class='konten'>
				<h4 class='konten-judul'><?= $kos->judul ?></h4>
				<p class='konten-alamat'><?= $kos->alamat ?></p>
				<p class='konten-keterangan'><?= $kos->keterangan ?></p>
			</div>
			<?php if (!empty($kos->fasilitas)) { ?>
			<div class="fasilitas">
				<h4 class='mb-4 title-primary'>Fasilitas</h4>
				<div class="row">
					<?php foreach ($kos->fasilitas as $faskey => $fasval) { ?>
						<?php if ($faskey != 'id_kos' && ($faskey != 'updated_at' && ($faskey != 'created_at'))) { ?>
							<?php if ($fasval != 0) { ?>
							<div class="text-center col -4 col-sm-3 col-md-2 mb-4">
								<img class='mb-2' src='<?= base_url("assets/img/icon/$faskey.png") ?>' alt='<?= $faskey ?>'>
								<p><?= unLineToSpace($faskey) ?></p>
							</div>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="col-md-4">
			<div class="side-detail shadow-sm rounded-lg mb-3">
				<div class='clearfix mb-3'>
					<img class='float-left mt-1' src="<?= BASE_URL('assets/img/user-default.png') ?>" alt="profile-picture">
					<span class="float-left ml-3">
						<b><?= $kos->pemilik ?></b>
						<p class='detail-no-hp mb-0'><?= $kos->no_handphone ?></p>
					</span>
				</div>
				<p class="kamar"><span class='fas fa-bed'></span> Tersisa <?= $this->lib_kos->hitungsisa($kos->id, $kos->pintu) ?>	 kamar</p>
				<p class="float-left">Per bulan :</p>
				<p class='text-right mb-0'>
					<b class='detail-harga'>Rp.<?= number_format($kos->harga) ?></b>
				</p>
			</div>
			<div class="side-detail shadow-sm rounded-lg mb-3">
				<?php if ($this->session->userdata('id') != null) {
					if ($kos->id_pemilik === $this->session->userdata('id')) { ?>
						<div class="form-row">
							<div class="col-6">
								<a class='detail-btn-1 form-control' href="<?= base_url("kos/update?id=$kos->id") ?>">Perbarui</a>
							</div>
							<div class="col-6">
								<a id="hapus-kos" class='detail-btn-2 form-control' href="<?= base_url("kos/delete?id=$kos->id") ?>">Hapus</a>
							</div>
						</div>
					<?php } else { ?>
						<div class="form-row">
							<div class="col-6">
								<button id="kontak-pemilik" class="detail-btn-1 form-control" data-kontak='<?= json_encode($kos) ?>'>Kontak Pemilik</button>
							</div>
							<?php if ($this->lib_kos->hitungsisa($kos->id, $kos->pintu) > 0) { ?>
								<div class="col-6">
									<button class="detail-btn-2 form-control ajukan">Booking</button>
								</div>
							<?php } else { ?>
								<div class="col-6">
									<button disabled class="detail-btn-3 form-control disabled">SOLD OUT</button>
								</div>
							<?php } ?>
						</div>
					<?php }
					} else {
						$idkos = !empty($this->input->get('id')) ? $this->input->get('id') : null; ?>
						<a class='detail-btn-1 form-control text-decoration-none' href="<?= BASE_URL("login?kos=$idkos") ?>">Login Untuk Booking</a>
				<?php } ?>
				<hr>
				<i>"Pastikan kamu telah membaca deskripsi & fasilitas kos ini"</i>
			</div>
			<?php if (!empty($kos->lat) && !empty($kos->lng)) { ?>
			<div class="side-detail shadow-sm rounded-lg">
				<b>Lokasi</b>
				<div id="mapid" style="z-index: -1;"></div>
				<script type='text/javascript'>
					// maps
					var lat = <?php echo $kos->lat ?>;
					var lng = <?php echo $kos->lng ?>;

					var mapOptions = {
						center: [lat,lng],
						zoom: 15
					}

					var map = new L.map('mapid', mapOptions);

					var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
					map.addLayer(layer);

					var marker = L.marker([lat,lng]).addTo(map);
					marker.bindPopup("<b>Here!</b>").openPopup();
				</script>
			</div>
			<br><br>
			<?php } ?>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-md-8">
			<div class="disqus">
				<p class='title-primary'>Komentar</p>
				<?php echo $disqus ?>
			</div>
		</div>
	</div>
</div>

<div class="popup-ajukan">
	<div class="popup-ajukan-content shadow-lg border">
		<h1>Form pengajuan</h1>
		<img class="popup-close" src="<?= BASE_URL('assets/img/close-window.png') ?>" alt="profile-picture">
		<hr>
		<?php
		$hidden = [
			'id' => $kos->id,
			'id_pemilik' => $kos->id_pemilik
		];
		?>
		<?= form_open(base_url("kos/pengajuan"), '', $hidden) ?>
			<div class="form-group">
				<label for="penghuni">Jumlah penghuni</label>
				<input type="number" class="form-control" name="penghuni" placeholder="ex : 3">
			</div>
			<div class="form-group">
				<label for="keterangan">Keterangan tambahan</label>
				<textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="ex : Mau cari yang ada AC nya."></textarea>
			</div>
			<div class="form-group">
				<input class="form-control btn btn-success" type="submit" name="submit" value="Ajukan">
			</div>
		<?= form_close() ?>
	</div>
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

<script type="text/javascript">

	$('.ajukan').click(function(e){
        $('.popup-ajukan').css('display', 'flex');
	});

    $('.popup-close').click(function(e){
        $('.popup-ajukan').hide();
	});

	//  slide img
	$(function() {
		//  configuration
		var width = 720;
		var animationSpeed = 500;
		var pause = 3000;
		var currentSlide = 1;

		// cache DOM
		var $slider = $('#slider');
		var $slideContainer = $slider.find('.slides');
		var $slides = $slideContainer.find('.slide');

		$('.goRight').click(function () {
			rightSlider();
		});
		$('.goLeft').click(function () {
			leftSlider();
		});

		function leftSlider() {
			currentSlide --;
			if (currentSlide < 1) {
				currentSlide = $slides.length;
				$slideContainer.animate({'margin-left' : '-'+(width*($slides.length-1))}, animationSpeed);
			} else {
				$slideContainer.animate({'margin-left' : '+='+width}, animationSpeed);
			}
		}

		function rightSlider() {
			currentSlide ++;
			if (currentSlide > $slides.length) {
				currentSlide = 1;
				$slideContainer.animate({'margin-left' : 0}, animationSpeed);
			} else {
				$slideContainer.animate({'margin-left' : '-='+width}, animationSpeed);
			}
		}

	});

</script>

<script type="text/javascript">
	$('#hapus-kos').on('click', function(e) {
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

	$('#kontak-pemilik').on('click', function (e) {
		var kontak = $(this).data('kontak');
		var str="<hr><b>Nama</b> : "+ kontak.pemilik + "<br>" +
				"<b>Kontak</b> : "+ kontak.no_handphone + "<br>" +
				"<b>Alamat</b> : "+ ((kontak.alamat_pemilik != null) ? kontak.alamat_pemilik : 'Belum terdaftar');
		Swal.fire({
			title: 'Kontak Pemilik',
			showClass: {
				popup: 'animated fadeInUp faster'
			},
			hideClass: {
				popup: 'animated fadeOutDown faster'
			},
			html: str,
			icon : 'info'
		})
	});
</script>

<script src=<?= BASE_URL("assets/vendor/swiper-master/package/js/swiper.min.js") ?>></script>
<!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween: 30,
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>