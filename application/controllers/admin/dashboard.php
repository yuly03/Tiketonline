<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
		$this->m_admin->sesiku();
	}

	public function index()
	{
		$data['cdestination']=$this->m_admin->cdestination();
		$data['cairport']=$this->m_admin->cairport();
		$data['ctransportation']=$this->m_admin->ctransportation();
		$data['crute']=$this->m_admin->crute();
		$data['destination']=$this->m_admin->tampil_destination();
		$this->load->view('admin/dashboard',$data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */