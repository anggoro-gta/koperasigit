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
		// header("Content-type: application/x-msdownload");
		// header("Content-Disposition: attachment; filename=$title.$ext");
		// header("Pragma: no-cache");
		// header("Expires: 0");
		echo $html;
	}
}
