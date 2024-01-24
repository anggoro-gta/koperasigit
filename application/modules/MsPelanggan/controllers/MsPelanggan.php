<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MsPelanggan extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MMsPelanggan');
		// $this->load->model('MMsCabang');
	}

	public function index()
	{
		$data = null;
		$data['MsPelanggan'] = 'active';
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Home/template', 'MsPelanggan/list', $data);
	}

	public function getListDetail()
	{
		$data['act_add'] = base_url() . 'MsPelanggan/create';
		$data['status'] = $this->input->post('status');
		$data['tgl_dari'] = $this->input->post('tgl_dari');
		$data['tgl_sampai'] = $this->input->post('tgl_sampai');

		$this->load->view('MsPelanggan/listDetail', $data);
	}

	public function getDatatables()
	{
		header('Content-Type: application/json');

		$status = $this->input->post('status');
		$tgl_dari = $this->input->post('tgl_dari');
		$tgl_sampai = $this->input->post('tgl_sampai');

		if ($status != '') {
			$this->datatables->where('ms_pelanggan.status', $status);
		}

		if ($tgl_dari != '') {
			$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
			$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		}

		$this->datatables->select("ms_pelanggan.id,nama,no_hp,alamat,p.jml_kunjungan,DATE_FORMAT(p.tgl,'%d-%m-%Y') tgl");
		$this->datatables->select("(CASE jenis_kel WHEN 'L' THEN	'Laki-laki' ELSE 'Perempuan' END) jenis_kel");
		$this->datatables->select("(CASE ms_pelanggan.status WHEN 1 THEN	'Aktif' ELSE 'Tidak Aktif' END) statusnya");
		$this->datatables->from("ms_pelanggan");
		$this->datatables->join("(
						SELECT max(t.tgl) tgl,fk_pelanggan_id,count(td.id) jml_kunjungan FROM t_pos t
						INNER JOIN t_pos_detail td ON td. fk_pos_id=t.id
						GROUP BY t.fk_pelanggan_id
					) p", "p.fk_pelanggan_id=ms_pelanggan.id", "left");
		$this->db->order_by('nama', 'asc');
		$this->db->group_by('ms_pelanggan.id');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MsPelanggan/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MsPelanggan/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$data = array(
			'action' => base_url() . 'MsPelanggan/save',
			'button' => 'Simpan',
			// 'fk_cabang_id' => set_value('fk_cabang_id'),
			'nama' => set_value('nama'),
			'no_hp' => set_value('no_hp'),
			'jenis_kel' => set_value('jenis_kel'),
			'status' => set_value('status', '1'),
			'alamat' => set_value('alamat'),
			'id' => set_value('id'),
		);

		$data['MsPelanggan'] = 'active';
		$data['act_back'] = base_url() . 'MsPelanggan';
		// $data['arrcabang'] = $this->MMsCabang->get(array('status'=>1));
		$this->template->load('Home/template', 'MsPelanggan/form', $data);
	}

	public function update($id)
	{
		$kat = $this->db->query("SELECT * FROM ms_pelanggan WHERE id=$id")->row();

		$data = array(
			'action' => base_url() . 'MsPelanggan/save',
			'button' => 'Update',
			// 'fk_cabang_id' => set_value('fk_cabang_id',$kat->fk_cabang_id),
			'nama' => set_value('nama', $kat->nama),
			'no_hp' => set_value('no_hp', $kat->no_hp),
			'jenis_kel' => set_value('jenis_kel', $kat->jenis_kel),
			'status' => set_value('status', $kat->status),
			'alamat' => set_value('alamat', $kat->alamat),
			'id' => set_value('id', $kat->id),
		);
		$data['MsPelanggan'] = 'active';
		$data['act_back'] = base_url() . 'MsPelanggan';
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Home/template', 'MsPelanggan/form', $data);
	}

	public function save()
	{
		$id = $this->input->post('id');
		// $data['fk_cabang_id'] = $this->input->post('fk_cabang_id');
		$nama = $this->input->post('nama');
		$data['nama'] = $nama;
		$jnsKel = $this->input->post('jenis_kel');
		$data['jenis_kel'] = $jnsKel;
		$data['status'] = $this->input->post('status');
		$data['alamat'] = $this->input->post('alamat');

		$no_hp = $this->input->post('no_hp');
		$data['no_hp'] = $no_hp;
		$cek = '';
		if ($no_hp != '-') {
			$cek = $this->db->query("SELECT no_hp,nama,alamat FROM ms_pelanggan WHERE no_hp='$no_hp' AND id!='$id' ")->row();
		}

		$page_pos = $this->input->post('page_pos');

		if ($cek) {
			$data['action'] = base_url() . 'MsPelanggan/save';
			$data['id'] = $id;

			$tombol = 'Update';
			if ($id) {
				$tombol = 'Update';
			}
			$data['button'] = $tombol;
			$data['act_back'] = base_url() . 'MsPelanggan';

			$this->session->set_flashdata('error', 'No Hp ' . $no_hp . ' sudah terdaftar a.n. : ' . $cek->nama . ', Alamat : ' . $cek->alamat);

			if ($page_pos) {
				redirect($page_pos);
			}
			return $this->template->load('Home/template', 'MsPelanggan/form', $data);
		}

		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		$page_pos = $this->input->post('page_pos');

		if (empty($id)) {
			$this->MMsPelanggan->insert($data);

			// if($no_hp!='-'){
			// 	$kpd = 'Ibu ';
			// 	if($jnsKel=='L'){
			// 		$kpd = 'Bapak ';
			// 	}
			// 	$pesan = "Terimakasih *$kpd $nama* atas kepercayaan anda kepada SNAP Pijat, kritik dan saran kami tunggu. silahkan review di google.";
			// 	$this->help->kirim_wa($no_hp,$pesan);
			// }

			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->MMsPelanggan->update($id, $data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}


		if ($page_pos) {
			redirect($page_pos);
		}

		redirect('MsPelanggan');
	}

	public function prosesKirimWA()
	{
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
		// if($this->session->fk_level_id==1){
		$result = $this->MMsPelanggan->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MsPelanggan');
	}

	public function viewRiwayat($id)
	{
		$query = "SELECT kode,tgl,nama_paket,nama_terapis,mc.nama_cabang FROM t_pos_detail td 
			INNER JOIN t_pos t ON t.id=td.fk_pos_id
			INNER JOIN ms_cabang mc ON mc.id=t.fk_cabang_id
			WHERE t.fk_pelanggan_id=$id
			ORDER BY tgl DESC";
		$data['hasil'] =  $this->db->query($query)->result();

		$this->template->load('Home/template', 'MsPelanggan/viewRiwayat', $data);
	}
}
