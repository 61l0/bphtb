<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sspd_model extends CI_Model {
	private $tbl = 'bphtb_sspd';
        
	function get_all()
	{
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
    
    function get_sspdno($id)
	{
        $sql = "select get_sspdno(id) as sspdno
                from bphtb_sspd 
                where id=?";
                
        $query = $this->db->query($sql, array($id));
		if($query->num_rows()!==0)
		{
			return $query->row()->sspdno;
		}
		else
			return FALSE;
	}
    
    function get_nop($id, $formated=true)
	{
        $formated = ($formated) ? 'true' : 'false';
        $sql = "select get_nop_sspd(id, {$formated}) as nopthn
                from bphtb_sspd 
                where id=?";
                
        $query = $this->db->query($sql, array($id));
		if($query->num_rows()!==0)
		{
			return $query->row()->nopthn;
		}
		else
			return FALSE;
	}
    
    function get_nopthn($id)
	{
        $sql = "select get_nop_thn_sspd(id, true) as nopthn
                from bphtb_sspd 
                where id=?";
                
        $query = $this->db->query($sql, array($id));
		if($query->num_rows()!==0)
		{
			return $query->row()->nopthn;
		}
		else
			return FALSE;
	}
    
    function get_new_sspdno($thn, $kode)
    {
        $sql = "select tahun, kode, no_sspd 
                from bphtb_sspd 
                where tahun={$thn} and kode='{$kode}' 
                order by no_sspd desc limit 1";
                
        $query = $this->db->query($sql);
        if ($query->num_rows() !== 0) {
            $result = $query->result();
            return array(
                $thn,
                $kode,
                (double) $result[0]->no_sspd + 1
            );
        } else {
            return array($thn,$kode,1);
        }
    }
    
    function do_upload($data)
    {
        $kode  = $data['tahun'] . '.' . $data['kode'];
        $nomor = $data['no_sspd'];
        $nomor = str_pad($nomor, 6, "0", STR_PAD_LEFT);
        $kode .= '.' . $nomor;
        for ($i = 1; $i <= 10; $i++) {
            $file = $this->upload_sspd_file($kode . '-doc' . (string) $i, 'attach' . (string) $i, $data['file' . (string) $i]);
            if ($file != '') {
                $data['file' . (string) $i] = $file;
            }
        }
        return $data;
    }
    
    function upload_sspd_file($nomor, $uplname, $current)
    {
        $mydir = dirname(__FILE__) . ('//..//files//');
        if ($uplname != '' && $nomor) {
            if (!$_FILES[$uplname]["error"]) {
                $newName = $nomor . '-' . $_FILES[$uplname]["name"];
                if (file_exists($mydir . $newName)) {
                    unlink($mydir . $newName);
                }
                move_uploaded_file($_FILES[$uplname]['tmp_name'], $mydir . $newName);
                return $newName;
            } else {
                return $current;
            }
        } else {
            return $current;
        }
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