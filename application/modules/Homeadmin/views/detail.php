<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><?= $judul ?></h3>
        </div>

        <div class="title_right">
            <div class="text-right">
                <a href="<?= base_url('homeadmin') ?>" class="btn btn-primary btn-sm" style="margin-top: 7px"><i
                        class="fa fa-arrow-circle-left"></i>
                    Kembali</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
                <label>Filter Tahun :</label>
                <select class="form-control filter-tahun" required>
                    <option value="all">Semua</option>
                    <?php
                        foreach ($ref_tahun as $key => $value) {
                    ?>
                    <option value="<?= $value ?>"><?= $value ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
        </div>
        <?php
            if($jenis=='simpanan'){
                $this->load->view('Homeadmin/_simpanan');
            }
        ?>
    </div>
</div>
</div>