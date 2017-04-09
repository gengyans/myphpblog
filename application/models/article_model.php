<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	*文章管理模型
	*/	
	class Article_model extends CI_Model{
		/**
		* 发表文章
		*/	
		public function add($data)
		{
			$this->db->insert('arcticle',$data);
		}
		public function article_category()
		{
			$data=$this->db->select('aid,title,cname,time')->from('article')
			->join('category','article.cid=category.cid')->
			order_by('aid','asc')->get()->result_array();
			return ($data);
		}
	}
?>