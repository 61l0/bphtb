<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class op_model extends CI_Model {
	private $tbl = 'objek_pajak';
	
	function __construct() {
		parent::__construct();
	}
	
    function grid_dlg_ts100() {
        $sql = "SELECT op.*, wp.nama wp_nama, wp.npwp, wp.kelurahan wp_kelurahan, wp.kecamatan wp_kecamatan
            FROM objek_pajak op
            INNER JOIN wajib_pajak wp ON wp.id=op.wp_id";
            
		$this->db->order_by('wp_nama, nama'); 
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
    }
    
    function grid_dlg_bill() {
        $sql = "SELECT op.*, 
            wp.nama wp_nama, wp.npwp, wp.kelurahan wp_kelurahan, wp.kecamatan wp_kecamatan,
            ts.agent_id, a.jalur
            FROM objek_pajak op
            INNER JOIN wajib_pajak wp ON wp.id=op.wp_id
            INNER JOIN ts100 ts ON ts.op_id=op.id
            INNER JOIN agent a ON a.id=ts.agent_id";
            
		$this->db->order_by('wp_nama, nama'); 
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
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
	
    function get_wp($id) 
    {
        $wp_id = $this->get($id)->wp_id;
        
		$this->db->where('id',$wp_id);
		$query = $this->db->get('wajib_pajak');
		if($query->num_rows()!==0)
		{
			return $query->row();
		}
		else
			return FALSE;
    }
    
    function get_item($id) 
    {       
		$this->db->where('op_id',$id);
		$query = $this->db->get('op_item');
		if($query->num_rows()!==0)
		{
			return $query->result();
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