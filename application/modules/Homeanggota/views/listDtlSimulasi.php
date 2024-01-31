<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Simulasi</h2>
                <div class="clearfix"></div>
            </div>
            <form class="form-horizontal form-label-left" autocomplete="off">
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Simulasi Berdasarkan</label>
                    <div class="col-md-2 col-sm-1 col-xs-3">
                        <select name="kategorisimulasi" id="idkategorisimulasi" class="form-control col-md-7 col-xs-12" required>
                            <option value="">.: Pilih :.</option>
                            <option value="nip">NIP</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> NIP</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="nipfield" id="idnipfield" required class="form-control col-md-7 col-xs-12" readonly value="">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Sisa masa jabatan (bulan)</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="sisajabatan" id="idsisajabatan" required class="form-control col-md-7 col-xs-12" readonly value="">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Sisa Gaji Pokok</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="gajipk" id="gajipk" required class="form-control col-md-7 col-xs-12 nominal" value="">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jumlah Pinjaman</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="pinjaman" id="pinjaman_simulasi" required class="form-control col-md-7 col-xs-12 nominal" value="">
                    </div>
                </div>
                <div class="form-group required">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jumlah Angsuran</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="angsuran" id="angsuran" required class="form-control col-md-7 col-xs-12 angka" value="">
                    </div>
                </div>
                <input type="hidden" name="nip" id="nip" required class="form-control col-md-7 col-xs-12" value="<?= $_SESSION['nip']; ?>">
                <!-- <div class="form-group required">
                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">Tgl Kunjungan</label>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="input-group">
                            <input type="text" name="tgl_dari" id="tgl_dari" required class="form-control col-md-2 col-xs-10 tanggal text-center">
                            <span class="input-group-addon"><b>s/d</b></span>
                            <input type="text" name="tgl_sampai" id="tgl_sampai" required class="form-control col-md-2 col-xs-10 tanggal text-center">
                        </div>
                    </div>
                </div> -->
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <a class="btn btn-sm btn-success" id="tampil"><i class="glyphicon glyphicon-search"></i> Simulasikan</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="tampilDataSimulasi"></div>

<script type="text/javascript">
    $(document).ready(function() {
         $(".nominal").autoNumeric("init", {
            vMax: 9999999999999,
            vMin: -9999999999999
          });
    });

    $("#idkategorisimulasi").change(function() {
        let idkategorisimulasi = $("#idkategorisimulasi").val();
        nipval = $("#nip").val();
        console.log(nipval);

        nip = $("#nip").val();
        tahunlahir = nip.substring(0, 4);
        bulanlahir = nip.substring(4, 6);
        tanggallahir = nip.substring(6, 8);

        kelahiran = tahunlahir + "-" + bulanlahir + "-" + tanggallahir;
        let kelahirandate = new Date(kelahiran);
        let yearlahir = kelahirandate.getFullYear();

        let getyearpensiun = yearlahir + 58;
        pensiun = getyearpensiun + "-" + bulanlahir + "-" + tanggallahir;
        let pensiundate = new Date(pensiun);

        let tglsekarang = new Date();

        console.log("TGL SEKARANG : " + tglsekarang);
        console.log("TGL PENSIUN : " + pensiundate);

        function differenceInMonths(date1, date2) {
            const monthDiff = date1.getMonth() - date2.getMonth();
            const yearDiff = date1.getYear() - date2.getYear();

            return monthDiff + yearDiff * 12;
        }

        const difference = differenceInMonths(pensiundate, tglsekarang);

        if (idkategorisimulasi == "umum") {
            $('#idsisajabatan').val(0);
            $("#idnipfield").val(nipval);
        } else {
            $('#idsisajabatan').val(difference);
            $("#idnipfield").val(nipval);
        }

    });

    $("#tampil").click(function() {
        data();
    });

    function data() {
        sisagajipokok = $("#gajipk").val();
        jumlahpinjam = $("#pinjaman_simulasi").val();
        jumlahangsuran = $("#angsuran").val();

        sisamasajabatan = $("#idsisajabatan").val();

        console.log(sisamasajabatan);

        if (sisagajipokok == '' && jumlahpinjam == '' && jumlahangsuran == '') {
            document.getElementById('gajipk').focus();
            document.getElementById('gajipk').style.borderColor = "red";
            document.getElementById('pinjaman_simulasi').style.borderColor = "red";
            document.getElementById('angsuran').style.borderColor = "red";
        } else if (sisagajipokok == '' && jumlahpinjam == '' && jumlahangsuran != '') {
            document.getElementById('gajipk').focus();
            document.getElementById('gajipk').style.borderColor = "red";
            document.getElementById('pinjaman_simulasi').style.borderColor = "red";
            document.getElementById('angsuran').style.borderColor = "green";
        } else if (sisagajipokok == '' && jumlahpinjam != '' && jumlahangsuran != '') {
            document.getElementById('gajipk').focus();
            document.getElementById('gajipk').style.borderColor = "red";
            document.getElementById('pinjaman_simulasi').style.borderColor = "green";
            document.getElementById('angsuran').style.borderColor = "green";
        } else if (sisagajipokok == '' && jumlahpinjam != '' && jumlahangsuran == '') {
            document.getElementById('gajipk').focus();
            document.getElementById('gajipk').style.borderColor = "red";
            document.getElementById('pinjaman_simulasi').style.borderColor = "green";
            document.getElementById('angsuran').style.borderColor = "red";
        } else if (sisagajipokok != '' && jumlahpinjam == '' && jumlahangsuran == '') {
            document.getElementById('pinjaman_simulasi').focus();
            document.getElementById('gajipk').style.borderColor = "green";
            document.getElementById('pinjaman_simulasi').style.borderColor = "red";
            document.getElementById('angsuran').style.borderColor = "red";
        } else if (sisagajipokok != '' && jumlahpinjam == '' && jumlahangsuran != '') {
            document.getElementById('pinjaman_simulasi').focus();
            document.getElementById('gajipk').style.borderColor = "green";
            document.getElementById('pinjaman_simulasi').style.borderColor = "red";
            document.getElementById('angsuran').style.borderColor = "green";
        } else if (sisagajipokok != '' && jumlahpinjam != '' && jumlahangsuran == '') {
            document.getElementById('angsuran').focus();
            document.getElementById('gajipk').style.borderColor = "green";
            document.getElementById('pinjaman_simulasi').style.borderColor = "green";
            document.getElementById('angsuran').style.borderColor = "red";
        } else if (sisagajipokok != '' && jumlahpinjam != '' && jumlahangsuran != '') {
            document.getElementById('gajipk').style.borderColor = "green";
            document.getElementById('pinjaman_simulasi').style.borderColor = "green";
            document.getElementById('angsuran').style.borderColor = "green";

            $.ajax({
                type: 'post',
                url: "<?php echo base_url() ?>Simulasi/getTableSimulasi",
                data: {
                    sisagajipokok,
                    jumlahpinjam,
                    jumlahangsuran,
                    sisamasajabatan
                },
                beforeSend: function() {
                    $("body").css("cursor", "progress");
                },
                success: function(data) {
                    $("body").css("cursor", "default");
                    $("#tampilDataSimulasi").html(data);
                }
            });
        }

        // nama = $("#nama").val();
        // document.getElementById('nama').style.borderColor = "red";
        // tgl_dari = $("#tgl_dari").val();
        // tgl_sampai = $("#tgl_sampai").val();


    };
</script>