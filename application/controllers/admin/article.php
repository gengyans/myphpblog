<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Article extends CI_Controller{
	/**
	* 查看文章
	*/
	public function index()
	{
		//载入分页
		$this->load->library('pagination');
		$perPage=3;//偏移量
		//配置项设置
		$config['base_url']=site_url('admin1/article/index');
		$config['total_rows']=$this->db->count_all_results('article');
		$config['per_page']=$perPage;
		$config['uri_segment']=4;//手动设置片段
		$config['first_link']='第一页';
		$config['prev_link']='上一页';
		$config['next_link']='下一页';
		$config['last_link']='最后一页';
	
		
		$this->pagination->initialize($config);
		
		$data['links']=$this->pagination->create_links();
		//p($data);die;
		$offset=$this->uri->segment(4);
		$this->db->limit($perPage,$offset);
		
		
		$this->load->model('article_model');
		$data['arcticle']=$this->article_model->article_category();
		
		$this->load->view('admin/check_article.html',$data);
	}
	/**
	*发表模板显示
	*/
	public function send_article()
	{
		$this->load->model('category_model');
		//返回栏目
		$data['category']=$this->category_model->check();
		
		$this->load->helper('form');
		//执行上传
		$this->load->view('admin/article.html',$data);
		
	}
	/**
	*发表文章动作
	*/
	public function send()
	{
		/*//文件上传
		//配置
		

			$config['upload_path']='./uploads/';
			$config['allowed_types']='gif|jpg|png|jpeg';
			$config['max_size']='10000';
			$config['file_name']=time() . mt_rand(1000,9999);
			//载入上传类
			$this->load->library('upload',$config);
			//执行上传
			$status=$this->upload->do_upload('thumb');
			
			
			
		if(!$status)
		{
			error('必须上传图片');
		}
		$wrong=$this->upload->display_errors();
		
		if($wrong)
		{
			error($wrong);
		}
		//返回信息
		$info=$this->upload->data();
		//缩略图
		$config['source_image'] = '/path/to/image/mypic.jpg';
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = TRUE;
		$config['width']     = 75;
		$config['height']   = 50;

		$this->load->library('image_lib', $config);

		$this->image_lib->resize();*/
		
		//载入表单验证
		$this->load->library('form_validation');
		//设置规则
		$this->form_validation->set_rules('title','文章标题','required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('genre','类型','required|integer');
		$this->form_validation->set_rules('cid','栏目','integer');
		$this->form_validation->set_rules('abstract','摘要','required|min_length[5]|max_length[500]');
		$this->form_validation->set_rules('contend','内容','required|min_length[5]|max_length[5000]');
		
		//执行验证
		$status=$this->form_validation->run();
		if($status)
		{
			//echo '数据库操作';
			$this->load->model('article_model');
			
				$data=array(
					'title' => $this->input->post('title'),
					'genre' => $this->input->post('genre'),
					'cid' => $this->input->post('cid'),
					'thumb' => $this->input->post('title'),
					'abstract' => $this->input->post('abstract'),
					'contend' => $this->input->post('contend'),
					'time'=>time()
				);
			$this->article_model->add($data);
			success('admin/article/index','发表成功');
		}else{
			$this->load->helper('form');
			$this->load->view('admin/article.html');
		}
		
	}

	/**
	*编辑文章
	**/
	public function edit_article()
	{
		$cid=$this->uri->segment(4);
		
		$this->load->model('articles_model');
		$data['arcticle']=$this->category_model->index($cid);
		
		$this->load->helper('form');
		$this->load->view('admin/edit_article.html');
	}
	/**
	*编辑动作
	**/
	public function edit()
	{
		$this->load->library('form_validation');
		//设置规则
		$this->form_validation->set_rules('title','文章标题','required|min_length[5]|max_length[12]');
		$this->form_validation->set_rules('genre','类型','required|integer');
		$this->form_validation->set_rules('cid','栏目','integer');
		$this->form_validation->set_rules('abstract','摘要','required|min_length[50]|max_length[500]');
		$this->form_validation->set_rules('contend','内容','required|min_length[500]|max_length[5000]');
		
		$status=$this->form_validation->run('article');
		
		if($status)
		{
			//echo '数据库操作';
			$this->load->model('articles_model');
				$data=array(
					'cid'=>$this->input->post('cid'),
					'title'=>$this->input->post('title'),
					'type' => $this->input->post('type'),
					'cid' => $this->input->post('cid'),
					'thumb' => $this->input->post('thumb'),
					'abstract' => $this->input->post('abstract'),
					'content' => $this->input->post('content'),
					'time'=>time()
				);
				$data['arcticle']=$this->articles_model->update_cate($data);
				success('admin/category/index','编辑成功');
		}else{
			$this->load->helper('form');
			$this->load->view('admin/edit_article.html');
		}
	}
}


















?>