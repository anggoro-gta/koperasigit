<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Info Simpanan - <?=$angg['nama'].' ('.$angg['nip'].')'?></h2>
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
                                    <th><center>Uraian</center></th>
                                    <th><center>Saldo</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center">1</td>
                                    <td align="center"><?=$this->help->ReverseTgl($angg['tanggal_mulai_aktif'])?></td>
                                    <td>SIMPANAN POKOK</td>
                                    <td align="right"><?=number_format($angg['simpanan_pokok'])?></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td align="center"><?=$wjb->bulan.'-'.$wjb->tahun?></td>
                                    <td>SIMPANAN WAJIB</td>
                                    <td align="right"><?=number_format($wjb->wajib)?></td>
                                </tr>
                                <tr>
                                    <td align="center">3</td>
                                    <td align="center"><?=$tpm->bulan.'-'.$tpm->tahun?></td>
                                    <td>SIMPANAN TERPIMPIN</td>
                                    <td align="right"><?=number_format($tpm->tapim)?></td>
                                </tr>
                                <tr>
                                    <td align="center">2</td>
                                    <td align="center"><?=$wjb->bulan.'-'.$wjb->tahun?></td>
                                    <td>SIMPANAN SUKARELA</td>
                                    <td align="right"><?=number_format($wjb->sukarela)?></td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="3"><b>TOTAL</b></td>
                                    <td align="right"><b><?=number_format($angg['simpanan_pokok']+$wjb->wajib+$tpm->tapim+$wjb->sukarela)?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>