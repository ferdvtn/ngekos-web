<!doctype html>
<html lang="id">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href=<?= BASE_URL("assets/vendor/bootstrap/css/bootstrap.min.css") ?>>
	<link href=<?= BASE_URL("assets/css/auth-master.css") ?> rel="stylesheet">
	<link href=<?= BASE_URL("assets/vendor/sweetalert/animate.css") ?> rel="stylesheet">
	<!-- font awesome -->
	<link href=<?= BASE_URL("assets/fontawesome-free-5.13.0-web/css/all.css") ?> rel="stylesheet">
	<script src=<?= BASE_URL("assets/fontawesome-free-5.13.0-web/js/all.js") ?>></script>
	<!-- data tables -->
	<script src=<?= BASE_URL("assets/vendor/jquery-3.1.0.js") ?>></script>
	<script src=<?= BASE_URL("assets/vendor/sweetalert/sweetalert2.all.min.js") ?>></script>
	<script>var base_url = '<?php echo base_url() ?>';</script>
	<style>
		/* @import url('https://fonts.googleapis.com/css?family=Pacifico|Raleway|Roboto&display=swap'); */
	</style>
	<title><?= $title ?></title>
</head>

<body>
	<header>
		<nav class="text-white navbar navbar-expand-lg navbar-light fixed-top">
			<a class="navbar-brand" href="<?= BASE_URL('/') ?>">
				<img class='navbar-img' src="<?= BASE_URL('assets/img/NGEKOS-blue.png') ?>" height="30" alt="Ngekos Logo">
			</a>
			<button class="navbar-toggler bg-white text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
					<li class="nav-item">
						<a class="nav-link nav-a" href="<?= BASE_URL('/') ?>">Home</a>
					</li>
					<!-- USER -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img style="height:20px" src=<?= $user_pic ?> alt="user picture">
						</a>
						<div class="dropdown-menu dropdown-menu-right border-0 bg-transparent" aria-labelledby="navbarDropdown">
						<a class="dropdown-item px-3 mb-1 bg-primary text-white shadow" style="border-radius: 10px; border-top-right-radius: 0"" href=<?= BASE_URL('login') ?>>Login</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<div id="alert" data-flashdata='<?= !empty($this->session->flashdata()) ? json_encode($this->session->flashdata()) : null ?>'></div>

	<script type="text/javascript">

		var flashdata = $('#alert').data('flashdata');
		if (flashdata) {
			var _icon = 'success';
			var _title = 'Berhasil';
			if (flashdata.class == 'alert-danger') {
				var _icon = 'error';
				var _title = 'Oops...';
			}

			Swal.fire({
				icon: _icon,
				title: _title,
				text: flashdata.flashdata,
				// footer: flashdata.flashdata
			})
		}

		// configurasi scroll nav
		$(window).scroll(function () {
			var target = 10;
			if ($('html').scrollTop() > target) {
				$('nav').css({
					'background-color' : '#007bff',
					'transition' : '.3s'
				});
				$('nav .nav-a').css({
					'color' : '#fff'
				});
				// assets/img/NGEKOS-white.png
				$('.navbar-img').attr('src', base_url + 'assets/img/NGEKOS-white.png');
			} else if ($('html').scrollTop() <= target) {
				$('nav').css({
					'background-color' : 'transparent',
					'transition' : '.3s'
				});
				$('nav .nav-a').css({
					'color' : '#007bff'
				});
				$('.navbar-img').attr('src', base_url + 'assets/img/NGEKOS-blue.png');
			}
		});

	</script>

