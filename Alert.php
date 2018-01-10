<?php

//產生回傳給line server的格式
$sender_groupid = "Cf730c8b8629a07ea607de980521e2bc7";
$sender_txt = "Alert";
$line_server_url = 'https://api.line.me/v2/bot/message/push';

$response = array (
	"to" => $sender_groupid,
	"messages" => array (
		array (
			"type" => "text",
			"text" => "Hello, YOU SAY ".$sender_txt
		)
	)
);



 //回傳給line server
 $header[] = "Content-Type: application/json";
 $header[] = "Authorization: Bearer zh275cPTIq0eAPgvrlwd/D9zJAcl6Jsa07NefXgXnpNZW9acevNUrnEpeUblbhNtvEIbzvKRjZMFNa3hQ8AAiP2aMNRn1bvn0SFRQ3WRM3dVYib8HK0JNqHVu+aOKVMzxINBx5RuQNmFnCgsFQf+LQdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init($line_server_url);                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);
 curl_close($ch); 

?>
