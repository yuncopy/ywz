<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */

use \Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Events\Dispatcher;
use \Illuminate\Container\Container;


class Bootstrap extends Yaf_Bootstrap_Abstract{
	protected $config;
    public function _initConfig() {
		//把配置保存起来
		$arrConfig = Yaf_Application::app()->getConfig();
		$this->config = $arrConfig->toArray();
		Yaf_Registry::set('config', $arrConfig);
	}
	/**
	 注册错误调试模式功能
	*/
	public function _initError(Yaf_Dispatcher $dispatcher) {
		$config_all = $this->config;

		if ($config_all['application']['debug'])
		{
			define('DEBUG_MODE', false);
			ini_set('display_errors', 'On');
		}
		else
		{
			define('DEBUG_MODE', false);
			ini_set('display_errors', 'Off');
		}
	}

	/**
	 * 注册composer
	 */
	public function _initAutoload(Yaf_Dispatcher $dispatcher) {

		// Autoload 自动载入
		require APPLICATION_PATH.'/vendor/autoload.php';

		// Eloquent ORM
		$capsule = new Capsule;
		$capsule->addConnection([
			'driver'    => 'mysql',
			'host'      => '192.168.1.137',
			'database'  => 'sample',
			'username'  => 'root',
			'password'  => '111111',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		]);

		$capsule->setEventDispatcher(new Dispatcher(new Container));
		// Make this Capsule instance available globally via static methods... (optional)
		$capsule->setAsGlobal();

		// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
		$capsule->bootEloquent();

	}





	public function _initPlugin(Yaf_Dispatcher $dispatcher) {
		//注册一个插件
		//$objSamplePlugin = new SamplePlugin();
		//$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Yaf_Dispatcher $dispatcher) {
		//在这里注册自己的路由协议,默认使用简单路由
	}
	
	public function _initView(Yaf_Dispatcher $dispatcher){
		//在这里注册自己的view控制器，例如smarty,firekylin
	}


}
