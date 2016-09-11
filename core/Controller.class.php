<?php
//核心控制器
class Controller {
	//提示信息并跳转
	public function jump($url,$message,$wait = 3){
		if ($wait == 0) {
			//立即跳转
			header("Location:$url");
		} else {
			include CUR_VIEW_PATH . "message.html";
		}
		//一定要退出
		exit();
	}

	//载入工具类模型
	public function library($lib){
		include LIB_PATH . "{$lib}.class.php";
	}

	//载入辅助函数
	public function helper($helper){
		include HELPER_PATH . "{$helper}.php";
	}
}