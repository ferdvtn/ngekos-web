<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<footer class='py-5'>
	<div class="container mt-0">
		<div class="row">
			<div class="col-md-6">
				<div class="footer-left">
					<img class='img-logo' src="<?= BASE_URL('assets/img/NGEKOS-blue.png') ?>" alt="ngekos logo">
					<div class="badge mybadge p-2 my-2">
						<p class='mb-0 text-white'>"Mau Sewa Kos ?"<br>
						Dapatkan info kos murah dan terbaik hanya di Aplikasi Ngekos</p>

					</div>
					<br>
					<a href="" class='mr-2'>
						<img class='img-app' src="<?= BASE_URL('assets/img/google-play.png') ?>" alt="Google Play">
					</a>
					<a href="">
						<img class='img-app' src="<?= BASE_URL('assets/img/app-store.png') ?>" alt="App Store">
					</a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="footer-center">
					<h4>NGEKOS INFO</h4></h4>
					<ul>
						<li><a href="#">Tentang Kami</a></li>
						<li><a href="#">Kebijakan Privasi</a></li>
						<li><a href="#">Syarat dan Ketentuan Umum</a></li>
						<li><a href="#">Pusat Bantuan</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-3">
				<div class="footer-right">
					<h4>HUBUNGI KAMI</h4></h4>
					<ul>
						<li>
							<img src="<?= base_url('assets/img/icon/email.svg') ?>" alt="email">
							<a href="#">contact@ngekos.com</a>
						</li>
						<li>
							<img class='p-1' src="<?= base_url('assets/img/icon/instagram.svg') ?>" alt="instagram">
							<a href="#">@ngekosapp</a>
						</li>
						<li>
							<img class='p-1' src="<?= base_url('assets/img/icon/whatsapp.svg') ?>" alt="whatsapp">
							<a href="#">08779940889</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>

<script src=<?= BASE_URL("assets/vendor/popper.js") ?>></script>
<script src=<?= BASE_URL("assets/vendor/bootstrap/js/bootstrap.min.js") ?>></script>
<!-- Optional JavaScript -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });
</script>
</body>

</html>