<!doctype html>
<html>

<head>
    <title>Laporan Transaksi</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="10" align="center"><b>LAPORAN TRANSAKSI</b></td>
            </tr>
            <tr>
                <td colspan="10" align="center"><b>PERIODE <?=$tgl_dari?> s/d <?=$tgl_sampai?></b></td>
            </tr>
            <?php if($cabang){ ?>
                <tr>
                    <td colspan="10" align="center"><b>CABANG <?=$cabang[0]['nama_cabang']?></b></td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">
            <thead>
                <tr>
                    <th width="50px">No.</th>
                    <th>Kode</th>
                    <th>Tgl Transaksi</th>
                    <th>Pelanggan</th>
                    <th>Paket</th>
                    <th>Tarif</th>
                    <th>Terapis</th>
                    <th>Fee Terapis</th>
                    <th>Keterangan</th>
                    <th>Cabang</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; $totNominal=0; $totFeeTrpis=0;?>
                <?php foreach ($hasil as $val) { ?>
                    <tr>
                        <td align="center"><?=$no++?></td>
                        <td align="center"><?=$val->kode?></td>
                        <td align="center"><?=$this->help->ReverseTgl($val->tgl)?></td>
                        <td><?=$val->nama_pelanggan?></td>
                        <td><?=$val->nama_paket?></td>
                        <td align="right"><?=($isExcel)?$val->nominal_paket:number_format($val->nominal_paket)?></td>
                        <td><?=$val->nama_terapis?></td>
                        <td align="right"><?=($isExcel)?$val->fee_terapis:number_format($val->fee_terapis)?></td>
                        <td><?=$val->keterangan?></td>
                        <td><?=$val->nama_cabang?></td>
                        <td><?=$val->nama_lengkap?></td>
                    </tr>
                    <?php
                        $totNominal+=$val->nominal_paket;
                        $totFeeTrpis+=$val->fee_terapis;
                    ?>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" align="center"><b>TOTAL</b></td>
                    <td align="right"><b><?=($isExcel)?$totNominal:number_format($totNominal)?></b></td>
                    <td></td>
                    <td align="right"><b><?=($isExcel)?$totFeeTrpis:number_format($totFeeTrpis)?></b></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
<style type="text/css">
    .bordersolid {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>