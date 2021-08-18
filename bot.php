<?php
/*

r10.net @doganemrex
instagram @dogancoder
twitter @DogansQ
R10 ÜZERİNDEN 25 TL VEREREK APİ AÇIK KALDIGI SÜRECE YARARLANABİLECEGİNİZ BİR TOKEN ALABİLİRSİNİZ

Yalnızca $apitoken ve $botToken degişkenini kendinize göre ayarlayınız.

*/

error_reporting(0);
$apitoken = ""; ///BURAYA BİZDEN ALDIGINIZ APİYİ GİREBİLİRSİNİZ.
$botToken = ""; ///TELEGRAM BOTUNUZUN TOKENİ


$website = "https://api.telegram.org/bot".$botToken;
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
$print = print_r($update);
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
if ((strpos($message, "!mp3") === 0)||(strpos($message, "/mp3") === 0)){
  $URL = substr($message, 5);
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://dogan.in/mp3?token=$apitoken&url=$URL",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
  ));
  $response = curl_exec($curl);
  $decode = json_decode($response);
  $audiourl = $decode->url;
  $info = $decode->status;
  if(strpos($info, 'true') !== false) {
      sendAudio($chatId, $audiourl);
  }else{
    sendMessage($chatId, "<b>Bot Yöneticisi İle İletişime Geçin \u{1F972}</b>");
  }
  }elseif((strpos($message, "!start") === 0)||(strpos($message, "/start") === 0)){
    sendMessage($chatId, "<b>Bot Yapımcısı @dogancoder</b>");
  }else{
    sendMessage($chatId, "<b>Geçersiz Komut \u{1F972}</b>");
}
curl_close($ch);
function sendMessage ($chatId, $message){
$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&parse_mode=HTML";
file_get_contents($url);      
}
function sendAudio ($chatId, $audiourl){
$url = $GLOBALS[website]."/sendAudio?chat_id=".$chatId."&audio=".$audiourl;
file_get_contents($url);      
}

?>
