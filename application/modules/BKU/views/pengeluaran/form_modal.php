<?php
function nilai_bku($row, $field)
{
    if ($row && isset($row->$field)) {
        if($row->$field > 0){
            return number_format((float) $row->$field, 2, ',', '.');
        }else{
            return '';
        }
    }

    return '';
}
?>

<input type="hidden" name="tahun" value="<?= $tahun ?>">
<input type="hidden" name="bulan" value="<?= $bulan ?>">
<input type="hidden" name="fk_id_ms_kategori_pengeluaran" value="<?= $id_kategori ?>">

<div class="alert alert-info">
    <b>Kategori:</b> <?= htmlspecialchars($kategori->nama_kategori_pengeluaran, ENT_QUOTES, 'UTF-8') ?><br>
    <b>Periode:</b> Bulan <?= $nama_bulan ?> Tahun <?= $tahun ?>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Simpanan Pokok</label>
            <input type="text" name="simpanan_pokok" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'simpanan_pokok') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Simpanan Wajib</label>
            <input type="text" name="simpanan_wajib" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'simpanan_wajib') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Simpanan TAPIM</label>
            <input type="text" name="simpanan_tapim" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'simpanan_tapim') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Simpanan Sukarela</label>
            <input type="text" name="simpanan_sukarela" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'simpanan_sukarela') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Dana Sosial</label>
            <input type="text" name="dana_sosial" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'dana_sosial') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Biaya</label>
            <input type="text" name="biaya" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'biaya') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kredit Uang</label>
            <input type="text" name="kredit_uang" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'kredit_uang') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Barang</label>
            <input type="text" name="barang" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'barang') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Pajak</label>
            <input type="text" name="pajak" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'pajak') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Dana Pendidikan</label>
            <input type="text" name="dana_pendidikan" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'dana_pendidikan') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>SHU</label>
            <input type="text" name="shu" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'shu') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Inventaris Kantor</label>
            <input type="text" name="inventaris_kantor" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'inventaris_kantor') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Cadangan Pemb. Usaha</label>
            <input type="text" name="cadangan_pemb_usaha" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'cadangan_pemb_usaha') ?>">
        </div>
    </div>
</div>