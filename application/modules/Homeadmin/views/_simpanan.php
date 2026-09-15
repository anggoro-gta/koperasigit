<style>
.progress-nominal {
    position: relative;
    height: 22px;
    margin-bottom: 12px;
}

/* teks selalu di kanan */
.progress-nominal .nominal-right {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    pointer-events: none;
    z-index: 2;
    /* di atas bar */
}

/* warna default (kalau bar kecil) */
.progress-nominal .nominal-right {
    color: #2d3d4d;
}

.progress-bar.is-negative {
    background-color: #dc3545 !important;
}

#graphx {
    height: 320px;
}

@media (max-width:576px) {
    #graphx {
        height: 380px;
    }

    /* tambah ruang untuk label miring */
}


.morris-legend {
    margin-top: 10px;
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    font-size: 12px;

    justify-content: center;
    /* ✅ center */
    width: 100%;
}


.morris-legend .l {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.morris-legend .l:before {
    content: "";
    width: 10px;
    height: 10px;
    display: inline-block;
    border-radius: 2px;
}

/* simpanan */
.morris-legend .pokok:before {
    background: #0000b3;
}

.morris-legend .wajib:before {
    background: #0000cc;
}

.morris-legend .tapim:before {
    background: #3333ff;
}

.morris-legend .sukarela:before {
    background: #4d4dff;
}

#bar-pokok {
    background-color: #0000b3 !important;
}

#bar-wajib {
    background-color: #0000cc !important;
}

#bar-tapim {
    background-color: #3333ff !important;
}

#bar-sukarela {
    background-color: #4d4dff !important;
}

/* penarikan */
.morris-legend .penarikan-pokok:before {
    background: #a16527;
}

.morris-legend .penarikan-wajib:before {
    background: #e69138;
}

.morris-legend .penarikan-tapim:before {
    background: #eba75f;
}

.morris-legend .penarikan-sukarela:before {
    background: #f0bd87;
}

#bar-penarikan-pokok {
    background-color: #a16527 !important;
}

#bar-penarikan-wajib {
    background-color: #e69138 !important;
}

#bar-penarikan-tapim {
    background-color: #eba75f !important;
}

#bar-penarikan-sukarela {
    background-color: #f0bd87 !important;
}


/* laba */
.morris-legend .laba-pokok:before {
    background: #275214;
}

.morris-legend .laba-wajib:before {
    background: #38761d;
}

.morris-legend .laba-tapim:before {
    background: #5f914a;
}

.morris-legend .laba-sukarela:before {
    background: #87ac77;
}

#bar-laba-pokok {
    background-color: #275214 !important;
}

#bar-laba-wajib {
    background-color: #38761d !important;
}

#bar-laba-tapim {
    background-color: #5f914a !important;
}

#bar-laba-sukarela {
    background-color: #87ac77 !important;
}

#bar-laba-pokok.is-negative,
#bar-laba-wajib.is-negative,
#bar-laba-tapim.is-negative,
#bar-laba-sukarela.is-negative {
    background-color: #dc3545 !important;
}
</style>

</style>
<div class="col-md-12"></div>
<!-- Simpanan -->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel tile">
        <div class="x_title">
            <h2>Detail Simpanan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>POKOK</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-pokok">
                        <div class="progress-bar" id="bar-pokok" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-pokok">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>WAJIB</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-wajib">
                        <div class="progress-bar" id="bar-wajib" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-wajib">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>TAPIM</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-tapim">
                        <div class="progress-bar" id="bar-tapim" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-tapim">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>SUKARELA</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-sukarela">
                        <div class="progress-bar" id="bar-sukarela" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-sukarela">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
<!-- Penarikan -->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel tile">
        <div class="x_title">
            <h2>Detail Penarikan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>POKOK</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-penarikan-pokok">
                        <div class="progress-bar" id="bar-penarikan-pokok" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-penarikan-pokok">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>WAJIB</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-penarikan-wajib">
                        <div class="progress-bar" id="bar-penarikan-wajib" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-penarikan-wajib">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>TAPIM</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-penarikan-tapim">
                        <div class="progress-bar" id="bar-penarikan-tapim" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-penarikan-tapim">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>SUKARELA</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-penarikan-sukarela">
                        <div class="progress-bar" id="bar-penarikan-sukarela" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-penarikan-sukarela">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
<!-- Laba -->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel tile">
        <div class="x_title">
            <h2>Detail Selisih Simpanan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>POKOK</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-laba-pokok">
                        <div class="progress-bar" id="bar-laba-pokok" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-laba-pokok">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>WAJIB</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-laba-wajib">
                        <div class="progress-bar" id="bar-laba-wajib" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-laba-wajib">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>TAPIM</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-laba-tapim">
                        <div class="progress-bar" id="bar-laba-tapim" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-laba-tapim">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>SUKARELA</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-laba-sukarela">
                        <div class="progress-bar" id="bar-laba-sukarela" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-laba-sukarela">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
