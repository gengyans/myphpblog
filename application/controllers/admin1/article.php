<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Article extends MY_Controller{
		//查看文章
		public function index()
		{
		//载入分页
		$this->load->library('pagination');
		$perPage=10;//偏移量
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
		
			$this->load->model('articles_model');
			$data['article']=$this->articles_model->article_category();
		
			$this->load->view('admin1/check_article.html',$data);
		}
		//载入模板
		public function send_article()
		{
			$this->load->model('categorys_model');
			//返回栏目
			$data['category']=$this->categorys_model->check();
			//p($data);die;
			$this->load->helper('form');
			$this->load->view('admin1/article.html',$data);
		}
		//发表文章动作
		public function send()
		{
			//文件上传
			//配置
			$config['upload_path']='./uploads/';
			$config['allowed_types']='gif|jpg|png|jpeg';
			$config['max_size']='10000';
			
			$config['file_name']=time().mt_rand(1000,9999);
			
			//载入上传类
			$this->load->library('upload',$config);
			//执行上传
			$status=$this->upload->do_upload('thumb');
			if(!$status){
				error('必须上传图片');
			}
			$wrong=$this->upload->display_errors();
			if($wrong){
				error($wrong);
			}
			//返回信息
			$info=$this->upload->data();
			//p($info);die;
			//缩略图处理
			//配置
			$config['source_image'] =$info['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			//$config['width']  = 180;
			//$config['height'] = 150;
			//载入缩略图类
			$this->load->library('image_lib', $config);
			//执行动作
			$status=$this->image_lib->resize();
			//var_dump($status);
			if(!$status){
				error('缩略图动作失败');
			}

			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
			
			
			$this->load->model('categorys_model');
			//返回栏目
			$data['category']=$this->categorys_model->check();
			//载入表单验证
			$this->load->library('form_validation');
			
			//设置规则
			//执行验证
			$status=$this->form_validation->run('article');
			if($status)
			{
				//echo "数据库操作";
				$data=array(
					'title'=>$this->input->post('title'),
					'writer' => $this->input->post('writer'),
					'type' => $this->input->post('type'),
					'cid' => $this->input->post('cid'),
					'abstract' => $this->input->post('abstract'),
					'content' => $this->input->post('content'),
					'thumb' => $info['file_name'],
					'time'=> time(),
					'date' => date('H:i,jS F')
				);
				$this->load->model('articles_model');
				$this->articles_model->add($data);
				success('admin1/article/index','发表成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin1/article.html',$data);
			}
		}
		//编辑文章
		public function edit_article()
		{
				

			
			$aid=$this->uri->segment(4);//片段
			
			$this->load->model('articles_model');
			//返回栏目
			$data['article']=$this->articles_model->check_article($aid);
			//p($data);die;
			$this->load->model('categorys_model');
			//返回栏目
			$data['category']=$this->categorys_model->check();
			//p($data);die;
			$this->load->helper('form');
			$this->load->view('admin1/edit_article.html',$data,$aid);
			
		}
		//编辑动作
		public function edit()
		{
			
			
			$aid=$this->uri->segment(4);//片段
			
			$this->load->model('articles_model');
			//返回栏目
			$data['article']=$this->articles_model->check_article($aid);
			//p($data);die;
			//文件上传
			//配置
			$config['upload_path']='./uploads/';
			$config['allowed_types']='gif|jpg|png|jpeg';
			$config['max_size']='10000';
			
			$config['file_name']=time().mt_rand(1000,9999);
			
			//载入上传类
			$this->load->library('upload',$config);
			
			//执行上传
			$status=$this->upload->do_upload('thumb');
			if(!$status){
				$this->load->library('form_validation');
				//验证规则
				$status=$this->form_validation->run('article');
			
				if($status){
					//echo "数据库操作";
					$this->load->model('articles_model');
					$aid=$this->input->post('aid');
					$title=$this->input->post('title');
					$writer=$this->input->post('writer');
					$content=$this->input->post('content');
					$type=$this->input->post('type');
					$abstract=$this->input->post('abstract');
					//$thumb = $info['file_name'];
					$cid=$this->input->post('cid');
					$time=$this->input->post('time');
					$date=$this->input->post('date');
					$data=array(
						'title' => $title,
						'writer'=>$writer,
						'content' => $content,
						'type' => $type,
						'abstract' => $abstract,
						//'thumb' => $thumb,
						'cid' => $cid,
						'time'=>time(),
						'date'=>date('H:i,jS F')
					);
					//p($data);die;
				
					$data['article']=$this->articles_model->update_article($aid,$data);
					success('admin1/article/index','编辑成功');
					}else{
					$this->load->helper('form');
					$this->load->view('admin1/edit_article.html',$data,$aid);
					}
			}else{
			$wrong=$this->upload->display_errors();
			if($wrong){
				error($wrong);
			}
			//返回信息
			$info=$this->upload->data();
			//p($info);die;
			//缩略图处理
			//配置
			$config['source_image'] =$info['full_path'];
			$config['create_thumb'] = FALSE;
			$config['maintain_ratio'] = TRUE;
			//$config['width']  = 180;
			//$config['height'] = 150;
			//载入缩略图类
			$this->load->library('image_lib', $config);
			//执行动作
			$status=$this->image_lib->resize();
			//var_dump($status);
			if(!$status){
				error('缩略图动作失败');
			}
			$this->load->library('image_lib', $config);

			$this->image_lib->resize();
			$this->load->library('form_validation');
			//验证规则
			$status=$this->form_validation->run('article');
			
			if($status){
				//echo "数据库操作";
				$this->load->model('articles_model');
				$aid=$this->input->post('aid');
				$title=$this->input->post('title');
				$writer=$this->input->post('writer');
				$content=$this->input->post('content');
				$type=$this->input->post('type');
				$abstract=$this->input->post('abstract');
				$thumb = $info['file_name'];
				$cid=$this->input->post('cid');
				$time=$this->input->post('time');
				$date=$this->input->post('date');
				$data=array(
					'title' => $title,
					'writer' => $writer,
					'content' => $content,
					'type' => $type,
					'abstract' => $abstract,
					'thumb' => $thumb,
					'cid' => $cid,
					'time'=>time(),
					'date'=>date('H:i,jS F')
				);
				//p($data);die;
			
				$data['article']=$this->articles_model->update_article($aid,$data);
				success('admin1/article/index','编辑成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin1/edit_article.html',$data,$aid);
			}
			}
		}
		//删除文章
		public function delete_article()
		{
			$aid=$this->uri->segment(4);
			
			$this->load->model('articles_model');
			$data['article']=$this->articles_model->delete_article($aid);	
			success('admin1/article/index','删除成功');
			
		}
		
	}
	


















?>