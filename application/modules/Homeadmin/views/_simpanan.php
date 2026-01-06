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

.morris-legend .pokok:before {
    background: #26B99A;
}

.morris-legend .wajib:before {
    background: #34495E;
}

.morris-legend .tapim:before {
    background: #ACADAC;
}

.morris-legend .sukarela:before {
    background: #3498DB;
}
</style>

</style>
<div class="col-md-12"></div>
<div class="col-md-8 col-sm-12 col-xs-12">
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
                        <div class="progress-bar bg-green" id="bar-pokok" role="progressbar" style="width:0%"></div>
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
                        <div class="progress-bar bg-green" id="bar-wajib" role="progressbar" style="width:0%"></div>
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
                        <div class="progress-bar bg-green" id="bar-tapim" role="progressbar" style="width:0%"></div>
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
                        <div class="progress-bar bg-green" id="bar-sukarela" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-sukarela">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
<!-- bar charts group -->
<div class="col-md-12 col-sm-12 col-xs-12">
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
<div class="clearfix"></div>
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

    let percent = t > 0 ? (v / t) * 100 : 0;
    percent = Math.max(0, Math.min(100, percent));

    bar.style.width = percent.toFixed(2) + '%';
    val.textContent = formatRupiah(v);

    // kalau bar cukup lebar, teks putih (di atas hijau)
    // threshold bisa kamu ubah: 30 / 35 / 40
    if (percent >= 35) wrap.classList.add('text-on-green');
    else wrap.classList.remove('text-on-green');
}

async function loadDetailSimpanan(tahun) {
    try {
        const url = AJAX_URL + '?jenis=simpanan&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const json = await res.json();

        setProgress('pokok', json.pokok, json.total);
        setProgress('wajib', json.wajib, json.total);
        setProgress('tapim', json.tapim, json.total);
        setProgress('sukarela', json.sukarela, json.total);
    } catch (e) {
        console.error(e);
    }
}
</script>
<script>
const AJAX_GRAFIK = '<?= site_url("Homeadmin/ajaxGrafik"); ?>';
let chartSimpanan = null;

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
    const url = AJAX_GRAFIK + '?jenis=simpanan&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
    const res = await fetch(url, {
        headers: {
            'Accept': 'application/json'
        }
    });
    const json = await res.json();
    if (!json.status) return;

    const data = buildMorrisData(json.labels, json.series);

    // destroy & rebuild (paling aman untuk Morris)
    document.getElementById('graphx').innerHTML = '';

    chartSimpanan = Morris.Bar({
        element: 'graphx',
        data: data,
        xkey: 'x',
        ykeys: ['pokok', 'wajib', 'tapim', 'sukarela'],
        labels: ['Pokok', 'Wajib', 'Tapim', 'Sukarela'],
        barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        hideHover: 'auto',
        resize: true,

        xLabelAngle: 45, // ✅ putar label biar muat
        gridTextSize: 10, // ✅ kecilin font sumbu
        // optional: gridTextFamily: 'Arial',
    });

    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 200);
}
</script>

<script>
function refreshAll() {
    const tahunEl = document.querySelector('.filter-tahun');
    const tahun = tahunEl ? tahunEl.value : 'all';
    loadDetailSimpanan(tahun);
    loadGrafikSimpanan(tahun);
}

$(document).on('change', '.filter-tahun', function() {
    refreshAll();
});

document.addEventListener('DOMContentLoaded', function() {
    refreshAll();
});
</script>