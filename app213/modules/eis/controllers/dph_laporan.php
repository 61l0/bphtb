<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dph_laporan extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('login')) {
            $this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
            redirect('login');
            exit;
        }
        
		$module = 'dph_laporan';		
		$this->load->library('module_auth',array('module'=> $module));

		$this->load->model(array('apps_model'));
		$this->load->model(array('dph_model','dph_payment_model'));
	}
    
    public function index()
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect(active_module_url(''));
        }
        
        $data['current']      = 'dph';
        $data['apps']         = $this->apps_model->get_active_only();
		
        //FORM Parameter
		$tahun  = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
        $kec_kd = (isset($_GET['kec_kd']) ? $_GET['kec_kd'] : '000');
        $kel_kd = (isset($_GET['kel_kd']) ? $_GET['kel_kd'] : '000');
		$kec_kd = (get_user_kec_kd()!='000' && get_user_kec_kd()!=$kec_kd) ? get_user_kec_kd() : $kec_kd;
		$kel_kd = (get_user_kel_kd()!='000' && get_user_kel_kd()!=$kel_kd) ? get_user_kel_kd() : $kel_kd;
		   
        $data['tahun']     = $tahun;
        $data['kec_kd']    = $kec_kd;
        $data['kel_kd']    = $kel_kd;
        
        $this->load->model('kecModel', 'kec');
        $this->load->model('kelModel', 'kel');
		$data['kecamatan'] = $this->kec->getRecord('000');
		$data['kelurahan'] = $this->kel->getRecord($kec_kd, $kel_kd);
		
        $data['data_source']    = active_module_url() . "dph_laporan/grid?tahun=$tahun&kec_kd=$kec_kd&kel_kd=$kel_kd";
		
        //Grid Standard Parameter
        $data['iDisplayLength'] = (isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $data['iDisplayStart']  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $data['iSortingCols']   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $data['sEcho']          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $data['sSearch']        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
        
        $this->load->view('vdph_lap', $data);
    }
    
    function grid()
    {
        ob_start("ob_gzhandler");
		
        $tahun  = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';
        
        $aColumns       = array('id', 'kode_lengkap', 'nama', 'tgl_bayar', 'denda', 'denda', 'bayar', 'status_posting');
        $sIndexColumn   = "kode_lengkap";
        $iDisplayLength = 9; //(isset($_GET['iDisplayLength']) && is_numeric($_GET['iDisplayLength'])) ? $_GET['iDisplayLength'] : 15;
        $iDisplayStart  = (isset($_GET['iDisplayStart']) && is_numeric($_GET['iDisplayStart'])) ? $_GET['iDisplayStart'] : 0;
        $iSortCol_0     = (isset($_GET['iSortCol_0']) && is_numeric($_GET['iSortCol_0'])) ? $_GET['iSortCol_0'] : 0;
        $iSortingCols   = (isset($_GET['iSortingCols']) && is_numeric($_GET['iSortingCols'])) ? $_GET['iSortingCols'] : 1;
        $sSortDir_0     = (isset($_GET['sSortDir_0'])) ? $_GET['sSortDir_0'] : "asc";
        $sEcho          = (isset($_GET['sEcho']) && is_numeric($_GET['sEcho'])) ? $_GET['sEcho'] : 1;
        $sSearch        = (isset($_GET['sSearch'])) ? $_GET['sSearch'] : "";
		
		/* Limit */
        $sLimit = "";
        if (isset($iDisplayLength) && $iDisplayStart != '-1') {
            $sLimit = "LIMIT $iDisplayLength OFFSET $iDisplayStart";
        }

		/* Ordering */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . ' ' . $_GET['sSortDir_' . $i] . ", ";
                }
            }
            
            $sOrder = substr_replace($sOrder, "", -2);
            
            if ($sOrder == "ORDER BY ") {
                $sOrder = "";
            }
        }
        
		/* Filtering */
        $sWhere = "WHERE tahun = '{$tahun}' 
             AND d.kd_propinsi = '" . KD_PROPINSI . "' 
             AND d.kd_dati2 = '" . KD_DATI2 . "'";
			 
        if ($kec_kd != "000") {
            $sWhere .= " AND d.kd_kecamatan='$kec_kd'";
            if ($kel_kd != "000") $sWhere .= " AND d.kd_kelurahan='$kel_kd'";
        }
        
        $search = '';
        if ($sSearch) $search .= " AND (nama ilike '%$sSearch%' OR nama ilike '%$sSearch%')";
        
        /* Total Data */
        $sql = "SELECT  COUNT(*) c FROM dph d ";
        if ($sWhere) $sql .= " $sWhere";
		
        $row       = $this->db->query($sql)->row();
        $iTotal    = $row->c;
        $iFiltered = $iTotal;
        
        if ($search) {
            $sql_query_r = "SELECT  COUNT(*) c FROM dph d ";
            if ($sWhere) $sql_query_r .= " $sWhere";
            if ($search) $sql_query_r .= " $search";
            
            $row = $this->db->query($sql_query_r)->row();
            $iFiltered = $row->c;
        }
        
        /*
         * Output
         */
        $sql_query_r = "SELECT d.id, d.kd_propinsi, d.kd_dati2, d.kd_kecamatan, d.kd_kelurahan, d.kode, 
			(d.kd_kecamatan||'-'||d.kd_kelurahan||'-'||d.tahun||'-'||d.kode) as kode_lengkap, 
			d.nama, d.tgl_bayar, case when d.status_posting=1 then 'Sudah' else 'Belum' end as status_posting, sum(dd.denda) denda, sum(dd.jml_yg_dibayar) bayar
			FROM dph d left join dph_payment dd  on d.id=dd.dph_id ";
		$groupBy = " GROUP BY d.id, d.kd_propinsi, d.kd_dati2, d.kd_kecamatan, d.kd_kelurahan, d.kode, d.nama, d.tgl_bayar, d.status_posting ";
		
        if ($sWhere) $sql_query_r .= " $sWhere";
        if ($search) $sql_query_r .= " $search";
        $sql_query_r .= $groupBy;
        if ($sOrder) $sql_query_r .= " $sOrder";
        if ($sLimit) $sql_query_r .= " $sLimit";

		
        $qry = $this->db->query($sql_query_r);
		
        $output = array(
            "sEcho" => $sEcho,
            "iDisplayLength" => $iDisplayLength,
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFiltered,
            "SQL Query" => $sql_query_r,
            "aaData" => array()
        );
        
        foreach ($qry->result() as $aRow) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($i == 3)
                    $row[] = (strtotime($aRow->tgl_bayar)) ? (string) date('d-m-Y', strtotime($aRow->tgl_bayar)) : '';
				elseif ($i == 4 || $i == 5 || $i == 6)
                    $row[] = number_format($aRow->$aColumns[$i], 0, ',', '.');
                else 
                    $row[] = $aRow->$aColumns[$i];
            }
            $output['aaData'][] = $row;
        }
        
        echo json_encode($output);
    }
	
	function cetak(){
		$dph_id = $this->uri->segment(4); //$this->input->post('download');

		if($row = $this->dph_model->get($dph_id)) {			
			$rows = $this->dph_model->get_detail2($dph_id);
			$data['header'] = $rows['header'];
			$data['detail'] = $rows['detail'];
				
			$this->load->view('vdph_rpt_detail', $data);
			
		} else {
			echo "Tidak ada data";
		}
	}
}