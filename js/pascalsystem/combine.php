<?php
/**
 * Pascal combine js and css
 * 
 * @category   PSystem
 * @package    PSystem_OptimizationHead
 * @author     Pascal System <info@pascalsystem.pl>
 * @version    1.0.0
 */

/**
 * Return clear cache time in second
 * 
 * @return int
 */
function getRefreshTime() {
	if (!empty($_GET['refresh']) && ($time = intval($_GET['refresh'])))
		return $time;
	return 259200;
}

/**
 * Set css header
 * 
 * @return void
 */
function setCssHeader() {
	if (empty($_GET['gzipoff'])) {
		ob_start('ob_gzhandler');
		header('Content-Encoding: gzip');
	}
	header('Content-type: text/css; charset:UTF-8');
	header('Cache-Control: must-revalidate');
	$offset = getRefreshTime();
	$ExpStr = 'Expires: '.gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT';
	header($ExpStr);
}

/**
 * Set js header
 * 
 * @return void
 */
function setJsHeader() {
	if (empty($_GET['gzipoff'])) {
		ob_start('ob_gzhandler');
		header('Content-Encoding: gzip');
	}
	header('Content-type: text/javascript; charset: UTF-8');
	header('Cache-Control: must-revalidate');
	$offset = getRefreshTime();
	$ExpStr = 'Expires: '.gmdate('D, d M Y H:i:s', time() + $offset) . ' GMT';
	header($ExpStr);
}

/**
 * Minify css
 * 
 * @param string $content
 * @return string
 */
function minifyCss($content) {
	if (!empty($_GET['minoff']))
		return $content;
	require_once 'Minify/CSS.php';
	return Minify_CSS::minify($content);
}

/**
 * Minify js
 * 
 * @param string $content
 * @return string
 */
function minifyJs($content) {
	if (!empty($_GET['minoff']))
		return $content;
	require_once 'JSMin.php';
	return JSMin::minify($content);
}

/**
 * Get media cache dir
 * 
 * @return string
 */
function getCacheDir() {
	$dir = dirname(__FILE__).'/../../media/optimizationhead';
	if (!is_dir($dir)) mkdir($dir, 0777);
	return $dir.'/';
}

/**
 * Get base dir
 *
 * @param string $type
 * @return string
 */
function getBaseDir($type = '') {
	$path = dirname(__FILE__).'/../..';
	if ($type)
		$path.= '/'.$type;
	return $path;
}

/**
 * Get base url
 * 
 * @reutrn string
 */
function getBaseUrl() {
	if (isset($GLOBALS['BASE_URL']))
		return $GLOBALS['BASE_URL'];
	$httpUrl = '';
	if (empty($_SERVER['REQUEST_URI']))
		return '/';
	$cutPos = strpos($_SERVER['REQUEST_URI'], 'js/pascalsystem');
	if ($cutPos===false)
		$httpUrl.= '/';
	else
		$httpUrl.= substr($_SERVER['REQUEST_URI'], 0, $cutPos);
	$GLOBALS['BASE_URL'] = $httpUrl;
	return $GLOBALS['BASE_URL'];
}

/**
 * Translate url in css file
 * 
 * @param string $content
 * @param string $file
 * @param string $prefix
 * @return string
 */
function translateUrlInCss($content, $file, $prefix) {
	preg_match_all('/url\(([\'\"])?([^\)\'\"]+)([\'\"])?\)/', $content, $matches);
	$absPath = getBaseUrl().$prefix.'/';
	$absFilePart = explode('/',dirname($file));
	$absFileNum = count($absFilePart);
	$replaces = array();
	foreach ($matches[0] as $num => $value) {
		$temps = explode('/',$matches[2][$num]);
		$numTemps = count($temps);
		for ($i=0;$i<$numTemps;$i++) {
			if ($temps[$i]=='..')
				continue;
			break;
		}
		if ($i>$absFileNum) {
			$i==$absFileNum;
		}
		if ($i>0) {
			$temps = array_slice($temps, $i);
		}
		$pathSlice = array_slice($absFilePart, 0, $absFileNum-$i);
		$replaces[$num] = 'url('.$matches[1][$num].$absPath.implode('/',$pathSlice).'/'.implode('/',$temps).$matches[3][$num].')';
	}
	return str_replace($matches[0], $replaces, $content);
}

/**
 * Combine files
 *
 * @param array $files
 * @param string $prefix
 * @param string $ext
 * @return string
 */
function combineFiles(array $files, $prefix, $ext) {
	$baseDir = getBaseDir($prefix).'/';
	$cacheDir = getCacheDir();
	
	$filesKey = md5(serialize($files)).'.'.$ext;
	
	$noCache = empty($_GET['nocache'])?false:true;
	
	if (!$noCache && file_exists($cacheDir.$filesKey) && (filemtime($cacheDir.$filesKey)+getRefreshTime() > time())) {
		$allData = file_get_contents($cacheDir.$filesKey);
	} else {
		$allData = '';
		foreach ($files as $file) {
			if (!file_exists($baseDir.$file))
				continue;
			
			$data = file_get_contents($baseDir.$file);
			if ($ext == 'css') {
				$data = translateUrlInCss($data, $file, $prefix);
			}
			
			if ($allData) {
				$allData.= "\n\n";
			}
			$allData.= $data;
		}
		
		if ($ext == 'css') {
			$allData = minifyCss($allData);
		} else {
			$allData = minifyJs($allData);
		}
		
		if (!$noCache) {
			file_put_contents($cacheDir.$filesKey, $allData);
		}
	}
	
	echo $allData;
}

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__).'/../../app/code/community/PSystem/OptimizationHead/lib');
$type = empty($_GET['type'])?'':$_GET['type'];
$files = empty($_GET['file'])?array():explode(',',$_GET['file']);
switch ($type) {
	case 'css' :
		setCssHeader();
		combineFiles($files, 'js', 'css');
		exit;
	case 'cssskin' :
		setCssHeader();
		combineFiles($files, 'skin', 'css');
		exit;
	case 'js' :
		setJsHeader();
		combineFiles($files, 'js', 'js');
		exit;
	case 'jsskin' :
		setJsHeader();
		combineFiles($files, 'skin', 'js');
		exit;
}
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");