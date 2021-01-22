<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
		$this->m_admin->sesiku();
	}

	public function index()
	{
		$data['reservation']=$this->m_admin->tampil_reservation();
		$this->load->view('admin/reservation/reservation',$data);
	}

}

/* End of file reservation.php */
/* Location: ./application/controllers/reservation.php */