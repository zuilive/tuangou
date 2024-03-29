<?php

/**
 * 系统初始化
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package base
 * @name init.php
 * @version 1.2
 */

function microtime_float()
{
	list ($usec, $sec) = explode(" ", microtime());
	return (( float )$usec + ( float )$sec);
}

function gzip_ops( &$buffer, $mode = 5 )
{
	if ( GZIP === true && function_exists('ob_gzhandler') && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') )
	{
		$buffer = ob_gzhandler($buffer, $mode);
	}
	return $buffer;
}

class TTTGMaster
{
	public static function load($file)
	{
		$bootFile = dirname($file).'/include/load/'.basename($file);
		is_file($bootFile) || exit('missing startup file');
		require $bootFile;
		$iniz = new initialize();
		
		$iniz->envInit();
		$iniz->allowMod(WEB_BASE_ENV_DFS::$MODULES);
		$iniz->load(WEB_BASE_ENV_DFS::$APPNAME);
		unset($iniz);
	}
}

class initialize
{
	var $config = array();
	var $allowModules = array();
	public $modulesPath = 'modules/';
	function initialize()
	{
		require_once 'setting/settings.php';
		$this->config = $config['settings'];
				if ($this->config['site_domain'] != $_SERVER['HTTP_HOST'] && $this->config['site_domain'] != 'localx.uuland.org')
		{
			$redir = 'http://'.$this->config['site_domain'].$_SERVER['REQUEST_URI'];
			header('Location: '.$redir);
			exit;
		}
	}
	function envInit()
	{
		if ( DEBUG )
		{
			error_reporting(E_ALL ^ E_NOTICE);
		}
		else
		{
			error_reporting(0);
		}
		@set_time_limit(30);
		@ini_set("arg_seperator.output", "&amp;");
		@ini_set("magic_quotes_runtime", 0);
		header('Content-Type: text/html; charset=' . $this->config['charset']);
		if ( version_compare(phpversion(), '5.1.0', '>=') )
		{
			date_default_timezone_set('PRC');
		}
		else
		{
			putenv("PRC");
		}
				define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc()); 		define('ROOT_PATH', './'); 				
		define('UPLOAD_PATH', $DEV_UPLOAD_PATH?$DEV_UPLOAD_PATH:ROOT_PATH.'uploads/'); 		define('CACHE_PATH', ROOT_PATH . 'cache/'); 		define('DATA_PATH', ROOT_PATH . 'data/'); 		define('INCLUDE_PATH', ROOT_PATH . "include/"); 		define('DB_DRIVER_PATH', INCLUDE_PATH . "db/"); 		define('LIB_PATH', INCLUDE_PATH . "lib/"); 		define('FUNCTION_PATH', INCLUDE_PATH . "function/"); 		define('TASK_PATH', INCLUDE_PATH . "task/"); 		define('LOGIC_PATH', INCLUDE_PATH . "logic/"); 		define('DRIVER_PATH', INCLUDE_PATH . 'driver/'); 		define('UI_POWER_PATH', INCLUDE_PATH . 'ui/'); 		define('APP_PATH', ROOT_PATH . 'app/'); 		define('CONFIG_PATH', ROOT_PATH . "setting/"); 		

				if ( !is_file(DATA_PATH.'install.lock') && 'inizd.php' != strstr($_SERVER['PHP_SELF'], 'inizd.php') )
		{
			header('Location: inizd.php?mod=install');
			exit;
		}
				if ( file_exists('./cache/site_enable.php') && 'account' != $_GET['mod'] && 'apiz' != $_GET['mod'] && !stristr($_SERVER['PHP_SELF'], 'admin.php'))
		{
			die(file_get_contents('./cache/site_enable.php'));
		}
				if ( is_file('./cache/upgrade.lock') && filemtime('./cache/upgrade.lock') + 600 > time() && 'apiz' != $_GET['mod'] && !stristr($_SERVER['PHP_SELF'], 'admin.php') )
		{
			die("now is Updating...");
		}
		
	}
	function allowMod( $modules )
	{
		foreach ( $modules as $i => $module )
		{
			$allowModules[$module] = true;
		}
		$this->allowModules = $allowModules;
	}
	function load( $module )
	{
		if ( $module == 'index' )
		{
			$module = '';
		}
		define('MOD_PATH', ROOT_PATH . $this->modulesPath . $module . '/');
				switch ( $module )
		{
			case 'ajax':
				header("Cache-Control: no-cache, must-revalidate");
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			break;
		}
		
				ob_start("gzip_ops");
		$this->run($module);
		ob_end_flush();
				
	}
	function run($module)
	{
		$config = $this->config;
				if ($module != 'admin')
		{
			global $rewriteHandler;
			include_once './include/rewrite.php';
		}
				require_once DRIVER_PATH . 'i18n.php';
		i18n_init($config['language']);
				require_once LIB_PATH . 'config.han.php';
				include_once CONFIG_PATH . 'robot.php';
				require_once FUNCTION_PATH . 'common.func.php';
				define('MY_QUERY_ERROR', 10);
				require_once CONFIG_PATH . 'constants.php'; 		require_once CONFIG_PATH . 'credits.php'; 				require_once FUNCTION_PATH . 'cache.func.php';
				require_once FUNCTION_PATH . 'global.func.php';
				require_once INCLUDE_PATH . 'load.php';
				require_once LIB_PATH . 'http.han.php';
				require_once LIB_PATH . 'template.han.php';
				require_once LIB_PATH . 'form.han.php';
				require_once DB_DRIVER_PATH . 'database.db.php';
		require_once DB_DRIVER_PATH . "mysql.db.php";
				require_once INCLUDE_PATH . 'constant.php';
				require_once INCLUDE_PATH . 'engine.php';
				require_once INCLUDE_PATH . 'extend.php';
				require_once MOD_PATH . 'master.mod.php';
				require_once MOD_PATH . $this->accessMod($config['default_module']) . '.mod.php';
				$_GET = HttpHandler::checkVars($_GET);
		$_POST = HttpHandler::checkVars($_POST);
		$moduleobject = new ModuleObject($config);
		$module != 'inizd' && handler('member')->SaveActionToLog($moduleobject->Title);
		unset($moduleobject);
	}
	function accessMod( $default = 'index' )
	{
		$modss = $this->allowModules;
		$mod = (isset($_POST['mod']) ? $_POST['mod'] : $_GET['mod']);
		if ( !$mod ) $mod = $default;
		if (DEBUG && $modss['*'])
		{
					}
		else
		{
			if ( !isset($modss[$mod]) || !$modss[$mod])
			{
				include (INCLUDE_PATH . 'error_404.php');
				exit();
			}
		}
		$_POST['mod'] = $_GET['mod'] = $mod;
		return $mod;
	}
}

?>