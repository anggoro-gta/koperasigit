<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>History Mutasi</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th>NAMA</th>
                        <th>TGL MUTASI</th>
                        <th>SKPD SEBELUM</th>
                        <th>SKPD SESUDAH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detailmutasi as $key => $p) { ?>
                        <tr>
                            <td scope="row"><?= ++$key ?></td>
                            <td><?= $p->nama ?></td>
                            <td><?= $this->help->ReverseTgl($p->tgl_mutasi) ?></td>
                            <td><?= $p->sebelum ?></td>
                            <td><?= $p->sesudah ?></td>
                            <td>
                                <div class="btn-group text-center"><a class="btn btn-xs btn-danger" onclick="return confirm('Apakah Anda akan menghapus data?');" href="<?php echo base_url() ?>/MscbAnggotaMutasi/delete_detailmutasi/<?= $p->id ?>"><i class="fa fa-trash"></i></a></div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>