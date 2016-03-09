<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class op_rpt extends CI_Controller
{
    private $module = 'pbbmop';
    
    function __construct()
    {
        parent::__construct();
        
        if (active_module() != 'pbbm') {
            show_404();
            exit;
        }
        $this->load->model(array(
            'apps_model',
            'login_model',
            'pbbm_model'
        ));
        $this->pbbm_model->set_userarea();
        $this->load->model(array(
            'kecModel',
            'kelModel'
        ));
        
    }
    
    function index()
    {
        $this->load->model('pbbm_model');      
        
        $tahun = (isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'));
		
        /* Mencari Kode NOP */
        if (isset($_POST['nop_kd'])) {
            $nop_kd = $_POST['nop_kd'];
        } else if (isset($_GET['nop_kd'])) {
            $nop_kd = $_GET['nop_kd'];
        } else {
            $nop_kd = 0;
        }
        $nama_wp = '';
        if (isset($_POST['nama_wp'])) {
            $nama_wp = $_POST['nama_wp'];
        } else if (isset($_GET['nama_wp'])) {
            $nama_wp = $_GET['nama_wp'];
        } else {
            $nama_wp = "";
        }
        
        $data['tahun']   = $tahun;
        $data['nop_kd']  = $nop_kd;
        $data['nama_wp'] = $nama_wp;
        /* Explode NOP untuk mendapatkan Kode Blok, No Urut, dan Kode Jenis Objek Pajak */
        $kec_kd          = 0;
        $kel_kd          = 0;
        $blok_kd         = 0;
        $urut_no         = 0;
        $jns_kd          = 0;
        $nop             = str_replace('.', '', $nop_kd);
        $nop             = str_replace('-', '', $nop);
        
        if ($nop_kd != 0 && strlen($nop) == 18) {
            
            $prop_kd = substr($nop, 0, 2);
            $kab_kd  = substr($nop, 2, 2);
            $kec_kd  = substr($nop, 4, 3);
            $kel_kd  = substr($nop, 7, 3);
            $blok_kd = substr($nop, 10, 3);
            $urut_no = substr($nop, 13, 4);
            $jns_kd  = substr($nop, 17, 1);
            
            /* Cek kode kecamatan */
            if (get_user_kec_kd() != '000') {
                if (get_user_kec_kd() != $kec_kd) {
                    $kec_kd = 999;
                }
            }
            
            /* Cek kode kelurahan */
            if (get_user_kel_kd() != '000') {
                if (get_user_kel_kd() != $kel_kd) {
                    $kel_kd = 999;
                }
            }
        }
        
        ## Get data ##
        $this->pbbm_model->setTahun($tahun);
        $this->pbbm_model->setKodeKecamatan($kec_kd);
        $this->pbbm_model->setKodeKelurahan($kel_kd);
        $this->pbbm_model->setKodeBlok($blok_kd);
        $this->pbbm_model->setNoUrut($urut_no);
        $this->pbbm_model->setKodeJenisOP($jns_kd);
        $data_source         = $this->pbbm_model->informasi_objek_pajak($nama_wp);
        $data['data_source'] = $data_source;
        
        $this->load->view('rpt_op', $data);        
    }
}