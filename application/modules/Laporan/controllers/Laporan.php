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
	public function index()
	{
		$data['lapTransaksi'] = 'active';
		$data['arrcabang'] = $this->MMsCabang->get();
		$data['arrPelanggan'] = $this->MMsPelanggan->get();
		$data['arrTerapis'] = $this->MMsTerapis->get();
		$data['action'] = base_url() . 'Laporan/cetak_transaksi';
		$this->template->load('Home/template', 'Laporan/form', $data);
	}

	public function cetak_transaksi()
	{
		$tgl_dari = $this->input->post('tgl_dari');
		$tgl_sampai = $this->input->post('tgl_sampai');
		$fk_cabang_id = $this->input->post('fk_cabang_id');
		$fk_pelanggan_id = $this->input->post('fk_pelanggan_id');
		$fk_terapis_id = $this->input->post('fk_terapis_id');

		$andWhre = ""; $cbg='';
		if($fk_cabang_id){
			$andWhre .= " AND t.fk_cabang_id=$fk_cabang_id";
			$cbg = $this->MMsCabang->get(array('id'=>$fk_cabang_id));
		}
		if($fk_pelanggan_id){
			$andWhre .= " AND fk_pelanggan_id=$fk_pelanggan_id";
		}
		if($fk_terapis_id){
			$andWhre .= " AND td.fk_terapis_id=$fk_terapis_id";
		}

		$dari = $this->help->ReverseTgl($tgl_dari);
		$sampai = $this->help->ReverseTgl($tgl_sampai);
		$que = "SELECT
					kode,tgl,nama_pelanggan,nama_paket,nominal_paket,nama_terapis,fee_terapis,td.keterangan,c.nama_cabang,u.nama_lengkap
				FROM
					t_pos_detail td
				INNER JOIN t_pos t ON t.id = td.fk_pos_id
				INNER JOIN ms_user u ON u.id = t.user_act
				INNER JOIN ms_cabang c ON c.id=t.fk_cabang_id
				WHERE (tgl BETWEEN '$dari' AND '$sampai') $andWhre
				ORDER BY tgl ASC";
		$data['hasil'] = $this->db->query($que)->result();
		$data['tgl_dari'] = $tgl_dari;
		$data['tgl_sampai'] = $tgl_sampai;
		$data['cabang'] = $cbg;
		$data['isExcel'] = false;

		$html = $this->load->view('Laporan/cetak_transaksi', $data, true);
		$title = 'Cetak Transaksi';

		// echo $html;die();
		$this->pdf($title, $html, $this->help->folio_L(), false);
	}
	public function excel_transaksi(){
		$tgl_dari = $this->input->get('tgl_dari');
		$tgl_sampai = $this->input->get('tgl_sampai');
		$fk_cabang_id = $this->input->get('fk_cabang_id');
		$fk_pelanggan_id = $this->input->get('fk_pelanggan_id');
		$fk_terapis_id = $this->input->get('fk_terapis_id');

		$andWhre = ""; $cbg='';
		if($fk_cabang_id){
			$andWhre .= " AND t.fk_cabang_id=$fk_cabang_id";
			$cbg = $this->MMsCabang->get(array('id'=>$fk_cabang_id));
		}
		if($fk_pelanggan_id){
			$andWhre .= " AND fk_pelanggan_id=$fk_pelanggan_id";
		}
		if($fk_terapis_id){
			$andWhre .= " AND td.fk_terapis_id=$fk_terapis_id";
		}

		$dari = $this->help->ReverseTgl($tgl_dari);
		$sampai = $this->help->ReverseTgl($tgl_sampai);
		$que = "SELECT
					kode,tgl,nama_pelanggan,nama_paket,nominal_paket,nama_terapis,fee_terapis,td.keterangan,c.nama_cabang,u.nama_lengkap
				FROM
					t_pos_detail td
				INNER JOIN t_pos t ON t.id = td.fk_pos_id
				INNER JOIN ms_user u ON u.id = t.user_act
				INNER JOIN ms_cabang c ON c.id=t.fk_cabang_id
				WHERE (tgl BETWEEN '$dari' AND '$sampai') $andWhre
				ORDER BY tgl ASC";
		$data['hasil'] = $this->db->query($que)->result();
		$data['tgl_dari'] = $tgl_dari;
		$data['tgl_sampai'] = $tgl_sampai;
		$data['cabang'] = $cbg;
		$data['isExcel'] = true;

		$html = $this->load->view('Laporan/cetak_transaksi', $data, true);
		$title = 'Cetak_transaksi';
		$this->excel($title, $html);
	}

	protected function pdf($title, $html, $page, $batas = false){
		// echo $html;
		if ($batas) {
			$mpdf = new \Mpdf\Mpdf(['mode'=>'utf-8', 'format' =>$page]);
		} else {
			$mpdf = new \Mpdf\Mpdf(['mode'=>'utf-8', 'format' =>$page, 0, '', 8, 8, 8, 8, 8, 8]);
		}
		$mpdf->AddPage();
		// $mpdf->SetFooter('{PAGENO}/{nbpg}');
		$mpdf->WriteHTML($html);
		$mpdf->Output($title . '.pdf', 'I');
	}

	protected function excel($title, $html, $ext = 'xls'){
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$title.$ext");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $html;
	}
	

}
