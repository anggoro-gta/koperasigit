<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MscbAnggotaMutasi extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('datatables');
		$this->load->model('MHome');
		$this->load->model('MMscbUseranggota');
		$this->load->model('MMscbSkpd');
		$this->load->model('MMscbStatuspekerjaan');
		$this->load->model('MMscbUserAnggotaMutasi');
		// $this->load->model('MMscbSimpanan');

		// $this->load->model('MMsCabang');
	}

	public function index()
	{
		$this->MHome->ceklogin();
		$data = null;
		$data['MscbAnggotaMutasi'] = 'active';
		$data['arrAnggotaMutasi'] = $this->MMscbSkpd->get();
		// $data['arrcabang'] = $this->MMsCabang->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggota/list', $data);
	}

	public function getListDetail()
	{
		$this->MHome->ceklogin();
		$data['act_add'] = base_url() . 'MscbAnggota/create';
		$data['skpd'] = $this->input->post('skpd');
		// $data['tgl_dari'] = $this->input->post('tgl_dari');
		// $data['tgl_sampai'] = $this->input->post('tgl_sampai');

		$this->load->view('MscbAnggota/listDetail', $data);
	}

	public function getDatatables()
	{
		$this->MHome->ceklogin();
		header('Content-Type: application/json');

		$skpd = $this->input->post('skpd');
		// $tgl_dari = $this->input->post('tgl_dari');
		// $tgl_sampai = $this->input->post('tgl_sampai');

		if ($skpd != '') {
			$this->datatables->where('a.fk_id_skpd', $skpd);
		}

		// if ($tgl_dari != '') {
		// 	$this->datatables->where("p.tgl >=", $this->help->ReverseTgl($tgl_dari));
		// 	$this->datatables->where("p.tgl <=", $this->help->ReverseTgl($tgl_sampai));
		// }

		$this->datatables->select("
		a.id,
		a.nama,
		a.alamat,
		a.nik,
		a.nip,
		a.nomor_hp,
		a.jenis_kelamin,
		a.status_keaktifan,
		a.simpanan_pokok,
		s.nama_skpd");
		$this->datatables->from("ms_cb_user_anggota a");
		$this->datatables->join('ms_cb_skpd s', 'a.fk_id_skpd=s.id', 'inner');
		$this->db->order_by('id', 'asc');
		$this->datatables->add_column('action', '<div class="btn-group">' . anchor(site_url('MscbAnggota/update/$1'), '<i title="edit" class="glyphicon glyphicon-edit icon-white"></i>', 'class="btn btn-xs btn-success"') . anchor(site_url('MscbAnggota/delete/$1'), '<i title="hapus" class="glyphicon glyphicon-trash icon-white"></i>', 'class="btn btn-xs btn-danger" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . anchor(site_url('MscbAnggota/resetpassword/$1'), '<i title="reset password" class="glyphicon glyphicon-refresh icon-white"></i>', 'class="btn btn-xs btn-warning" onclick="javasciprt: return confirm(\'Apakah anda yakin?\')"') . '</div>', 'id');

		echo $this->datatables->generate();
	}

	public function create()
	{
		$this->MHome->ceklogin();

		$pokok = $this->db->query("SELECT * FROM ms_cb_simpanan WHERE kategori='pokok'")->row();
		$wajib = $this->db->query("SELECT * FROM ms_cb_simpanan WHERE kategori='wajib'")->row();

		$data = array(
			'action' => base_url() . 'MscbAnggotaMutasi/save',
			'button' => 'Simpan',
			'id' => set_value('id'),
			'nama' => set_value('nama'),
			'alamat' => set_value('alamat'),
			'nik' => set_value('nik'),
			'nip' => set_value('nip'),
			'nomor_hp' => set_value('nomor_hp'),
			'jenis_kelamin' => set_value('jenis_kelamin'),
			'fk_id_status_pekerjaan' => set_value('fk_id_status_pekerjaan'),
			'fk_id_skpd' => set_value('fk_id_skpd'),
			'status_keaktifan' => set_value('status_keaktifan'),
			'simpanan_pokok' => set_value('simpanan_pokok', $pokok->nominal),
			'simpanan_wajib' => set_value('simpanan_wajib', $wajib->nominal),
			'keterangan' => set_value('keterangan'),
		);

		$data['MscbAnggota'] = 'active';
		$data['act_back'] = base_url() . 'MscbAnggota';
		$data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrSimpanan'] = $this->MMscbSimpanan->get();
		// $data['arrcabang'] = $this->MMsCabang->get(array('status'=>1));
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggota/form', $data);
	}

	public function update($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db->query("SELECT * FROM ms_cb_user_anggota WHERE id=$id")->row();

		$data = array(
			'action' => base_url() . 'MscbAnggotaMutasi/savemutasi',
			'button' => 'Update',
			'id' => set_value('id', $kat->id),
			'nama' => set_value('nama', $kat->nama),
			'tgl' => set_value('tgl'),
			'alamat' => set_value('alamat', $kat->alamat),
			'nik' => set_value('nik', $kat->nik),
			'nip' => set_value('nip', $kat->nip),
			'nomor_hp' => set_value('nomor_hp', $kat->nomor_hp),
			'jenis_kelamin' => set_value('jenis_kelamin', $kat->jenis_kelamin),
			'fk_id_status_pekerjaan' => set_value('fk_id_status_pekerjaan', $kat->fk_id_status_pekerjaan),
			'fk_id_skpd' => set_value('fk_id_skpd', $kat->fk_id_skpd),
			'status_keaktifan' => set_value('status_keaktifan', $kat->status_keaktifan),
			'simpanan_pokok' => set_value('simpanan_pokok', $kat->simpanan_pokok),
			'simpanan_wajib' => set_value('simpanan_wajib', $kat->simpanan_wajib),
			'keterangan' => set_value('keterangan', $kat->keterangan),
		);
		$data['MscbAnggotaMutasi'] = 'active';
		$data['act_back'] = base_url() . 'MscbAnggota';
		// $data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		$data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrSimpanan'] = $this->MMscbSimpanan->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggotaMutasi/form', $data);
	}

	public function savemutasi()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');
		$fk_id_skpd_lama = $this->input->post('fk_id_skpd_lama');
		$fk_id_skpd = $this->input->post('fk_id_skpd');

		if ($fk_id_skpd == $fk_id_skpd_lama) {
			$this->session->set_flashdata('error', 'Data gagal diupdate');
		} else {
			$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');

			$this->MMscbUseranggota->update($id, $data);

			$datamutasi['fk_user_anggota_id'] = $this->input->post('id');
			$datamutasi['tgl_mutasi'] = $this->help->ReverseTgl($this->input->post('tgl'));
			$datamutasi['fk_opd_sebelum'] = $this->input->post('fk_id_skpd_lama');
			$datamutasi['fk_opd_sesudah'] = $this->input->post('fk_id_skpd');
			$datamutasi['user_act'] = $this->session->id;
			$datamutasi['time_act'] = date('Y-m-d H:i:s');

			$this->MMscbUserAnggotaMutasi->insert($datamutasi);
			$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
		}
		redirect('MscbAnggota');
	}

	public function save()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');

		$data['user_act'] = $this->session->id;
		$data['time_act'] = date('Y-m-d H:i:s');

		if (empty($id)) {
			$last = $this->db->query("SELECT username FROM ms_cb_user_anggota ORDER BY id DESC LIMIT 1")->row();
			$castint = intval($last->username);
			$caststring = strval($castint);
			$panjanghuruf = strlen($caststring);

			$idnew = $castint + 1;
			$stringidnew = strval($idnew);

			$finalidnew = '';

			if ($panjanghuruf == 1) {
				$stringnull = "00000";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 2) {
				$stringnull = "0000";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 3) {
				$stringnull = "000";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 4) {
				$stringnull = "00";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 5) {
				$stringnull = "0";
				$finalidnew = $stringnull . '' . $stringidnew;
			} else if ($panjanghuruf == 6) {
				$finalidnew = $stringidnew;
			}

			$getsimpwajib = $this->input->post('simpanan_wajib');

			if ($getsimpwajib == "") {
				// $data['id'] = $finalidnew;
				$data['username'] = $finalidnew;
				$data['password'] = md5('admin');
				$data['nama'] = $this->input->post('nama');
				$data['alamat'] = $this->input->post('alamat');
				$data['nik'] = $this->input->post('nik');
				$data['nip'] = $this->input->post('nip');
				$data['nomor_hp'] = $this->input->post('nomor_hp');
				$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
				$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');
				$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');
				$data['status_keaktifan'] = $this->input->post('status_keaktifan');
				$data['simpanan_pokok'] = str_replace(",", "", $this->input->post('simpanan_pokok'));
				// $data['simpanan_wajib'] = NULL;
				$data['keterangan'] = $this->input->post('keterangan');

				$this->MMscbUseranggota->insert($data);
				$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
			} else {
				// $data['id'] = $finalidnew;
				$data['username'] = $finalidnew;
				$data['password'] = md5('admin');
				$data['nama'] = $this->input->post('nama');
				$data['alamat'] = $this->input->post('alamat');
				$data['nik'] = $this->input->post('nik');
				$data['nip'] = $this->input->post('nip');
				$data['nomor_hp'] = $this->input->post('nomor_hp');
				$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
				$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');
				$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');
				$data['status_keaktifan'] = $this->input->post('status_keaktifan');
				$data['simpanan_pokok'] = str_replace(",", "", $this->input->post('simpanan_pokok'));
				$data['simpanan_wajib'] = str_replace(",", "", $this->input->post('simpanan_wajib'));
				$data['keterangan'] = $this->input->post('keterangan');

				$this->MMscbUseranggota->insert($data);
				$this->session->set_flashdata('success', 'Data Berhasil disimpan.');
			}
		} else {

			$getsimpwajib = $this->input->post('simpanan_wajib');

			if ($getsimpwajib == "") {
				$data['id'] = $id;
				$data['nama'] = $this->input->post('nama');
				$data['alamat'] = $this->input->post('alamat');
				$data['nik'] = $this->input->post('nik');
				$data['nip'] = $this->input->post('nip');
				$data['nomor_hp'] = $this->input->post('nomor_hp');
				$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
				$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');
				$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');
				$data['status_keaktifan'] = $this->input->post('status_keaktifan');
				$data['simpanan_pokok'] = str_replace(",", "", $this->input->post('simpanan_pokok'));
				// $data['simpanan_wajib'] = NULL;
				$data['keterangan'] = $this->input->post('keterangan');

				$this->MMscbUseranggota->update($id, $data);
				$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
			} else {
				$data['id'] = $id;
				$data['nama'] = $this->input->post('nama');
				$data['alamat'] = $this->input->post('alamat');
				$data['nik'] = $this->input->post('nik');
				$data['nip'] = $this->input->post('nip');
				$data['nomor_hp'] = $this->input->post('nomor_hp');
				$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
				$data['fk_id_status_pekerjaan'] = $this->input->post('fk_id_status_pekerjaan');
				$data['fk_id_skpd'] = $this->input->post('fk_id_skpd');
				$data['status_keaktifan'] = $this->input->post('status_keaktifan');
				$data['simpanan_pokok'] = str_replace(",", "", $this->input->post('simpanan_pokok'));
				$data['simpanan_wajib'] = str_replace(",", "", $this->input->post('simpanan_wajib'));
				$data['keterangan'] = $this->input->post('keterangan');

				$this->MMscbUseranggota->update($id, $data);
				$this->session->set_flashdata('success', 'Data Berhasil diupdate.');
			}
		}

		redirect('MscbAnggota');
	}

	public function detail_mutasi($id)
	{
		$this->MHome->ceklogin();
		$skpd = $this->db->query("select * from ms_cb_skpd")->result_array();
		$data = array(
			'action' => base_url() . 'Tagihan/save_kolektif',
			'button' => 'Buat Tagihan',
			'id' => set_value('id', $id)
		);

		$data['MscbAnggota'] = 'active';
		$data['act_back'] = base_url() . 'MscbAnggota';
		$data['arrUserAnggota'] = $this->MMscbUseranggota->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggotaMutasi/formdetailmutasi', $data);
	}

	function getData($id = null)
	{
		$getdatapost = $this->input->post('datatest');

		$detailmutasi = $this->db->query('select
			m.id,m.tgl_mutasi,m.fk_user_anggota_id,a.nama,sb.nama_skpd as sebelum,sd.nama_skpd as sesudah
		from
			ms_cb_user_anggota_mutasi m
			join ms_cb_user_anggota a on a.id= m.fk_user_anggota_id
			join ms_cb_skpd sb on m.fk_opd_sebelum = sb.id
			join ms_cb_skpd sd on m.fk_opd_sesudah = sd.id
		where
			m.fk_user_anggota_id =' . $id . ' ORDER BY m.id DESC')->result();

		$data = [
			'detailmutasi' => $detailmutasi
		];
		$this->load->view('MscbAnggotaMutasi/_formdetailmutasi', $data);
	}

	public function update_tgl_mutasi($id)
	{
		$this->MHome->ceklogin();
		$kat = $this->db->query("SELECT * FROM ms_cb_user_anggota_mutasi WHERE id=$id")->row();
		$nama_anggota = $this->db->query("SELECT * FROM ms_cb_user_anggota WHERE id = $kat->fk_user_anggota_id")->row();
		$skpd_lama = $this->db->query("SELECT * FROM ms_cb_skpd WHERE id = $kat->fk_opd_sebelum")->row();
		$skpd_baru = $this->db->query("SELECT * FROM ms_cb_skpd WHERE id = $kat->fk_opd_sesudah")->row();

		$data = array(
			'action' => base_url() . 'MscbAnggotaMutasi/saveupdatetglmutasi',
			'button' => 'Update',
			'id' => set_value('id', $kat->id),
			'nama' => set_value('nama', $nama_anggota->nama),
			'tgl' => set_value('tgl', $this->help->ReverseTgl($kat->tgl_mutasi)),
			'skpd_lama' => set_value('skpd_lama', $skpd_lama->nama_skpd),
			'skpd_baru' => set_value('skpd_baru', $skpd_baru->nama_skpd)
		);
		$data['MscbAnggotaMutasi'] = 'active';
		$data['act_back'] = base_url() . 'MscbAnggotaMutasi/detail_mutasi/' . $kat->fk_user_anggota_id;
		// $data['arrStatuspekerjaan'] = $this->MMscbStatuspekerjaan->get();
		// $data['arrSkpd'] = $this->MMscbSkpd->get();
		// $data['arrSimpanan'] = $this->MMscbSimpanan->get();
		$this->template->load('Homeadmin/templateadmin', 'MscbAnggotaMutasi/formupdatetglmutasi', $data);
	}

	public function saveupdatetglmutasi()
	{
		$this->MHome->ceklogin();
		$id = $this->input->post('id');

		$data['tgl_mutasi'] = $this->help->ReverseTgl($this->input->post('tgl'));

		$this->MMscbUserAnggotaMutasi->update($id, $data);
		$this->session->set_flashdata('success', 'Tanggal mutasi berhasil di update');

		redirect('MscbAnggota');
	}

	public function delete_detailmutasi($id)
	{
		$this->MHome->ceklogin();
		// if($this->session->fk_level_id==1){
		$result = $this->MMscbUserAnggotaMutasi->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbAnggota');
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
		$result = $this->MMscbUseranggota->delete($id);
		if ($result) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		}
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbAnggota');
	}

	public function resetpassword($id)
	{
		$this->MHome->ceklogin();
		$data['password'] = md5('kedirikab');
		// if($this->session->fk_level_id==1){
		$this->MMscbUseranggota->update($id, $data);
		$this->session->set_flashdata('success', 'Data berhasil direset passwordnya.');
		// if ($result) {
		// 	$this->session->set_flashdata('success', 'Data berhasil direset passwordnya.');
		// } else {
		// 	$this->session->set_flashdata('error', 'Data gagal direset passwordnya.');
		// }
		// }else{
		// 	$this->session->set_flashdata('error', 'Data hanya bisa diupdate');
		// }

		redirect('MscbAnggota');
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
				$this->MMscbUseranggota->update($this->session->id, $dataUpdate);
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

		$this->template->load('Homeanggota/templateanggota', 'MscbAnggota/formUbahPswd', $data);
	}
}
