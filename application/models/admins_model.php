<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//后台用户管理模型
	class Admins_model extends CI_Model
	{
		//查询后台用户数据
		public function check($username)
		{
			//或者$this->db->where(array('username'=>$username))->get('admin')->result_array();
			$data=$this->db->get_where('admin',array('username'=>$username))->result_array();
			return $data;
		}
		//修改密码
		public function change($uid,$data)
		{
			$this->db->update('admin',$data,array('uid'=>$uid));
		}
	}



?>