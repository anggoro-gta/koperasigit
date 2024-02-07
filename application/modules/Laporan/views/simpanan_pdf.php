<!doctype html>
<html>

<head>
    <title>Laporan Simpanan</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="7" align="center"><b>LAPORAN SIMPANAN</b></td>
            </tr>
            <tr>
                <td colspan="7" align="center"><b>Dinas <?= $skpd ?></b></td>
            </tr>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">

            <tr>
                <th style="text-align: center;" width="5%">No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Pokok</th>
                <th>Wajib</th>
                <th width="10%">Sukarela</th>
                <th width="15%">Tapim </th>
            </tr>

            <?php foreach ($hasil as $key => $value) : ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->nip ?></td>
                    <td align="right"><?= number_format($value->simpanan_pokok) ?></td>
                    <td align="right"><?= number_format($value->wajib) ?></td>
                    <td align="right"><?= number_format($value->sukarela) ?></td>
                    <td align="right"><?= number_format($value->tapim) ?></td>
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