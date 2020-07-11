<style>
	#profile_pic {
		background-image : url(<?= $user_pic ?>); /* 50% 50% centers image in div */
		background-position-x : 50%;
		background-position-y : 50%;
		background-size : cover;
		width: 180px;
		height: 180px;
		border-radius : 50%;
		 -webkit-transition: .2s;
	}
	#profile_pic a {
		border-radius : 50%;
		display: block;
		width: 180px;
		height: 180px;
	}

	#profile_pic:hover {
		/* background-color : rgba('255', '0', '0', '.5'); */
		-webkit-filter: brightness(70%);
		-webkit-transition: all .2s ease;
		-moz-transition: all .2s ease;
		-o-transition: all .2s ease;
		-ms-transition: all .2s ease;
		transition: all .2s ease;
	}
</style>
<div class="container">
	<div class="mx-auto profile" style='max-width:700px'>
		<?php if (!empty($this->session->flashdata('successAlert'))) { ?>
		<div class="mt-3 alert alert-success">
			<?= $this->session->flashdata('successAlert') ?>
		</div>
		<?php } ?>
		<?php if (!empty($this->session->flashdata('errorAlert'))) { ?>
		<div class="mt-3 alert alert-danger">
			<?= $this->session->flashdata('errorAlert') ?>
		</div>
		<?php } ?>
		<div class="profile-head row mt-5">
			<?= form_open_multipart(BASE_URL('user/cp'), ['id'=>'form_picture']) ?>
				<input type="hidden" name="id" value="<?= $user['id'] ?>">
				<input type="file" name="profile_pict" id="profile_pict_hidden" style="display:none">
			<?= form_close() ?>
			<div id="profile_pic">
				<a href="#" id="profile_pict"> </a>
			</div>
			<div class='col-md-7 col-sm-12 my-auto'>
				<p class='px-3 py-2 float-left shadow'>Kos : <b><?= !empty($totalKamarKos) ? $totalKamarKos : 0 ?></b></p>
				<p class='ml-2 px-3 py-2 float-left shadow'>Tersewa : <b><?= $tersewa ?></b></p>
				<p class='ml-2 px-3 py-2 float-left shadow'>Sisa : <b><?= $sisa ?></b></p>
			</div>
		</div>
		<hr>
	</div>
</div>

<script type='text/javascript'>

	// mengganti foto profile
	$('#profile_pict').click(function(){ $('#profile_pict_hidden').trigger('click'); });
	$('#profile_pict_hidden').change(function() {
		$('#form_picture').submit();
	});

</script>