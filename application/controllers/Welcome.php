<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Welcome extends CI_Controller
	{

		public function index()
		{	
			//$this->output->enable_profiler(TRUE);
			$this->load->library('calendar');
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->limit_category(5);
			//p($data);die;
			
			$this->load->model('articles_model');
			$data['article']=$this->articles_model->checks_article(4,1);
			//p($data);die;
			
			$data['title']=$this->articles_model->title(10);
			$this->load->view('index1/blog.html',$data);
		}
		public function category()
		{
			$this->load->library('calendar');
			$cid=$this->uri->segment(3);
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->limit_category(5);
			$data['cname']=$this->categorys_model->check_cate($cid);
			
			$this->load->model('articles_model');
			$data['article']=$this->articles_model->category_article($cid);
			$data['title']=$this->articles_model->title(10);
			$this->load->view('index1/category.html',$data);
		}
		public function article()
		{
			$this->load->library('calendar');
			$aid=$this->uri->segment(3);
			$this->load->model('articles_model');
			$data['article']=$this->articles_model->aid_article($aid);
			//p($data);
			$cid=$this->uri->segment(3);
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->limit_category(5);
			$data['cname']=$this->categorys_model->check_cate($cid);
	
			$this->load->model('message_model');
			$data['message']=$this->message_model->check_message(2,$aid);
			//分页码
			$this->load->library('pagination');
			$perPage=2;//偏移量
			//配置项设置
			$config['base_url']=site_url('welcome/article/'.$aid);
			$config['total_rows']=$this->db->select()->from('message')->where(array('aid'=>$aid))->
									order_by('sid','desc')->count_all_results();
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
			
			$data['title']=$this->articles_model->title(10);
			
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			//设置规则
			$this->form_validation->set_rules('say','留言内容','required|min_length[1]|max_length[1000]');
			$this->form_validation->set_rules('username','用户名','required|min_length[1]|max_length[20]');
			//执行验证
			$status=$this->form_validation->run();
			if($status)
			{
				//echo "数据库操作";
				$data=array(
					'say'=>$this->input->post('say'),
					'username' => $this->input->post('username'),
					'aid' => $this->input->post('aid'),
					'sid' => $this->input->post('sid'),
					'date'=>date('H:i,jS F')
				);
			
				$this->load->model('message_model');
				$this->message_model->add($data);
				success('welcome/article/'.$aid,'发表成功');
			}else{
				$this->load->helper('form');
				$this->load->view('index1/article.html',$data);
				}
		}
		public function message()
		{
			$this->load->model('categorys_model');
			$data['category']=$this->categorys_model->limit_category(5);
			//查看评论
			$this->load->model('message_model');
			$data['message']=$this->message_model->check_message(6,0);
			//分页码
			$this->load->library('pagination');
			$perPage=6;//偏移量
			//配置项设置
			$config['base_url']=site_url('welcome/message');
			$config['total_rows']=$this->db->select()->from('message')->where(array('aid'=>0))->
									order_by('sid','desc')->count_all_results();
			$config['per_page']=$perPage;
			$config['uri_segment']=3;//手动设置片段
			$config['first_link']='第一页';
			$config['prev_link']='上一页';
			$config['next_link']='下一页';
			$config['last_link']='最后一页';
	
		
			$this->pagination->initialize($config);
			
			$data['links']=$this->pagination->create_links();
			//p($data);die;
			$offset=$this->uri->segment(3);
			$this->db->limit($perPage,$offset);
			//p($data);die;
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			//设置规则
			$this->form_validation->set_rules('say','留言内容','required|min_length[1]|max_length[1000]');
			$this->form_validation->set_rules('username','用户名','required|min_length[1]|max_length[20]');
			//执行验证
			$status=$this->form_validation->run();
			if($status)
			{
				//echo "数据库操作";
				$data=array(
					'say'=>$this->input->post('say'),
					'username' => $this->input->post('username'),
					'aid' => $this->input->post('aid'),
					'sid' => $this->input->post('sid'),
					'date'=>date('H:i,jS F')
				);
			
				$this->load->model('message_model');
				$this->message_model->add($data);
				success('welcome/message','发表成功');
			}else{
				$this->load->helper('form');
				$this->load->view('index1/message.html',$data);
				}
			
			
		}
		
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	?>