<!-- bar charts group -->
<!-- Simpanan -->
<div class="clearfix"></div>
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Grafik Simpanan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content2">
            <div id="graphx" style="width:100%; height:500px;"></div>
            <div class="morris-legend" id="legend-simpanan">
                <span class="l pokok">Pokok</span>
                <span class="l wajib">Wajib</span>
                <span class="l tapim">Tapim</span>
                <span class="l sukarela">Sukarela</span>
            </div>
        </div>
    </div>
</div>
<!-- Penarikan -->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Grafik Penarikan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content2">
            <div id="graphx_penarikan" style="width:100%; height:500px;"></div>
            <div class="morris-legend" id="legend-penarikan">
                <span class="l penarikan-pokok">Pokok</span>
                <span class="l penarikan-wajib">Wajib</span>
                <span class="l penarikan-tapim">Tapim</span>
                <span class="l penarikan-sukarela">Sukarela</span>
            </div>
        </div>
    </div>
</div>
<!-- Laba -->
<div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Grafik Selisih Simpanan</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content2">
            <div id="graphx_laba" style="width:100%; height:500px;"></div>
            <div class="morris-legend" id="legend-laba">
                <span class="l laba-pokok">Pokok</span>
                <span class="l laba-wajib">Wajib</span>
                <span class="l laba-tapim">Tapim</span>
                <span class="l laba-sukarela">Sukarela</span>
            </div>
        </div>
    </div>
</div>
<script>
const AJAX_URL = '<?= site_url("Homeadmin/ajaxDetail"); ?>';

function formatRupiah(n) {
    return new Intl.NumberFormat('id-ID').format(Number(n || 0));
}

function setProgress(key, value, total) {
    const wrap = document.getElementById('wrap-' + key);
    const bar = document.getElementById('bar-' + key);
    const val = document.getElementById('val-' + key);

    if (!wrap || !bar || !val) return;

    const v = Number(value || 0);
    const t = Number(total || 0);
    const isNegative = v < 0;

    let percent = t > 0 ? (Math.abs(v) / t) * 100 : 0;
    percent = Math.min(100, percent);

    // Supaya nilai minus tetap terlihat walaupun kecil
    if (v !== 0 && percent < 2) {
        percent = 2;
    }

    bar.style.width = percent.toFixed(2) + '%';
    bar.classList.toggle('is-negative', isNegative);

    val.textContent = formatRupiah(v);

    if (percent >= 35 && !isNegative) {
        wrap.classList.add('text-on-green');
    } else {
        wrap.classList.remove('text-on-green');
    }
}

let dataSimpanan = null;
let dataPenarikan = null;

async function loadDetailSimpanan(tahun) {
    try {
        const url = AJAX_URL + '?jenis=simpanan&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        dataSimpanan = await res.json();

        setProgress('pokok', dataSimpanan.pokok, dataSimpanan.total);
        setProgress('wajib', dataSimpanan.wajib, dataSimpanan.total);
        setProgress('tapim', dataSimpanan.tapim, dataSimpanan.total);
        setProgress('sukarela', dataSimpanan.sukarela, dataSimpanan.total);

        return dataSimpanan;
    } catch (e) {
        console.error(e);
        return null;
    }
}
async function loadDetailPenarikan(tahun) {
    try {
        const url = AJAX_URL + '?jenis=penarikan&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        dataPenarikan = await res.json();

        setProgress('penarikan-pokok', dataPenarikan.pokok, dataPenarikan.total);
        setProgress('penarikan-wajib', dataPenarikan.wajib, dataPenarikan.total);
        setProgress('penarikan-tapim', dataPenarikan.tapim, dataPenarikan.total);
        setProgress('penarikan-sukarela', dataPenarikan.sukarela, dataPenarikan.total);

        return dataPenarikan;
    } catch (e) {
        console.error(e);
        return null;
    }
}
async function loadDetailLaba() {
    if (!dataSimpanan || !dataPenarikan) return;

    const laba = {
        pokok: Number(dataSimpanan.pokok || 0) -
            Number(dataPenarikan.pokok || 0),

        wajib: Number(dataSimpanan.wajib || 0) -
            Number(dataPenarikan.wajib || 0),

        tapim: Number(dataSimpanan.tapim || 0) -
            Number(dataPenarikan.tapim || 0),

        sukarela: Number(dataSimpanan.sukarela || 0) -
            Number(dataPenarikan.sukarela || 0)
    };

    const totalLaba = Object.values(laba)
        .reduce((total, nilai) => total + Math.abs(nilai), 0);

    setProgress('laba-pokok', laba.pokok, totalLaba);
    setProgress('laba-wajib', laba.wajib, totalLaba);
    setProgress('laba-tapim', laba.tapim, totalLaba);
    setProgress('laba-sukarela', laba.sukarela, totalLaba);
}
</script>
<script>
const AJAX_GRAFIK = '<?= site_url("Homeadmin/ajaxGrafikSimpanan"); ?>';
const AJAX_GRAFIK_PENARIKAN = '<?= site_url("Homeadmin/ajaxGrafikPenarikan"); ?>';

let chartSimpanan = null;
let chartPenarikan = null;
let chartLaba = null;

