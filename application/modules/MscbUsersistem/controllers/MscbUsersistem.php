<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MscbUsersistem extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbLevel');
		$this->load->model('MMscbUsersistem');
		// $this->load->model('MMscbStatuspekerjaan');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['MscbUsersistem'] = 'active';
		// $data['arrAnggota'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbUsersistem/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'MscbUsersistem/create';
		// $data['skpd'] = $this->input->post('skpd');
		// $data['tgl_dari'] = $this->input->post('tgl_dari');
		// $data['tgl_sampai'] = $this->input->post('tgl_sampai');

		$this->load->view('MscbUsersistem/listDetail', $data);
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
		u.id,
		u.username,
		u.nama_lengkap,
		l.nama,
		u.blokir");
		$this->datatables->from("ms_cb_user_sistem u");
		$this->datatables->join('ms_cb_level l', 'u.fk_cb_level_id = l.id', 'inner');
		$this->db->order_by('id', 'asc');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbUsersistem/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MscbUsersistem/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . anchor(site_url('MscbUsersistem/resetpassword/$1'), '<i title="reset password" class="glyphicon glyphicon-refresh icon-white"></i>', 'class="btn btn-xs btn-warning" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();
		$data = array(
			'action' => base_url() . 'MscbUsersistem/save',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'username' => set_value('username'),
			'nama_lengkap' => set_value('nama_lengkap'),
			'fk_cb_level_id' => set_value('fk_cb_level_id'),
			'blokir' => set_value('blokir'),
		);

		$data['MscbUsersistem'] = 'active';
		$data['act_back'] = base_url() . 'MscbUsersistem';
		$data['arrLevel'] = $this->MMscbLevel->get();
		// $data['arrSkpd'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbUsersistem/form', $data);
	}

	public function update($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db->query("SELECT * FROM ms_cb_user_sistem WHERE id=$id")->row();

		$data = array(
			'action' => base_url() . 'MscbUsersistem/save',
			'button' => 'Update',
			'id' => set_value('id', $kat->id),
			'username' => set_value('username', $kat->username),
			'nama_lengkap' => set_value('nama_lengkap', $kat->nama_lengkap),
			'fk_cb_level_id' => set_value('fk_cb_level_id', $kat->fk_cb_level_id),
			'blokir' => set_value('blokir', $kat->blokir),
		);
		$data['MscbUsersistem'] = 'active';
		$data['act_back'] = base_url() . 'MscbUsersistem';
		$data['arrLevel'] = $this->MMscbLevel->get();
		// $data['arrSkpd'] = $this->MMscbSkpd->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbUsersistem/form', $data);
	}

	public function save()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');
		$data['username'] = $this->input->post('username');
		$data['nama_lengkap'] = $this->input->post('nama_lengkap');
		$data['fk_cb_level_id'] = $this->input->post('fk_cb_level_id');
		$data['blokir'] = $this->input->post('blokir');

		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		if (empty($id)) {
			$data['password'] = md5('admin');

			$this->MMscbUsersistem->insert($data);
			$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
		} else {
			$this->MMscbUsersistem->update($id, $data);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}

		redirect('MscbUsersistem');
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
		// if($this->session->fk_level_id==1){
		$result = $this->MMscbUsersistem->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbUsersistem');
	}

	public function resetpassword($id)
	{
		$this->MHome->ceklogin();
		$data['password'] = md5('admin');
		// if($this->session->fk_level_id==1){
		$this->MMscbUsersistem->update($id, $data);
		$this->session->set_flashdata('success', 'Data berhasil direset passwordnya.');
		// if ($result) {
		// 	$this->session->set_flashdata('success', 'Data berhasil direset passwordnya.');
		// } else {
		// 	$this->session->set_flashdata('error', 'Data gagal direset passwordnya.');
		// }
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbUsersistem');
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

	public function ubahPswd()
	{
		$data = array(
			'pswdLama' => set_value('pswdLama'),
			'pswdBaru' => set_value('pswdBaru'),
			'ulangiPswdBaru' => set_value('ulangiPswdBaru'),
		);
		if (isset($_POST['pswdBaru'])) {
			$pswdLama = $this->input->post('pswdLama');
			$pswdBaru = $this->input->post('pswdBaru');
			$ulangiPswdBaru = $this->input->post('ulangiPswdBaru');

			if (md5($pswdLama) != $this->session->password) {
				$this->session->set_flashdata('error', 'Password Lama tidak sesuai.');
				$error = true;
			} else if ($pswdBaru != $ulangiPswdBaru) {
				$this->session->set_flashdata('error', 'Ulangi Password Baru harus sama dengan Password baru.');
				$error = true;
			} else {
				$dataUpdate['password'] = md5($pswdBaru);
				$dataUpdate['user_act'] = $this->session->id;
				$dataUpdate['time_act'] = date('Y-m-d H:i:s');
				$this->MMscbUsersistem->update($this->session->id, $dataUpdate);
				$error = false;
				$this->session->set_flashdata('success', 'Password Berhasil diubah, silahkan logout dan login kembali dengan password yg baru.');
			}

			if ($error) {
				$data = array(
					'pswdLama' => set_value('pswdLama', $pswdLama),
					'pswdBaru' => set_value('pswdBaru', $pswdBaru),
					'ulangiPswdBaru' => set_value('ulangiPswdBaru', $ulangiPswdBaru),
				);
			} else {
				$data['pswdLama'] = '';
				$data['pswdBaru'] = '';
				$data['ulangiPswdBaru'] = '';
			}
		}

		$this->template->load('Homeadmin/templateadmin', 'MscbUsersistem/formUbahPswd', $data);
	}
}
