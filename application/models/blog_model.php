<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {


	
	/**
		* 查询最新的文章
		*/
		public function select_article($limit)
		{	
			$data=$this->db->limit($limit)->select()->from('article')
			->join('category','article.cid=category.cid')->
			order_by('aid','desc')->get()->result_array();
			return ($data);
			
		}
}
