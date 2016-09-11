<?php
//核心启动类
class Framework {
	//run方法，
	public static function run(){
		//echo "hello,world!";
		self::init();
		self::autoload();
		self::dispatch();
	}
	//初始化工作
	private static function init(){
		//定义路径常量
		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT", getcwd() . DS); //根目录
		define("APP_PATH", ROOT . "application" .DS);
		define("FRAMEWORK_PATH", ROOT . "framework" .DS);
		define("PUBLIC_PATH", ROOT . "public" .DS);
		define("CONTROLLER_PATH", APP_PATH . "controllers" .DS);
		define("MODEL_PATH", APP_PATH . "models" .DS);
		define("VIEW_PATH", APP_PATH . "views" .DS);
		define("CONFIG_PATH", APP_PATH . "config" .DS);
		define("CORE_PATH", FRAMEWORK_PATH . "core" .DS);
		define("DB_PATH", FRAMEWORK_PATH . "databases". DS);
		define("LIB_PATH", FRAMEWORK_PATH . "libraries" .DS);
		define("HELPER_PATH", FRAMEWORK_PATH . "helpers" .DS);
		define("UPLOAD_PATH", PUBLIC_PATH . "uploads" .DS);
		//index.php?p=admin&c=goods&a=insert -- > admin下的GoodsController
		//获取pca参数
		define("PLATFORM", isset($_GET['p']) ? $_GET['p'] : "admin");
		define("CONTROLLER", isset($_GET['c']) ? ucfirst($_GET['c']) : "Index");
		define("ACTION", isset($_GET['a']) ? $_GET['a'] : "index");
		//当前控制器目录和当前视图目录
		define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM .DS);
		define("CUR_VIEW_PATH", VIEW_PATH . PLATFORM .DS);

		//载入核心类文件
		include CORE_PATH . "Controller.class.php";
		include CORE_PATH . "Model.class.php";
		include DB_PATH . "Mysql.class.php";

		//载入配置文件
		$GLOBALS['config'] = include CONFIG_PATH . "config.php";

		//开启session
		session_start();
	}
	//完成路由分发
	//index.php?p=admin&c=goods&a=insert GoodsController中的insertAction
	private static function dispatch(){
		//说白了，其实就是实例化控制器对象并调用方法
		//获取控制器和方法的名字
		$controller_name = CONTROLLER . "Controller";
		$action_name = ACTION . "Action";
		//实例化对象，并调用方法
		$controller = new $controller_name();
		$controller->$action_name();
	}

	//完成自动载入
	private static function autoload(){
		spl_autoload_register('self::load');
	}

	//普通方法，完成指定名称的类的载入
	//此处，只载入application中的控制器和模型，没有其他的。
	//如GoodsController，GoodsModel
	private static function load($classname){
		if (substr($classname, -10) == 'Controller') {
			//控制器
			include CUR_CONTROLLER_PATH . "{$classname}.class.php";
		} elseif (substr($classname, -5) == 'Model') {
			//模型
			include MODEL_PATH . "{$classname}.class.php";
		} else {
			//其他，暂时没有
		}
	}
}
