<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MHome extends CI_Model {
	function ceklogin(){
		$exp=array('Auth','Android');
		$ctrl=$this->uri->segment(1);
		$id=$this->session->userdata('id');
		if(!in_array($ctrl,$exp)){
			if(empty($id)) {
                redirect('Auth');
     			die();
            }
		}
	}
}