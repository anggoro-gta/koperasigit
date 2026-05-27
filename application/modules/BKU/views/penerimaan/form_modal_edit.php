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

<input type="hidden" name="id_bku_penerimaan" value="<?= $row->id ?>">
<input type="hidden" name="tahun" value="<?= $tahun ?>">
<input type="hidden" name="bulan" value="<?= $bulan ?>">

<div class="alert alert-info">
    <b>Periode:</b> Bulan <?= $nama_bulan ?> Tahun <?= $tahun ?>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Kategori</label>
            <select class="form-control input-sm no-select2" name="kategori" required>
                <option value="">Pilih</option>
                <?php
                    foreach ($ref_kategori as $k) {
                ?>
                <option value="<?= $k->id ?>" <?= $k->id==$row->fk_id_ms_kategori_penerimaan ? 'selected' : ''?>>
                    <?= $k->nama_kategori_penerimaan ?></option>
                <?php
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Angsuran Pokok</label>
            <input type="text" name="angsuran_pokok" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'angsuran_pokok') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Angsuran Bunga</label>
            <input type="text" name="angsuran_bunga" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'angsuran_bunga') ?>">
        </div>
    </div>

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
            <label>Angsuran Barang</label>
            <input type="text" name="angsuran_barang" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'angsuran_barang') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Penjualan Tunai</label>
            <input type="text" name="penjualan_tunai" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'penjualan_tunai') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Bank</label>
            <input type="text" name="bank" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'bank') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Foto Copy</label>
            <input type="text" name="foto_copy" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'foto_copy') ?>">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Barang Titipan & Konsinyasi</label>
            <input type="text" name="barang_titipan" class="form-control input-sm text-right input-rupiah"
                value="<?= nilai_bku($row, 'barang_titipan') ?>">
        </div>
    </div>
</div>