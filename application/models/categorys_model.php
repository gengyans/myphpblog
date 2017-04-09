<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class Categorys_model extends CI_Model
	{
		//添加栏目
		public function add($data)
		{
			$this->db->insert('acticle',$data);
		}
		//查看栏目
		public function check()
		{
			$data=$this->db->get('category')->result_array();
			return $data;
		}
		/**
		* 查询相对应的栏目
		*/
		public function check_cate($cid)
		{
			$data=$this->db->where(array('cid'=>$cid))->get('category')->result_array();
			return $data;
		}
		//修改栏目
		public function update_cate($cid,$data)
		{
			$this->db->update('category',$data,array('cid'=>$cid));
		}
		//删除栏目
		public function delete_cate($cid)
		{
			$this->db->delete('category',array('cid'=>$cid));
		}
		//选择导航栏
		public function limit_category($limit)
		{
			$data=$this->db->limit($limit)->get('category')->result_array();
			return $data;
		}
		
	}
?>