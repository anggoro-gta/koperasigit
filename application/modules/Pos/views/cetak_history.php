<!doctype html>
<html>

<head>
    <title>Riwayat Pelanggan</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="11" align="center"><b>RIWAYAT TRANSAKSI PELANGGAN</b></td>
            </tr>
            <tr>
                <td colspan="11" align="center"><b><?= $pelanggan->nama.' ('.$pelanggan->no_hp.')' ?></b></td>
            </tr>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">
            <thead>
                <tr>
                    <th style="vertical-align: middle;" rowspan="2" width="40px">No</th>
                    <th style="vertical-align: middle;" rowspan="2">Kode</th>
                    <th style="vertical-align: middle;" rowspan="2">Tanggal</th>
                    <th style="vertical-align: middle;" rowspan="2">Kategori</th>
                    <th style="vertical-align: middle;" rowspan="2">Menit</th>
                    <th style="vertical-align: middle;" rowspan="2">Metode<br>Bayar</th>
                    <th style="vertical-align: middle;" rowspan="2" width="25%">Item</th>
                    <th style="vertical-align: middle;" rowspan="2">Qty</th>
                    <th style="vertical-align: middle;" rowspan="2">Satuan<br>(K)</th>
                    <th style="vertical-align: middle;" colspan="2">Voucher</th>
                    <th style="vertical-align: middle;" rowspan="2">Nama<br>Promo</th>
                    <th style="vertical-align: middle;" rowspan="2">Harga (K)<br>(Satuan x Qty)</th>
                    <th style="vertical-align: middle;" rowspan="2">Potongan<br>(K)</th>
                    <th style="vertical-align: middle;" rowspan="2">Total (K)<br>(Harga-Potongan)</th>
                    <th style="vertical-align: middle;" rowspan="2">Terapis</th>
                    <th style="vertical-align: middle;" rowspan="2">Alasan<br>Void</th>
                </tr>
                <tr>
                    <th>Kode</th>
                    <th>Expired</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; $totHarga = 0; $totPot = 0; $totBayarAll = 0; ?>
                <?php foreach ((array)$hasil as $hsl) { ?>
                    <tr>
                        <td valign="top">
                            <center><?= $no++ ?></center>
                        </td>
                        <td valign="top">
                            <center><?= $hsl->kode ?></center>
                        </td>
                        <td valign="top">
                            <center><?= $hsl->tgl.' '.$hsl->time ?></center>
                        </td>
                        <td valign="top">
                            <center><?= $hsl->kategori ?></center>
                        </td>
                        <td valign="top">
                            <center><?= $hsl->menit ?></center>
                        </td>
                        <td valign="top">
                            <center><?= $hsl->pembayaran ?></center>
                        </td>
                        <td valign="top">
                            <center><?php
                                $itm='';
                                if(!empty($hsl->nama_voucher)){
                                    $itm=$hsl->nama_voucher.' ('.$hsl->kode_voucher_beli.')';
                                }else if(!empty($hsl->nama_detail)){
                                    $itm=$hsl->nama_detail;
                                }else if(!empty($hsl->nama_produk)){
                                    $itm=$hsl->nama_produk;
                                }
                                echo $itm;
                            ?></center>
                        </td> 
                        <td valign="top">
                            <center><?= $hsl->qty ?></center>
                        </td> 
                        <td valign="top" style="text-align: right"><?= number_format($hsl->harga) ?></td>
                        <td valign="top">
                            <center><?= $hsl->kode_voucher ?></center>
                        </td>
                        <td valign="top">
                            <center><?= $hsl->expired ?></center>
                        </td>                        
                        <td valign="top">
                            <center><?= $hsl->nama_promo ?></center>
                        </td>                     
                        <td valign="top" style="text-align: right"><?= number_format($hsl->harganya) ?></td>
                        <td valign="top" style="text-align: right"><?= number_format($hsl->potongan) ?></td>
                        <?php $totalBayar=$hsl->harganya-$hsl->potongan;?>            
                        <td valign="top" style="text-align: right"><?= number_format($totalBayar) ?></td>
                        <td valign="top">
                            <center><?= $hsl->nama_panggilan ?></center>
                        </td>                    
                        <td valign="top">
                            <?= $hsl->alasan_void ?>
                        </td>                        
                    </tr>
                    <?php $totHarga += $hsl->harganya; $totPot += $hsl->potongan; $totBayarAll += $totalBayar; ?>
                <?php } ?>
                <tr>
                    <th colspan="12" style="text-align:center">TOTAL</th>
                    <th style="text-align: right"><?= number_format($totHarga) ?></th>
                    <th style="text-align: right"><?= number_format($totPot) ?></th>
                    <th style="text-align: right"><?= number_format($totBayarAll) ?></th>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
        <br>
    </div>
</body>

</html>