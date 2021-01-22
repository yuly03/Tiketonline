<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destinations extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_admin');
		$this->m_admin->sesiku();
	}

	public function index()
	{
		$data['destination']=$this->m_admin->tampil_destination();
		// $data['jairport']=$this->db->query('SELECT COUNT(*) FROM airport A JOIN destination D WHERE A.id_destination=D.id AND D.id=4');
		$this->load->view('admin/destination/destination',$data);
	}

	function add()
	{
		$this->load->view('admin/destination/add');
	}

	function add_destination()
	{
		$id = $this->input->post('id');
		$destination = $this->input->post('destination');
		$iso = $this->input->post('iso');

		$data = array(
			'id' => $id,
			'destination' => $destination,
			'iso' => $iso,
		);
		$this->m_admin->add_destination($data,'destination');
		redirect('admin/destinations');
	}

	function edit($id)
	{
		$where = array('id' => $id);
		$data['destination'] = $this->m_admin->edit_destination('destination',$where)->result();
		$this->load->view('admin/destination/edit',$data);
	}

	function update($id){
		$destination = $this->input->post('destination');
		$iso = $this->input->post('iso');

		$data = array(
			'destination' =>$destination,
			'iso' =>$iso,
		);
		$this->m_admin->update_destination($id,$data);
		redirect('admin/destinations','refresh');
	}

	function del($id)
	{
		$this->m_admin->hapus_destination($id);
		redirect('admin/destinations','refresh');
	}

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */