<!doctype html>
<html>

<head>
    <title><?= $jenis == 1 ? 'Rekap' : 'Rincian' ?> Update Anggota</title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt;">
            <tr>
                <td colspan="5" align="center"><b><?= $jenis == 1 ? 'REKAP' : 'RINCIAN' ?> UPDATE ANGGOTA</b></td>
            </tr>
            <?php if ($jenis == 2) : ?>
                <tr>
                    <td colspan="5" align="center"><b> <?= $skpd ?></b></td>
                </tr>
            <?php endif; ?>
        </table>

        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">
            <?php if ($jenis == 2) : ?>
                <tr>
                    <th style="text-align: center;" width="5%">No</th>
                    <th>Nama</th>
                    <th>Status Update</th>
                </tr>

                <?php foreach ($hasil as $key => $value) : ?>
                    <tr>
                        <td align="center"><?= ++$key ?></td>
                        <td><?= $value->nama ?></td>
                        <td align="center" style="color:<?= $value->status_update == 1 ? 'green' : 'red' ?>"><?= $value->status_update == 1 ? 'Sudah Update' : 'Belum Update' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>

                <tr>
                    <th style="text-align: center;" width="5%">No</th>
                    <th>SKPD</th>
                    <th>Belum Update</th>
                    <th>Sudah Update</th>
                    <th width="15%">Total</th>
                </tr>

                <?php foreach ($hasil as $key => $value) : ?>
                    <tr>
                        <td align="center"><?= ++$key ?></td>
                        <td><?= $value->nama_skpd ?></td>
                        <td align="center"><?= $value->status_update ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
<style type="text/css">
    .bordersolid {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>