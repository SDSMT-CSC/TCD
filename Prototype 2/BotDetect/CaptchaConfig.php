<?php

$LBD_CaptchaConfig = new stdClass();

// Captcha code configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->CodeLength = 5;
$LBD_CaptchaConfig->CodeStyle = CodeStyle::Alphanumeric;
$LBD_CaptchaConfig->CodeTimeout = 1200;
$LBD_CaptchaConfig->Locale = 'en-US';
$LBD_CaptchaConfig->CustomCharset = '';
$LBD_CaptchaConfig->BannedSequences = '';

// Captcha image configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->ImageStyle = ImageStyle::AncientMosaic;
$LBD_CaptchaConfig->ImageWidth = 250;
$LBD_CaptchaConfig->ImageHeight = 50;
$LBD_CaptchaConfig->ImageFormat = ImageFormat::Jpeg;
$LBD_CaptchaConfig->CustomDarkColor = '';
$LBD_CaptchaConfig->CustomLightColor = '';
$LBD_CaptchaConfig->ImageTooltip = 'CAPTCHA';

// Captcha sound configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->SoundEnabled = true;
$LBD_CaptchaConfig->SoundStyle = SoundStyle::Workshop;
$LBD_CaptchaConfig->SoundFormat = SoundFormat::WavPcm16bit8kHzMono;
$LBD_CaptchaConfig->SoundTooltip = 'Speak the CAPTCHA code';
$LBD_CaptchaConfig->WarnAboutMissingSoundPackages = true;
$LBD_CaptchaConfig->SoundStartDelay = 0;

// Captcha reload configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->ReloadEnabled = true;
$LBD_CaptchaConfig->ReloadTooltip = 'Reload the CAPTCHA code';
$LBD_CaptchaConfig->AutoReloadExpiredCaptchas = true;
$LBD_CaptchaConfig->AutoReloadTimeout = 7200;

// Captcha help link configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->HelpLinkEnabled = false;
/*
$LBD_CaptchaConfig->HelpLinkMode = HelpLinkMode::Text;
$LBD_CaptchaConfig->HelpLinkUrl = 'http://captcha.biz/captcha.html';
$LBD_CaptchaConfig->HelpLinkText = '';
*/

// Captcha user input configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->AutoFocusInput = true;
$LBD_CaptchaConfig->AutoClearInput = true;
$LBD_CaptchaConfig->AutoUppercaseInput = true;

// Captcha URL configuration
// ---------------------------------------------------------------------------
$LBD_CaptchaConfig->HandlerUrl = 'BotDetect.php';
$LBD_CaptchaConfig->ReloadIconUrl = LBD_URL_ROOT . 'LBD_ReloadIcon.gif';
$LBD_CaptchaConfig->SoundIconUrl = LBD_URL_ROOT . 'LBD_SoundIcon.gif';
$LBD_CaptchaConfig->LayoutStylesheetUrl = LBD_URL_ROOT . 'LBD_Layout.css';
$LBD_CaptchaConfig->ScriptIncludeUrl = LBD_URL_ROOT . 'LBD_Scripts.js';

CaptchaConfiguration::SaveSettings($LBD_CaptchaConfig);


// Captcha persistence configuration
// ---------------------------------------------------------------------------
function LBD_Persistence_Save($p_Key, $p_Value) {
  // save the given value with the given string key
  $_SESSION[$p_Key] = serialize($p_Value);
}

function LBD_Persistence_Load($p_Key) {
  // load persisted value for the given string key
  if (isset($_SESSION) && array_key_exists($p_Key, $_SESSION)) {
    return unserialize($_SESSION[$p_Key]); // NOTE: returns false in case of failure
  }
}

function LBD_Persistence_Clear($p_Key) {
  // clear persisted value for the given string key
  if (isset($_SESSION) && array_key_exists($p_Key, $_SESSION)) {
    unset($_SESSION[$p_Key]);
  }
}
?>