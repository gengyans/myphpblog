<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//��̨�û�����ģ��
	class Admin_model extends CI_Model
	{
		//��ѯ��̨�û�����
		public function check($username)
		{
			//����$this->db->where(array('username'=>$username))->get('admin')->result_array();
			$data=$this->db->get_where('admin',array('username'=>$username))->result_array();
			return $data;
		}
	}



?>