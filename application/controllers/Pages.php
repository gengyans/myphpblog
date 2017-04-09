<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
		class Pages extends CI_Controller{
			public function view($page='home')
			{
				if(!file_exists(APPPATH.'views/pages/'.$page.'.php'))
				{
					//Whoops,we don't have a page for that!
					show_404();
					
				}
				$date['title']=ucfirst($page);
				
				$this->load->view('templates/header',$date);
				$this->load->view('pages/'.$page,$date);
				$this->load->view('templates/footer',$date);
			
			}	
		
		}
?>