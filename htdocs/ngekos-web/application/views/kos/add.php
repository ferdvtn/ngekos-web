<!-- Leaflet and esri -->
<script src=<?= BASE_URL("assets/vendor/leaflet/leaflet.js") ?>></script>
<link rel="stylesheet" href=<?= BASE_URL("assets/vendor/leaflet/leaflet.css") ?>>
<script src=<?= BASE_URL("assets/vendor/leaflet/esri-leaflet.js") ?>></script>
<script src=<?= BASE_URL("assets/vendor/leaflet/esri-leaflet-geocoder.js") ?>></script>
<link rel="stylesheet" type="text/css" href="https://cdn-geoweb.s3.amazonaws.com/esri-leaflet-geocoder/0.0.1-beta.5/esri-leaflet-geocoder.css">
<style type="text/css">
	.map {
		position : fixed;
		height: 100%;
		width: 100%;
		display : none;
		/* display : flex; */
	}
	.map #mapid {
		height: 70%;
		width: 70%;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	.map .close-map {
		position : absolute;
		top : 10%;
		left : 50%;
		transform: translate(-50%, 0);
		cursor : pointer;
		opacity : .7;
		z-index: 10;
	}
	html, body {
		height: 100%;
	}
	.fas-cekbox {
		display: inline-block;
		margin : 2px 10px;
	}
</style>

<div class="map fixed-top">
	<div id="mapid" class='shadow-lg'></div>
	<div class="close-map">
	<span class="far fa-lg fa-times-circle"></span>
	</div>
</div>

<div class="container">
	<div class="row">
	  <div class="my-5 mx-auto">
		<h1>Add your new kos</h1>
		<hr>

		<?php
		  $attr = ['class' => 'px-4 py-3 border rounded shadow bg-white', 'style' => 'max-width: 700px'];
		  $hidden = [
			  'id_pemilik' => $user['id'],
			  'lat' => set_value('lat'),
			  'lng' => set_value('lng'),
			];
		  echo form_open_multipart('main/tambahKos', $attr, $hidden);
		?>
		  <?php if (!empty($this->session->flashdata('flashError'))) { ?>
			<div class='alert alert-danger'>
				<?= $this->session->flashdata('flashError'); ?>
			</div>
		  <?php } ?>
		  <div class="form-group">
			<label for="judul">Title</label>
			<input type="text" value="<?= set_value('judul') ?>" id="judul" class="form-control" name="judul" placeholder="Nama kosan">
			<small><?= form_error('judul') ?></small>
		  </div>
		  <div class="form-group">
			<label for="alamat">Alamat</label>
			<a href="#" class='detail-btn-1' id="open-map">MAPS</a>
			<textarea name="alamat" class="form-control" id="alamat" rows="5"><?= set_value('alamat') ?></textarea>
			<small><?= form_error('alamat') ?></small>
		  </div>
		  <div class="form-row">
			<div class="form-group col">
				<label for="luas">Luas</label>
				<input type="text" value="<?= set_value('luas') ?>" id="luas" class="form-control" name="luas" placeholder="Luas kamar (m2)">
				<small><?= form_error('luas') ?></small>
			</div>
			<div class="form-group col">
			  <label for="harga">Harga</label>
			  <input type="text" value="<?= set_value('harga') ?>" name="harga" id="harga" class="form-control" placeholder="Harga (per bulan)">
			  <small><?= form_error('harga') ?></small>
			</div>
			<div class="form-group col">
			  <label for="pintu">Pintu</label>
			  <input type="text" value="<?= set_value('pintu') ?>" name="pintu" id="pintu" class="form-control" placeholder="Jumlah pintu">
			  <small><?= form_error('pintu') ?></small>
			</div>
		  </div>
		  <div class="form-group">
			  <label for="img_kos">Foto kamar <small><i>max : 5 foto</i></small></label><br>
			  <?php echo form_upload(['name' => 'img_kos[]', 'multiple' => true], set_value('img_kos[]')) ?>
		  </div>
		  <div class="form-group">
			<label>Fasilitas</label><br>
			<?php
				foreach ($fasilitas as $fas) {
					if ($fas != 'id_kos' && ($fas != 'updated_at' && ($fas != 'created_at'))) {
						$tmp_fas = array(
							'name'          => "fasilitas[$fas]",
							'class'         => 'fas-cekbox-input',
							'id'            => $fas,
							'value'         => $fas,
							'checked'       => set_value("fasilitas[$fas]"),
						);
						echo "<div class='fas-cekbox'>";
							echo form_checkbox($tmp_fas);
							echo form_label(unLineToSpace($fas), $fas, ['class' => 'form-check-label']);
						echo "</div>";
					}
				}
			?>
		  </div>
		  <div class="form-group">
			<label for="keterangan">Keterangan</label>
			<textarea name="keterangan" class="form-control" id="keterangan" rows="5"><?= set_value('keterangan') ?></textarea>
		  </div>
		  <div class="form-group text-center">
			<input type="submit" class="btn btn-info shadow" name="submit" value="Process">
		  </div>
		  <hr>
		  <small><a href=<?= BASE_URL('profile') ?>>Back</a></small>
		<?= form_close() ?>
	  </div>
	</div>
</div>

<script type='text/javascript'>

	$('#open-map').on('click', function () {
		$('.map').css('display', 'flex');
	});

	$('.close-map').on('click', function () {
		$('.map').css('display', 'none');
	});

</script>

<script type="text/javascript">

	if ($('[name=lat]').val().length === 0) { var lat = -6.170896486266472 }
	// else {var lat = $('[name=lat]').val()}
	else {var lat = $('[name=lat]').val()}
	if ($('[name=lng]').val().length === 0) { var lng = 106.8265889387204 }
	else {var lng = $('[name=lng]').val()}

	// This setup the leafmap object by linking the map() method to the map id (in <div> html element)
	var map = L.map('mapid', {
		center: [lat, lng],
		zoom: 15,
		minZoom: 1.5,
		//   maxZoom: 15
	});

	// Start adding controls as follow... L.controlName().addTo(map);

	// Control 1: This add the OpenStreetMap background tile
	L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);


	// Control 2: This add a scale to the map
	L.control.scale().addTo(map);

	// Control 3: This add a Search bar
	var searchControl = new L.esri.Controls.Geosearch().addTo(map);

	var results = new L.LayerGroup().addTo(map);

	searchControl.on('results', function(data){
		results.clearLayers();
		for (var i = data.results.length - 1; i >= 0; i--) {
			results.addLayer(L.marker(data.results[i].latlng).addTo(map));
		}
	});

	map.on('dblclick', function (e) {
        $('[name=lat]').val(e.latlng.lat);
        $('[name=lng]').val(e.latlng.lng);
		var marker = L.marker([e.latlng.lat,e.latlng.lng]).addTo(map);
		marker.bindPopup('<b>Here!</b>').openPopup();
    	alert("Maps telah ditandai!");
	});


</script>