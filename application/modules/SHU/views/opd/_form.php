<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Daftar Anggota</h2>
            <ul class="nav navbar-right panel_toolbox">
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th>NAMA</th>
                        <th>NIP</th>
                        <th class="text-right">NOMINAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail as $key => $value) { ?>
                    <tr>
                        <td scope="row"><?= ++$key ?>
                        </td>
                        <td><?= $value->nama ?></td>
                        <td><?= $value->nip ?></td>
                        <td class="text-right">
                            <?php if ($status_posting == 0) { ?>
                            <input type="text" name="nominal[<?= $value->id ?>]"
                                class="form-control col-md-7 col-xs-12 nominal" value="<?= $value->nominal ?? '' ?>">
                            <?php } else { ?>
                            <?= $value->nominal ? number_format($value->nominal) : '-' ?>
                            <?php  } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if ($status_posting == 0) { ?>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
$(".nominal").autoNumeric("init", {
    vMax: 9999999999999,
    vMin: -9999999999999
});
</script>