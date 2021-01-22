<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function pembelian()
	{
		$this->load->view('page/pembelian');
	}

	public function kontak()
	{
		$this->load->view('kontak');
	}

	public function about()
	{
		$this->load->view('page/about');
	}
}

/* End of file kontak.php */
/* Location: ./application/controllers/kontak.php */