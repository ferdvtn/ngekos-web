<!doctype html>
<html lang="id">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href=<?= BASE_URL("assets/vendor/bootstrap/css/bootstrap.min.css") ?>>
	<link href=<?= BASE_URL("assets/css/simple-sidebar.css") ?> rel="stylesheet">
	<link href=<?= BASE_URL("assets/css/profile-style.css") ?> rel="stylesheet">
	<link href=<?= BASE_URL("assets/css/front-master.css") ?> rel="stylesheet">
	<link href=<?= BASE_URL("assets/css/crud-master.css") ?> rel="stylesheet">
	<link href=<?= BASE_URL("assets/vendor/sweetalert/animate.css") ?> rel="stylesheet">
	<link href=<?= BASE_URL("assets/vendor/swiper-master/package/css/swiper.min.css") ?> rel="stylesheet">
	<!-- font awesome -->
	<link href=<?= BASE_URL("assets/fontawesome-free-5.13.0-web/css/all.css") ?> rel="stylesheet">
	<!-- data tables -->
	<link href=<?= BASE_URL("assets/vendor/datatable/dataTables.bootstrap4.min.css") ?> rel="stylesheet">
	<script src=<?= BASE_URL("assets/fontawesome-free-5.13.0-web/js/all.js") ?>></script>
	<script src=<?= BASE_URL("assets/vendor/jquery-3.1.0.js") ?>></script>
	<script src=<?= BASE_URL("assets/vendor/datatable/jquery.dataTables.min.js") ?>></script>
	<script src=<?= BASE_URL("assets/vendor/datatable/dataTables.bootstrap4.min.js") ?>></script>
	<script src=<?= BASE_URL("assets/vendor/sweetalert/sweetalert2.all.min.js") ?>></script>
	<script>var base_url = '<?php echo base_url() ?>';</script>
	<style>
		/* @import url('https://fonts.googleapis.com/css?family=Pacifico|Raleway|Roboto&display=swap'); */
	</style>
	<title><?= $title ?></title>
</head>

<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light fixed-top">
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
					<!-- NOTIFICATIONS -->
					<?php if ($this->session->has_userdata('id_user')) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link nav-a dropdown-toggle" href="#" id="notifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Notification
							<?php if (isset($notif) && count($notif) > 0) { ?>
								<span class="notif-total"><?= count($notif) ?></span>
							<?php } ?>
						</a>
						<div class="dropdown-menu dropdown-menu-right border-0 bg-transparent" aria-labelledby="notifications">
						<?php
						if (isset($notif) && count($notif) > 0) {
							foreach ($notif as $idx => $ntf) {
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
							}
							?> <a class="notif dropdown-item bg-primary text-white shadow" href="<?= BASE_URL('user/n') ?>" style="border-radius: 10px; border-top-right-radius: 0">Tampilkan semua pemberitahuan (<?= count($notif) ?>)</a> <?php
						} else {
						?>
							<a class="bg-light notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0" href="">
								Tidak ada Pemberitahuan
							</a>
							<?php
							}
						?>
						</div>
					</li>
					<?php } ?>
					<!-- STATUS PENGAJUAN -->
					<?php if ($this->session->has_userdata('id_user')) { ?>
					<li class="nav-item dropdown">
						<a class="nav-link nav-a dropdown-toggle" href="#" id="notifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Status
							<?php if (isset($status_pengajuan) && count($status_pengajuan) > 0) { ?>
								<span class="notif-total"><?= count($status_pengajuan) ?></span>
							<?php } ?>
						</a>
						<div class="dropdown-menu dropdown-menu-right border-0 bg-transparent" aria-labelledby="notifications">
						<?php
						if (isset($status_pengajuan) && count($status_pengajuan) > 0) {
							foreach ($status_pengajuan as $idx => $status) {
							$border_bottom = 'border-bottom pb-1';
							if ($status->status_pengajuan == 1) {
								$title = 'Approve';
								$class = 'bg-primary text-white';
							} else {
								$title = 'Reject';
								$class = 'border border-danger bg-light text-danger';
								$border_bottom = 'border-bottom border-danger pb-1';
							}
							$status->title = $title;
							?>
								<a class="<?= $class ?> notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0">
									<h4 class="text-right <?= $border_bottom ?>"><?= $title ?></h4>
									<img class='float-left mr-2' style="height:20px" src=<?= $user_pic ?> alt="user picture">
									<div>
										<p class='m-0 overflow-hidden'><b><?= ucfirst($status->pemilik) ?></b> | <?= $status->nama_kos ?></p>
										<small>"<?php
										echo substr(ucfirst($status->keterangan),0,45);
										if(strlen($status->keterangan) > 45) echo '...';
										?>"</small>
									</div>
								</a>
								<?php
								if ($idx == 2) {
								break;
								}
							}
							?> <a class="notif dropdown-item bg-primary text-white shadow" href="<?= BASE_URL('user/s') ?>" style="border-radius: 10px; border-top-right-radius: 0">Tampilkan semua pemberitahuan (<?= count($status_pengajuan) ?>)</a> <?php
						} else {
						?>
							<a class="bg-light notif dropdown-item clearfix px-3 mb-1 shadow" style="border-radius: 10px; border-top-right-radius: 0" href="">
								Tidak ada Pemberitahuan
							</a>
							<?php
							}
						?>
						</div>
					</li>
					<?php } ?>
					<!-- USER -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img style="height:20px" src=<?= $user_pic ?> alt="user picture">
						</a>
						<div class="dropdown-menu dropdown-menu-right border-0 bg-transparent" aria-labelledby="navbarDropdown">
						<?php if ($this->session->has_userdata('id_user')) { ?>
							<a class="dropdown-item px-3 mb-1 bg-primary text-white shadow" style="border-radius: 10px; border-top-right-radius: 0"" href="<?= BASE_URL('/profile') ?>"><?= $user['nama'] ?></a>
							<a class="dropdown-item px-3 mb-2 bg-primary text-white shadow" style="border-radius: 10px; border-top-right-radius: 0"" href=<?= BASE_URL('auth/change_password') ?>>Change Password</a>
							<a class="bg-danger text-white dropdown-item px-3 mb-1 bg-primary text-white shadow" style="border-radius: 10px; border-top-right-radius: 0"" href="<?= BASE_URL('auth/logout') ?>">Logout</a>
						<?php } else { ?>
							<a class="dropdown-item px-3 mb-1 bg-primary text-white shadow" style="border-radius: 10px; border-top-right-radius: 0"" href=<?= BASE_URL('login') ?>>Login</a>
						<?php } ?>
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

