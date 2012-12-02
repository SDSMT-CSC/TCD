<?php // include BotDetect PHP CAPTCHA Library v3.0.Alpha3-Build201211021402

// PHP 5.2.x compatibility workaround
if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }


// 1. define BotDetect paths

// physical path to Captcha library files (the BotDetect folder)
$LBD_Include_Path = __DIR__ . '/BotDetect/';

// BotDetect Url prefix (base Url of the BotDetect public resources)
$LBD_Url_Root = 'BotDetect/Public/';

// physical path to the folder with the (optional!) config override file
$LBD_Config_Override_Path = __DIR__;


// normalize paths
if (is_file(__DIR__ . '/BotDetect/CaptchaIncludes.php')) {
  // in case a local copy of the library exists, it is always used
  $LBD_Include_Path = __DIR__ . '/BotDetect/';
  $LBD_Url_Root = 'BotDetect/Public/';
} else {
  // clean-up path specifications
  $LBD_Include_Path = LBD_NormalizePath($LBD_Include_Path);
  $LBD_Url_Root = LBD_NormalizePath($LBD_Url_Root);
  $LBD_Config_Override_Path = LBD_NormalizePath($LBD_Config_Override_Path);
}
define('LBD_INCLUDE_PATH', $LBD_Include_Path);
define('LBD_URL_ROOT', $LBD_Url_Root);
define('LBD_CONFIG_OVERRIDE_PATH', $LBD_Config_Override_Path);


function LBD_NormalizePath($p_Path) {
  // replace backslashes with forward slashes
  $canonical = str_replace('\\', '/', $p_Path);
  // ensure ending slash
  $canonical = rtrim($canonical, '/');
  $canonical .= '/';
  return $canonical;
}


// 2. include required base class declarations
require_once (LBD_INCLUDE_PATH . 'CaptchaIncludes.php');


// 3. include BotDetect configuration

// a) mandatory global config, located in lib path
require_once(LBD_INCLUDE_PATH . 'CaptchaConfig.php');

// b) optional config override
$configOverridePath = LBD_CONFIG_OVERRIDE_PATH . 'CaptchaConfig.php';
if (is_file($configOverridePath)) {
  include_once($configOverridePath);
}


// 4. determine is this file included in a form/class, or requested directly
$requestFilename = basename($_SERVER['REQUEST_URI']);
if (StringHelper::StartsWith($requestFilename, 'BotDetect.php')) {
  // direct access, proceed as Captcha handler (serving images and sounds)
  require_once(LBD_INCLUDE_PATH . 'CaptchaHandler.php');
} else {
  // included in another file, proceed as Captcha class (form helper)
  require_once(LBD_INCLUDE_PATH . 'CaptchaClass.php');
}
?>