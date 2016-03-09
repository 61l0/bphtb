<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class real_rpt extends CI_Controller {
  private $module = 'pbbmt';

  function __construct() {
    parent::__construct();

    if(active_module()!='pbbm') { 
      show_404();
      exit;
    }
    $this->load->model(array('apps_model', 'login_model', 'pbbm_model'));
    $this->pbbm_model->set_userarea();
    $this->load->model(array('kecModel','kelModel'));
    
  }
  
  function nb(){
    $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
    $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
    $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
    $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');

    $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
    $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

    $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
    $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');
    $data['tglawal']=$tglm;
    $data['tglakhir']=$tgls;

    $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
    $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

    if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
        $kec_kd = get_user_kec_kd();

    if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
        $kel_kd = get_user_kel_kd();
    
    //die($sql_query_r);
    if ($kec_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_kec($tahun,$tglm,$tgls,$buku));
    elseif ($kel_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_kel($tahun,$tglm,$tgls,$kec_kd,$buku));
    else 
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_op($tahun,$tglm,$tgls,$kec_kd,$kel_kd,$buku));
    

    $data['detail'] = $qry->result();
    for ($i=1; $i<=5; $i++){
      for ($j=$i;$j<=5;$j++){
          $r="";
          for ($k=$i;$k<=$j;$k++) $r.="$k,";
          $r=substr($r,0,strlen($r)-1);
          if ($buku=="$i$j") $data['buku']= "$r";
        }
      }
    if ($kec_kd=='000') $kec_kd='999';  
    $data['kec_nm'] = $this->kecModel->getrecord($kec_kd);
    if ($kel_kd=='000') $kel_kd='999';
    $data['kel_nm'] = $this->kelModel->getrecord($kec_kd,$kel_kd);

    $data['tahun'] = $tahun;
    
    $this->load->view('rpt_real', $data);
  }

  function kb(){
    $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
    $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
    $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
    $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');

    $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
    $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

    $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
    $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');
    $data['tglawal']=$tglm;
    $data['tglakhir']=$tgls;

    $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
    $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

    if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
        $kec_kd = get_user_kec_kd();

    if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
        $kel_kd = get_user_kel_kd();
    
    //die($sql_query_r);
    if ($kec_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_kb_kec($tahun));
    elseif ($kel_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_kb_kel($tahun,$kec_kd));
    else 
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_kb_op($tahun,$kec_kd,$kel_kd));
    

    $data['detail'] = $qry->result();
    for ($i=1; $i<=5; $i++){
      for ($j=$i;$j<=5;$j++){
          $r="";
          for ($k=$i;$k<=$j;$k++) $r.="$k,";
          $r=substr($r,0,strlen($r)-1);
          if ($buku=="$i$j") $data['buku']= "$r";
        }
      }
    if ($kec_kd=='000') $kec_kd='999';  
    $data['kec_nm'] = $this->kecModel->getrecord($kec_kd);
    if ($kel_kd=='000') $kel_kd='999';
    $data['kel_nm'] = $this->kelModel->getrecord($kec_kd,$kel_kd);

    $data['tahun'] = $tahun;
    
    $this->load->view('rpt_real_kb', $data);
  }

  function lb(){
    $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
    $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
    $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
    $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');

    $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
    $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

    $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
    $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');
    $data['tglawal']=$tglm;
    $data['tglakhir']=$tgls;

    $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
    $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

    if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
        $kec_kd = get_user_kec_kd();

    if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
        $kel_kd = get_user_kel_kd();
    
    //die(qry_realisasi_lb_kel($tahun,$tglm,$tgls,$kec_kd,$buku));
    if ($kec_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_lb_kec($tahun));
    elseif ($kel_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_lb_kel($tahun,$kec_kd));
    else 
        $qry       = $this->db->query($this->pbbm_model->qry_realisasi_lb_op($tahun,$kec_kd,$kel_kd));
    
    //die($qry);
    $data['detail'] = $qry->result();
    for ($i=1; $i<=5; $i++){
      for ($j=$i;$j<=5;$j++){
          $r="";
          for ($k=$i;$k<=$j;$k++) $r.="$k,";
          $r=substr($r,0,strlen($r)-1);
          if ($buku=="$i$j") $data['buku']= "$r";
        }
      }
    if ($kec_kd=='000') $kec_kd='999';  
    $data['kec_nm'] = $this->kecModel->getrecord($kec_kd);
    if ($kel_kd=='000') $kel_kd='999';
    $data['kel_nm'] = $this->kelModel->getrecord($kec_kd,$kel_kd);

    $data['tahun'] = $tahun;
    
    $this->load->view('rpt_real_lb', $data);
  }  
  
  function utang(){
    $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
    $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
    $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
    $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
    $tahun2 = (isset($_GET['tahun2'])) ? $_GET['tahun2'] : date('Y');

    $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
    $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

    if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
        $kec_kd = get_user_kec_kd();

    if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
        $kel_kd = get_user_kel_kd();
    
    //die($sql_query_r);
    if ($kec_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_piutang_kec($tahun,$tahun2,$buku));
    elseif ($kel_kd=="000")
        $qry       = $this->db->query($this->pbbm_model->qry_piutang_kel($tahun,$tahun2,$buku,$kec_kd));
    else 
        $qry       = $this->db->query($this->pbbm_model->qry_piutang_op($tahun,$tahun2,$buku,$kec_kd,$kel_kd));
    

    $data['detail'] = $qry->result();
    for ($i=1; $i<=5; $i++){
      for ($j=$i;$j<=5;$j++){
          $r="";
          for ($k=$i;$k<=$j;$k++) $r.="$k,";
          $r=substr($r,0,strlen($r)-1);
          if ($buku=="$i$j") $data['buku']= "$r";
        }
      }
    if ($kec_kd=='000') $kec_kd='999';  
    $data['kec_nm'] = $this->kecModel->getrecord($kec_kd);
    if ($kel_kd=='000') $kel_kd='999';
    $data['kel_nm'] = $this->kelModel->getrecord($kec_kd,$kel_kd);

    $data['tahun'] = $tahun;
    $data['tahun2'] = $tahun2;
    
    $this->load->view('rpt_utang', $data);
  }
  
}