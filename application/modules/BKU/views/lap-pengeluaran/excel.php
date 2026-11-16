<!doctype html>
<html>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="15" align="center"><b><?= $title ?></b></td>
            </tr>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:8pt;' border="1" cellspacing="-1" class="bordersolid">
            <thead>
                <tr style="background-color: #d2d2d2;">
                    <th rowspan="2" style="text-align: center">BULAN</th>
                    <th colspan="4" style="text-align: center">MACAM - MACAM SIMPANAN</th>
                    <th rowspan="2" style="text-align: center">DANA SOSIAL</th>
                    <th rowspan="2" style="text-align: center">BIAYA</th>
                    <th rowspan="2" style="text-align: center">PENGELUARAN KREDIT</th>
                    <th rowspan="2" style="text-align: center">BARANG</th>
                    <th rowspan="2" style="text-align: center">PAJAK</th>
                    <th rowspan="2" style="text-align: center">DANA PENDIDIKAN</th>
                    <th rowspan="2" style="text-align: center">SHU</th>
                    <th rowspan="2" style="text-align: center">INVENTARIS_KANTOR</th>
                    <th rowspan="2" style="text-align: center">CADANGAN PEMB. USAHA</th>
                    <th rowspan="2" style="text-align: center">JUMLAH</th>
                </tr>
                <tr style="background-color: #d2d2d2;">
                    <th style="text-align: center">POKOK</th>
                    <th style="text-align: center">WAJIB</th>
                    <th style="text-align: center">TAPIM</th>
                    <th style="text-align: center">S. RELA</th>
                </tr>
            </thead>
            <tbody id="tbody-pengeluaran">
                <?= $data ?>
            </tbody>
        </table>
        <br>
        <table width="100%" style="font-family:tahoma; font-size: 9pt;">
            <tr>
                <td colspan="7" align="left"><b>SISA KAS TERDIRI DARI:</b></td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="5%" align="left">TUNAI</td>
                <td width="1%">:</td>
                <td width="2%">Rp</td>
                <td width="10%" align="right"><?= number_format($nilai_tunai, 0, ',', '.')?></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td align=" left">BANK</td>
                <td>:</td>
                <td class="border-bottom">Rp</td>
                <td align="right" class="border-bottom"><?= number_format($nilai_bank, 0, ',', '.')?>
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td align=" left"></td>
                <td></td>
                <td colspan="2">
                    <hr style="margin: 0 0;">
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td align="left"><b>JUMLAH</b></td>
                <td>:</td>
                <td class="border-bottom">Rp</td>
                <td align="right" class="border-bottom">
                    <b><?= number_format($nilai_tunai+$nilai_bank, 0, ',', '.')?>
                    </b>
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td></td>
                <td align=" left"></td>
                <td></td>
                <td colspan="2">
                    <hr style="margin: 0 0;">
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="7"> &nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="center" colspan="4"><b>JUMLAH PENDAPATAN :</b></td>
                <td class="border-bottom" width="3%" style="font-size: 11pt"><b>Rp</b></td>
                <td width="11%" align="right" style="font-size: 11pt">
                    <b><?= number_format(($nilai_tunai+$nilai_bank+$jml_pengeluaran), 0, ',', '.')?>
                    </b>
                </td>
                <td colspan="8">&nbsp;&nbsp;&nbsp;&nbsp;<small><i>(jumlah sisa saldo + jumlah pengeluaran)</i></small>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4"></td>
                <td colspan="2">
                    <hr style="margin: 0 0;">
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7"> &nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td align="center" colspan="4"></td>
                <td colspan="2">Mengetahui,</td>
                <td></td>
            </tr>
        </table>
        <br>
        <br>
        <table width="100%" style="font-family:tahoma; font-size: 10pt;">
            <tr>
                <td width="33%" align="center" colspan="5"><b>KETUA I</b></td>
                <td width="33%" align="center" colspan="5"><b>BENDAHARA I</b></td>
                <td align="center" colspan="5"><b>MANAGER</b></td>
            </tr>
            <tr>
                <td colspan="15">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="15">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="15">&nbsp;</td>
            </tr>
            <tr>
                <td width="33%" align="center" colspan="5"><b><u><?= $nama_ketua_1 ?></u></b>
                </td>
                <td width="33%" align="center" colspan="5"><b><u><?= $nama_bendahara_1 ?></u></b></td>
                <td align="center" colspan="5"><b><u><?= $nama_manager ?></u></b></td>
            </tr>
        </table>
    </div>
</body>

<style type=" text/css">
.bordersolid {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>