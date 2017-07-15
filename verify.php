<?php
$access_token = 'KuCXzRz4QBneDsSyVFbSPocVsbufOVxWuhs+vg9XlhqkfXfe3JolM41YUAHV6FSo4DbX

+gi4nnn9zb17Z8uV9l5lfPT8H2pt2CklucGNTq3jC3FeGYcBgOBmggeMxMh4EWrfepnTwvwfVzoHKK4LUgdB04t89/1O/w1c

DnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>