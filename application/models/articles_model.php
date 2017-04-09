<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	*���¹���ģ��
	*/	
	class Articles_model extends CI_Model
	{
		/**
		* ��������
		*/	
		public function add($data)
		{
			$this->db->insert('article',$data);
		}
		//�鿴����
		public function article_category()
		{
			$data=$this->db->select('aid,title,cname,time,date')->from('article')
			->join('category','article.cid=category.cid')->
			order_by('aid','asc')->get()->result_array();
			return ($data);
		}
		/**
		* ��ѯ���Ӧ������
		*/
		public function check_article($aid)
		{	
			$data=$this->db->select()->from('article')->where(array('aid'=>$aid))
			->join('category','article.cid=category.cid')->
			order_by('aid','asc')->get()->result_array();
			return ($data);
		}
		/**
		* �޸�����
		*/
		public function update_article($aid,$data)
		{
			$this->db->update('article',$data,array('aid'=>$aid));
			
		}
		/**
		* ɾ������
		*/
		public function delete_article($aid)
		{
			$this->db->delete('article',array('aid'=>$aid));
		}
		/**
		* ��ѯ���Ӧ������
		*/
		public function checks_article($limit,$type)
		{	
			$data=$this->db->limit($limit)->select('aid,title,abstract,date,cname,thumb,writer')->from('article')->where(array('type'=>$type))
			->join('category','article.cid=category.cid')->
			order_by('aid','desc')->get()->result_array();
			return ($data);
		}
		/**
		* ��ѯ���µ�����
		*/
		public function title($limit)
		{	
			$data=$this->db->limit($limit)->select('aid,title')->
			order_by('time','desc')->get('article')->result_array();
			return ($data);
			
		}
		/**
		* ȡ�������ҵ�����
		*/
	
		public function select_article($cid)
		{	
			$data=$this->db->select()->from('article')->join('category','article.cid=category.cid')->where(array('cid'=>$cid))
			->get()->result_array();
			return ($data);
		}
		/**
		* ͨ����Ŀѡȡ����
		*/
		public function category_article($cid)
		{
			$data=$this->db->select('aid,title,abstract,date,thumb,writer')->order_by('time','desc')->get_where('article',array('cid'=>$cid))->
			result_array();
			return ($data);
		}
		/**
		* ͨ��aidѡȡ����
		*/
		public function aid_article($aid)
		{
			$data=$this->db->join('category','article.cid=category.cid')->get_where('article',array('aid'=>$aid))->result_array();
			
			return $data;
		}
		
	}
		
	