<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bphtb_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
    function get_daftar_sspd()
	{   
        $sql = "select id, 
            cast(kd_propinsi||'.'||kd_dati2||'.'||kd_kecamatan||'.'||kd_kelurahan||'.'||kd_blok||'-'||no_urut||'.'||kd_jns_op as varchar) nop
            from  bphtb_sspd             
            where kode='1' and posted<>1
            order by tahun desc, kode desc, no_sspd desc";
                
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
			return $query->result();
		else
			return FALSE;
	}
    
    function get_sspd($id) {
        $sql = "select 
            wp_nama, wp_npwp, wp_alamat, wp_blok_kav, wp_kelurahan, wp_rt, wp_rw, 
            wp_kecamatan, wp_kota, wp_provinsi, wp_identitas, wp_identitaskd, 
            
            op_alamat, op_blok_kav, op_rt, op_rw, bumi_luas, 
            bumi_njop, bng_luas, bng_njop, no_sertifikat, njop, 
            
            no_ajb, tgl_ajb, wp_nama_asal, jml_pph, tgl_pph, posted,
            cast(kd_propinsi||kd_dati2||kd_kecamatan||kd_kelurahan||kd_blok||no_urut||kd_jns_op as varchar) nop
            
            from bphtb_sspd
            where id={$id}";
                
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
			return $query->row_array();
		else
			return FALSE;
    }
    
    function get_sismiop_op($nop) {
        $sql = "select kd_propinsi, kd_dati2, kd_kecamatan, kd_kelurahan, kd_blok, no_urut, 
            kd_jns_op, subjek_pajak_id, no_formulir_spop, no_persil, jalan_op, 
            blok_kav_no_op, rw_op, rt_op, kd_status_cabang, kd_status_wp, 
            total_luas_bumi, total_luas_bng, njop_bumi, njop_bng
            
            from dat_objek_pajak 
            where cast(kd_propinsi||kd_dati2||kd_kecamatan||kd_kelurahan||kd_blok||no_urut||kd_jns_op as varchar)='{$nop}'";
            
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
			return $query->row();
		else
			return FALSE;
    }
    
    function get_sismiop_wp($id) {
        $sql = "select subjek_pajak_id, nm_wp, jalan_wp, blok_kav_no_wp, rw_wp, rt_wp, 
            kelurahan_wp, kota_wp, kd_pos_wp, telp_wp, npwp, status_pekerjaan_wp, 
            kecamatan_wp, propinsi_wp
            
            from dat_subjek_pajak
            where subjek_pajak_id='{$id}'";
            
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
			return $query->row();
		else
			return FALSE;
    }
    
	//-- admin
	function update_sspd($id, $data) {
        $tbl = 'bphtb_sspd';
        $this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update($tbl, $data);
        $this->db->trans_complete();
            
        if($this->db->trans_status())
            return true;
        else
            return false;
	}
    
	function update_sp($sp_id, $data) {
        $tbl = 'dat_subjek_pajak';
        $this->db->trans_start();
		$this->db->where('trim(subjek_pajak_id)=', $sp_id);
		$this->db->update($tbl, $data);
        $this->db->trans_complete();
            
        if($this->db->trans_status())
            return true;
        else
            return false;
	}
    
	function update_op($nop, $data) {
        $tbl = 'dat_objek_pajak';
        $this->db->trans_start();
		$this->db->where('cast(kd_propinsi||kd_dati2||kd_kecamatan||kd_kelurahan||kd_blok||no_urut||kd_jns_op as varchar)=', $nop);
		$this->db->update($tbl, $data);
        $this->db->trans_complete();
            
        if($this->db->trans_status())
            return true;
        else
            return false;
	}
    
    
    
    
    
    
	function save($data) {
        $this->db->trans_start();
		$this->db->insert($this->tbl,$data);
        $this->db->trans_complete();
            
        if($this->db->trans_status())
            return $this->db->insert_id();
        else
            return false;
	}
	
	function update($id, $data) {
        $this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update($this->tbl,$data);
        $this->db->trans_complete();
            
        if($this->db->trans_status())
            return true;
        else
            return false;
	}
	
	function delete($id) {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
        $this->db->trans_complete();
            
        if($this->db->trans_status())
            return true;
        else
            return false;
	}
}

/* End of file _model.php */