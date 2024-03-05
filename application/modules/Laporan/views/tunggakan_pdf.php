<!doctype html>
<html>

<head>
    <title>Laporan Tunggakan</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="5" align="center"><b>LAPORAN TUNGGAKAN</b></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><b>Tagihan Bulan <?= $periode ?> <?= $tahun ?></b></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><b> <?= $skpd ?></b></td>
            </tr>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">

            <tr>
                <th style="text-align: center;" width="5%">No</th>
                <th>Nip</th>
                <th>Nama</th>
                <th>Terakhir Bayar</th>
                <th width="15%">Tunggakan</th>
            </tr>

            <?php foreach ($hasil as $key => $value) : ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $value->nip ?></td>
                    <td><?= $value->nama ?></td>
                    <td align="center"><?= $this->help->ReverseTgl($value->last_tx) ?></td>
                    <td align="center"><?= $value->jml_tunggakan ?></td>
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