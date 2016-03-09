<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agent extends CI_Controller
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
        
        $module = 'im';
        $this->load->library('module_auth', array(
            'module' => $module
        ));
        
        $this->load->model(array(
            'apps_model', 'agent_model'
        ));
        
        $this->controller = $this->router->fetch_class();
        $this->view       = 'v'.$this->controller;
        $this->view_form  = 'v'.$this->controller.'_form';
    }
    
    public function index() 
    {
        if (!$this->module_auth->read) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_read);
            redirect();
        }
        
        $data['current'] = 'im';
        $data['apps']    = $this->apps_model->get_active_only();
		
        $this->load->view($this->view, $data);
    }
    
    function grid()
    {		
		$i=0;
        $responce = new stdClass;
		if($query = $this->agent_model->get_all()) {
			foreach($query as $row) {
				$responce->aaData[$i][]=$row->id;
				$responce->aaData[$i][]=$row->jalur;
				$responce->aaData[$i][]=$row->status;
				$responce->aaData[$i][]=$row->job;
				$responce->aaData[$i][]=$row->lastjob;
				$responce->aaData[$i][]=$row->startup;
				$responce->aaData[$i][]=$row->ket;
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
        $this->form_validation->set_rules('id','ID Agent','required');
        $this->form_validation->set_rules('jalur','Jalur','required|numeric');
        $this->form_validation->set_rules('status','Status','numeric');
        $this->form_validation->set_rules('job','Job','numeric');
    }
    
    private function fpost()
    {
        $data['id'] = $this->input->post('id');
        $data['jalur'] = $this->input->post('jalur');
        $data['status'] = $this->input->post('status');
        $data['job'] = $this->input->post('job');
        $data['lastjob'] = $this->input->post('lastjob');
        $data['startup'] = $this->input->post('startup');
        $data['ket'] = $this->input->post('ket');
        $data['lasterr'] = $this->input->post('lasterr');
        $data['url'] = $this->input->post('url');
		
        return $data;
    }
    
    public function add()
    {
        if (!$this->module_auth->create) {
            $this->session->set_flashdata('msg_warning', $this->module_auth->msg_create);
            redirect(active_module_url($this->controller));
        }
        
        $post_data  = $this->fpost();
        
        $data['current'] = 'im';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url($this->controller.'/add');
        
        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post = $post_data;
            $update_data = array(
                'id' => $input_post['id'],
                'jalur' => empty($input_post['jalur']) ? 7 : $input_post['jalur'],
                'status' => empty($input_post['status']) ? 0 : 1,
                'job' => empty($input_post['job']) ? 0 : $input_post['job'],
                'lastjob' => empty($input_post['lastjob']) ? NULL : date('Y-m-d h:m:s', strtotime($input_post['lastjob'])),
                'startup' => empty($input_post['startup']) ? NULL : date('Y-m-d h:m:s', strtotime($input_post['startup'])),
                'ket' => empty($input_post['ket']) ? NULL : $input_post['ket'],
                'lasterr' => empty($input_post['lasterr']) ? NULL : $input_post['lasterr'],
                'url' => empty($input_post['url']) ? NULL : $input_post['url'],
            );
            $this->agent_model->save($update_data);
            
            $this->session->set_flashdata('msg_success', 'Data telah disimpan');
            redirect(active_module_url($this->controller));
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
        
        $data['current'] = 'im';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url($this->controller."/update/{$p_id}");
        
        if ($p_id && $get = $this->agent_model->get($p_id)) {
            $data['dt']['id'] = empty($get->id) ? NULL : $get->id;
            $data['dt']['jalur'] = empty($get->jalur) ? NULL : $get->jalur;
            $data['dt']['status'] = empty($get->status) ? 0 : $get->status;
            $data['dt']['job'] = empty($get->job) ? 0 : $get->job;
            $data['dt']['lastjob'] = empty($get->lastjob) ? NULL : date('d-m-Y', strtotime($get->lastjob));
            $data['dt']['startup'] = empty($get->startup) ? NULL : date('d-m-Y', strtotime($get->startup));
            $data['dt']['ket'] = empty($get->ket) ? NULL : $get->ket;
            $data['dt']['lasterr'] = empty($get->lasterr) ? NULL : $get->lasterr;
            $data['dt']['url'] = empty($get->url) ? NULL : $get->url;
			
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
        
        $data['current'] = 'im';
        $data['apps']    = $this->apps_model->get_active_only();
        $data['faction'] = active_module_url($this->controller."/update/{$p_id}");
        
        $this->fvalidation();
        if ($this->form_validation->run() == TRUE) {
            $input_post  = $post_data;
            $update_data = array(
                'id' => empty($input_post['id']) ? NULL : $input_post['id'],
                'jalur' => empty($input_post['jalur']) ? 7 : $input_post['jalur'],
                'status' => empty($input_post['status']) ? 0 : $input_post['status'],
                'job' => empty($input_post['job']) ? 0 : $input_post['job'],
                'lastjob' => empty($input_post['lastjob']) ? NULL : date('Y-m-d h:m:s', strtotime($input_post['lastjob'])),
                'startup' => empty($input_post['startup']) ? NULL : date('Y-m-d h:m:s', strtotime($input_post['startup'])),
                'ket' => empty($input_post['ket']) ? NULL : $input_post['ket'],
                'lasterr' => empty($input_post['lasterr']) ? NULL : $input_post['lasterr'],
                'url' => empty($input_post['url']) ? NULL : $input_post['url'],
            );
            
            $this->agent_model->update($p_id, $update_data);
            
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
        if ($id && $this->agent_model->get($id)) {
            $this->agent_model->delete($id);
            $this->session->set_flashdata('msg_success', 'Data telah dihapus');
            redirect(active_module_url($this->controller));
        } else {
            show_404();
        }
    }
}