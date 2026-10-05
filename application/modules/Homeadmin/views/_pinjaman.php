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
            <h2>Detail Realisasi Pinjaman</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>KREDIT UANG</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-uang">
                        <div class="progress-bar" style="background-color: #26B99A !important;" id="bar-uang"
                            role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-uang">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>KREDIT BARANG</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-barang">
                        <div class="progress-bar" style="background-color: #d5a242 !important;" id="bar-barang"
                            role="progressbar" style="width:0%">
                        </div>
                        <span class="nominal-right" id="val-barang">0</span>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>

            <div class="widget_summary">
                <div class="w_left w_25">
                    <span>KREDIT PALEN</span>
                </div>

                <div class="w_center" style="width: 75%">
                    <div class="progress progress-nominal" id="wrap-palen">
                        <div class="progress-bar" style="background-color: #2577d4 !important;" id="bar-palen"
                            role="progressbar" style="width:0%"></div>
                        <span class="nominal-right" id="val-palen">0</span>
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
            <h2>Grafik Realisasi Pinjaman</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content2">
            <div id="graphx" style="width:100%; height:500px;"></div>
            <div class="morris-legend" id="legend-pinjaman">
                <span class="l uang">Kredit Uang</span>
                <span class="l barang">Kredit Barang</span>
                <span class="l palen">Kredit Palen</span>
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

async function loadDetail(tahun) {
    try {
        const url = AJAX_URL + '?jenis=pinjaman&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
        const res = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });
        const json = await res.json();

        setProgress('uang', json.uang, json.total);
        setProgress('barang', json.barang, json.total);
        setProgress('palen', json.palen, json.total);
    } catch (e) {
        console.error(e);
    }
}
</script>
<script>
const AJAX_GRAFIK = '<?= site_url("Homeadmin/ajaxGrafikPinjaman"); ?>';
let chartSimpanan = null;

function buildMorrisData(labels, series) {
    const out = [];
    for (let i = 0; i < labels.length; i++) {
        out.push({
            x: labels[i],
            uang: Number(series.uang?. [i] ?? 0),
            barang: Number(series.barang?. [i] ?? 0),
            palen: Number(series.palen?. [i] ?? 0),
        });
    }
    return out;
}

async function loadGrafik(tahun) {
    const url = AJAX_GRAFIK + '?jenis=pinjaman&tahun=' + encodeURIComponent(tahun) + '&_=' + Date.now();
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
        ykeys: ['uang', 'barang', 'palen'],
        labels: ['Kredit Uang', 'Kredit Barang', 'Kredit Palen'],
        barColors: ['#26B99A', '#d5a242', '#2577d4'],
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
    loadDetail(tahun);
    loadGrafik(tahun);
}

$(document).on('change', '.filter-tahun', function() {
    refreshAll();
});

document.addEventListener('DOMContentLoaded', function() {
    refreshAll();
});
</script>