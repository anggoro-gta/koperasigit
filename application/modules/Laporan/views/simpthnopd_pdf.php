<!doctype html>
<html>
<style>
table {
    border-collapse: collapse;
}

th,
td {
    white-space: nowrap;
    /* PENTING: jangan turun baris */
    word-break: keep-all;
    /* jangan pecah kata/angka */
    overflow: hidden;
    /* opsional */
    text-overflow: clip;
    /* opsional */
    padding: 2px 3px;
    /* kecilkan padding biar muat */
    vertical-align: middle;
}

.angka {
    text-align: right;
}

/* kalau mau font lebih kecil khusus tabel */
.tbl-report {
    font-size: 7pt;
}

/* silakan 6pt kalau masih kepotong */
</style>

<head>
    <!-- <title><?= $tittle ?></title> -->
</head>

<body>
    <div class="responsive">
        <table width="100%" style="font-family:tahoma; font-size: 12pt; padding-top: -20px">
            <tr>
                <td colspan="51" align="center"><b>LAPORAN SIMPANAN TAHUN <?= $tahun ?></b></td>
            </tr>
            <tr>
                <td colspan="51" align="center"><b> <?= $skpd ?></b></td>
            </tr>
        </table>
        <br>
        <?php
            $months = [
                'jan' => 'Januari', 'feb' => 'Februari', 'mar' => 'Maret', 'apr' => 'April',
                'mei' => 'Mei', 'jun' => 'Juni', 'jul' => 'Juli', 'agu' => 'Agustus',
                'sep' => 'September', 'okt' => 'Oktober', 'nov' => 'November', 'des' => 'Desember',
            ];

            $fmt = function($v) {
                return number_format((float)$v, 0, ',', '.'); // bisa Anda ubah
            };
        ?>
        <table width="100%" class="bordersolid tbl-report" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th style="text-align: center;" rowspan="2">No</th>
                    <th rowspan="2">Nama</th>
                    <?php foreach($months as $mKey => $mName): ?>
                    <th colspan="4" style="text-align: center;"><?= $mName ?></th>
                    <?php endforeach; ?>
                    <th rowspan="2">Total</th>
                </tr>

                <tr class="text-center">
                    <?php foreach($months as $mKey => $mName): ?>
                    <th>P</th>
                    <th>W</th>
                    <th>T</th>
                    <th>S</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($rows as $r): ?>
                <?php
                    $total = 0;    
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($r['nama']) ?></td>

                    <?php foreach($months as $mKey => $mName): ?>
                    <td class="angka" style="text-align: right;"><?= $fmt($r['pokok'][$mKey]    ?? 0) ?></td>
                    <td class="angka" style="text-align: right;"><?= $fmt($r['wajib'][$mKey]    ?? 0) ?></td>
                    <td class="angka" style="text-align: right;"><?= $fmt($r['tapim'][$mKey]    ?? 0) ?></td>
                    <td class="angka" style="text-align: right;"><?= $fmt($r['sukarela'][$mKey] ?? 0) ?></td>
                    <?php
                        $total += ($r['pokok'][$mKey]    ?? 0);
                        $total += ($r['wajib'][$mKey]    ?? 0);
                        $total += ($r['tapim'][$mKey]    ?? 0);
                        $total += ($r['sukarela'][$mKey] ?? 0);
                    ?>
                    <?php endforeach; ?>
                    <td class="angka"><?= $fmt($total) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<style type="text/css">
.bordersolid {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>