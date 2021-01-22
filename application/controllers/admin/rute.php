<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rute extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->model('m_admin');
		$this->m_admin->sesiku();

	}

	function index(){
		$arr_data_rute= array();
		$data_rute = $this->m_admin->tampil_rute();
		foreach($data_rute as $key) {
			$datasaturute = array();
			$airport_from = $this->m_admin->tampil_airport($key->rute_from)->row();
			$airport_to = $this->m_admin->tampil_airport($key->rute_to)->row();
			$datasaturute = array(
				'id' => $key->id,
				'depart_at' => $key->depart_at,
				'arrival' => $key->arrival,
				'mangkat_from' => $airport_from->destination,
				'rute_from' => $airport_from->name,
				'iso_from' => $airport_from->iso,
				'mangkat_to' => $airport_to->destination,
				'rute_to' => $airport_to->name,
				'iso_to' => $airport_to->iso,
				'price' => $key->price,
				'maskapai' => $key->maskapai,
				'idmaskapai' => $key->id_transportation,
				'creat_date' => $key->creat_date,
			);
			array_push($arr_data_rute, $datasaturute);
		}
		$data['rute'] = $arr_data_rute;
		$this->load->view('admin/rute/rute',$data);
	}

	function add(){
		$data['transportation']=$this->m_admin->tampil_transportation();
		$data['destination']=$this->m_admin->tampil_destination();
		// $data['rute'] = $this->m_admin->tampil_rute()->result();
		$this->load->view('admin/rute/add',$data);
	}

	function add_rute(){
		$id = $this->input->post('id');
		$id_transportation = $this->input->post('id_transportation');
		$rute_from = $this->input->post('rute_from');
		$rute_to = $this->input->post('rute_to');
		$depart_at = $this->input->post('depart_at');
		$arrival = $this->input->post('arrival');
		$price = $this->input->post('price');

		$data = array(
			'id' => $id,
			'id_transportation' => $id_transportation,
			'rute_from' => $rute_from,
			'rute_to' => $rute_to,
			'depart_at' => $depart_at,
			'arrival' => $arrival,
			'price' => $price,
		);
		$this->m_admin->add_rute($data,'rute');
		redirect('admin/rute');
	}

	function update_rute(){
		$id = $this->input->post('id');
		$id_transportation = $this->input->post('id_transportation');
		$rute_from = $this->input->post('rute_from');
		$rute_to = $this->input->post('rute_to');
		$depart_at = $this->input->post('depart_at');
		$arrival = $this->input->post('arrival');
		$price = $this->input->post('price');

		$data = array(
			'id' => $id,
			'id_transportation' => $id_transportation,
			'rute_from' => $rute_from,
			'rute_to' => $rute_to,
			'depart_at' => $depart_at,
			'arrival' => $arrival,
			'price' => $price,
		);
		$this->m_admin->update_rute($id,$data);
		redirect('admin/rute');
	}

	function del($id){
		$this->m_admin->hapus_rute($id);
		$this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil diubah <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/rute','refresh');
	}

	function edit($id){
		$data['transportation']=$this->m_admin->tampil_transportation();
		$data['destination']=$this->m_admin->tampil_destination();
		$arr_data_rute= array();
		$data_rute = $this->m_admin->tampil_rute($id);
		foreach($data_rute as $key) {
			$datasaturute = array();
			$airport_from = $this->m_admin->tampil_airport($key->rute_from)->row();
			$airport_to = $this->m_admin->tampil_airport($key->rute_to)->row();
			$datakotafrom = $this->m_admin->get_airport($airport_from->idkota);
			$optionfrom = '<option value="">Pilih Bandara</option>';
			foreach($datakotafrom->result() as $keyy){
				$optionfrom .= '<option value="'.$keyy->id.'" '.($keyy->id==$key->rute_from?"selected":"").'>'.$keyy->name.' ('.$keyy->iso.')</option>';
			}
			$datakotato = $this->m_admin->get_airport($airport_to->idkota);
			$optionto = '<option value="">Pilih Bandara</option>';
			foreach($datakotato->result() as $keyy){
				$optionto .= '<option value="'.$keyy->id.'" '.($keyy->id==$key->rute_to?"selected":"").'>'.$keyy->name.' ('.$keyy->iso.')</option>';
			}
			$datasaturute = array(
				'id' => $key->id,
				'idkotafrom' => $airport_from->idkota,
				'idkotato' => $airport_to->idkota,
				'optionbandarafrom' => $optionfrom,
				'optionbandarato' => $optionto,
				'depart_at' => $key->depart_at,
				'arrival' => $key->arrival,
				'mangkat_from' => $airport_from->destination,
				'rute_from' => $airport_from->name,
				'iso_from' => $airport_from->iso,
				'mangkat_to' => $airport_to->destination,
				'rute_to' => $airport_to->name,
				'iso_to' => $airport_to->iso,
				'price' => $key->price,
				'maskapai' => $key->maskapai,
				'idmaskapai' => $key->id_transportation,
				'creat_date' => $key->creat_date,
			);
			array_push($arr_data_rute, $datasaturute);
		}
		$data['rute'] = $arr_data_rute;
		$this->load->view('admin/rute/edit',$data);
	}

	function getairport($id){
		$data = $this->m_admin->get_airport($id);
		$option = '<option value="">Pilih Bandara</option>';
		foreach($data->result() as $key){
			$option .= '<option value="'.$key->id.'">'.$key->name.' ('.$key->iso.')</option>';
		}
		echo $option;
	}

}