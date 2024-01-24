<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MPos');
		$this->load->model('MPosDetail');
		$this->load->model('MMsPelanggan');
		$this->load->model('MMsCabang');
		$this->load->model('MMsPaket');
		$this->load->model('MMsTerapis');
	}
	public function index()
	{
		$data = null;
		$data['Pos'] = 'active';		
		$data['arrcabang'] = $this->MMsCabang->get();
		$data['arrPelanggan'] = $this->MMsPelanggan->get();
		$this->template->load('Home/template', 'Pos/list', $data);
	}

	public function getListDetail(){
		$data['act_add'] = base_url().'Pos/create';
		$data['fk_pelanggan_id'] = $this->input->post('fk_pelanggan_id');
		$data['fk_cabang_id'] = $this->input->post('fk_cabang_id');

		$this->load->view('Pos/listDetail',$data);
	}

	public function getDatatables()
	{
		header('Content-Type: application/json');

		$fk_cabang_id = $this->input->post('fk_cabang_id');        
        if(!empty($fk_cabang_id)){
			$this->datatables->where('fk_cabang_id',$fk_cabang_id);
		} 

		$fk_pelanggan_id = $this->input->post('fk_pelanggan_id');        
        if(!empty($fk_pelanggan_id)){
			$this->datatables->where('fk_pelanggan_id',$fk_pelanggan_id);
		} 

		$this->datatables->select('t_pos.id,nama_cabang,kode,tgl,nama_pelanggan,no_tlp_pelanggan,alamat_pelanggan');
		$this->datatables->from("t_pos");
        $this->datatables->join('ms_cabang','ms_cabang.id=t_pos.fk_cabang_id','inner'); 
        $this->db->order_by('tgl','desc');
		// $this->datatables->where("status", 1);
		// if($this->session->level == 2){
		// 	$this->datatables->where("user_act", $this->session->id);
		// }
		
		echo $this->datatables->generate();
	}

	public function create()
	{		
		$data = array(
			'action' => base_url() . 'Pos/save',
			'button' => 'Simpan',
			'kode' => set_value('kode'),
			'tgl' => set_value('tgl', date('d-m-Y')),
			'fk_cabang_id' => set_value('fk_cabang_id'),
			'fk_pelanggan_id' => set_value('fk_pelanggan_id'),
			'id' => set_value('id'),
		);

		$data['arrPelanggan'] = $this->MMsPelanggan->get(array('status'=>1));
		$data['arrcabang'] = $this->MMsCabang->get(array('status'=>1));
		$data['arrPaket'] = $this->MMsPaket->get();

		$cabang =array('status'=>1);
		if($this->session->fk_level_id!='1'){
			$cabang =array('status'=>1,'fk_cabang_id'=>$this->session->fk_cabang_id);
		}
		$data['arrTerapis'] = $this->MMsTerapis->get($cabang);

		$this->template->load('Home/template', 'Pos/form', $data);
	}

	public function cariPaket(){
		$idPaket = $this->input->post('idPaket');
		$hsl = $this->MMsPaket->get(array('id'=>$idPaket));
		$hsl = $hsl[0];

		$data['nama_paket'] = $hsl['nama_paket'];
		$data['nominal'] = number_format($hsl['nominal']);
		$data['fee_terapis'] = number_format($hsl['fee_terapis']);

		echo json_encode($data);
	}

	public function cariTerapis(){
		$idTerapis = $this->input->post('idTerapis');

		$hsl = $this->MMsTerapis->get(array('id'=>$idTerapis));
		$hsl = $hsl[0];

		$data['nama_lengkap'] = $hsl['nama_lengkap'];

		echo json_encode($data);
	}

	public function save(){
		$id = $this->input->post('id');
		$listPaketId = $this->input->post('listPaketId');

		if(empty($listPaketId)){
			$this->session->set_flashdata('error', 'Paket wajib diisi.');
			redirect('Pos/create');
		}
		// echo "<pre>";
		// var_dump($this->input->post());
		// echo "</pre>";
		// die();

		$data['fk_cabang_id'] = $this->input->post('fk_cabang_id');
		$data['tgl'] = $this->help->ReverseTgl($this->input->post('tgl'));

		$fk_pelanggan_id = $this->input->post('fk_pelanggan_id');
		$plgn = $this->MMsPelanggan->get(array('id'=>$fk_pelanggan_id));
		$plgn = $plgn[0];

		$data['fk_pelanggan_id'] = $fk_pelanggan_id;
			$nmPgn = $plgn['nama'];
		$data['nama_pelanggan'] = $nmPgn;
			$tlpPlgn = $plgn['no_hp'];
		$data['no_tlp_pelanggan'] = $tlpPlgn;
		$data['alamat_pelanggan'] = $plgn['alamat'];
		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		$namaPaket = $this->input->post('listNamaPaket');
		$nmnalPaket = $this->input->post('listNomPaket');
		$feeTerapis = $this->input->post('listFeeTerapis');
		$idTrpis = $this->input->post('listTerapisId');
		$namaTerapis = $this->input->post('listNamaTerapis');
		$keterangan = $this->input->post('listKeterangan');

		$this->db->trans_start();
			if (empty($id)) {
					$kode_pj=$this->session->kode_pj;
				$que = "SELECT max(SUBSTRING(kode,4))+1 nomor FROM t_pos WHERE SUBSTRING_INDEX(kode, '-', 1)='$kode_pj'";
				$dat = $this->db->query($que)->row();
				if(!empty($dat->nomor)){
					$nomBaru = $dat->nomor;
					if(strlen($dat->nomor)==1){
						$nomBaru = '00'.$nomBaru;
					}
					if(strlen($dat->nomor)==2){
						$nomBaru = '0'.$nomBaru;
					}
					$kodeJual = $nomBaru;
				}else{
					$kodeJual = '001';
				}
				$data['kode'] = $kode_pj.'-'.$kodeJual;

				$this->MPos->insert($data);
				$posId = $this->db->insert_id();				

			}
			// else {
			// 	$this->MPos->update($id, $data);
			// 	$posId=$id;
			// }

			if(isset($listPaketId)){
				foreach ($listPaketId as $key => $val) {
					$dataDetail[] = array(
								'fk_pos_id'=>$posId,
								'fk_paket_id'=>$val,
								'nama_paket'=>$namaPaket[$key],
								'nominal_paket'=>str_replace(',', '', $nmnalPaket[$key]),
								'fee_terapis'=> empty($feeTerapis[$key])?null:str_replace(',', '', $feeTerapis[$key]),
								'fk_terapis_id'=>$idTrpis[$key],
								'nama_terapis'=>$namaTerapis[$key],
								'keterangan'=>$keterangan[$key],
							);
				}
				$this->db->insert_batch('t_pos_detail', $dataDetail);
			}

				// notif Whatsapp
			$kpd = 'Ibu ';
			if($plgn['jenis_kel']=='L'){
				$kpd = 'Bapak ';
			}
			$kpdnya=$kpd.$nmPgn;
			$pesan = "Terima kasih *$kpdnya* telah menjadi pelanggan SNAP PIJAT, kami sangat senang bisa melayani Anda.";
			$this->help->kirim_wa($tlpPlgn,$pesan);

		$this->db->trans_complete();			
		if ($this->db->trans_status() === FALSE) {
		    $this->db->trans_rollback();
		    $this->session->set_flashdata('error', 'Data Gagal disimpan.');
		} 
		else {
		    $this->db->trans_commit();
			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		}

		// redirect('Pos/print_nota/' . $posId);
		redirect('Pos');
	}

	public function print_nota($id)
	{
		$pos = $this->db->query("SELECT * FROM t_pos WHERE id=$id")->row();
		$data['pos'] = $pos; 
		$data['kasir'] =  $this->db->query("SELECT nama_lengkap FROM ms_user WHERE id=$pos->user_act")->row();
		$data['cabang'] =  $this->db->query("SELECT * FROM ms_cabang WHERE id=$pos->fk_cabang_id")->row();
		$data['detail'] =  $this->db->query("SELECT * FROM t_pos_detail WHERE fk_pos_id=$id")->result();
		
		$this->load->view('Pos/print_nota', $data);
	}	

	public function show($id){
		$pos = $this->db->query("SELECT * FROM t_pos WHERE id=$id")->row();
		$data['pos'] = $pos; 
		$data['cabang'] =  $this->db->query("SELECT * FROM ms_cabang WHERE id=$pos->fk_cabang_id")->row();
		$data['detail'] =  $this->db->query("SELECT * FROM t_pos_detail WHERE fk_pos_id=$id")->result();

		$this->template->load('Home/template', 'Pos/viewDetail', $data);
	}	
	
	public function prosesKirimUlangWA(){
		$id = $this->input->post('id');
		$pos = $this->db->query("SELECT * FROM t_pos WHERE id=$id")->row();
		$detail =  $this->db->query("SELECT * FROM t_pos_detail WHERE fk_pos_id=$id")->result();
		$hsl = $this->MMsPelanggan->get(array('id'=>$pos->fk_pelanggan_id));
		$hsl = $hsl[0];

		$kpd = 'Ibu ';
		if($hsl['jenis_kel']=='L'){
			$kpd = 'Bapak ';
		}
		$kpdnya=$kpd.$pos->nama_pelanggan;
		$tgl = $this->help->ReverseTgl($pos->tgl);

		$pesan = "Terima kasih *$kpdnya* telah menjadi pelanggan SNAP PIJAT, kami sangat senang bisa melayani Anda.";
		$pesan .= " ~Detail Transaksi~, kode : $pos->kode, tgl : $tgl, ";
		$no = 1; 
		foreach ((array)$detail as $val) {
			$paket = $val->nama_paket;
			$nominal = number_format($val->nominal_paket);
			$pesan .= " No. $no | $paket |  $nominal |";
			$no++;
		}
		$this->help->kirim_wa($hsl['no_hp'],$pesan);

		$data['notif'] = 'Pengiriman ke No WA Pelanggan telah berhasil.';
		echo json_encode($data);
	}

	public function delete($id)
	{
		if ($this->session->fk_level_id == 1) {
			$result = $this->MPos->delete($id);
			if ($result) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus.');
			} else {
				$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
			}
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}

		redirect('Pos');
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
}
