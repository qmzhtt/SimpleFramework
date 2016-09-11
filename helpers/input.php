<?php
//批量完成实体转义操作
function deepspecialchars($data){
	//对空数组做一个处理
	if (empty($data)) {
		return $data;
	}	
	//中高级程序员的写法
	return is_array($data) ? array_map('deepspecialchars', $data) : htmlspecialchars($data);
	/*
		//初级程序员的写法
		if (is_array($data)) {
			//数组, array('cat_id'=>1,'cat_name'=>'服装','parent_id'=>0)
			foreach ($data as $k => $v) {
				$data[$k] = deepspecialchars($v);
			}
			return $data;
		} else {
			//单个变量 $username
			return htmlspecialchars($data);
		}
	*/
}

//批量单引号转义
function deepslashes($data){
	if (empty($data)) {
		return $data;
	}
	return is_array($data) ?  array_map('deepslashes', $data) : addslashes($data);
}