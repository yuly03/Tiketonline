<?php
Class M_admin extends CI_Model
{

	function sesiku(){
		$this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Login Pak</div>');
		if($this->session->statusadmin != "online"){
			redirect('admin/login','refresh');
		}
	}

	function cairport(){
		return $this->db->query('SELECT COUNT(*) as jumlah FROM airport;')->result();
	}

	function cdestination(){
		return $this->db->query('SELECT COUNT(*) as jumlah FROM destination;')->result();
	}

	function ctransportation(){
		return $this->db->query('SELECT COUNT(*) as jumlah FROM transportation;')->result();
	}

	function crute(){
		return $this->db->query('SELECT COUNT(*) as jumlah FROM rute;')->result();
	}

	function tampil_user(){
		return $this->db->get('users')->result();	
	}

	function tampil_airport($id=''){
		if($id!=''){
			$where = ' AND A.id = "'.$id.'"';
		} else {
			$where = '';
		}
		$query = $this->db->query('SELECT A.id,A.name,A.iso, B.destination,B.id as idkota FROM airport A,destination B WHERE A.id_destination=B.id' . $where);
		return $query;
		// return $this->db->get('airport')->result();	
	}

	function get_airport($id=''){
		if($id!=''){
			$where = ' AND id_destination = "'.$id.'"';
		} else {
			$where = '';
		}
		$query = $this->db->query('SELECT * FROM airport WHERE 1=1 ' . $where);
		return $query;
	}

	function tampil_rute($id=''){
		if($id!=''){
			$where = ' AND A.id = "'.$id.'"';
		} else {
			$where = '';
		}
		$query= $this->db->query('SELECT A.*,B.name as maskapai FROM rute A, transportation B WHERE A.id_transportation=B.id '.$where.' ORDER BY creat_date DESC');
    	return $query->result();
		
    }

	function tampil_transportation(){
		return $this->db->get('transportation')->result();
	}

	function tampil_reservation(){
		$query = $this->db->query('SELECT R.*,C.id_users,C.name,C.noid,JR.rute_from,JR.rute_to,(select name from airport where JR.rute_from=airport.id) AS mktndol,(select iso from airport where JR.rute_from=airport.id) AS codemkt,(select iso from airport where JR.rute_to=airport.id) AS codebli,(select name from airport where JR.rute_to=airport.id) AS blindol FROM reservation R, customer C JOIN rute JR JOIN airport JA WHERE R.customer_id=C.id AND R.rute_id=JR.id AND JR.rute_from=JA.id ORDER BY reservation_date DESC');
		return $query->result();
	}

	function tampil_destination(){
		return $this->db->get('destination')->result();
	}

	function add_destination($data){
    $this->db->insert('destination', $data);
	}

	function add_transportation($data){
    $this->db->insert('transportation', $data);
	}

	function add_airport($data){
    $this->db->insert('airport', $data);
	}

	function add_rute($data,$table){
		$this->db->insert($table,$data);
	}

	function edit_destination($destination,$where){
		return $this->db->get_where($destination,$where);
	}

	function edit_user($users,$id){
		return $this->db->get_where($users,$where);
	}

	function edit_airport($table,$id){
		$query = $this->db->query('SELECT A.*,D.destination FROM airport A JOIN destination D WHERE A.id='.$id.' AND D.id=A.id_destination');
		return $query;
	}

	function edit_transportation($table,$id){
		$this->db->where('id', $id);
		return $this->db->get($table,$id);
	}

	function update_destination($id,$data){
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	function update_user($id,$data){
		$this->db->where('id', $id);
		$this->db->update('users', $data);
	}

	function update_airport($id,$data){
		$this->db->where('id', $id);
		$this->db->update('airport', $data);
	}

	function update_rute($id,$data){
		$this->db->where('id', $id);
		$this->db->update('rute', $data);
	}

	function update_transportation($id,$data){
		$this->db->where('id', $id);
		$this->db->update('transportation', $data);
	}

	function hapus_destination($id){
		$this->db->where('id', $id);
		$this->db->delete('destination');
	}

	function hapus_user($id){
		$this->db->where('id', $id);
		$this->db->delete('users');
	}

	function hapus_rute($id){
		$this->db->where('id', $id);
		$this->db->delete('rute');
	}

	function hapus_transportation($id){
		$this->db->where('id', $id);
		$this->db->delete('transportation');
	}

	function hapus_airport($id){
		$this->db->where('id', $id);
		$this->db->delete('airport');
	}
}
?>