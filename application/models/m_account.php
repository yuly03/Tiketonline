	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class M_account extends CI_Model{

		function sesiku(){
			$this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Login Pak</div>');
			if($this->session->status != "online"){
				redirect('akun/login','');
			}
		}

		function jml_seat(){
			return $this->db->query('SELECT T.id,T.seat_qty FROM transportation T JOIN rute R WHERE R.id_transportation=1')->result();
		}
		
		function daftar($data)
		{
			$this->db->insert('users',$data);
		}

		function rute(){
			$this->db->select('rute_from,rute_to');
			$this->db->distinct('rute_from,rute_to');
			return $this->db->get('rute')->result();
		}

		function destination(){
			return $this->db->get('destination')->result();
		}

		function transportation(){
			return $this->db->get('transportation')->result();
		}

		function tiket_akun($id){
			$query = $this->db->query('SELECT R.*,JR.depart_at,C.id_users,C.name,C.noid,JR.rute_from,JR.rute_to,(select name from airport where JR.rute_from=airport.id) AS mktndol,(select iso from airport where JR.rute_from=airport.id) AS codemkt,(select iso from airport where JR.rute_to=airport.id) AS codebli,(select name from airport where JR.rute_to=airport.id) AS blindol FROM reservation R, customer C JOIN rute JR JOIN airport JA WHERE R.customer_id=C.id AND R.rute_id=JR.id AND JR.rute_from=JA.id AND id_users='.$id.' ORDER BY reservation_date DESC');
			return $query->result();
		}

		function treservation($id){
			$query = $this->db->query('SELECT R.id,R.seat_code FROM reservation R, customer C JOIN rute JR JOIN airport JA WHERE R.customer_id=C.id AND R.rute_id=JR.id AND JR.rute_from=JA.id AND JR.id='.$id.'')->result();
			return $query;
		}

		function cari($rute_from,$rute_to,$depart_at,$seat_qty){
			return $this->db->query('SELECT T.code,T.img,T.name as maskapai,rute.id,rute.depart_at,rute.arrival,dari.name as bandarafrom,dari.iso as isofrom,ke.iso as isoto,ke.name as bandarato,darikota.destination as darikota,kekota.destination as kekota, darikota.iso as dariiso,kekota.iso as keiso,price,T.seat_qty
				FROM `rute` 
				INNER JOIN airport dari ON rute.rute_from=dari.id
				INNER JOIN airport ke ON rute.rute_to=ke.id
				INNER JOIN destination darikota ON darikota.id=dari.id_destination
				INNER JOIN destination kekota ON kekota.id=ke.id_destination
				INNER JOIN transportation T On T.id=rute.id_transportation
				WHERE darikota.iso="'.$rute_from.'" AND kekota.iso="'.$rute_to.'" AND depart_at LIKE "'.$depart_at.'%" AND T.seat_qty-(SELECT COUNT(*) FROM reservation WHERE rute_id=rute.id)>='.$seat_qty.'');
		}

		function booking($id){
			return $this->db->query('SELECT T.img,T.name as maskapai,rute.id,rute.depart_at,rute.arrival,dari.name as bandarafrom,dari.iso as isofrom,ke.iso as isoto,ke.name as bandarato,darikota.destination as darikota,kekota.destination as kekota, darikota.iso as dariiso,kekota.iso as keiso,price,T.seat_qty
				FROM `rute` 
				INNER JOIN airport dari ON rute.rute_from=dari.id
				INNER JOIN airport ke ON rute.rute_to=ke.id
				INNER JOIN destination darikota ON darikota.id=dari.id_destination
				INNER JOIN destination kekota ON kekota.id=ke.id_destination
				INNER JOIN transportation T On T.id=rute.id_transportation
				
				WHERE rute.id='.$id.'');
		}

		function add_booking($table, $data){
			$this->db->set($data);
			$this->db->insert($table);
		}

		function getuser($id){
			return $this->db->query('SELECT * FROM users where id = "'.$id.'"')->result();
		}
	}