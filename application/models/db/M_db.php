<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * 数据库类
 */
class M_db extends CI_Model {
	
 	public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        
        //载入数据库
        $db=$this->load->database('default');
        
        //数据库工厂类
        $this->load->dbforge();
        
        $this->m_define();
        
        $this->update_db_table('sys_log_login');
    }
    
	/**
     * 
     * 定义
     */
	public function m_define()
    {
    	if( defined('LOAD_M_DB') ) return;
    	
    	define('LOAD_M_DB', 1);
    	
		//数据库字段基本类型
		$GLOBALS['m_db']['text']['db_type_length'] = array(
				'VARCHAR'=>80,
				'INT'=>11,
				'TINYINT'=>3,
			    'SMALLINT'=>5,
				'BIGINT'=>20,
				'DECIMAL'=>'11,2',
				'DATETIME'=>'',
				'DATE'=>'',
				'TEXT'=>'',
				'LONGTEXT'=>'',
				'BLOB'=>'',
				'LONGBLOB'=>'',
		);
		
    }
    
	/**
     * 
     * 改变数据库
     */
	public function change_db($db_name)
    {
    	 //载入数据库
    	$this->db->close();
        $this->load->database($db_name);
    }
    
	/**
     * 
     * 验证权限
     */
	public function check()
    {
    	
    }
    
	/**
	  * 
	  * 获取最大，最小值
	  * @param $table 表名
	  * @param $field 字段名
	  * @param $where 条件
	  * @param $type 类型 MAX MIN
	  */
    public function get_m_value($table,$field,$where='',$type="MAX")
	{
		$sql="SELECT {$type}({$field}) m FROM {$table} WHERE 1=1 {$where}  ";
    	$rs=$this->db->query($sql);
        $rtn=current($rs->result_array());
       
        return $rtn['m'];
	}
	
    
	/**
     * 
     * 过滤保存信息
     * @param $table_form 表结构
     * @param $content    保存信息
     */
    public function filter_data_save($table_form,$content=array())
    {
    	$data_save=array();
    	
    	if(count($content)>0)
    	{
    		foreach ($content as $k=>$v)
    		{
	    		// 非表数据
				if ( ! isset($table_form['fields'][$k]))
				{
					continue;
				}
				
				if(is_array($v))
				continue;
				
				$v = trim($v);
				
				//验证数据类型
				switch ($table_form['fields'][$k]['type']) {
					case 'DECIMAL':
						$v = str_replace(',', '', $v);
					break;
					
					case 'TINYINT':
					case 'SMALLINT':
						if( empty($v) && $v != '0' )
						$v = NULL;
						else 
						$regex = "/^[0-9]+$/";
						
					break;
					
					case 'INT':
					case 'BIGINT':
						$data_in['regex'] = "/^[-+]?[0-9]+$/";
					break;
					
					case 'DATE':
						if( empty($v))
						$v = NULL;
						else 
						$regex = "/^([1][9][7-9][0-9]|[2][0][0-9][0-9])(-)([0][1-9]|[1][0-2])(-)([0-2][0-9]|[3][0-1])$/";
					break;
					
					case 'DATETIME':
						if( empty($v))
						$v = NULL;
						else 
						{
							$regex = "/^([1][9][0-9][0-9]|[2][0][0-9][0-9])(-)([0][1-9]|[1][0-2])(-)([0-2][0-9]|[3][0-1])( )([0-1][0-9]|[2][0-3])(:)([0-5][0-9])(:)([0-5][0-9])$/";
							$regex2 = "/^([1][9][0-9][0-9]|[2][0][0-9][0-9])(-)([0][1-9]|[1][0-2])(-)([0-2][0-9]|[3][0-1])( )([0-1][0-9]|[2][0-3])(:)([0-5][0-9])$/";
						}
					break;
					
					case 'VARCHAR':
						
						if($table_form['fields'][$k]['constraint'] < 200)
						$v = str_replace(' ', '', $v);
						
					case 'TEXT':
					case 'LONGTEXT':
						$v=$this->m_base->filter_str($v);
					break;
				}
				
	    		if ( ! empty($regex) )
				{
					$check = preg_match($regex, $v);// 用正则进行文本格式检查
					$regex='';
					
					if( ! $check
					 && $table_form['fields'][$k]['type'] == 'DATETIME')
					{
						$check = preg_match($regex2, $v);// 用正则进行文本格式检查
					}
					
					$regex='';
					if( ! $check) continue;
				}
				
				//验证数据长度
				if( ! empty($table_form['fields'][$k]['constraint']) 
				&& strlen($v) > $table_form['fields'][$k]['constraint'] )
				{
					continue;
				}
				
				$data_save[$k]=$v;
    		}
    	}
    	
    	return $data_save;
    }
    
	/**
     * 
     * 查询信息
     * @param $arr_search 
     * 条件数组   field=>'', 字段
     * 		  from=>'',  表
     * 		  where=>'', 条件
     * 		  value=>'', 查询值
     *        page=>'',  页
     *        rows=>'',  分页
     *        sort=>'',  排序字段
     *        order=>''  顺序
     *        sum_all=>''合计
     *        
     */
    public function query($arr_search)
    {
    	//返回数组
    	$rtn=array();
    	
    	$field=$arr_search['field'];
    	$from=$arr_search['from'];
    	
    	if( empty($field) )$field='*';
    	if( empty($from) ) 
    	{
    		$rtn['total']=0;
    		$rtn['content']=array();
    		$rtn['time']=0;
    		
    		return $rtn;
    	}
    	
    	//起始页
    	$page=0;
    	if(isset($arr_search['page'])) $page=$arr_search['page']-1;
    	if($page<0) $page=0;
    	
    	//分页
    	$rows=0;
    	if(isset($arr_search['rows'])) $rows=$arr_search['rows'];
    	$page=$page*$rows;
    	
    	//排序
    	$sort=element('sort',$arr_search);
    	$order=element('order',$arr_search);
    	
    	//查询条件
    	$where='';
    	if(isset($arr_search['where'])) $where=$arr_search['where'];
    	
    	$value=array();
    	if(isset($arr_search['value'])) $value=$arr_search['value'];
    	
    	//查询起始时间
    	$sql_time_start=time();
    	
    	//计算合计
    	$sum_field='';
    	if(isset($arr_search['sum_all']) && count($arr_search['sum_all'])>0)
    	{
    		foreach ($arr_search['sum_all'] as $v) {
    			$sum_field.=',SUM('.$v.') sum_'.str_replace('.', '_', $v);
    		}
    	}
    	
    	//查询总数
    	$sql="SELECT COUNT(*) total {$sum_field} FROM {$from} WHERE 1=1 {$where} ";
    	$rs=$this->db->query($sql,$value);
    	$rtn=current($rs->result_array());
//    	if( ! is_array($rtn) || empty(element('total', $rtn)) )
//    	$rtn['total']=0;
//    	
//    	if(count($rs->result_array())>1)
//    	$rtn['total']=count($rs->result_array());

    	if(stristr($where, 'GROUP'))
    	{
    		$rtn['total']=$rs->num_rows();
    	}
    	
    	//查询内容
    	$sql="SELECT {$field} FROM {$from} WHERE 1=1 {$where} ";
    	if( is_array($sort))
    	{
    		if(count($sort)>0)
    		{
    			$sql.=" ORDER BY ";   
    			foreach ($sort as $k=>$v) {
    				if( ! empty(element($k, $order)))
    				$sql.=$v.' '.$order[$k].',';
    				else
    				$sql.=$v.' ASC,';
    			}
    			$sql=trim($sql,',');
    		}
    	}
    	elseif( ! empty( $sort ))
    	{
    		$sql.=" ORDER BY {$sort} {$order} ";
    	} 
    	
    	if( ! empty( $rows )) $sql.=" LIMIT {$page},{$rows} ";    
    	
    	$rs=$this->db->query($sql,$value);
        $rtn['content']=$rs->result_array();
        
        //查询结束时间
        $sql_time_end=time();
        
        //查询消耗时间
        $rtn['time']=$sql_time_end-$sql_time_start;
        
        return $rtn;
    }
    
	/**
     * 
     * 插入数据
     * @param $content    插入数据
     * @param $table_name 表名
     */
    public function insert($content,$table_name,$table_form=NULL)
    {
    	
    	$rtn=array();
    	if( empty($table_form) )
    	{
    		$this->config->load('db_table/'.$table_name, FALSE,TRUE);
    		$table_form=$this->config->item($table_name);
    	}
    	
    	$table_pk=$table_form['primary_key'];
    	$data_save=$this->filter_data_save($table_form,$content);
    	
    	if(count($table_pk)>0)
    	{
    		foreach ($table_pk as $k=>$v) 
    		{
    			if( ! isset($data_save[$v])) 
    			{
    				$rtn['rtn']=FALSE;
    				$rtn['msg']='数据表【'.$table_name.'】插入数据缺少主键【'.$v.'】';
    				
    				return $rtn;
    			}
    			
    		}
    	}
    	
    	if(count($data_save)>0)
        {
        	$this->db->insert($table_name, $data_save);
        	
        	$rtn['rtn']=$this->db->trans_status();
        	
	        if ($rtn['rtn'] === FALSE)
			{
				$rtn['msg']='数据表【'.$table_name.'】插入【'.json_encode($data_save).'】失败!';
			}
			
        	return $rtn;
        }
    }
    
	/**
	 * 
	 * 更新信息
	 * @param $table_name 表名
	 * @param $content    更新数据
	 * @param $where      条件
	 */
    public function update($table_name,$content,$where)
    {
    	$rtn=array();
    	
    	if( empty($table_form) )
    	{
    		$this->config->load('db_table/'.$table_name, FALSE,TRUE);
    		$table_form=$this->config->item($table_name);
    	}
    	
    	$data_save=$this->filter_data_save($table_form,$content);
    	
    	if(count($data_save)>0)
        {
        	$this->db->update($table_name,$data_save,$where);
        	
        	$rtn['rtn']=$this->db->trans_status();
	        if ($rtn['rtn'] === FALSE)
			{
				$rtn['msg']='数据表【'.$table_name.'】更新【'.json_encode($data_save).'】，条件【'.$where.'】失败!';
			}
        }
        
        return $rtn;
    }
    
	/**
	 * 
	 * 删除数据
	 * @param $table_name 表名
	 * @param $where      条件 array()
	 */
    public function delete($table_name,$where)
    {
    	$rtn=array();
    	
    	if( count($where) > 0 )
    	{
    		foreach ($where as $k=>$v) 
    		{
    			$this->db->where($k, $v); 
    		}
    		
        	$this->db->delete($table_name);
        	
        	$rtn['rtn']=$this->db->trans_status();
        	
	        if ($rtn['rtn'] === FALSE)
			{
				$rtn['msg']='数据表【'.$table_name.'】删除，条件【'.$where.'】失败!';
			}
    	}
    	
    	return $rtn;
    }
    
	/**
	 * 
	 * 执行sql
	 * @param $sql 
	 */
    public function exec_sql($sql,$value=array())
    {
    	$rtn=array();
    	
		$this->db->query($sql,$value);
		
    	$rtn['rtn']=$this->db->trans_status();
        	
        if ($rtn['rtn'] === FALSE)
		{
			$rtn['msg']='执行sql【'.$sql.'】失败!';
		}
		
		return $rtn;
    }
    
	/**
	  * 
	  * 获取form sql
	  * @param $table 表名
	  */
    public function get_sql_form($table)
	{
		 //读取表结构
        $this->config->load('db_table/'.$table, FALSE,TRUE);
        $table_form=$this->config->item($table);
        
        $arr_field=$table_form['fields'];
		$arr_field_index=$table_form['fields_index'];
		
		$form='';
		foreach ($arr_field as $k=>$v) {
			$form.=$k.' '.$v['type'];
			if( $v['constraint'] )
			$form.='('.$v['constraint'].')';
			
			switch ($v['type']) {
				case 'TEXT':
				case 'LONGTEXT':
					$form.=',';
					continue 2;
				break;
			}
			
			if(element('UNSIGNED', $v))
			$form.=' UNSIGNED';
			
			if(element('null', $v))
			$form.=' NULL';
			else 
			$form.=' NOT NULL';
			
			if(element('default', $v) || element('default', $v) == '0')
			$form.=' DEFAULT '.$v['default'];
			
			$form.=',';
		}
		
		$form.='PRIMARY KEY(';
		$arr_field_pk=$table_form['primary_key'];
		
		foreach ($arr_field_pk as $k=>$v) {
			$form.=$v.',';
		}
		$form=trim($form,',');
		$form.=')';
		
		if(count($arr_field_index)>0)
		{
			$form.=',INDEX(';
			foreach ($arr_field_index as $v) {
				$form.=$v.',';
			}
			$form=trim($form,',');
			$form.=')';
		}
		
		return $form;
	}
    
	/**
	 * 
	 * 更新表
	 * @param $table_name 表名
	 */
    public function update_db_table($table_name)
    {
    	//读取表结构
        $this->config->load('db_table/'.$table_name, FALSE,TRUE);
        $table_form=$this->config->item($table_name);
        
        //分表
        if(element('type', $table_form) == 'merge')
        {
        	$year=date("Y");
        	
        	// 检测表是否存在
	        if ( ! $this->db->table_exists($table_name.$year))
			{
				$this->db->trans_start();
				$sql="
		        DROP TABLE IF EXISTS {$table_name};
		        ";
				
				$this->db->query($sql);
				
				$form=$this->get_sql_form($table_name);
			
				//创建分表
		        $sql="
		        CREATE TABLE IF NOT EXISTS {$table_name}{$year} (
		          {$form}
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
		        ";
		        $this->db->query($sql);
		        
		        //获取所有分表
		        $list_table='';
				$year--;
		        while($this->db->table_exists($table_name.$year) )
		        {
		        	$list_table.=$table_name.$year.',';
		        	$year--;
		        }
		        
		        $list_table.=$table_name.date("Y");
		        
		        //创建主表
		        $sql="
		        CREATE TABLE IF NOT EXISTS `{$table_name}` (
				  {$form}
				) ENGINE=MERGE UNION=({$list_table}) INSERT_METHOD=LAST;
		        ";
		        $this->db->query($sql);
		        
		        $this->db->trans_complete();
		        
			}
			
        	return;
        }
        
    	// 检测表是否存在
        if ( ! $this->db->table_exists($table_name))
		{
			//创建表
	        $this->dbforge->add_field($table_form['fields']);
	        
	        //添加主键
	        $this->dbforge->add_key($table_form['primary_key'],TRUE);
	        
	        //添加索引
	        if(count($table_form['fields_index']) > 0)
	        {
	        	$this->dbforge->add_key($table_form['fields_index']);
	        }
	        
	        $this->dbforge->create_table($table_name, TRUE);
		}
		else 
		{
			//获取数据库元数据
			$fields = $this->db->field_data($table_name);
			
			$table_form['fields_add']=array();
			$table_form['fields_modify']=array();
			$table_form['fields_drop']=array();
			
			foreach ($fields as  $field)
			{
				if(element($field->name, $table_form['fields']))
				{
					$table_form['fields_modify'][$field->name]=$table_form['fields'][$field->name];
					$table_form['fields_modify'][$field->name]['name']=$field->name;
					unset($table_form['fields'][$field->name]);
				}
				else 
				{
					//删除列
					$this->dbforge->drop_column($table_name, $field->name);
				}
			}
			
			$table_form['fields_add'] = $table_form['fields'];
			
			//修改列
			$this->dbforge->modify_column($table_name, $table_form['fields_modify']);
			
			//添加列
			$this->dbforge->add_column($table_name, $table_form['fields_add']);
			
			//更新索引
			$sql="show index from {$table_name};";
	    	$rs_index=$this->db->query($sql);
	    	$rs_index=$rs_index->result_array();
	    	if(count($rs_index)>0)
	    	{
	    		foreach ($rs_index as $v) {
	    			if( element('Key_name', $v) == 'PRIMARY')
	    				continue;
	    			
	    			$sql="DROP INDEX {$v['Key_name']} ON {$table_name}";
					$this->db->query($sql);
	    		}
	    	}
	    	
	    	if(count($table_form['fields_index'])>0)
	    	{
	    		$field_index=implode(',', $table_form['fields_index']);
	    		$sql="ALTER TABLE {$table_name} ADD INDEX({$field_index});";
	    		$this->db->query($sql);
	    	}
		}
    }
}