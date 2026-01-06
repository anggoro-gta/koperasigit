<?php
defined('BASEPATH') or exit('No direct script access allowed');

class homeadmin extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MHome');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data['beranda'] = 'active';

		$idANggota = $this->session->id;

		//get data user tagihan simpanan
		$quetagihanwajib = "SELECT SUM(wajib) wajib FROM t_cb_tagihan_simpanan";
		$quetagihansukarela = "SELECT SUM(sukarela) sukarela FROM t_cb_tagihan_simpanan";

		$getrowtagihanwajib = $this->db->query($quetagihanwajib)->row()->wajib;
		$getrowtagihansukarela = $this->db->query($quetagihansukarela)->row()->sukarela;

		$doubletagihanwajib = doubleval($getrowtagihanwajib);
		$doubletagihansukarela = doubleval($getrowtagihansukarela);

		$totaltagihansimpanan = $doubletagihanwajib + $doubletagihansukarela;

		//get data user simpanan pokok dan wajib
		$queuserpokok = "SELECT SUM(simpanan_pokok) simpanan_pokok FROM ms_cb_user_anggota";
		$queuserwajib = "SELECT SUM(simpanan_wajib) simpanan_wajib FROM ms_cb_user_anggota";

		$getrowqueuserpokok = $this->db->query($queuserpokok)->row()->simpanan_pokok;
		$getrowqueuserwajib = $this->db->query($queuserwajib)->row()->simpanan_wajib;

		$doubleuserpokok = doubleval($getrowqueuserpokok);
		$doubleuserwajib = doubleval($getrowqueuserwajib);

		//ambil data tapim
		$quetotaltapim = "SELECT SUM(tapim) tapim FROM t_cb_tagihan_pinjaman";
		$getrowtotaltapim = $this->db->query($quetotaltapim)->row()->tapim;
		$doubletotaltapim = doubleval($getrowtotaltapim);

		$totaluserpokokwajib = $doubleuserpokok + $doubleuserwajib;;

		//TOTAL KESELURUHAN SIMPANAN
		$totalall = $totaltagihansimpanan + $totaluserpokokwajib + $doubletotaltapim;

		//get PIUTANG PINJAMAN Penerimaan dari tagihan
		$quepiupokok = "SELECT SUM(pokok) pokok FROM t_cb_tagihan_pinjaman";
		$quepiubunga = "SELECT SUM(bunga) bunga FROM t_cb_tagihan_pinjaman";

		$doublepiupokok = doubleval($this->db->query($quepiupokok)->row()->pokok);
		$doublepiubunga = doubleval($this->db->query($quepiubunga)->row()->bunga);

		$totalpiu = $doublepiupokok + $doublepiubunga;

		//get perkiraan tagihan yang belum terbayar
		$quetagihan = "SELECT SUM(( pokok + tapim + bunga )*( tenor - jml_angsuran )) AS total FROM t_cb_pinjaman WHERE `status` = 0";

		$doubletagihan = doubleval($this->db->query($quetagihan)->row()->total);

		//mencari total piutang pinjaman
		$quetotalpinjaman = "SELECT SUM(pinjaman) pinjaman FROM t_cb_pinjaman";
		$doubletotalpinjaman = doubleval($this->db->query($quetotalpinjaman)->row()->pinjaman);
		$doublepiutangpinj = $doubletotalpinjaman - $totalpiu; //piutang pinjaman = realisasi pinjaman - penerimaan angsuran

		//total pinjaman keseluruhan
		$quepinjaman = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman";

		$doublepinjaman = doubleval($this->db->query($quepinjaman)->row()->pinjaman);

		//total pinjaman lunas
		$quepinjamanlunas = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE status = 1";

		$doublepinjamanlunas = doubleval($this->db->query($quepinjamanlunas)->row()->pinjaman);

		//total bunga keseluruhan
		$quehitungbungaall = "SELECT SUM(bunga) bunga FROM t_cb_tagihan_pinjaman";
		$doublebungaall = doubleval($this->db->query($quehitungbungaall)->row()->bunga);

		//TOTAL SALDO
		$saldo = $totalall + $totalpiu + $doubletagihan - $doublepinjaman - $doublepinjamanlunas;

		//GET DATA USER AKTIF
		$quetotaluseraktif = "SELECT COUNT(id) AS jmlhuseraktif FROM ms_cb_user_anggota WHERE status_keaktifan = 'Aktif' AND fk_id_skpd NOT IN (124,129,130,131,132)";

		// $que1 = "SELECT (COALESCE(sum(simpanan_pokok),0)+COALESCE(sum(simpanan_wajib),0)+COALESCE(sum(wajib),0)+COALESCE(sum(sukarela),0)+COALESCE(sum(tapim),0)) simpanan FROM ms_cb_user_anggota a
		// 	INNER JOIN t_cb_tagihan_simpanan s ON s.fk_anggota_id=a.id
		// 	INNER JOIN t_cb_tagihan_pinjaman p ON p.fk_anggota_id=a.id";
		// $data['simpanan'] = $this->db->query($que1)->row()->simpanan;

		$data['simpanan'] = $totalall;
		$data['jmlhuseraktif'] = $this->db->query($quetotaluseraktif)->row()->jmlhuseraktif;
		$data['piupinjaman'] = $totalpiu;
		$data['tagihan'] = $doublepiutangpinj;

		// $que2 = "SELECT sum(pinjaman) pinjaman FROM t_cb_pinjaman WHERE status = 0";
		$data['pinjaman'] = $doublepinjaman;
		$data['bungalall'] = $doublebungaall;

		$data['saldo'] = $saldo;

		// 	$get_simpanan = $this->db->query("SELECT
		// 	FORMAT(SUM(jml_simpanan),0) jumlah_simpanan
		// FROM
		// 	v_simpanan_new")->row();

		// 	$get_int_simpanan = $this->db->query("SELECT
		// 	SUM(jml_simpanan) jumlah_simpanan
		// FROM
		// 	v_simpanan_new")->row();

		// 	$get_pinjaman = $this->db->query("SELECT FORMAT(SUM(nilai),0) jml_pinjaman FROM t_cb_pinjaman")->row();
		// 	$get_int_pinjaman = $this->db->query("SELECT SUM(nilai) jml_pinjaman FROM t_cb_pinjaman")->row();

		// 	$floatsimpanan = (int)$get_int_simpanan->jumlah_simpanan;
		// 	$floatpinjaman = (int)$get_int_pinjaman->jml_pinjaman;
		// 	$floatsaldo = $floatsimpanan - $floatpinjaman;
		// 	$strsaldo = strval($floatsaldo);

		// 	$data['simpanan'] = str_replace(',', '.', $get_simpanan->jumlah_simpanan);
		// 	$data['pinjaman'] = str_replace(',', '.', $get_pinjaman->jml_pinjaman);
		// 	$data['saldo'] = number_format($floatsaldo, 0, ",", ".");


		$this->template->load('Homeadmin/templateadmin', 'Homeadmin/berandaadmin', $data);
	}

	public function detail($jenis){
		if($jenis=='simpanan'){
			$data = [
				'judul' => 'SIMPANAN'
			];
		}

		$startYear = 2023;
		$currentYear = (int) date('Y');

		$years = range($currentYear, $startYear);

		$data['jenis'] = $jenis;
		$data['ref_tahun'] = $years;
		
		$this->template->load('Homeadmin/templateadmin', 'Homeadmin/detail', $data);
	}

	public function ajaxDetail()
	{
		$jenis = $this->input->get('jenis', true);
		$tahun = $this->input->get('tahun', true);

		$data = ['status' => false, 'message' => 'Jenis tidak dikenali'];

		if ($jenis === 'simpanan') {

			// normalisasi tahun
			$isAll = ($tahun === 'all' || $tahun === 'semua' || $tahun === null || $tahun === '');
			$tahunInt = $isAll ? null : (int) $tahun;

			// SQL dengan COALESCE biar tidak NULL
			$sql_pokok = "SELECT COALESCE(SUM(simpanan_pokok),0) AS nominal
						FROM ms_cb_user_anggota
						WHERE YEAR(tanggal_mulai_aktif) = ?";

			$sql_wajib = "SELECT COALESCE(SUM(tcts.wajib),0) AS nominal
						FROM t_cb_tagihan_simpanan tcts
						JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id
						WHERE tct.tahun = ?";

			$sql_wajib_2 = "SELECT COALESCE(SUM(simpanan_wajib),0) AS nominal
							FROM ms_cb_user_anggota
							WHERE YEAR(tanggal_mulai_aktif) = ?";

			$sql_tapim = "SELECT COALESCE(SUM(tctp.tapim),0) AS nominal
						FROM t_cb_tagihan_pinjaman tctp
						JOIN t_cb_tagihan tct ON tctp.fk_tagihan_id = tct.id
						WHERE tct.tahun = ?";

			$sql_sukarela = "SELECT COALESCE(SUM(tcts.sukarela),0) AS nominal
							FROM t_cb_tagihan_simpanan tcts
							JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id
							WHERE tct.tahun = ?";

			if ($isAll) {
				$pokok    = (float) $this->db->query("SELECT COALESCE(SUM(simpanan_pokok),0) AS nominal FROM ms_cb_user_anggota")->row()->nominal;
				$wajib    = (float) $this->db->query("SELECT COALESCE(SUM(tcts.wajib),0) AS nominal
													FROM t_cb_tagihan_simpanan tcts
													JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id")->row()->nominal;
				$wajib_2  = (float) $this->db->query("SELECT COALESCE(SUM(simpanan_wajib),0) AS nominal FROM ms_cb_user_anggota")->row()->nominal;
				$tapim    = (float) $this->db->query("SELECT COALESCE(SUM(tctp.tapim),0) AS nominal
													FROM t_cb_tagihan_pinjaman tctp
													JOIN t_cb_tagihan tct ON tctp.fk_tagihan_id = tct.id")->row()->nominal;
				$sukarela = (float) $this->db->query("SELECT COALESCE(SUM(tcts.sukarela),0) AS nominal
													FROM t_cb_tagihan_simpanan tcts
													JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id")->row()->nominal;
			} else {
				$pokok    = (float) $this->db->query($sql_pokok,    [$tahunInt])->row()->nominal;
				$wajib    = (float) $this->db->query($sql_wajib,    [$tahunInt])->row()->nominal;
				$wajib_2  = (float) $this->db->query($sql_wajib_2,  [$tahunInt])->row()->nominal;
				$tapim    = (float) $this->db->query($sql_tapim,    [$tahunInt])->row()->nominal;
				$sukarela = (float) $this->db->query($sql_sukarela, [$tahunInt])->row()->nominal;
			}

			$wajibTotal = $wajib + $wajib_2;
			$total = $pokok + $wajibTotal + $tapim + $sukarela;

			$data = [
				'status'   => true,
				'pokok'    => $pokok ?? 0,
				'wajib'    => $wajibTotal ?? 0,
				'tapim'    => $tapim ?? 0,
				'sukarela' => $sukarela ?? 0,
				'total'    => $total ?? 0,
			];
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}

	public function ajaxGrafik()
	{
		$jenis = $this->input->get('jenis', true);
		$tahun = $this->input->get('tahun', true);

		$data = ['status' => false, 'message' => 'Jenis tidak dikenali'];

		if ($jenis !== 'simpanan') {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode($data));
		}

		$isAll = ($tahun === 'all' || $tahun === 'semua' || $tahun === null || $tahun === '');

		$bulanNama = [1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

		// Master bulan 1..12
		$monthTable = "
			(SELECT 1 bulan UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
			UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8
			UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12) m
		";

		// ✅ Normalisasi bulan tagihan:
		// - kalau tct.bulan valid -> pakai
		// - kalau tidak valid / NULL -> lempar ke 12 (Des) supaya tidak hilang dari grafik
		// Catatan: kalau kamu punya kolom tanggal di t_cb_tagihan (mis. tct.tanggal_tagihan),
		// kamu bisa ganti ELSE 12 jadi ELSE MONTH(tct.tanggal_tagihan)
		$bulanTagihanExpr = "CASE WHEN tct.bulan BETWEEN 1 AND 12 THEN tct.bulan ELSE 12 END";

		if ($isAll) {
			// ================= ALL (tanpa filter tahun) =================
			$sql = "
				SELECT m.bulan,
					COALESCE(p.pokok, 0)    AS pokok,
					COALESCE(w.wajib, 0)    AS wajib,
					COALESCE(t.tapim, 0)    AS tapim,
					COALESCE(s.sukarela, 0) AS sukarela
				FROM {$monthTable}

				LEFT JOIN (
					SELECT
						CASE WHEN MONTH(tanggal_mulai_aktif) BETWEEN 1 AND 12 THEN MONTH(tanggal_mulai_aktif) ELSE 12 END AS bulan,
						SUM(COALESCE(simpanan_pokok,0)) AS pokok
					FROM ms_cb_user_anggota
					GROUP BY bulan
				) p ON p.bulan = m.bulan

				LEFT JOIN (
					SELECT bulan, SUM(nominal) AS wajib
					FROM (
						-- wajib tagihan (tanpa filter tahun)
						SELECT
							{$bulanTagihanExpr} AS bulan,
							SUM(COALESCE(tcts.wajib,0)) AS nominal
						FROM t_cb_tagihan_simpanan tcts
						LEFT JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id
						GROUP BY bulan

						UNION ALL

						-- wajib anggota (tanpa filter tahun)
						SELECT
							CASE WHEN MONTH(tanggal_mulai_aktif) BETWEEN 1 AND 12 THEN MONTH(tanggal_mulai_aktif) ELSE 12 END AS bulan,
							SUM(COALESCE(simpanan_wajib,0)) AS nominal
						FROM ms_cb_user_anggota
						GROUP BY bulan
					) x
					GROUP BY bulan
				) w ON w.bulan = m.bulan

				LEFT JOIN (
					SELECT
						{$bulanTagihanExpr} AS bulan,
						SUM(COALESCE(tctp.tapim,0)) AS tapim
					FROM t_cb_tagihan_pinjaman tctp
					LEFT JOIN t_cb_tagihan tct ON tctp.fk_tagihan_id = tct.id
					GROUP BY bulan
				) t ON t.bulan = m.bulan

				LEFT JOIN (
					SELECT
						{$bulanTagihanExpr} AS bulan,
						SUM(COALESCE(tcts.sukarela,0)) AS sukarela
					FROM t_cb_tagihan_simpanan tcts
					LEFT JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id
					GROUP BY bulan
				) s ON s.bulan = m.bulan

				ORDER BY m.bulan
			";

			$rows = $this->db->query($sql)->result_array();
			$tahunOut = 'all';

		} else {
			// ================= 1 TAHUN =================
			$tahunInt = (int)$tahun;

			$sql = "
				SELECT m.bulan,
					COALESCE(p.pokok, 0)    AS pokok,
					COALESCE(w.wajib, 0)    AS wajib,
					COALESCE(t.tapim, 0)    AS tapim,
					COALESCE(s.sukarela, 0) AS sukarela
				FROM {$monthTable}

				LEFT JOIN (
					SELECT
						CASE WHEN MONTH(tanggal_mulai_aktif) BETWEEN 1 AND 12 THEN MONTH(tanggal_mulai_aktif) ELSE 12 END AS bulan,
						SUM(COALESCE(simpanan_pokok,0)) AS pokok
					FROM ms_cb_user_anggota
					WHERE YEAR(tanggal_mulai_aktif) = ?
					GROUP BY bulan
				) p ON p.bulan = m.bulan

				LEFT JOIN (
					SELECT bulan, SUM(nominal) AS wajib
					FROM (
						SELECT
							{$bulanTagihanExpr} AS bulan,
							SUM(COALESCE(tcts.wajib,0)) AS nominal
						FROM t_cb_tagihan_simpanan tcts
						LEFT JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id
						WHERE tct.tahun = ?
						GROUP BY bulan

						UNION ALL

						SELECT
							CASE WHEN MONTH(tanggal_mulai_aktif) BETWEEN 1 AND 12 THEN MONTH(tanggal_mulai_aktif) ELSE 12 END AS bulan,
							SUM(COALESCE(simpanan_wajib,0)) AS nominal
						FROM ms_cb_user_anggota
						WHERE YEAR(tanggal_mulai_aktif) = ?
						GROUP BY bulan
					) x
					GROUP BY bulan
				) w ON w.bulan = m.bulan

				LEFT JOIN (
					SELECT
						{$bulanTagihanExpr} AS bulan,
						SUM(COALESCE(tctp.tapim,0)) AS tapim
					FROM t_cb_tagihan_pinjaman tctp
					LEFT JOIN t_cb_tagihan tct ON tctp.fk_tagihan_id = tct.id
					WHERE tct.tahun = ?
					GROUP BY bulan
				) t ON t.bulan = m.bulan

				LEFT JOIN (
					SELECT
						{$bulanTagihanExpr} AS bulan,
						SUM(COALESCE(tcts.sukarela,0)) AS sukarela
					FROM t_cb_tagihan_simpanan tcts
					LEFT JOIN t_cb_tagihan tct ON tcts.fk_tagihan_id = tct.id
					WHERE tct.tahun = ?
					GROUP BY bulan
				) s ON s.bulan = m.bulan

				ORDER BY m.bulan
			";

			$rows = $this->db->query($sql, [$tahunInt, $tahunInt, $tahunInt, $tahunInt, $tahunInt])->result_array();
			$tahunOut = $tahunInt;
		}

		// Build output series
		$labels = [];
		$pokok = [];
		$wajib = [];
		$tapim = [];
		$sukarela = [];

		foreach ($rows as $r) {
			$b = (int)$r['bulan'];
			$labels[]   = $bulanNama[$b] ?? (string)$b;
			$pokok[]    = (float)$r['pokok'];
			$wajib[]    = (float)$r['wajib'];
			$tapim[]    = (float)$r['tapim'];
			$sukarela[] = (float)$r['sukarela'];
		}

		// ✅ total grafik (buat pembanding dengan ajaxDetail)
		$grandTotal = array_sum($pokok) + array_sum($wajib) + array_sum($tapim) + array_sum($sukarela);

		$data = [
			'status' => true,
			'tahun'  => $tahunOut,
			'labels' => $labels,
			'series' => [
				'pokok'    => $pokok,
				'wajib'    => $wajib,
				'tapim'    => $tapim,
				'sukarela' => $sukarela,
			],
			'total' => $grandTotal, // <- pembanding
		];

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($data));
	}




}