<!doctype html>
<html>

<head>
    <title>Laporan Kompensasi</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="5" align="center"><b>LAPORAN KOMPENSASI</b></td>
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
                <th>Tgl Hutang</th>
                <th>Pinjaman</th>
                <th>Pokok</th>
                <th>Tapim</th>
                <th>Bunga</th>
                <th>jml pelunasan</th>
            </tr>

            <?php foreach ($hasil as $key => $value) : ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $value->nama ?></td>
                    <td align="center"><?= $value->tgl ?></td>
                    <td align="right"><?= number_format($value->pinjaman) ?></td>
                    <td align="right"><?= number_format($value->pokok) ?></td>
                    <td align="right"><?= number_format($value->tapim) ?></td>
                    <td align="right"><?= number_format($value->bunga) ?></td>
                    <td align="right"><?= number_format($value->jml_tagihan) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
<style type="text/css">
    .bordersolid {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>