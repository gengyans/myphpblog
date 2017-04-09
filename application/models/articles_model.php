<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	*文章管理模型
	*/	
	class Articles_model extends CI_Model
	{
		/**
		* 发表文章
		*/	
		public function add($data)
		{
			$this->db->insert('article',$data);
		}
		//查看文章
		public function article_category()
		{
			$data=$this->db->select('aid,title,cname,time,date')->from('article')
			->join('category','article.cid=category.cid')->
			order_by('aid','asc')->get()->result_array();
			return ($data);
		}
		/**
		* 查询相对应的文章
		*/
		public function check_article($aid)
		{	
			$data=$this->db->select()->from('article')->where(array('aid'=>$aid))
			->join('category','article.cid=category.cid')->
			order_by('aid','asc')->get()->result_array();
			return ($data);
		}
		/**
		* 修改文章
		*/
		public function update_article($aid,$data)
		{
			$this->db->update('article',$data,array('aid'=>$aid));
			
		}
		/**
		* 删除文章
		*/
		public function delete_article($aid)
		{
			$this->db->delete('article',array('aid'=>$aid));
		}
		/**
		* 查询相对应的文章
		*/
		public function checks_article($limit,$type)
		{	
			$data=$this->db->limit($limit)->select('aid,title,abstract,date,cname,thumb,writer')->from('article')->where(array('type'=>$type))
			->join('category','article.cid=category.cid')->
			order_by('aid','desc')->get()->result_array();
			return ($data);
		}
		/**
		* 查询最新的文章
		*/
		public function title($limit)
		{	
			$data=$this->db->limit($limit)->select('aid,title')->
			order_by('time','desc')->get('article')->result_array();
			return ($data);
			
		}
		/**
		* 取出关于我的文章
		*/
	
		public function select_article($cid)
		{	
			$data=$this->db->select()->from('article')->join('category','article.cid=category.cid')->where(array('cid'=>$cid))
			->get()->result_array();
			return ($data);
		}
		/**
		* 通过栏目选取文章
		*/
		public function category_article($cid)
		{
			$data=$this->db->select('aid,title,abstract,date,thumb,writer')->order_by('time','desc')->get_where('article',array('cid'=>$cid))->
			result_array();
			return ($data);
		}
		/**
		* 通过aid选取文章
		*/
		public function aid_article($aid)
		{
			$data=$this->db->join('category','article.cid=category.cid')->get_where('article',array('aid'=>$aid))->result_array();
			
			return $data;
		}
		
	}
		
	