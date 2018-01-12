<?php

// Using shell_exec for better understandability. Use cURL or other http client for production environment.

require_once __DIR__ . '/vendor/autoload.php';

$CHANNEL_ACCESS_TOKEN= "zh275cPTIq0eAPgvrlwd/D9zJAcl6Jsa07NefXgXnpNZW9acevNUrnEpeUblbhNtvEIbzvKRjZMFNa3hQ8AAiP2aMNRn1bvn0SFRQ3WRM3dVYib8HK0JNqHVu+aOKVMzxINBx5RuQNmFnCgsFQf+LQdB04t89/1O/w1cDnyilFU=";
putenv("CHANNEL_ACCESS_TOKEN=$CHANNEL_ACCESS_TOKEN");

$CHANNEL_SECRET="b31e8198da5d4628baed950a6479c1ae";
putenv("CHANNEL_SECRET=$CHANNEL_SECRET");

$httpClient = new LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);
$signature = $_SERVER['HTTP_' . LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
foreach ($events as $event) {

  if ($event instanceof LINE\LINEBot\Event\MessageEvent) {
    if($event instanceof LINE\LINEBot\Event\MessageEvent\TextMessage) {
      
        $bot->replyText($event->getReplyToken(),'test text');
      
    }
  }
}
?>
