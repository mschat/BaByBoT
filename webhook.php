<?php
// 1. ใส่ Channel Access Token ที่ได้จาก LINE Developers
$access_token = '2BNK6+03zA3wkBW5E+fBBeS3sfOOFI90fXjiOOq73kjmQUV3wt7hLdi/rLdu/3soVl/6OIwNpVf5XY4IWbBrJFG2iS/k3kJOwOQ6pKj/9iyfzQPHu7BKq1Ypx8czHSG14sGs2XsDC2QsEtamK/C9MAdB04t89/1O/w1cDnyilFU=';

// 2. รับข้อมูลที่ LINE ส่งมา
$content = file_get_contents('php://input');
$events = json_decode($content, true);

// 3. ตรวจสอบว่ามีข้อมูลส่งมาจริงไหม
if (!is_null($events['events'])) {
    foreach ($events['events'] as $event) {
        
        // ตรวจสอบว่าเป็น Message ประเภทข้อความ (Text)
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            
            $replyToken = $event['replyToken']; // ใช้สำหรับตอบกลับ
            $userText = $event['message']['text']; // ข้อความที่ User พิมพ์มา

            // 4. เตรียมข้อมูลสำหรับตอบกลับ (Echo กลับไป)
            $messages = [
                'replyToken' => $replyToken,
                'messages' => [
                    [
                        'type' => 'text',
                        'text' => 'บอทได้รับข้อความว่า: ' . $userText
                    ]
                ]
            ];

            // 5. ส่งข้อมูลกลับไปด้วย cURL
            $url = 'https://api.line.me/v2/bot/message/reply';
            $post = json_encode($messages);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            
            $result = curl_exec($ch);
            curl_close($ch);
        }
    }
}

// ตอบกลับสถานะ 200 ให้ LINE Platform ทราบว่าเราได้รับข้อมูลแล้ว
http_response_code(200);
echo "OK";
