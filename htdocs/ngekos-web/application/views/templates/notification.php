<div class="popup-notif shadow">
    <img class="popup-notif-close" src="<?= BASE_URL('assets/img/close.png') ?>" alt="close-picture">
    <div class="popup-notif-content">
        <h1 class="text-primary"></h1>
        <b class="text-primary"></b>
        <hr>
        <p class="ket"></p>
    </div>
    <div class="popup-notif-approval my-auto text-center">
        <?php
            $hidden = [
                'id' => '',
                'id_pemilik' => '',
                'id_penyewa' => '',
                'id_kos' => '',
                'penghuni' => '',
                'keterangan' => '',
                'status' => 1
			];
			$attributes = array('id' => 'form-notif');
            echo form_open('tersewa/approval', $attributes, $hidden);
        ?>
        <input type="submit" name="submit" class="btn btn-lg border-white btn-success shadow" style="min-width:70%" value="Approve">
        <?php echo form_close(); ?>
        <hr>
        <button id="reject" class="btn btn-lg btn-danger border-white text-white" style="min-width:70%">Reject</button>
        <div class="reject-hidden">
            <?php
                $hidden = [
                    'id' => '',
                    'id_pemilik' => '',
                    'id_penyewa' => '',
                    'id_kos' => '',
                    'penghuni' => '',
                    'status' => 0
                ];
                echo form_open('tersewa/approval', 'id="notif"', $hidden);
            ?>
            <div class="form-group center">
                <textarea id='keterangan' style="width: 70%" name="keterangan" class="form-control mx-auto"></textarea>
                <label for="keterangan">Masukan alasan penolakan anda</label>
            </div>
            <input type="submit" name="submit" class="btn btn btn-danger shadow" style="min-width:50%" value="Confirm Reject">
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showNotif(data) {
        $('.popup-notif').css('display', 'flex');
        $('.popup-notif-content>h1').text(data.pengaju);
        $('.popup-notif-content>b').text(data.no_pengaju);
        $('.popup-notif-content>.ket').text('"'+data.keterangan+'"');
        $('[name=id]').val(data.id);
        $('[name=id_pemilik]').val(data.id_pemilik);
        $('[name=id_penyewa]').val(data.id_pengaju);
        $('[name=id_kos]').val(data.id_kos);
        $('[name=penghuni]').val(data.penghuni);
		$('[name=keterangan]').val(data.keterangan);
		$('html,body').animate({ scrollTop: 0 }, 'slow');
    }

    $('.popup-notif-close').click(function () {
        $('.popup-notif').css('display', 'none');
    });

    $('#reject').click(function () {
        $('.reject-hidden').css('display', 'block');
        $('#keterangan').val('Kepada Yth : ');
     });
</script>