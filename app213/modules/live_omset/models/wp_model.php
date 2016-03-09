<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wp_model extends CI_Model {
	private $tbl = 'wajib_pajak';
	
	function __construct() {
		parent::__construct();
	}
	
	function get_all()
	{
		$this->db->order_by('id'); 
		$query = $this->db->get($this->tbl);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	}
		
	function get_all_op($wp_id)
	{
		$this->db->where(array('wp_id' => $wp_id)); 
		$this->db->order_by('nama'); 
		$query = $this->db->get('objek_pajak');
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	}
    
	function get_all_op_item($wp_id)
	{
        $sql = "SELECT op.nama op_nama, opi.* 
            FROM op_item opi
            INNER JOIN objek_pajak op ON op.id=opi.op_id
            WHERE op.wp_id={$wp_id}";
		$this->db->order_by('op_nama, nama'); 
		$query = $this->db->query($sql); 
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	}
		
	function get($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get($this->tbl);
		if($query->num_rows()!==0)
		{
			return $query->row();
		}
		else
			return FALSE;
	}
	
	//-- admin
	function save($data) {
		$this->db->insert($this->tbl,$data);
		return $this->db->insert_id();
	}
	
	function update($id, $data) {
		$this->db->where('id', $id);
		$this->db->update($this->tbl,$data);
	}
	
	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->tbl);
	}
}

/* End of file _model.php */