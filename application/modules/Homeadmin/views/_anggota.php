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

.morris-legend .aktif:before {
    background: #26B99A;
}

.morris-legend .nonaktif:before {
    background: #34495E;
}

</style>
<div class="col-md-12"></div>
<div class="col-md-8 col-sm-12 col-xs-12">
    <div class="x_panel tile">
        <div class="x_title">
            <h2>Detail Anggota</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>AKTIF</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-aktif">
                        <div class="progress-bar bg-green" id="bar-aktif" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-aktif">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>NON AKTIF</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-nonaktif">
                        <div class="progress-bar bg-green" id="bar-nonaktif" role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-nonaktif">0</span>
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
            <h2>Grafik Anggota</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content2">
            <div id="graphx" style="width:100%; height:500px;"></div>
            <div class="morris-legend" id="legend-anggota">
                <span class="l aktif">Aktif</span>
                <span class="l nonaktif">Non-Aktif</span>
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

async function loadDetailAnggota(tahun) {
    try {
        const url = AJAX_URL + '?jenis=anggota&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const json = await res.json();

        setProgress('aktif', json.aktif, json.total);
        setProgress('nonaktif', json.nonaktif, json.total);
    } catch (e) {
        console.error(e);
    }
}
</script>
<script>
const AJAX_GRAFIK = '<?= site_url("Homeadmin/ajaxGrafikAnggota"); ?>';
let chartAnggota = null;

function buildMorrisData(labels, series) {
    const out = [];
    for (let i = 0; i < labels.length; i++) {
        out.push({
            x: labels[i],
            aktif: Number(series.aktif?. [i] ?? 0),
            nonaktif: Number(series.nonaktif?. [i] ?? 0),
        });
    }
    return out;
}

async function loadGrafikAnggota(tahun) {
    const url = AJAX_GRAFIK + '?jenis=anggota&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
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

    chartAnggota = Morris.Bar({
        element: 'graphx',
        data: data,
        xkey: 'x',
        ykeys: ['aktif', 'nonaktif'],
        labels: ['Aktif', 'Non-Aktif'],
        barColors: ['#26B99A', '#34495E'],
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
    loadDetailAnggota(tahun);
    loadGrafikAnggota(tahun);
}

$(document).on('change', '.filter-tahun', function() {
    refreshAll();
});

document.addEventListener('DOMContentLoaded', function() {
    refreshAll();
});
</script>
