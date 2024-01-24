<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MscbSkpd extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbSkpd');
		// $this->load->model('MMscbUseranggota');
		// $this->load->model('MMscbStatuspekerjaan');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['MscbSkpd'] = 'active';
		// $data['arrAnggota'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbSkpd/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'MscbSkpd/create';
		// $data['skpd'] = $this->input->post('skpd');
		// $data['tgl_dari'] = $this->input->post('tgl_dari');
		// $data['tgl_sampai'] = $this->input->post('tgl_sampai');

		$this->load->view('MscbSkpd/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		// $skpd = $this->input->post('skpd');
		// $tgl_dari = $this->input->post('tgl_dari');
		// $tgl_sampai = $this->input->post('tgl_sampai');

		// if ($skpd != '') {
		// 	$this->datatables->where('a.fk_id_skpd', $skpd);
		// }

		// if ($tgl_dari != '') {
		// 	$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
		// 	$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		// }

		$this->datatables->select("
		id,
		nama_skpd,
		keterangan");
		$this->datatables->from("ms_cb_skpd");
		$this->db->order_by('id', 'asc');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbSkpd/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MscbSkpd/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		$data = array(
			'action' => base_url() . 'MscbSkpd/save',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'nama_skpd' => set_value('nama_skpd'),
			'keterangan' => set_value('keterangan'),
		);

		$data['MscbSkpd'] = 'active';
		$data['act_back'] = base_url() . 'MscbSkpd';
		// $data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		// $data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get(array('status'=>1));
		$this->template->load('Homeadmin/templateadmin', 'MscbSkpd/form', $data);
	}

	public function update($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db->query("SELECT * FROM ms_cb_skpd WHERE id=$id")->row();

		$data = array(
			'action' => base_url() . 'MscbSkpd/save',
			'button' => 'Update',
			'id' => set_value('id', $kat->id),
			'nama_skpd' => set_value('nama_skpd', $kat->nama_skpd),
			'keterangan' => set_value('keterangan', $kat->keterangan),
		);
		$data['MscbSkpd'] = 'active';
		$data['act_back'] = base_url() . 'MscbSkpd';
		// $data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		// $data['arrSkpd'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbSkpd/form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');
		$data['nama_skpd'] = $this->input->post('nama_skpd');
		$data['keterangan'] = $this->input->post('keterangan');

		// $data['user_act'] = $this->session->id;
		// $data['time_act'] = date('Y-m-d H:i:s');

		if (empty($id)) {
			$last = $this->db->query("SELECT id FROM ms_cb_skpd ORDER BY id DESC LIMIT 1")->row();
			$castint = intval($last->id);

			$idnew = $castint + 1;

			$data['id'] = $idnew;

			$this->MMscbSkpd->insert($data);

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->MMscbSkpd->update($id, $data);

			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
		redirect('MscbSkpd');
	}

	public function prosesKirimWA()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');
		$hsl = $this->MMsPelanggan->get(array('id' => $id));
		$hsl = $hsl[0];

		$kpd = 'Ibu ';
		if ($hsl['jenis_kel'] == 'L') {
			$kpd = 'Bapak ';
		}
		$kpdnya = $kpd . $hsl['nama'];

		$pesan = "Hallo *$kpdnya* Pelanggan Setia SNAP PIJAT!!! Anda capek? Badan Pegal-Pegal ? Sudah waktunya Pijat lagi nih, Yukk Buruan Datang ke SNAP PIJAT. Jangan sampai Capekmu mengganggu Produktifitasmu.";
		$this->help->kirim_wa($hsl['no_hp'], $pesan);

		$data2['notif'] = 'Pengiriman ke No WA Pelanggan telah berhasil.';
		echo json_encode($data2);
	}

	public function delete($id)
	{
		$this->MHome->ceklogin();
		$result = $this->MMscbSkpd->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}

		redirect('MscbSkpd');
	}

	public function viewRiwayat($id)
	{
		$this->MHome->ceklogin();
		$query = "SELECT kode,tgl,nama_paket,nama_terapis,mc.nama_cabang FROM t_pos_detail td 
			INNER JOIN t_pos t ON t.id=td.fk_pos_id
			INNER JOIN ms_cabang mc ON mc.id=t.fk_cabang_id
			WHERE t.fk_pelanggan_id=$id
			ORDER BY tgl DESC";
		$data['hasil'] =  $this->db->query($query)->result();

		$this->template->load('Home/template', 'MsPelanggan/viewRiwayat', $data);
	}
}
