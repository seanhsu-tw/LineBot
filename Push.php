<?php
 $json_str = file_get_contents('php://input'); //接收REQUEST的BODY
 $json_obj = json_decode($json_str); //轉JSON格式

	$myfile = fopen("log.txt", "w+") or die("Unable to open file!"); //設定一個log.txt，用來印訊息
	fwrite($myfile, "\xEF\xBB\xBF".$json_str); //在字串前加上\xEF\xBB\xBF轉成utf8格式
	
	//產生回傳給line server的格式
	$richmenuId="richmenu-ae9ad2bfdf46e3f44c4bd0fed4c53574";
	$sender_userid = $json_obj->events[0]->source->userId;
	$sender_txt = $json_obj->events[0]->message->text;
	$sender_replyToken = $json_obj->events[0]->replyToken;
	$line_server_url = 'https://api.line.me/v2/bot/message/push';
	switch ($sender_txt) {
		case "upload":
			$line_server_url = 'https://api.line.me/v2/bot/richmenu/$richmenuId/content';
			
			$m_img = imagecreatefrompng("https://i.imgur.com/Ea5ZPDz.png");
			imagealphablending($m_img, false);
			imagesavealpha($m_img, true);
			imagepng($m_img, "controller.png", 0);

			//$imagefile = fopen("controller.png", "w+") or die("Unable to open file!"); //設定一個log.txt，用來印訊息
			//fwrite($imagefile, $json_content); 
			//fclose($imagefile);
			
			$response = array (
				$m_im
			);
			
			break;
		case "create":
			
			$line_server_url = 'https://api.line.me/v2/bot/richmenu';
        		$response=array("size"=> array("width"=> "2500","height"=> "1686"),
			    "selected"=> false,
			    "name"=> "Controller",
			    "chatBarText"=> "Controller",
			    "areas"=> array(array("bounds" => array("x"=> "551","y"=> "325","width"=> "321","height"=> "321"),"action"=>array("type"=> "message","text"=> "up")),
					    array("bounds"=> array("x"=> "876","y"=> "651","width"=> "321","height"=> "321"),"action"=> array("type"=> "message","text"=> "right")),
					    array("bounds"=> array("x"=> "551","y"=> "972","width"=> "321","height"=> "321"),"action"=> array("type"=> "message","text"=> "down")),
					    array("bounds"=> array("x"=> "225","y"=> "651","width"=> "321","height"=> "321"),"action"=> array("type"=> "message","text"=> "left")),
					    array("bounds"=> array("x"=> "1433","y"=> "657","width"=> "367","height"=> "367"),"action"=> array("type"=> "message","text"=> "btn b")),
					    array("bounds"=> array("x"=> "1907","y"=> "657","width"=> "367","height"=> "367"),"action"=> array("type"=> "message","text"=> "btn a"))
					    )
			);
			break;
		case "group":
			$sender_groupid = $json_obj->events[0]->source->groupId;
			$response = array (
				"to" => $sender_groupid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
			break;
    		case "push":
        		$response = array (
				"to" => $sender_userid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
        		break;
    		case "reply":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "text",
						"text" => "Hello, YOU SAY ".$sender_txt
					)
				)
			);
        		break;
		case "image":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "image",
						"originalContentUrl" => "https://www.w3schools.com/css/paris.jpg",
						"previewImageUrl" => "https://www.nasa.gov/sites/default/themes/NASAPortal/images/feed.png"
					)
				)
			);
        		break;
		case "location":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "location",
						"title" => "my location",
						"address" => "〒150-0002 東京都渋谷区渋谷２丁目２１−１",
            					"latitude" => 35.65910807942215,
						"longitude" => 139.70372892916203
					)
				)
			);
        		break;
		case "sticker":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "sticker",
						"packageId" => "1",
						"stickerId" => "1"
					)
				)
			);
        		break;
		case "button":
			$line_server_url = 'https://api.line.me/v2/bot/message/reply';
        		$response = array (
				"replyToken" => $sender_replyToken,
				"messages" => array (
					array (
						"type" => "template",
						"altText" => "this is a buttons template",
						"template" => array (
							"type" => "buttons",
							"thumbnailImageUrl" => "https://www.w3schools.com/css/paris.jpg",
							//"title" => "Menu",
							"text" => "類別",
							"actions" => array (
								array (
									"type" => "postback",
									"label" => "Buy",
									"data" => "action=buy&itemid=123"
								),
								array (
									"type" => "postback",
                   							"label" => "ADSL",
                    							"data" => "action=ADSL&itemid=123"
								),
								array (
									"type" => "postback",
                   							"label" => "FIXLINE",
                    							"data" => "action=ADSL&itemid=123"
								),
								array (
									"type" => "postback",
                   							"label" => "MOD",
                    							"data" => "action=ADSL&itemid=123"
								)
							)
						)
					)
				)
			);
        		break;
    		default:
			$objID = $json_obj->events[0]->message->id;
			$url = 'https://api.line.me/v2/bot/message/'.$objID.'/content';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Authorization: Bearer cCubKq3mCMRx0RcZcoHLDP0r38pPEn5ZkqgTRT0c4fexsmrtN52Fs5kGkQxZYmED5pM1iDsG5M+1si8PS5dgKDs8xF6Qw0DNdddVrMkhc9WJmD1pRVtGqwY4rSNS+/AgkfGoI10hRps8GI//6k7f9AdB04t89/1O/w1cDnyilFU=',
			));
				
			$json_content = curl_exec($ch);
			curl_close($ch);

			$imagefile = fopen($objID.".jpeg", "w+") or die("Unable to open file!"); //設定一個log.txt，用來印訊息
			fwrite($imagefile, $json_content); 
			fclose($imagefile);
        		$header[] = "Content-Type: application/json";
			$post_data = array (
				"requests" => array (
						array (
							"image" => array (
								"source" => array (
									"imageUri" => "http://139.59.123.8/chtChatBot/20180109_LineBot/".$objID.".jpeg"
								)
							),
							"features" => array (
								array (
									"type" => "TEXT_DETECTION",
									"maxResults" => 1
								)
							)
						)
					)
			);
			$ch = curl_init('https://vision.googleapis.com/v1/images:annotate?key=AIzaSyCiyGiCfjzzPR1JS8PrAxcsQWHdbycVwmg');                                                                      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));                                                                  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
			$result = json_decode(curl_exec($ch));
			$result_ary = mb_split("\n",$result -> responses[0] -> fullTextAnnotation -> text);
			$ans_txt = "這張發票沒用了，你又製造了一張垃圾";
			foreach ($result_ary as $val) {
				if($val == "AG-26272435"){
					$ans_txt = "恭喜您中獎啦，快分紅!!";
				}
			}
			$response = array (
				"to" => $sender_userid,
				"messages" => array (
					array (
						"type" => "text",
						"text" => $ans_txt
					)
				)
			);
        		break;
	}

	
	
	//fwrite($myfile, "\xEF\xBB\xBF".json_encode($response)); //在字串前加上\xEF\xBB\xBF轉成utf8格式
	


 //回傳給line server
if($sender_txt=="upload")
{
 $header[] = "Content-Type: image/png";
}
else
{
 $header[] = "Content-Type: application/json";
}
 $header[] = "Authorization: Bearer zh275cPTIq0eAPgvrlwd/D9zJAcl6Jsa07NefXgXnpNZW9acevNUrnEpeUblbhNtvEIbzvKRjZMFNa3hQ8AAiP2aMNRn1bvn0SFRQ3WRM3dVYib8HK0JNqHVu+aOKVMzxINBx5RuQNmFnCgsFQf+LQdB04t89/1O/w1cDnyilFU=";
 $ch = curl_init($line_server_url);                                                                      
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));                                                                  
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
 curl_setopt($ch, CURLOPT_HTTPHEADER, $header);                                                                                                   
 $result = curl_exec($ch);


fwrite($myfile, "\xEF\xBB\xBF".$result); //在字串前加上\xEF\xBB\xBF轉成utf8格式
 fclose($myfile);

 curl_close($ch); 

?>
