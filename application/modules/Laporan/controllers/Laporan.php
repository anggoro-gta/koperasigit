<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MPos');
		$this->load->model('MMsPelanggan');
		$this->load->model('MMsCabang');
		$this->load->model('MMsTerapis');
	}

	public function tunggakan()
	{

		$data['type'] = 'tunggakan';
		$data['judul'] = 'Laporan Tunggakan';
		$data['lapTransaksi'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_tunggakan';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/tunggakan_form', $data);
	}

	public function cetak_tunggakan()
	{
		$type = $this->input->post('type');
		$periode = $this->input->post('periode');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$periode = explode('-', $periode);
		$periode = $periode[1] . '-' . $periode[0] . '-01';
		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;
		$data['hasil'] = $this->getTunggakanPinjaman($periode, $fk_skpd_id);
		$data['periode'] = $this->help->namaBulan(substr($periode, 5, 2));
		$data['tahun'] = substr($periode, 0, 4);
		$html = $this->load->view('Laporan/tunggakan_pdf', $data, true);
		$title = 'Laporan Tunggakan';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}
	function getTunggakanPinjaman($periode, $fk_skpd_id)
	{
		return $this->db->query("	select * from (SELECT
			nip,
			nama,
			jml_angsuran,
			tenor,
			MAX(
			STR_TO_DATE( CONCAT( tahun, '-', bulan, '-', 01 ), '%Y-%m-%d' )) last_tx,
		CASE

				WHEN tenor - jml_angsuran < TIMESTAMPDIFF( MONTH, MAX( STR_TO_DATE( CONCAT( tahun, '-', bulan, '-', 01 ), '%Y-%m-%d' )), ? ) THEN
				tenor - jml_angsuran ELSE TIMESTAMPDIFF( MONTH, MAX( STR_TO_DATE( CONCAT( tahun, '-', bulan, '-', 01 ), '%Y-%m-%d' )), ? )
			END AS jml_tunggakan
		FROM
			t_cb_pinjaman
			JOIN t_cb_tagihan_pinjaman ON t_cb_tagihan_pinjaman.fk_pinjaman_id = t_cb_pinjaman.id
			JOIN ms_cb_user_anggota ON ms_cb_user_anggota.id = t_cb_tagihan_pinjaman.fk_anggota_id
			JOIN t_cb_tagihan ON t_cb_tagihan.id = t_cb_tagihan_pinjaman.fk_tagihan_id
		WHERE
			status = 0
			AND fk_id_skpd = ?
		GROUP BY
			t_cb_pinjaman.id
		) a WHERE jml_tunggakan > 0
	ORDER BY
		jml_tunggakan DESC;", [$periode, $periode, $fk_skpd_id])->result();
	}

	public function pinjaman()
	{
		$data['type'] = 'pinjaman';
		$data['judul'] = 'Laporan Pinjaman';
		$data['lapPinjaman'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_pinjaman';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/tunggakan_form', $data);
	}

	public function cetak_pinjaman()
	{
		$type = $this->input->post('type');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;
		$data['hasil'] = $this->db->query("select
		nomor_anggota ,nama ,nip,tenor,pinjaman,jml_angsuran,jml_angsuran*jml_tagihan jumlah
	from
		t_cb_pinjaman tcp
		join ms_cb_user_anggota mcua on mcua.id  = tcp.fk_anggota_id
	where
		status = 0 and fk_id_skpd = ? ", [$fk_skpd_id])->result();
		$html = $this->load->view('Laporan/pinjaman_pdf', $data, true);
		$title = 'Laporan Pinjaman';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}
	public function simpanan()
	{
		$data['type'] = 'simpanan';
		$data['judul'] = 'Laporan Simpanan';
		$data['lapSimpanan'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_simpanan';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/tunggakan_form', $data);
	}
	public function cetak_simpanan()
	{
		$type = $this->input->post('type');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;
		$data['hasil'] = $this->db->query("select
		nomor_anggota ,
		nama ,
		nip ,
		simpanan_pokok,
		sum(wajib) wajib,
		sum(sukarela) sukarela ,
		ifnull(sum(tapim),0)  tapim
	from
		ms_cb_user_anggota mcua
	join t_cb_tagihan_simpanan tcts on
		mcua.id = tcts.fk_anggota_id
		left join t_cb_tagihan_pinjaman tctp on mcua.id =tctp.fk_anggota_id
	where
		fk_id_skpd = ?
	group by
		nomor_anggota ,
		nama ,
		nip ,
		simpanan_pokok", [$fk_skpd_id])->result();
		$html = $this->load->view('Laporan/simpanan_pdf', $data, true);
		$title = 'Laporan Simpanan';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function updateanggota()
	{
		$data['judul'] = 'Laporan Update Anggota';
		$data['lapUpdateAnggota'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_update_anggota';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/update_anggota_form', $data);
	}

	public function cetak_update_anggota()
	{
		$type = $this->input->post('type');
		$jenis = $this->input->post('jenis');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;
		$data['jenis'] = $jenis;
		if ($jenis == 1) {
			$data['hasil'] = $this->db->query("select
			nama_skpd,
				sum(case
					when status_update = 0 then 1
				end ) as belum_update,
				COALESCE(sum(case
					when status_update = 1 then 1
				end) ,0) as sudah_update
			from
				ms_cb_user_anggota mcua
			join ms_cb_skpd mcs on
				mcua.fk_id_skpd = mcs.id
			group by
				nama_skpd
				order by nama_skpd")->result();
		} else {
			$data['hasil'] = $this->db->query("select
			nama,status_update from ms_cb_user_anggota where fk_id_skpd = ?
				order by nama", [$fk_skpd_id])->result();
		}
		$html = $this->load->view('Laporan/update_anggota_pdf', $data, true);
		$title = 'Laporan Simpanan';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function kompensasi()
	{
		$data['type'] = 'pinjaman';
		$data['judul'] = 'Laporan Kompensasi';
		$data['lapKompensasi'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_kompensasi';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/kompensasi_form', $data);
	}

	public function cetak_kompensasi()
	{
		$type = $this->input->post('type');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;

		$data['hasil'] = $this->db->query("SELECT
			a.nama,
			tp.fk_anggota_id,
			DATE_FORMAT(p.tgl,'%d-%m-%Y') tgl,
			p.pinjaman,
			tp.jml_tagihan 
		from
			t_cb_tagihan_pinjaman tp
			join t_cb_tagihan t ON tp.fk_tagihan_id = t.id
			join t_cb_pinjaman p ON tp.fk_pinjaman_id = p.id
			join ms_cb_user_anggota a ON tp.fk_anggota_id = a.id 
		where
			tp.is_kompensasi = 1 
			and t.fk_skpd_id = ? ", [$fk_skpd_id])->result();

		$html = $this->load->view('Laporan/kompensasi_pdf', $data, true);

		$title = 'Laporan Kompensasi';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function pelunasan()
	{
		$data['type'] = 'pinjaman';
		$data['judul'] = 'Laporan Pelunasan';
		$data['lapPelunasan'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_pelunasan';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/pelunasan_form', $data);
	}

	public function cetak_pelunasan()
	{
		$type = $this->input->post('type');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;

		$data['hasil'] = $this->db->query("SELECT
			a.nama,
			tp.fk_anggota_id,
			DATE_FORMAT( p.tgl, '%d-%m-%Y' ) tgl,
			p.pinjaman,
			tp.pokok,
			tp.tapim,
			tp.bunga,
			tp.jml_tagihan 
		FROM
			t_cb_tagihan_pinjaman AS tp
			INNER JOIN t_cb_tagihan AS t ON tp.fk_tagihan_id = t.id
			INNER JOIN t_cb_pinjaman AS p ON tp.fk_pinjaman_id = p.id
			INNER JOIN ms_cb_user_anggota AS a ON tp.fk_anggota_id = a.id 
		WHERE
			tp.is_pelunasan = 1 
			AND t.fk_skpd_id  = ? ", [$fk_skpd_id])->result();

		$html = $this->load->view('Laporan/pelunasan_pdf', $data, true);

		$title = 'Laporan Pelunasan';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function simpnbln()
	{
		// $data['type'] = 'tunggakan';
		$data['judul'] = 'Laporan Simpanan Bulanan';
		$data['lapSimpbln'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_simpnbln';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/simpbln_form', $data);
	}

	public function cetak_simpnbln()
	{
		$type = $this->input->post('type');
		$periode = $this->input->post('periode');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$bulan = substr($periode, 0, 2);
		$tahun = substr($periode, 3, 4);

		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;

		$que = "SELECT ts.wajib, ts.sukarela, t.bulan, t.tahun, a.nama FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON ts.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND ts.fk_skpd_id = $fk_skpd_id";

		$quetotalwajib = "SELECT SUM( ts.wajib ) AS totalwajib FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON ts.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND ts.fk_skpd_id = $fk_skpd_id";
		$doubletotalwajib = doubleval($this->db->query($quetotalwajib)->row()->totalwajib);

		$quetotalsukarela = "SELECT SUM( ts.sukarela ) AS totalsukarela FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON ts.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND ts.fk_skpd_id = $fk_skpd_id";
		$doubletotalsukarela = doubleval($this->db->query($quetotalsukarela)->row()->totalsukarela);

		$totalsemuasimp = $doubletotalwajib + $doubletotalsukarela;

		$data['hasil'] = $this->db->query($que)->result_array();
		$data['totalwajib']	= $doubletotalwajib;
		$data['totalsukarela'] = $doubletotalsukarela;
		$data['totalsemuasimp'] = $totalsemuasimp;

		$data['periode'] = $this->help->namaBulan($bulan);
		$data['tahun'] = $tahun;
		$data['tittle'] = 'Laporan Simpanan_' . $data['skpd'] . '_' . $data['periode'] . '_' . $tahun;
		$html = $this->load->view('Laporan/simpbln_pdf', $data, true);
		$title = 'Laporan Simpanan_' . $data['skpd'] . '_' . $data['periode'] . '_' . $tahun;
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function simpnthn()
	{
		$data['judul'] = 'Laporan Simpanan Tahunan';
		$data['lapSimpthn'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_simpnthn';
		$this->template->load('Homeadmin/templateadmin', 'Laporan/simpthn_form', $data);
	}

	public function cetak_simpnthn()
	{
		$type = $this->input->post('type');
		$periode = $this->input->post('periode');

		$quegetallskpd = "select * from ms_cb_skpd";
		$dataallskpd = $this->db->query($quegetallskpd)->result_array();
		$countallskpd = count($dataallskpd);

		$arraysimpthn = [];

		for ($i = 0; $i < $countallskpd; $i++) {
			$arraysimpthn[$i]['nama_opd'] = $dataallskpd[$i]['nama_skpd'];

			$quewajib = "SELECT SUM(ts.wajib) AS wajib FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id WHERE t.tahun = $periode AND t.fk_skpd_id = " . $dataallskpd[$i]['id'];
			$doublewajib = doubleval($this->db->query($quewajib)->row()->wajib);
			$arraysimpthn[$i]['wajib'] = $doublewajib;

			$quesukarela = "SELECT SUM(ts.sukarela) AS sukarela FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id WHERE t.tahun = $periode AND t.fk_skpd_id = " . $dataallskpd[$i]['id'];
			$doublesukarela = doubleval($this->db->query($quesukarela)->row()->sukarela);
			$arraysimpthn[$i]['sukarela'] = $doublesukarela;

			$quetapim = "SELECT SUM(tp.tapim) AS tapim FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode AND t.fk_skpd_id = " . $dataallskpd[$i]['id'];
			$doubletapim = doubleval($this->db->query($quetapim)->row()->tapim);
			$arraysimpthn[$i]['tapim'] = $doubletapim;
		}
		$data['hasil'] = $arraysimpthn;

		$quetotalwajib = "SELECT SUM(ts.wajib) AS wajib FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id WHERE t.tahun = $periode";
		$doubletotalwajib = doubleval($this->db->query($quetotalwajib)->row()->wajib);

		$quetotalsukarela = "SELECT SUM(ts.sukarela) AS sukarela FROM t_cb_tagihan_simpanan ts INNER JOIN t_cb_tagihan t ON ts.fk_tagihan_id = t.id WHERE t.tahun = $periode";
		$doubletotalsukarela = doubleval($this->db->query($quetotalsukarela)->row()->sukarela);

		$quetotaltapim = "SELECT SUM(tp.tapim) AS tapim FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode";
		$doubletotaltapim = doubleval($this->db->query($quetotaltapim)->row()->tapim);

		$totalsemuasimp = $doubletotalwajib + $doubletotalsukarela + $doubletotaltapim;

		$data['totalwajib']	= $doubletotalwajib;
		$data['totalsukarela'] = $doubletotalsukarela;
		$data['totalsemuasimp'] = $totalsemuasimp;
		$data['totaltapim'] = $doubletotaltapim;

		$data['periode'] = $periode;

		$data['tittle'] = 'Laporan Simpanan_' . $periode;
		$html = $this->load->view('Laporan/simpthn_pdf', $data, true);
		$title = 'Laporan Simpanan_' . $periode;
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function simpnpkk()
	{
		$data['judul'] = 'Laporan Simpanan Pokok';
		$data['lapSimppkk'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_simpnpkk';
		$this->template->load('Homeadmin/templateadmin', 'Laporan/simppkk_form', $data);
	}

	public function cetak_simpnpkk()
	{
		$type = $this->input->post('type');

		$quegetallskpd = "select * from ms_cb_skpd";
		$dataallskpd = $this->db->query($quegetallskpd)->result_array();
		$countallskpd = count($dataallskpd);

		$arraysimppkk = [];

		for ($i = 0; $i < $countallskpd; $i++) {
			$arraysimppkk[$i]['nama_opd'] = $dataallskpd[$i]['nama_skpd'];

			$quepokok = "SELECT SUM(simpanan_pokok) AS pokok FROM ms_cb_user_anggota WHERE fk_id_skpd = " . $dataallskpd[$i]['id'];
			$doublepokok = doubleval($this->db->query($quepokok)->row()->pokok);
			$arraysimppkk[$i]['pokok'] = $doublepokok;

			$quewajib = "SELECT SUM(simpanan_wajib) AS wajib FROM ms_cb_user_anggota WHERE fk_id_skpd = " . $dataallskpd[$i]['id'];
			$doublewajib = doubleval($this->db->query($quewajib)->row()->wajib);
			$arraysimppkk[$i]['wajib'] = $doublewajib;
		}
		$data['hasil'] = $arraysimppkk;

		$quetotalpokok = "SELECT SUM(simpanan_pokok) AS pokok FROM ms_cb_user_anggota";
		$doubletotalpokok = doubleval($this->db->query($quetotalpokok)->row()->pokok);

		$quetotalwajib = "SELECT SUM(simpanan_wajib) AS wajib FROM ms_cb_user_anggota";
		$doubletotalwajib = doubleval($this->db->query($quetotalwajib)->row()->wajib);

		$totalsemua = $doubletotalpokok + $doubletotalwajib;

		$data['totalpokok']	= $doubletotalpokok;
		$data['totalwajib'] = $doubletotalwajib;
		$data['totalsemua'] = $totalsemua;

		$data['tittle'] = 'Laporan Simpanan Pokok';
		$html = $this->load->view('Laporan/simppkk_pdf', $data, true);
		$title = 'Laporan Simpanan Pokok';
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function pentagbln()
	{
		// $data['type'] = 'tunggakan';
		$data['judul'] = 'Laporan Penerimaan Tagihan Bulanan';
		$data['lapPentagbln'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_pentagbln';
		$data['arrSKPD'] = $this->db->query("select * from ms_cb_skpd")->result_array();
		$this->template->load('Homeadmin/templateadmin', 'Laporan/pentagbln_form', $data);
	}

	public function cetak_pentagbln()
	{
		$type = $this->input->post('type');
		$periode = $this->input->post('periode');
		$fk_skpd_id = $this->input->post('fk_skpd_id');
		$bulan = substr($periode, 0, 2);
		$tahun = substr($periode, 3, 4);

		$data['skpd'] = $this->db->query("select nama_skpd from ms_cb_skpd where id = ? ", [$fk_skpd_id])->row()->nama_skpd;

		$queall = "SELECT tp.id, tp.pokok, tp.tapim, tp.bunga, t.bulan,t.tahun,a.nama FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON tp.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND t.fk_skpd_id = $fk_skpd_id";
		$quesumpokok = "SELECT SUM( tp.pokok ) AS pokok FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON tp.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND t.fk_skpd_id = $fk_skpd_id";
		$quesumtapim = "SELECT SUM( tp.tapim ) AS tapim FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON tp.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND t.fk_skpd_id = $fk_skpd_id";
		$quesumbunga = "SELECT SUM( tp.bunga ) AS bunga FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id INNER JOIN ms_cb_user_anggota a ON tp.fk_anggota_id = a.id WHERE t.bulan = $bulan AND t.tahun = $tahun AND t.fk_skpd_id = $fk_skpd_id";

		$doublsumpokok = doubleval($this->db->query($quesumpokok)->row()->pokok);
		$doublesumtapim = doubleval($this->db->query($quesumtapim)->row()->tapim);
		$doublesumbunga = doubleval($this->db->query($quesumbunga)->row()->bunga);

		$totalall = $doublsumpokok + $doublesumtapim + $doublesumbunga;

		$data['hasil'] = $this->db->query($queall)->result_array();
		$data['sumpokok'] = $doublsumpokok;
		$data['sumtapim'] = $doublesumtapim;
		$data['sumbunga'] = $doublesumbunga;
		$data['totalall'] = $totalall;

		$data['periode'] = $this->help->namaBulan($bulan);
		$data['tahun'] = $tahun;
		$data['tittle'] = 'Laporan Penerimaan Tagihan_' . $data['skpd'] . '_' . $data['periode'] . '_' . $tahun;
		$html = $this->load->view('Laporan/pentagbln_pdf', $data, true);
		$title = 'Laporan Penerimaan Tagihan_' . $data['skpd'] . '_' . $data['periode'] . '_' . $tahun;
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	public function pentagthn()
	{
		$data['judul'] = 'Laporan Penerimaan Tagihan Tahunan';
		$data['lapPentagthn'] = 'active';
		$data['action'] = base_url() . 'Laporan/cetak_pentagthn';
		$this->template->load('Homeadmin/templateadmin', 'Laporan/pentagthn_form', $data);
	}

	public function cetak_pentagthn()
	{
		$type = $this->input->post('type');
		$periode = $this->input->post('periode');

		$quegetallskpd = "select * from ms_cb_skpd";
		$dataallskpd = $this->db->query($quegetallskpd)->result_array();
		$countallskpd = count($dataallskpd);

		$arraysimpthn = [];

		for ($i = 0; $i < $countallskpd; $i++) {
			$arraysimpthn[$i]['nama_opd'] = $dataallskpd[$i]['nama_skpd'];

			$quepokok = "SELECT SUM( tp.pokok ) AS pokok FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode AND t.fk_skpd_id = " . $dataallskpd[$i]['id'];
			$doublepokok = doubleval($this->db->query($quepokok)->row()->pokok);
			$arraysimpthn[$i]['pokok'] = $doublepokok;

			$quetapim = "SELECT SUM( tp.tapim ) AS tapim FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode AND t.fk_skpd_id = " . $dataallskpd[$i]['id'];
			$doubletapim = doubleval($this->db->query($quetapim)->row()->tapim);
			$arraysimpthn[$i]['tapim'] = $doubletapim;

			$quebunga = "SELECT SUM( tp.bunga ) AS bunga FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode AND t.fk_skpd_id = " . $dataallskpd[$i]['id'];
			$doublebunga = doubleval($this->db->query($quebunga)->row()->bunga);
			$arraysimpthn[$i]['bunga'] = $doublebunga;
		}

		$quesumpokok = "SELECT SUM( tp.pokok ) AS pokok FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode";
		$quesumtapim = "SELECT SUM( tp.tapim ) AS tapim FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode";
		$quesumbunga = "SELECT SUM( tp.bunga ) AS bunga FROM t_cb_tagihan_pinjaman tp INNER JOIN t_cb_tagihan t ON tp.fk_tagihan_id = t.id WHERE t.tahun = $periode";

		$data['hasil'] = $arraysimpthn;

		$doublesumpokok = doubleval($this->db->query($quesumpokok)->row()->pokok);
		$doublesumtapim = doubleval($this->db->query($quesumtapim)->row()->tapim);
		$doublesumbunga = doubleval($this->db->query($quesumbunga)->row()->bunga);

		$totalallsum = $doublesumpokok + $doublesumtapim + $doublesumbunga;

		$data['sumpokok'] = $doublesumpokok;
		$data['sumtapim'] = $doublesumtapim;
		$data['sumbunga'] = $doublesumbunga;
		$data['totalallsum'] = $totalallsum;

		$data['periode'] = $periode;

		$data['tittle'] = 'Laporan Penerimaan Tagihan_' . $periode;
		$html = $this->load->view('Laporan/pentagthn_pdf', $data, true);
		$title = 'Laporan Penerimaan Tagihan_' . $periode;
		if ($type == 'pdf') {
			$this->pdf($title, $html, $this->help->folio_P(), false);
		} else {
			$this->excel($title, $html);
		}
	}

	protected function pdf($title, $html, $page, $batas = false)
	{
		// echo $html;
		if ($batas) {
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => $page]);
		} else {
			$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => $page, 0, '', 8, 8, 8, 8, 8, 8]);
		}
		$mpdf->AddPage();
		// $mpdf->SetFooter('{PAGENO}/{nbpg}');
		$mpdf->WriteHTML($html);
		$mpdf->Output($title . '.pdf', 'I');
	}

	protected function excel($title, $html, $ext = 'xls')
	{
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$title.$ext");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $html;
	}
}
