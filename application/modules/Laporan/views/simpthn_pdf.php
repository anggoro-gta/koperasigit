<!doctype html>
<html>

<head>
    <title><?= $tittle ?></title>
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="5" align="center"><b>LAPORAN SIMPANAN</b></td>
            </tr>
            <tr>
                <td colspan="5" align="center"><b>Tahun <?= $periode ?></b></td>
            </tr>
        </table>
        <br>
        <table width='100%' style='font-family: tahoma;font-size:10pt;' border="1" cellspacing="-1" class="bordersolid">

            <tr>
                <th style="text-align: center;" width="5%">No</th>
                <th>SKPD</th>
                <th>Wajib</th>
                <th>Sukarela</th>
                <th>Tapim</th>
            </tr>

            <?php foreach ($hasil as $key => $value) : ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td align="left"><?= $value['nama_opd'] ?></td>
                    <td align="right"><?= number_format($value['wajib'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($value['sukarela'], 0, ',', '.') ?></td>
                    <td align="right"><?= number_format($value['tapim'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" align="center"><b>Total</b></td>
                <td align="right"><b><?= number_format($totalwajib, 0, ',', '.') ?></b></td>
                <td align="right"><b><?= number_format($totalsukarela, 0, ',', '.') ?></b></td>
                <td align="right"><b><?= number_format($totaltapim, 0, ',', '.') ?></b></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><b>Total Wajib + Sukarela + Tapim</b></td>
                <td colspan="3" align="right"><b><?= number_format($totalsemuasimp, 0, ',', '.') ?></b></td>                
        </table>
    </div>
</body>
<style type="text/css">
    .bordersolid {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>