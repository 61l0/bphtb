<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bphtb_unposted extends CI_Controller {

	private $module  = 'bphtb';
	private $current = 'bphtb';
	
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('login')) {
			$this->session->set_flashdata('msg_warning', 'Session telah kadaluarsa, silahkan login ulang.');
			redirect('login');
			exit;
		}

		$this->load->model(array('apps_model'));
        $this->load->model(array('bphtb_model'));
    }

	function load_auth() {
        $this->load->library('module_auth', array('module' => $this->module));
    }

	public function index() {
		$this->load_auth();
		if(!$this->module_auth->read) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
			redirect(active_module_url(''));
		}

		$data['current'] = $this->current;
		$data['apps']    = $this->apps_model->get_active_only();
        
		$this->load->view('vbphtb_unposted', $data);
	}
	
	function grid() {
		$i=0;
        $query = $this->bphtb_model->get_daftar_sspd();
        
        if($query) {
			foreach($query as $row) {
				$responce->aaData[$i][]=$row->id;
                $responce->aaData[$i][]='';
                $responce->aaData[$i][]=$row->nop;
				$responce->aaData[$i][]="<input type='checkbox' class='cek_sspd_id' id='sspd_id' name='sspd_id' value='{$row->id}' onClick='ceklik();'>";
				$i++;
			}
		} else {
			$responce->sEcho=1;
			$responce->iTotalRecords="0";
			$responce->iTotalDisplayRecords="0";
			$responce->aaData=array();
		}
		echo json_encode($responce);
	}

    public function load_data()
    {
		$this->load_auth();
		if(!$this->module_auth->read) {
			$this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
			redirect(active_module_url(''));
		}
        
        $sspd_id = $this->uri->segment(4);
        
        if ($sspd_id && $sspd = $this->bphtb_model->get_sspd($sspd_id)) {
            //nambahin prefix 
            foreach ($sspd as $key => $val) {
                $sspd['bphtb_'.$key] = $val;
                unset($sspd[$key]);
            }
            
            $ret = (object) array_merge($sspd, array(
                'sspd_id' => $sspd_id,
                'found' => 1,
            ));
            
            $sismiop_op_val = 0;
            $sismiop_wp_val = 0;
            if($sismiop_op = $this->bphtb_model->get_sismiop_op($sspd['bphtb_nop'])) {
                $sismiop_op_val = 1;
                $ret = (object) array_merge((array) $ret, (array) $sismiop_op);
                
                if($sismiop_wp = $this->bphtb_model->get_sismiop_wp($sismiop_op->subjek_pajak_id)) {
                    $sismiop_wp_val = 1;
                    $ret = (object) array_merge((array) $ret, (array) $sismiop_wp);
                }
            } 
            
            $ret = (object) array_merge((array) $ret, array(
                'sismiop_op' => $sismiop_op_val,
                'sismiop_wp' => $sismiop_wp_val,
            ));
            
            echo json_encode($ret);
        } else {
            $result['found'] = 0;
            echo json_encode($result);
        }
    }
    
    function update() {
        if (!$_POST) redirect(active_module_url('bphtb_unposted'));
        
        // update bphtb sspd
        $data = array (
            'wp_nama' => $_POST["wp_nama"],
            'wp_npwp' => $_POST["wp_npwp"],
            'wp_alamat' => $_POST["wp_alamat"],
            'wp_blok_kav' => $_POST["wp_blok_kav"],
            'wp_kelurahan' => $_POST["wp_kelurahan"],
            'wp_rt' => substr($_POST["wp_rt"], -3),
            'wp_rw' => substr($_POST["wp_rw"], -2),
            'wp_kecamatan' => $_POST["wp_kecamatan"],
            'wp_kota' => $_POST["wp_kota"],
            'wp_provinsi' => $_POST["wp_provinsi"],
            'op_alamat' => $_POST["op_alamat"],
            'op_blok_kav' => $_POST["op_blok_kav"],
            'op_rt' => $_POST["op_rt"],
            'op_rw' => $_POST["op_rw"],
            'bumi_luas' => $_POST["bumi_luas"],
            'bumi_njop' => $_POST["bumi_njop"],
            'bng_luas' => $_POST["bng_luas"],
            'bng_njop' => $_POST["bng_njop"],
            
            // 'posted' => 1,
        );
        //$this->bphtb_model->update_sspd($_POST["bphtb_sspd_id"], $data);
            
        // update dat_subjek_pajak
        $data = array (
            'nm_wp' => $_POST["wp_nama"],
            'npwp' => $_POST["wp_npwp"],
            'jalan_wp' => $_POST["wp_alamat"],
            'blok_kav_no_wp' => $_POST["wp_blok_kav"],
            'kelurahan_wp' => $_POST["wp_kelurahan"],
            'rt_wp' => substr($_POST["wp_rt"], -3),
            'rw_wp' => substr($_POST["wp_rw"], -2),
            'kecamatan_wp' => $_POST["wp_kecamatan"],
            'kota_wp' => $_POST["wp_kota"],
            'propinsi_wp' => $_POST["wp_provinsi"],
        );       
        //$this->bphtb_model->update_sp(trim($_POST["sp_id"]), $data);
        
        // update dat_objek_pajak
        $data = array (
            'jalan_op' => $_POST["op_alamat"],
            'blok_kav_no_op' => $_POST["op_blok_kav"],
            'rt_op' => substr($_POST["op_rt"], -3),
            'rw_op' => substr($_POST["op_rw"], -2),
            'total_luas_bumi' => $_POST["bumi_luas"],
            'njop_bumi' => $_POST["bumi_njop"],
            'total_luas_bng' => $_POST["bng_luas"],
            'njop_bng' => $_POST["bng_njop"],
        );
        //$this->bphtb_model->update_op($_POST["nop"], $data);
        
        // update dat_op_bumi
        // ...
        
        
        
		$this->session->set_flashdata('msg_success', 'Data telah diupdate');
        redirect(active_module_url('bphtb_unposted'));
    }
    
    function pecah() {
    }
    
    function gabung() {
    }
}
