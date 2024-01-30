<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Dashboard</h3>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
              <div class="">
                <div class="row top_tiles">
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='simpanan'>
                    <div class="tile-stats" style="background-color: green;color: white">
                      <div class="icon"><i class="fa fa-money" style="color: white"></i></div>
                      <div class="count">20.000.000</div>
                      <h3 style="color: white">SIMPANAN</h3>
                      <p>Jumlah Simpanan</p>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='pinjaman'>
                    <div class="tile-stats"  style="background-color: red;color: white">
                      <div class="icon"><i class="fa fa-money" style="color: white"></i></div>
                      <div class="count">10.000.000</div>
                      <h3 style="color: white">PINJAMAN</h3>
                      <p>Jumlah Pinjaman</p>
                    </div>
                  </div>
                  <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='simulasi'>
                    <div class="tile-stats" style="background-color: orange;color: white">
                      <div class="icon"><i class="fa fa-sort-amount-desc" style="color: white"></i></div>
                      <div class="count">&nbsp;</div>
                      <h3 style="color: white">Simulasi</h3>
                      <p>Perhitungan Pinjaman</p>
                    </div>
                  </div>
                  <!-- <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                      <div class="icon"><i class="fa fa-check-square-o"></i></div>
                      <div class="count">179</div>
                      <h3>New Sign ups</h3>
                      <p>Lorem ipsum psdea itgum rixt.</p>
                    </div>
                  </div>
                </div> -->
            </div>
          <div class="clearfix"></div>
        </div>

        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
          <div id="tampilData"></div>
      </div>
    </div>
</div>

<script type="text/javascript">
$("#simpanan").click(function(){

    $.ajax({
        type: 'post',
        url: "<?php echo base_url() ?>Homeanggota/getListDtlSimpanan",
        data: {
            // skpd
        },
        beforeSend: function() {
            $("body").css("cursor", "progress");
        },
        success: function(data) {
            $("body").css("cursor", "default");
            $("#tampilData").html(data);
        }
    });
})
$("#pinjaman").click(function(){

    $.ajax({
        type: 'post',
        url: "<?php echo base_url() ?>Homeanggota/getListDtlPinjaman",
        data: {
            // skpd
        },
        beforeSend: function() {
            $("body").css("cursor", "progress");
        },
        success: function(data) {
            $("body").css("cursor", "default");
            $("#tampilData").html(data);
        }
    });
})
$("#simulasi").click(function(){

    $.ajax({
        type: 'post',
        url: "<?php echo base_url() ?>Homeanggota/getListDtlSimulasi",
        data: {
            // skpd
        },
        beforeSend: function() {
            $("body").css("cursor", "progress");
        },
        success: function(data) {
            $("body").css("cursor", "default");
            $("#tampilData").html(data);
        }
    });
})
</script>