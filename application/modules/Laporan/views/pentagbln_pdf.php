<!doctype html>
<html>

<head>
    <title><?= $tittle ?></title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="5" align="center"><b>LAPORAN PENERIMAAN TAGIHAN</b></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><b>Bulan <?= $periode ?> <?= $tahun ?></b></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><b> <?= $skpd ?></b></td>
            </tr>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">

            <tr>
                <th style="text-align: center;" width="5%">No</th>
                <th>Nama</th>
                <th>Pokok</th>
                <th>Tapim</th>
                <th>Bunga</th>
            </tr>

            <?php foreach ($hasil as $key => $value) : ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $value['nama'] ?></td>
                    <td align="right"><?= number_format($value['pokok'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($value['tapim'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($value['bunga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" align="center"><b>Total</b></td>
                <td align="right"><b><?= number_format($sumpokok, 0, ',', '.') ?></b></td>
                <td align="right"><b><?= number_format($sumtapim, 0, ',', '.') ?></b></td>
                <td align="right"><b><?= number_format($sumbunga, 0, ',', '.') ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><b>Total Pokok + Tapim + Bunga</b></td>
                <td colspan="3" align="right"><b><?= number_format($totalall, 0, ',', '.') ?></b></td>
            </tr>
        </table>
    </div>
</body>
<style type="text/css">
    .bordersolid {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>