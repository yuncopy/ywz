# YWZ
yaf使用composer管理模块，并集成illuminate database eloquent model

#### 1.安装YAF
#### 2.在NGINX上配置YAF
注意：
**项目根目录public**


==更改项目根目录，必须加上去，否则无法使用默认路由（实路由URL重写功能）==
```
if (!-e $request_filename) {
		rewrite ^/(.*\.(js|ico|gif|jpg|png|css|bmp|wsdl|pdf|xls)$) /public/$1 last;
		rewrite ^/(.*) /index.php?$1 last;
	}
```


```
#
# The default server
#
server {
    listen       	90;
    server_name 	demo.ywz;
    root   /usr/share/nginx/yafmy/public;
    index  index.php index.html index.htm;

	if (!-e $request_filename) {
		rewrite ^/(.*\.(js|ico|gif|jpg|png|css|bmp|wsdl|pdf|xls)$) /public/$1 last;
		rewrite ^/(.*) /index.php?$1 last;
	}

	if ($http_user_agent ~ ApacheBench|webBench|Java/|http_load|must-revalidate|wget) { 
		return 403; 
	}

    error_page  404              /404.html;
    location = /404.html {
        root   /usr/share/nginx/html;
    }

    # redirect server error pages to the static page /50x.html
    #
    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root   /usr/share/nginx/html;
    }

    # proxy the PHP scripts to Apache listening on 127.0.0.1:80
    #
    #location ~ \.php$ {
    #    proxy_pass   http://127.0.0.1;
    #}

    # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
    #
    location ~ \.php$ {
 
		fastcgi_buffers 2 256k;
		fastcgi_buffer_size 128k;
		fastcgi_busy_buffers_size  256k;
		fastcgi_temp_file_write_size  256k;

		fastcgi_pass   	127.0.0.1:9000;
        fastcgi_index  	index.php;
        #fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;
        fastcgi_param  	SCRIPT_FILENAME  $document_root$fastcgi_script_name;
		include        	fastcgi_params;
    }
  
}
```


#### 3.安装composer

```
wget https://getcomposer.org/composer.phar建议在家目录下载
chmod +x composer.phar 添加可执行权限
composer脚本拷贝一份到环境变量目录下(为了执行方便)
cp -a composer.phar /usr/bin/composer
```

#### 4.集成illuminate database
- index.php入口文件集成
``` 
<?php
#define('APPLICATION_PATH', dirname(__FILE__));
use \Illuminate\Database\Capsule\Manager as Capsule;
// Set the event dispatcher used by Eloquent models... (optional)
use \Illuminate\Events\Dispatcher;
use \Illuminate\Container\Container;

define('APPLICATION_PATH', dirname(__DIR__));

// Autoload 自动载入
require '../vendor/autoload.php';
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

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");
$application->bootstrap()->run();
?>

```

- \application\Bootstrap.php 引导文件中集成
> 注意命名空间的使用
```
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
```

> 具体使用：
> Laravel 5.1 LTS 速查表
> https://cs.laravel-china.org/

简单使用查看内部控制器，模型的案例代码




