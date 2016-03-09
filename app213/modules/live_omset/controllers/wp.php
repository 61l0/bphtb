<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class wp extends CI_Controller
{
    private $controller;
    private $view;
    private $view_form;

    function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            echo "<script>window.location.replace('" . base_url() . "');</script>";
            exit;
        }
        
        $module = 'master';
        $this->load->library('module_auth', array(
            'module' => $module
        ));
        
        $this->load->model(array(
            'apps_model', 'wp_model'
        ));
        
        $this->controller = $this->router->fetch_class();
        $this->view      = 'v'.$this->controller;
        $this->view_form = 'v'.$this->controller.'_form';
    }
    
    public function index() 
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect();
        }
        
        $data['current'] = 'master';
        $data['apps']    = $this->apps_model->get_active_only();
		
        $this->load->view($this->view, $data);
    }
    
    function grid()
    {		
		$i=0;
        $responce = new stdClass;
		if($query = $this->wp_model->get_all()) {
			foreach($query as $row) {
				$responce->aaData[$i][]=$row->id;
				$responce->aaData[$i][]=$row->npwp;
				$responce->aaData[$i][]=$row->nama;
				$responce->aaData[$i][]=$row->kelurahan;
				$responce->aaData[$i][]=$row->kecamatan;
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
    
    private function fvalidation()
    {
        $this->form_validation->set_rules('npwp','NPWP','required|trim');
        $this->form_validation->set_rules('nama','Nama','required|trim');
        $this->form_validation->set_rules('jalan','Jalan','trim');
        $this->form_validation->set_rules('rt','RT','numeric');
        $this->form_validation->set_rules('rw','RW','numeric');
        $this->form_validation->set_rules('kelurahan','Kelurahan','trim');
        $this->form_validation->set_rules('kecamatan','Kecamatan','trim');
        $this->form_validation->set_rules('kabupaten','Kota','trim');
        $this->form_validation->set_rules('propinsi','Propinsi','trim');
        $this->form_validation->set_rules('kode_pos','Kode Pos','trim');
    }
    
    private function fpost()
    {
        $data['id'] = $this->input->post('id');
        $data['nama'] = $this->input->post('nama');
        $data['jalan'] = $this->input->post('jalan');
        $data['rt'] = $this->input->post('rt');
        $data['rw'] = $this->input->post('rw');
        $data['kelurahan'] = $this->input->post('kelurahan');
        $data['kecamatan'] = $this->input->post('kecamatan');
        $data['kabupaten'] = $this->input->post('kabupaten');
        $data['propinsi'] = $this->input->post('propinsi');
        $data['kode_pos'] = $this->input->post('kode_pos');
        $data['npwp'] = $this->input->post('npwp');
        
        return $data;
    }
    
    public function add()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_create);
            redirect(active_module_url($this->controller));
        }
        
        $post_data  = $this->fpost();
        
        $data['current'] = 'master';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url($this->controller.'/add');
        
        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post = $post_data;
            $update_data = array(
                'nama' => empty($input_post['nama']) ? NULL : $input_post['nama'],
                'jalan' => empty($input_post['jalan']) ? NULL : $input_post['jalan'],
                'rt' => empty($input_post['rt']) ? NULL : $input_post['rt'],
                'rw' => empty($input_post['rw']) ? NULL : $input_post['rw'],
                'kelurahan' => empty($input_post['kelurahan']) ? NULL : $input_post['kelurahan'],
                'kecamatan' => empty($input_post['kecamatan']) ? NULL : $input_post['kecamatan'],
                'kabupaten' => empty($input_post['kabupaten']) ? NULL : $input_post['kabupaten'],
                'propinsi' => empty($input_post['propinsi']) ? NULL : $input_post['propinsi'],
                'kode_pos' => empty($input_post['kode_pos']) ? NULL : $input_post['kode_pos'],
                'npwp' => empty($input_post['npwp']) ? NULL : $input_post['npwp'],
            );
            
			if($new_id = $this->wp_model->save($update_data)) {
				$this->session->set_flashdata('msg_success', 'Data telah disimpan, silahkan lengkapi data Objek Pajak.');
				//redirect(active_module_url($this->controller));
				redirect(active_module_url($this->controller.'/edit/'.$new_id));
			}
        }
        
        $data['dt']      = $post_data;
        $this->load->view($this->view_form, $data);
    }
    
    public function edit()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url($this->controller));
        }
        
        $p_id = $this->uri->segment(4);
        
        $data['current'] = 'master';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url($this->controller."/update/{$p_id}");
        
        if ($p_id && $get = $this->wp_model->get($p_id)) {
            $data['dt']['id'] = empty($get->id) ? NULL : $get->id;
            $data['dt']['nama'] = empty($get->nama) ? NULL : $get->nama;
            $data['dt']['jalan'] = empty($get->jalan) ? NULL : $get->jalan;
            $data['dt']['rt'] = empty($get->rt) ? NULL : $get->rt;
            $data['dt']['rw'] = empty($get->rw) ? NULL : $get->rw;
            $data['dt']['kelurahan'] = empty($get->kelurahan) ? NULL : $get->kelurahan;
            $data['dt']['kecamatan'] = empty($get->kecamatan) ? NULL : $get->kecamatan;
            $data['dt']['kabupaten'] = empty($get->kabupaten) ? NULL : $get->kabupaten;
            $data['dt']['propinsi'] = empty($get->propinsi) ? NULL : $get->propinsi;
            $data['dt']['kode_pos'] = empty($get->kode_pos) ? NULL : $get->kode_pos;
            $data['dt']['npwp'] = empty($get->npwp) ? NULL : $get->npwp;
			
            // op
            $data['dt']['op_wp_id'] = "";
            $data['dt']['op_id'] = "";
            $data['dt']['op_nama'] = "";
            $data['dt']['op_jalan'] = "";
            $data['dt']['op_rt'] = "";
            $data['dt']['op_rw'] = "";
            $data['dt']['op_kelurahan'] = "";
            $data['dt']['op_kecamatan'] = "";
            $data['dt']['op_kabupaten'] = "";
            $data['dt']['op_propinsi'] = "";
            $data['dt']['op_kode_pos'] = "";
            
            // op item
            $data['dt']['op_item_id'] = "";
            $data['dt']['op_item_op_id'] = "";
            $data['dt']['op_item_nama'] = "";
            
			$this->load->view($this->view_form, $data);
        } else {
            show_404();
        }
    }
    
    public function update()
    {
        if (!$this->module_auth->update) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_update);
            redirect(active_module_url($this->controller));
        }
        
        $p_id      = $this->uri->segment(4);
        $post_data = $this->fpost();
        
        $data['current'] = 'master';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url($this->controller."/update/{$p_id}");
        
        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post  = $post_data;
            $update_data = array(
                'nama' => empty($input_post['nama']) ? NULL : $input_post['nama'],
                'jalan' => empty($input_post['jalan']) ? NULL : $input_post['jalan'],
                'rt' => empty($input_post['rt']) ? NULL : $input_post['rt'],
                'rw' => empty($input_post['rw']) ? NULL : $input_post['rw'],
                'kelurahan' => empty($input_post['kelurahan']) ? NULL : $input_post['kelurahan'],
                'kecamatan' => empty($input_post['kecamatan']) ? NULL : $input_post['kecamatan'],
                'kabupaten' => empty($input_post['kabupaten']) ? NULL : $input_post['kabupaten'],
                'propinsi' => empty($input_post['propinsi']) ? NULL : $input_post['propinsi'],
                'kode_pos' => empty($input_post['kode_pos']) ? NULL : $input_post['kode_pos'],
                'npwp' => empty($input_post['npwp']) ? NULL : $input_post['npwp'],
            );
            
            $this->wp_model->update($p_id, $update_data);
            
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url($this->controller));
        }
        
        $data['dt'] = $post_data;		
		$this->load->view($this->view_form, $data);
    }
    
    public function delete()
    {
        if (!$this->module_auth->delete) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_delete);
            redirect(active_module_url($this->controller));
        }
        
        $id = $this->uri->segment(4);
        if ($id && $this->wp_model->get($id)) {
            $this->wp_model->delete($id);
            $this->session->set_flashdata('msg_success', 'Data telah dihapus');
            redirect(active_module_url($this->controller));
        } else {
            show_404();
        }
    }
    
    
    
    
    /* OP */
	function grid_objek_pajak() {
        $wp_id = $this->uri->segment(4);
		
		$i=0;
        $responce = new stdClass;
		if($query = $this->wp_model->get_all_op($wp_id)) {
			foreach($query as $row) {
				$responce->aaData[$i][]=$row->id;
				$responce->aaData[$i][]=$row->nama;
				$responce->aaData[$i][]=$row->kelurahan;
				$responce->aaData[$i][]=$row->kecamatan;
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
    
    function get_op() {
        $op_id    = $this->uri->segment(4);
        $op_data = $this->load->model('op_model')->get($op_id);
		
        echo json_encode($op_data);
    }
	
    function new_op() {
        /* new_op */
    }
	
	function proces_op() {
        $mode = $this->uri->segment(4);					
		$op_id = $this->input->get_post('op_id');
		
		$update_data = array(
            'wp_id' => $this->input->get_post('op_wp_id'),
            'nama' => $this->input->get_post('op_nama'),
            'jalan' => $this->input->get_post('op_jalan'),
            'rt' => $this->input->get_post('op_rt'),
            'rw' => $this->input->get_post('op_rw'),
            'kelurahan' => $this->input->get_post('op_kelurahan'),
            'kecamatan' => $this->input->get_post('op_kecamatan'),
            'kabupaten' => $this->input->get_post('op_kabupaten'),
            'propinsi' => $this->input->get_post('op_propinsi'),
            'kode_pos' => $this->input->get_post('op_kode_pos'),
		);
		
		$op_model = $this->load->model('op_model');
		if ($mode == 'add') {
			$op_model->save($update_data);
		} elseif ($mode == 'edit') {
			$op_model->update($op_id, $update_data);
		}	
	}
	
    public function delete_op() {
        if (!$this->module_auth->delete) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_delete);
            redirect(active_module_url($this->controller));
        }
        
        $id = $this->uri->segment(4);
        $model = $this->load->model('op_model');
        if ($id && $model->get($id)) {
            $model->delete($id);
			echo "sip";
        } else {
            show_404();
        }
    }
    
    
    /* OP Item */
	function grid_op_item() {
        $wp_id = $this->uri->segment(4);
		
		$i=0;
        $responce = new stdClass;
		if($query = $this->wp_model->get_all_op_item($wp_id)) {
			foreach($query as $row) {
				$responce->aaData[$i][]=$row->id;
				$responce->aaData[$i][]=$row->op_nama;
				$responce->aaData[$i][]=$row->nama;
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
    
    function get_op_item() {
        $op_item_id   = $this->uri->segment(4);
        $wp_id        = $this->uri->segment(5);
        $op_item_data = $this->load->model('op_item_model')->get($op_item_id);
		
        $select_data  = $this->wp_model->get_all_op($wp_id);
        $op = '';
        foreach ($select_data as $row) {
			if ($row->id == $op_item_data->op_id)
				$op .= "<option value={$row->id} selected >{$row->nama}</option>";
			else
				$op .= "<option value={$row->id}>{$row->nama}</option>";
        }
		$op_item_data->op = $op;
		
        echo json_encode($op_item_data);
    }
	
    function new_op_item() {
        $wp_id       = $this->uri->segment(4);
        $select_data = $this->wp_model->get_all_op($wp_id);
        $op = '';
        foreach ($select_data as $row) {
			$op .= "<option value={$row->id}>{$row->nama}</option>";
        }
		$op_item_data->op = $op;
		
        echo json_encode($op_item_data);
    }
	
	function proces_op_item() {
        $mode = $this->uri->segment(4);					
		$op_item_id = $this->input->get_post('op_item_id');
		
		$update_data = array(
			'op_id' => $this->input->get_post('op_item_op_id'),
			'nama' => $this->input->get_post('op_item_nama'),
		);
		
		$op_item_model = $this->load->model('op_item_model');
		if ($mode == 'add') {
			$op_item_model->save($update_data);
		} elseif ($mode == 'edit') {
			$op_item_model->update($op_item_id, $update_data);
		}	
	}
	
    public function delete_op_item() {
        if (!$this->module_auth->delete) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_delete);
            redirect(active_module_url('subjek_pajak'));
        }
        
        $id = $this->uri->segment(4);
        $model = $this->load->model('op_item_model');
        if ($id && $model->get($id)) {
            $model->delete($id);
			echo "sip";
        } else {
            show_404();
        }
    }
}