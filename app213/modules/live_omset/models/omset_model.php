<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class omset_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function get_realisasi()
	{
        $sql = "select sum(monthly) monthly, sum(yearly) yearly from (
                    select sum(nominal) monthly, 0 yearly from bill
                    where extract(year from tgl)=extract(year from now()::date) AND extract(month from tgl) = extract (month from now()::date) 

                    union
                    select 0 monthly, sum(nominal) yearly from bill
                    where extract(year from tgl)=extract(year from now()::date) 
                ) as realisasi";
        
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->row();
		}
		else
			return FALSE;
	}
    
	function get_realisasi_op()
	{
        $sql = "select op_nama, sum(last_month) last_month, sum(this_month) this_month from (
                    select op.nama op_nama, sum(nominal) last_month, 0 this_month from bill b
                    inner join objek_pajak op on op.id=b.op_id
                    where extract(year from tgl)=extract(year from now()::date) AND extract(month from tgl) = extract(month from now()::date)-1
                    group by op.nama

                    union	
                    select op.nama op_nama, 0 last_month, sum(nominal) this_month from bill b
                    inner join objek_pajak op on op.id=b.op_id
                    where extract(year from tgl)=extract(year from now()::date) AND extract(month from tgl) = extract(month from now()::date)
                    group by op.nama
                ) as realisasi_op
                group by op_nama order by op_nama";
        
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
	}
    
    function get_realisasi_wp($op) 
    {
        $sql = "select wp_nama, sum(last_month) last_month, sum(this_month) this_month from (
                    select wp.nama wp_nama, nominal last_month, 0 this_month, b.id bill_id
                    from bill b
                    inner join objek_pajak op on op.id=b.op_id
                    inner join wajib_pajak wp on wp.id=op.wp_id
                    where extract(year from tgl)=extract(year from now()::date) AND extract(month from tgl) = extract(month from now()::date)-1
                    and lower(op.nama)=lower('{$op}')

                    union	
                    select wp.nama wp_nama, 0 last_month, nominal this_month, b.id bill_id
                    from bill b
                    inner join objek_pajak op on op.id=b.op_id
                    inner join wajib_pajak wp on wp.id=op.wp_id
                    where extract(year from tgl)=extract(year from now()::date) AND extract(month from tgl) = extract(month from now()::date)
                    and lower(op.nama)=lower('{$op}')
                ) as realisasi_wp
                group by wp_nama";
                
		$query = $this->db->query($sql);
		if($query->num_rows()!==0)
		{
			return $query->result();
		}
		else
			return FALSE;
    }
}

/* End of file _model.php */