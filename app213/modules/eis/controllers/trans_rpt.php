<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class trans_rpt extends CI_Controller {
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
  
  function bulan(){
        $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        $tahun = (isset($_GET['tahun'])) ? $_GET['tahun'] : date('Y');
        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');

        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();

        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kel_kd = get_user_kel_kd();
        
        $path_to_root = active_module_url();

        $where = "WHERE extract(year FROM p.tgl_pembayaran_sppt)= $tahun 
             AND p.kd_propinsi='" . KD_PROPINSI . "' 
             AND p.kd_dati2='" . KD_DATI2 . "'
             AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax 
             AND p.thn_pajak_sppt between '$tahun_sppt1' AND '$tahun_sppt2' ";
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
       
        $sql_query_r = "
      SELECT  Extract(month FROM tgl_pembayaran_sppt) kode,
          tp.kd_kanwil||tp.kd_kantor||tp.kd_tp||':'||tp.nm_tp uraian, sum(k.pbb_yg_harus_dibayar_sppt)  pokok, 
          sum(p.denda_sppt) denda, sum(p.jml_sppt_yg_dibayar) bayar
          FROM sppt k 
          INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
          LEFT JOIN tempat_pembayaran tp ON p.kd_kanwil=tp.kd_kanwil and p.kd_kantor=tp.kd_kantor AND p.kd_tp=tp.kd_tp
          $where 
          GROUP BY 1,2 ";
        $sql_query_r .= "ORDER BY kode";
        //die($sql_query_r);
        $qry       = $this->db->query($sql_query_r);
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
        $data['tahun_sppt1'] = $tahun_sppt1;
        $data['tahun_sppt2'] = $tahun_sppt2;
        
        $this->load->view('rpt_trans_bulan', $data);
  }
  function trans1(){
        $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
        $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');
        $data['tglawal']=$tglm;
        $data['tglakhir']=$tgls;

        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');

        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();

        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kel_kd = get_user_kel_kd();
        
        

        $path_to_root = active_module_url();

        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN '$tglm' AND '$tgls'
             AND k.kd_propinsi='" . KD_PROPINSI . "' 
             AND k.kd_dati2='" . KD_DATI2 . "' 
             AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
             AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";
        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
       
        $sql_query_r = "
       SELECT  
            k.kd_propinsi||'.'||k.kd_dati2||'-'||k.kd_kecamatan||'.'||k.kd_kelurahan ||'-'|| k.kd_blok ||'.'||k.no_urut||'.'|| k.kd_jns_op ||' '|| k.thn_pajak_sppt kode, 
            k.nm_wp_sppt uraian, 
            k.pbb_yg_harus_dibayar_sppt pokok, p.denda_sppt denda, p.jml_sppt_yg_dibayar bayar, p.tgl_pembayaran_sppt tanggal
          FROM sppt k 
          INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
          $where   ";
        $sql_query_r .= "ORDER BY kode";
        //die($sql_query_r);
        $qry       = $this->db->query($sql_query_r);
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
        $data['tahun_sppt1'] = $tahun_sppt1;
        $data['tahun_sppt2'] = $tahun_sppt2;
        
        $this->load->view('rpt_trans_1', $data);

  }    
  
  function trans2(){
        $buku    = (isset($_GET['buku'])) ? $_GET['buku'] : '11';
        $bukumin = $this->pbbm_model->rangebuku[substr($buku, 0, 1)][0];
        $bukumax = $this->pbbm_model->rangebuku[substr($buku, 1, 1)][1];
        $tglm = (isset($_GET['tglawal'])) ? $_GET['tglawal'] : date('d-m-Y');
        $tgls = (isset($_GET['tglakhir'])) ? $_GET['tglakhir'] : date('d-m-Y');
        $data['tglawal']=$tglm;
        $data['tglakhir']=$tgls;

        $tglm = substr($tglm, 6, 4) . '-' . substr($tglm, 3, 2) . '-' . substr($tglm, 0, 2);
        $tgls = substr($tgls, 6, 4) . '-' . substr($tgls, 3, 2) . '-' . substr($tgls, 0, 2);

        $tahun_sppt1 = (isset($_GET['tahun_sppt1'])) ? $_GET['tahun_sppt1'] : date('Y');
        $tahun_sppt2 = (isset($_GET['tahun_sppt2'])) ? $_GET['tahun_sppt2'] : date('Y');

        $kec_kd = (isset($_GET['kec_kd']) && is_numeric($_GET['kec_kd'])) ? $_GET['kec_kd'] : '000';
        $kel_kd = (isset($_GET['kel_kd']) && is_numeric($_GET['kel_kd'])) ? $_GET['kel_kd'] : '000';

        if (get_user_kec_kd() != '000' && get_user_kec_kd() != $kec_kd)
            $kec_kd = get_user_kec_kd();

        if (get_user_kel_kd() != '000' && get_user_kel_kd() != $kel_kd)
            $kel_kd = get_user_kel_kd();
        
        

        $path_to_root = active_module_url();

        $where = "WHERE p.tgl_pembayaran_sppt BETWEEN '$tglm' AND '$tgls'
             AND p.kd_propinsi='" . KD_PROPINSI . "' 
             AND p.kd_dati2='" . KD_DATI2 . "' 
             AND p.thn_pajak_sppt BETWEEN '$tahun_sppt1' AND '$tahun_sppt2'
             AND k.pbb_yg_harus_dibayar_sppt between $bukumin AND $bukumax ";

        if ($kec_kd != "000")
            $where .= " AND p.kd_kecamatan='$kec_kd'";
        if ($kel_kd != "000")
            $where .= " AND p.kd_kelurahan='$kel_kd'";
       
        $sql_query_r = "
      SELECT  tgl_pembayaran_sppt kode,tp.kd_kanwil||tp.kd_kantor||tp.kd_tp||':'||tp.nm_tp uraian, 
              sum(k.pbb_yg_harus_dibayar_sppt)  pokok, sum(p.denda_sppt) denda, 
              sum(p.jml_sppt_yg_dibayar) bayar
          FROM sppt k 
          INNER JOIN pembayaran_sppt p 
            ON k.kd_propinsi = p.kd_propinsi
            AND k.kd_dati2 = p.kd_dati2 
            AND k.kd_kecamatan = p.kd_kecamatan 
            AND k.kd_kelurahan = p.kd_kelurahan 
            AND k.kd_blok = p.kd_blok 
            AND k.no_urut = p.no_urut 
            AND k.kd_jns_op = p.kd_jns_op 
            AND k.thn_pajak_sppt = p.thn_pajak_sppt 
          LEFT JOIN tempat_pembayaran tp ON p.kd_kanwil=tp.kd_kanwil and p.kd_kantor=tp.kd_kantor AND p.kd_tp=tp.kd_tp
          $where 
          GROUP BY 1,2  ";
        $sql_query_r .= "ORDER BY kode";
        //die($sql_query_r);
        $qry       = $this->db->query($sql_query_r);
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
        $data['tahun_sppt1'] = $tahun_sppt1;
        $data['tahun_sppt2'] = $tahun_sppt2;
        
        $this->load->view('rpt_trans_2', $data);

  }    

}