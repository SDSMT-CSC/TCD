<?php 
session_start();

// There are several Captcha commands accessible through the Http interface;
// first we detect which of the valid commands is the current Http request for.
$commandString = StringHelper::Normalize($_GET['get']);
if (!StringHelper::HasValue($commandString)) {
  HttpHelper::BadRequest('command');
}

$command = CaptchaHttpCommand::FromQuerystring($commandString);
switch ($command) {
  case CaptchaHttpCommand::GetImage:
    GetImage();
    break;
  case CaptchaHttpCommand::GetSound:
    GetSound();
    break;
  case CaptchaHttpCommand::GetValidationResult:
    GetValidationResult();
    break;
  default:
    HttpHelper::BadRequest('command');
    break;
}


// Returns the Captcha image binary data
function GetImage() {

  // saved data for the specified Captcha object in the application
  $captcha = GetCaptchaObject();
  if (is_null($captcha)) {
    HttpHelper::BadRequest('captcha');
  }
  
  // identifier of the particular Captcha object instance 
  $instanceId = GetInstanceId();
  if (is_null($instanceId)) {
    HttpHelper::BadRequest('instance');
  }
  
  while (ob_get_length()) {
    ob_end_clean();
  }
  ob_start();
  try {
    // response headers
    HttpHelper::DisallowCache();
    
    // MIME type
    $mimeType = $captcha->ImageMimeType;
    header("Content-Type: {$mimeType}");
    
    // we don't support content chunking, since image files 
    // are regenerated randomly on each request
    header('Accept-Ranges: none');
    
    // disallow audio file search engine indexing
    header('X-Robots-Tag: noindex, nofollow, noarchive, nosnippet');
    
    // image generation
    $rawImage = $captcha->GetImage($instanceId);
    
    // record generated Captcha code for validation
    $captcha->Save();
    
    $length = strlen($rawImage);
    header("Content-Length: {$length}");
    echo $rawImage;
  } catch (Exception $e) {
    header('Content-Type: text/plain');
    echo $e->getMessage();
  }
  ob_end_flush();
  exit;
}


// Returns the Captcha sound binary data
function GetSound() {

  // saved data for the specified Captcha object in the application
  $captcha = GetCaptchaObject();
  if (is_null($captcha)) {
    HttpHelper::BadRequest('captcha');
  }
  
  // identifier of the particular Captcha object instance 
  $instanceId = GetInstanceId();
  if (is_null($instanceId)) {
    HttpHelper::BadRequest('instance');
  }
  
  while (ob_get_length()) {
    ob_end_clean();
  }
  ob_start();
  try {
    // response headers
    HttpHelper::SmartDisallowCache();
    
    // MIME type
    $mimeType = $captcha->SoundMimeType;
    header("Content-Type: {$mimeType}");
    header('Content-Transfer-Encoding: binary');
    
    // attachment downloading (for the javascript sound player)
    if (empty($_GET['d'])) {
      header("Content-Disposition: attachment; filename=captcha_{$instanceId}.wav");
    }
    
    // we don't support content chunking, since audio files 
    // are regenerated randomly on each request
    header('Accept-Ranges: none');
    
    // disallow audio file search engine indexing
    header('X-Robots-Tag: noindex, nofollow, noarchive, nosnippet');
    
    // sound generation & raw bytes output
    $rawSound = $captcha->GetSound($instanceId);
    $length = strlen($rawSound);
    header("Content-Length: {$length}");
    echo $rawSound;
  } catch (Exception $e) {
    header('Content-Type: text/plain');
    echo $e->getMessage();
  }
  ob_end_flush();
  exit;
}


// Used for client-side validation, returns Captcha validation result as JSON
function GetValidationResult() {

  // saved data for the specified Captcha object in the application
  $captcha = GetCaptchaObject();
  if (is_null($captcha)) {
    HttpHelper::BadRequest('captcha');
  }
  
  // identifier of the particular Captcha object instance 
  $instanceId = GetInstanceId();
  if (is_null($instanceId)) {
    HttpHelper::BadRequest('instance');
  }
  
  // code to validate
  $userInput = GetUserInput();
  
  while (ob_get_length()) {
    ob_end_clean();
  }
  ob_start();
  try {
    // response MIME type & headers
    header('Content-Type: text/javascript');
    header('X-Robots-Tag: noindex, nofollow, noarchive, nosnippet');
    
    // JSON-encoded validation result
    $result = false;
     if (isset($userInput) && (isset($instanceId))) {
      $result = $captcha->Validate($userInput, $instanceId, ValidationAttemptOrigin::Client);
      $captcha->Save();
    }
    $resultJson = GetJsonValidationResult($result);
    echo $resultJson;
  } catch (Exception $e) {
    header('Content-Type: text/plain');
    echo $e->getMessage();
  }
  ob_end_flush();
  exit;
}


// gets Captcha instance according to the CaptchaId passed in querystring
function GetCaptchaObject() {
  $captchaId = StringHelper::Normalize($_GET['c']);
  if (!StringHelper::HasValue($captchaId) ||
      !CaptchaBase::IsValidCaptchaId($captchaId)) {
    return;
  }
  
  $captcha = new CaptchaBase($captchaId);
  return $captcha; 
}


// extract the exact Captcha code instance referenced by the request
function GetInstanceId() {
  $instanceId = StringHelper::Normalize($_GET['t']);
  if (!StringHelper::HasValue($instanceId) ||
      !CaptchaBase::IsValidInstanceId($instanceId)) {
    return;
  }
  return $instanceId;
}


// extract the user input Captcha code string from the Ajax validation request
function GetUserInput() {
  $input = null;
  
  if (isset($_GET['i'])) {
    // BotDetect built-in Ajax Captcha validation
    $input = StringHelper::Normalize($_GET['i']);
  } else {
    // jQuery validation support, the input key may be just about anything,
    // so we have to loop through fields and take the first unrecognized one
    $recognized = array('get', 'c', 't');
    foreach($_GET as $key => $value) {
      if (!in_array($key, $recognized)) {
        $input = $value;
        break;
      }
    }
  }
  
  return $input;
}
    
// encodes the Captcha validation result in a simple JSON wrapper
function GetJsonValidationResult($p_Result) {
  $resultStr = ($p_Result ? 'true': 'false');
  /*return "{ \"result\" : {$resultStr} }";*/
  return $resultStr;
}

?>