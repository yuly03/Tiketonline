<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesawat extends CI_Controller {

	/**
	 * Index Page for this controller.
	 * https://github.com/odol95/booking-tiket
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 * github.com/ondol95
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function index(){
		redirect('');
	}

	public function cari()
	{
		$rute_from = $this->input->get('rute_from');
		$rute_to = $this->input->get('rute_to');
		$depart_at = $this->input->get('depart_at');
		$seat_qty = $this->input->get('seat_qty');

    	$data['rute']=$this->m_account->cari($rute_from,$rute_to,$depart_at,$seat_qty)->result();
    	$data['seat_qty']=$seat_qty;
    	$this->load->view('cari', $data,$seat_qty);
	}

	function booking()
	{
		$id=$this->input->get('id');
		$seat_qty=$this->input->get('seat_qty');

		$this->session->set_flashdata('seat_qty', $seat_qty);

		//$data['jml_seat']=$this->m_account->jml_seat();
		$data['user']=$this->m_account->getuser($this->session->userdata('id'));
		$data['rute']=$this->m_account->booking($id)->result();
		$data['booked']=$this->m_account->treservation($id);
		$data['seat_qty']=$seat_qty;
		$this->load->view('booking',$data);
	}

	function payment(){
		$waktu = date('dm');
		// $id = $this->input->post('id');
		$id_users = $this->input->post('id_users');

		for($i = 0;$i < $this->session->seat_qty; $i++)
		{
			$name = $this->input->post('name');
			$noid = $this->input->post('noid');
			
			$kursi = $this->input->post('seat_code');
			
			$data = array(
				// 'id' => $id,
				'id_users' => $id_users,
				'name' => $name[$i],
				'noid' => $noid[$i],
			);
			
			$this->m_account->add_booking('customer', $data);
			
			//batas
			
			$kindol = $this->db->query('SELECT COUNT(id) as jumlah FROM `reservation` WHERE reservation_code like \'TOM'.$waktu.'%\'')->result()[0]->jumlah+1;

			$reservation_code = 'TOM'.$waktu.$kindol;
			$customer_id = $this->db->query('SELECT id FROM customer WHERE noid = \''.$noid[$i].'\'')->result()[0]->id;
			$seat_code = $this->input->post('seat_code_'.$i);
			$kiedie = $this->input->post('rute_id');
			$price = $this->input->post('price');
		
			$data = array(
				'reservation_code' => $reservation_code,
				'customer_id' => $customer_id,
				'seat_code' => $kursi[$i],
				'rute_id' => $kiedie,
			);
			$reservationp=$this->input->post('id_users');
			$this->m_account->add_booking('reservation', $data);

			// batas maning
			$telepon = $this->input->post('telepon');
			$invoice = 'INV'.$waktu.$telepon;

			$data = array(
				'telepon' => $telepon,
				'invoice' => $invoice,
			);
			
		}
		$this->load->view('payment',$data);
	}

	function success(){
		$this->load->view('common/success');
	}
}
