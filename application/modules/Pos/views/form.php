<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Transaksi</h3>
    </div>

    <div class="title_right">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group"></div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Sukses!</strong> <?php echo $this->session->flashdata('success') ?>
        </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Error!</strong> <?php echo $this->session->flashdata('error') ?>
        </div>
      <?php endif; ?>
      <div class="x_panel">
        <div class="x_title">
          <ul class="nav navbar-left panel_toolbox">
            <div class="pull-left">
              <a href="<?=base_url() .'Pos'?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-chevron-left"></i> kembali</a>
            </div>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form action="<?= $action; ?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
            <?php if (!empty($id)) { ?>
              <div class="form-group required">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Kode</label>
                <div class="col-md-2 col-sm-4 col-xs-8">
                  <input type="text" required class="form-control col-md-7 col-xs-12" value="<?= $kode ?>" readonly>
                </div>
              </div>
            <?php } ?>
            <?php
              $clssTgl = '';
              if ($this->session->fk_level_id == 1) {
                $clssTgl = 'tanggal';
              }
            ?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tanggal</label>
              <div class="col-md-2 col-sm-4 col-xs-8">
                <input type="text" name="tgl" required class="form-control col-md-7 col-xs-12 <?= $clssTgl ?> text-center" id="tgl" value="<?= $tgl ?>" readonly autocomplete='off'>
              </div>
            </div>
            <?php if($this->session->fk_level_id==1){ ?>
              <div class="form-group required">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Cabang</label>
                <div class="col-md-5">
                    <select class="form-control" name="fk_cabang_id" id="fk_cabang_id" required>
                        <option value="">.: Pilih :.</option>
                        <?php foreach ($arrcabang as $val) { ?>
                            <option value="<?=$val['id']?>"><?=$val['nama_cabang']?></option>
                        <?php } ?>
                    </select>
                </div>
              </div>
            <?php } else{ ?>
                <input type="hidden" name="fk_cabang_id" value="<?=$this->session->fk_cabang_id?>" required>
            <?php } ?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Pelanggan</label>
              <div class="col-md-5">
                <select class="form-control" name="fk_pelanggan_id" required id="fk_pelanggan_id">
                  <option value="">.: Pilih :.</option>
                  <?php foreach ($arrPelanggan as $val) { ?>
                    <option <?= $fk_pelanggan_id == $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['nama'] . ' (' . $val['no_hp'] . ')' ?></option>
                  <?php } ?>
                </select>
              </div>
              <input type="hidden" class="form-control kosong" name="id" value="<?=$id?>">
              <a id="tambah_pelanggan" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-plus"></i> Tambah Pelanggan</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                    <tr>
                        <th style="text-align: center" width="25%">Paket</th>
                        <th style="text-align: center" width="12%">Tarif</th>
                        <th style="text-align: center" width="12%">Fee Terapis</th>
                        <th style="text-align: center" width="20%">Nama Terapis</th>
                        <th style="text-align: center" width="22%">Keterangan</th>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control chosen kosong" id="idPaket" >
                                <option value="">Pilih</option>
                                <?php foreach($arrPaket as $pkt): ?>
                                    <option value="<?=$pkt['id']?>"><?=$pkt['nama_paket']?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" class="form-control kosong" id="namaPaket" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control kosong nominal" id="nomPaket" >
                        </td>
                        <td>
                            <input type="text" class="form-control kosong nominal" id="feeTerapis" readonly>
                        </td>
                        <td>
                            <select class="form-control chosen kosong" id="idTerapis" >
                                <option value="">Pilih</option>
                                <?php foreach($arrTerapis as $trp): ?>
                                    <option value="<?=$trp['id']?>"><?=$trp['nama_lengkap']?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control kosong " id="keterangan" autocomplete='off'>
                        </td>
                    </tr>
                </table>
              </div>
              <div class="form-group">
                  <div class="col-md-2"></div>
                  <div class="col-md-6" align="center">
                      <a id="reset" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-remove"></i> Reset (esc)</a>
                      <a id="tambah" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-plus"></i> Tambahkan Ke List (F2)</a>
                      <i id='loading'></i>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-12">
                      <div class="panel panel-default">
                      <table class="table table-bordered table-striped" >
                          <tr style="background-color: #d5d2d1">
                              <th style="vertical-align: middle; width: 25%" class="text-center">Paket</th>
                              <th style="vertical-align: middle; width: 15%" class="text-center">Tarif</th>
                              <th style="vertical-align: middle; width: 15%" class="text-center">Fee Terapis</th>
                              <th style="vertical-align: middle; width: 20%" class="text-center">Nama Terapis</th>
                              <th style="vertical-align: middle; width: 22%" class="text-center">Keterangan</th>
                              <th style="vertical-align: middle; width: 10%" class="text-center">Aksi</th>
                          </tr>
                          <tbody id="tampilDetail"></tbody>
                      </table>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-md-2"></div>
                  <div class="col-md-6" align="center">
                  <button id="submit" type="submit" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-hdd"></i> <?=$button?></button>
                  </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade slide-up disable-scroll" id="modal_pelanggan" role="dialog" aria-hidden="false">
  <div class="modal-dialog" style="width: 35%;padding: 0px">
    <div class="modal-content">
      <form method="post" action="<?= base_url("MsPelanggan/save") ?>" enctype="multipart/form-data" class="form-horizontal" autocomplete='off'>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h5><b>TAMBAH PELANGGAN</b></h5>
        </div>
        <div class="modal-body">
          <div class="form-group required">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nama</label>
            <div class="col-md-8 col-sm-10 col-xs-12">
              <input type="text" name="nama" required class="form-control col-md-7 col-xs-12 upper">
            </div>
          </div>
          <div class="form-group required">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">No. HP</label>
            <div class="col-md-8 col-sm-10 col-xs-12">
              <input type="text" name="no_hp" required class="form-control col-md-7 col-xs-12" placeholder="jika tidak punya no HP maka diisi (-) / Strip">
            </div>
          </div>
          <div class="form-group required">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Jenis Kelamin</label>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <select name="jenis_kel" id="jenis_kel" class="form-control col-md-7 col-xs-12" required>
                <option value="">.: Pilih :.</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
          </div>          
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Alamat</label>
            <div class="col-md-8 col-sm-10 col-xs-12">
              <input type="text" name="alamat" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <input type="hidden" name="id">
          <input type="hidden" name="status" value="1">
          <input type="hidden" name="page_pos" value="Pos/create">
        </div>
        <div class="modal-footer">
          <button class="btn btn-md btn-default pull-right inline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-md btn-success pull-right inline">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function(){
    $(document).keyup(function(e) {
        if(e.which == 27) { //esc
            kosong();  
        }
        if(e.which == 113) { //f2
            tambahList();        
        }
    }); 

});

  $("#tambah_pelanggan").click(function() {
    $("#modal_pelanggan").modal("show");
  });

  $("#tambah").click(function() {
    tambahList();
  });

  $("#idPaket").change(function() {
     idPaket = $(this).val();
     $.ajax({
        type: "POST",
        url: "<?php echo base_url().'Pos/cariPaket'?>",
        data: {idPaket},
        dataType: 'json',
        success: function(msg){ 
            $('#namaPaket').val(msg.nama_paket);
            $('#nomPaket').val(msg.nominal);
            $('#feeTerapis').val(msg.fee_terapis);
        }
      });        
  });

  function tambahList() {
    idPaket = $('#idPaket').val();
    namaPaket = $('#namaPaket').val();
    nomPaket = $('#nomPaket').val();
    feeTerapis = $('#feeTerapis').val();
    keterangan = $('#keterangan').val();
    idTerapis = $('#idTerapis').val();

    if(idPaket==''){
        alert('Paket tidak boleh kosong..');
        return false;
    }
    if(idTerapis==''){
        alert('Terapis tidak boleh kosong..');
        return false;
    }
    $.ajax({
        async: false,
        type: "POST",
        url: "<?php echo base_url().'Pos/cariTerapis'?>",
        data: {idTerapis},
        dataType: 'json',
        success: function(msg){ 
            nama_lengkap = msg.nama_lengkap;
        }
    }); 

    $("#tampilDetail").append(
        '<tr>'+
            '<td class="text-center">'+namaPaket+'</td>'+
            '<td class="text-right">'+nomPaket+'</td>'+
            '<td class="text-right">'+feeTerapis+'</td>'+
            '<td class="text-center">'+nama_lengkap+'</td>'+
            '<td class="text-center">'+keterangan+'</td>'+
            '<td class="text-center"><a style="cursor: pointer;" title="hapus" class="remove btn btn-xs btn-danger" ><i class="glyphicon glyphicon-trash"></i></a>'+
                '<input type="hidden" name="listPaketId[]" value="'+idPaket+'">'+
                '<input type="hidden" name="listNamaPaket[]" value="'+namaPaket+'">'+
                '<input type="hidden" name="listNomPaket[]" value="'+nomPaket+'">'+
                '<input type="hidden" name="listFeeTerapis[]" value="'+feeTerapis+'">'+
                '<input type="hidden" name="listTerapisId[]" value="'+idTerapis+'">'+
                '<input type="hidden" name="listNamaTerapis[]" value="'+nama_lengkap+'">'+
                '<input type="hidden" name="listKeterangan[]" value="'+keterangan+'">'+
            '</td>'+
        '</tr>'
    ); 
    kosong();
  }

  $("#tampilDetail").on('click','.remove',function(){
    if(confirm('Apakah anda yakin?')){
        $(this).parent().parent().remove();
    }
  });

  $("#reset").click(function() {
    kosong();
  });

  function kosong() {
    $(".kosong").val('');
    $('#idPaket').trigger("change");
    $('#idTerapis').trigger("change");
  }
</script>