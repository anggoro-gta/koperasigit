<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                    Info Pinjaman - <?=$angg['nama'].' ('.$angg['nip'].')'?><br>
                    Tenor = <?=$pinjam->tenor?>
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                    <div class="form-group">
                        <table class="table table-bordered table-striped" id="example2" style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th><center>Transaksi Terakhir</center></th>
                                    <th><center>Angsuran Ke</center></th>
                                    <th><center>Pokok</center></th>
                                    <th><center>Tapim</center></th>
                                    <th><center>Bunga</center></th>
                                    <th><center>Jml Tagihan</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($detail as $val) { ?>
                                    <tr>
                                        <td align="center"><?=$no++?></td>
                                        <td align="center"><?=$val->bulan.'-'.$val->tahun?></td>
                                        <td align="center"><?=$val->angsuran_ke?></td>
                                        <td align="right"><?=number_format($val->pokok)?></td>
                                        <td align="right"><?=number_format($val->tapim)?></td>
                                        <td align="right"><?=number_format($val->bunga)?></td>
                                        <td align="right"><?=number_format($val->jml_tagihan)?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>