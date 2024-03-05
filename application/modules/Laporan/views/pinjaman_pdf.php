<!doctype html>
<html>

<head>
    <title>Laporan Pinjaman</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="5" align="center"><b>LAPORAN PINJAMAN</b></td>
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
                <th>NIP</th>
                <th>Tenor</th>
                <th>Pinjaman</th>
                <th width="10%">Sudah Diangsur</th>
                <th width="15%">Jumlah</th>
            </tr>

            <?php foreach ($hasil as $key => $value) : ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->nip ?></td>
                    <td align="right"><?= $value->tenor ?></td>
                    <td align="right"><?= number_format($value->pinjaman) ?></td>
                    <td align="right"><?= $value->jml_angsuran ?></td>
                    <td align="right"><?= number_format($value->jumlah) ?></td>
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