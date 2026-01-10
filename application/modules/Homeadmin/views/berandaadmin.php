<style>
.simpanan {
    cursor: pointer;
}

.simpanan .tile-stats {
    transition: .15s ease;
}

.simpanan:hover .tile-stats {
    transform: translateY(-2px);
    filter: brightness(1.08);
    box-shadow: 0 10px 22px rgba(0, 0, 0, .18);
}
</style>
<div class="">
    <div class="row top_tiles" style="margin: 10px 0;">
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12 simpanan" id='simpanan'>
            <div class="tile-stats" style="background-color: gray;color: white">
                <div class="icon"><i class="fa-solid fa-wallet" style="color: white"></i></div>
                <div class="count"><?= number_format($simpanan) ?></div>
                <h3 style="color: white">SIMPANAN</h3>
                <p>POKOK, WAJIB, TAPIM, SUKARELA</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='pinjaman'>
            <div class="tile-stats" style="background-color: gray;color: white">
                <div class="icon"><i class="fa-solid fa-wallet" style="color: white"></i></div>
                <div class="count"><?= number_format($pinjaman) ?></div>
                <h3 style="color: white">REALISASI PINJAMAN</h3>
                <p>KREDIT UANG, BARANG, ISIDENTIL</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='simulasi'>
            <div class="tile-stats" style="background-color: #748CAB;color: white">
                <div class="icon"><i class="fa-solid fa-user" style="color: white"></i></div>
                <div class="count"><?= number_format($jmlhuseraktif) ?></div>
                <h3 style="color: white">ANGGOTA AKTIF</h3>
                <p></p>
            </div>
        </div>
    </div>

    <div class="row top_tiles" style="margin: 10px 0;">
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='simpanan'>
            <div class="tile-stats" style="background-color: gray;color: white">
                <div class="icon"><i class="fa-solid fa-wallet" style="color: white"></i></div>
                <div class="count"><?= number_format($piupinjaman) ?></div>
                <h3 style="color: white">PENERIMAAN ANGSURAN</h3>
                <p>POKOK PINJAMAN, BUNGA</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='pinjaman'>
            <div class="tile-stats" style="background-color: gray;color: white">
                <div class="icon"><i class="fa-solid fa-wallet" style="color: white"></i></div>
                <div class="count"><?= number_format($bungalall) ?></div>
                <h3 style="color: white">PENERIMAAN BUNGA</h3>
                <p>BUNGA REGULER, KOMPEN, PELUNASAN</p>
            </div>
        </div>
    </div>

    <div class="row top_tiles" style="margin: 10px 0;">
        <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12" id='simpanan'>
            <div class="tile-stats" style="background-color: gray;color: white">
                <div class="icon"><i class="fa-solid fa-wallet" style="color: white"></i></div>
                <div class="count"><?= number_format($tagihan) ?></div>
                <h3 style="color: white">PIUTANG</h3>
                <p>REALISASI PINJAMAN - PENERIMAAN ANGSURAN</p>
            </div>
        </div>
    </div>

    <br />

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph x_panel">
                <div class="row x_title">
                    <!-- <div class="col-md-6">
            <h3>Network Activities <small>Graph title sub-title</small></h3>
          </div> -->
                    <!-- <div class="col-md-6">
            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
              <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
            </div>
          </div> -->
                </div>
                <div class="x_content">
                    <div class="demo-container" style="height:250px">
                        <div id="placeholder3xx3" class="demo-placeholder" style="width: 100%; height:250px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pull-right">
        © Copyright 2025 KPRI Canda Bhirawa
    </div>
    <div class="clearfix"></div>
</div>

<!-- script khusus admin -->

<!-- bootstrap-daterangepicker -->
<script type="text/javascript">
$(document).ready(function() {

    var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    };

    var optionSet1 = {
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: {
            days: 60
        },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month')
                .endOf('month')
            ]
        },
        opens: 'left',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'MM/DD/YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
            ],
            firstDay: 1
        }
    };
    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format(
        'MMMM D, YYYY'));
    $('#reportrange').daterangepicker(optionSet1, cb);
    $('#reportrange').on('show.daterangepicker', function() {
        console.log("show event fired");
    });
    $('#reportrange').on('hide.daterangepicker', function() {
        console.log("hide event fired");
    });
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        console.log("apply event fired, start/end dates are " + picker.startDate.format(
            'MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
    });
    $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
        console.log("cancel event fired");
    });
    $('#options1').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
    });
    $('#options2').click(function() {
        $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
    });
    $('#destroy').click(function() {
        $('#reportrange').data('daterangepicker').remove();
    });
});
</script>
<!-- /bootstrap-daterangepicker -->

<!-- Skycons -->
<script>
var icons = new Skycons({
        "color": "#73879C"
    }),
    list = [
        "clear-day", "clear-night", "partly-cloudy-day",
        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
        "fog"
    ],
    i;

for (i = list.length; i--;)
    icons.set(list[i], list[i]);

icons.play();
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.simpanan').forEach(function(el) {
        el.addEventListener('click', function() {
            window.location.href = '<?= base_url("Homeadmin/detail/simpanan"); ?>';
        });
    });
});
</script>
<!-- /Skycons -->