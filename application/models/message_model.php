<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
	*留言管理模型
	*/	
	class Message_model extends CI_Model
	{
		/**
		* 发表留言
		*/	
		public function add($data)
		{
			$this->db->insert('message',$data);
		}
		/**
		* 查看留言
		*/
		public function check_message($limit,$aid)
		{
			$data=$this->db->limit($limit)->select()->from('message')->where(array('aid'=>$aid))->
			order_by('sid','desc')->get()->result_array();
			return ($data);
		}
		/**
		* 查看留言
		*/	
		public function checks_message()
		{
			$data=$this->db->order_by('sid','desc')->get('message')->result_array();
			return $data;
		}
		/**
		* 删除留言
		*/	
		public function delete_message($sid)
		{
			$this->db->delete('message',array('sid'=>$sid));
		}
		
	}
?>