let dataGrafikSimpanan = null;
let dataGrafikPenarikan = null;

function buildMorrisData(labels, series) {
    const out = [];
    for (let i = 0; i < labels.length; i++) {
        out.push({
            x: labels[i],
            pokok: Number(series.pokok?. [i] ?? 0),
            wajib: Number(series.wajib?. [i] ?? 0),
            tapim: Number(series.tapim?. [i] ?? 0),
            sukarela: Number(series.sukarela?. [i] ?? 0),
        });
    }
    return out;
}

async function loadGrafikSimpanan(tahun) {
    try {
        const url = AJAX_GRAFIK + '?jenis=simpanan&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        dataGrafikSimpanan = await res.json();
        if (!dataGrafikSimpanan.status) return;

        const data = buildMorrisData(dataGrafikSimpanan.labels, dataGrafikSimpanan.series);

        // destroy & rebuild (paling aman untuk Morris)
        document.getElementById('graphx').innerHTML = '';

        chartSimpanan = Morris.Bar({
            element: 'graphx',
            data: data,
            xkey: 'x',
            ykeys: ['pokok', 'wajib', 'tapim', 'sukarela'],
            labels: ['Pokok', 'Wajib', 'Tapim', 'Sukarela'],
            barColors: ['#0000b3', '#0000cc', '#3333ff', '#4d4dff'],
            hideHover: 'auto',
            resize: true,

            xLabelAngle: 45, // ✅ putar label biar muat
            gridTextSize: 10, // ✅ kecilin font sumbu
            // optional: gridTextFamily: 'Arial',
        });

        return dataGrafikSimpanan;

        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 200);
    } catch (e) {
        console.error(e);
        return null;
    }
}
async function loadGrafikPenarikan(tahun) {
    try {
        const url = AJAX_GRAFIK_PENARIKAN + '?jenis=penarikan&tahun=' + encodeURIComponent(tahun) + '&_=' + Date
            .now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        dataGrafikPenarikan = await res.json();
        if (!dataGrafikPenarikan.status) return;

        const data = buildMorrisData(dataGrafikPenarikan.labels, dataGrafikPenarikan.series);

        // destroy & rebuild (paling aman untuk Morris)
        document.getElementById('graphx_penarikan').innerHTML = '';

        chartPenarikan = Morris.Bar({
            element: 'graphx_penarikan',
            data: data,
            xkey: 'x',
            ykeys: ['pokok', 'wajib', 'tapim', 'sukarela'],
            labels: ['Pokok', 'Wajib', 'Tapim', 'Sukarela'],
            barColors: ['#a16527', '#e69138', '#eba75f', '#f0bd87'],
            hideHover: 'auto',
            resize: true,

            xLabelAngle: 45, // ✅ putar label biar muat
            gridTextSize: 10, // ✅ kecilin font sumbu
            // optional: gridTextFamily: 'Arial',
        });

        return dataGrafikPenarikan

        setTimeout(() => {
            window.dispatchEvent(new Event('resize'));
        }, 200);
    } catch (e) {
        console.error(e);
        return null;
    }
}

function loadGrafikLaba() {
    if (!dataGrafikSimpanan || !dataGrafikPenarikan) return;

    const labels = dataGrafikSimpanan.labels;
    const keys = ['pokok', 'wajib', 'tapim', 'sukarela'];

    const seriesLaba = {};

    keys.forEach(function(key) {
        seriesLaba[key] = labels.map(function(_, index) {
            const simpanan = Number(
                dataGrafikSimpanan.series?. [key]?. [index] ?? 0
            );

            const penarikan = Number(
                dataGrafikPenarikan.series?. [key]?. [index] ?? 0
            );

            return simpanan - penarikan;
        });
    });

    const data = buildMorrisData(labels, seriesLaba);

    document.getElementById('graphx_laba').innerHTML = '';

    chartLaba = Morris.Bar({
        element: 'graphx_laba',
        data: data,
        xkey: 'x',
        ykeys: keys,
        labels: ['Pokok', 'Wajib', 'Tapim', 'Sukarela'],
        barColors: ['#275214', '#38761d', '#5f914a', '#87ac77'],
        hideHover: 'auto',
        resize: true,
        xLabelAngle: 45,
        gridTextSize: 10
    });

    setTimeout(function() {
        window.dispatchEvent(new Event('resize'));
    }, 200);
}
</script>

<script>
async function refreshAll() {
    const tahunEl = document.querySelector('.filter-tahun');
    const tahun = tahunEl ? tahunEl.value : 'all';

    await Promise.all([
        loadDetailSimpanan(tahun),
        loadDetailPenarikan(tahun)
    ]);

    // Diproses setelah data simpanan dan penarikan selesai
    loadDetailLaba();

    await Promise.all([
        loadGrafikSimpanan(tahun),
        loadGrafikPenarikan(tahun)
    ]);

    loadGrafikLaba();
}


$(document).on('change', '.filter-tahun', function() {
    refreshAll();
});

document.addEventListener('DOMContentLoaded', function() {
    refreshAll();
});
</script>