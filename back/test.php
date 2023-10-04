<?php
$api = 'http://tinywebdb.appinventor.space/api?user=xjc0317&secret=77e45d31&action=get&tag=用户';
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_RETURNTRANSFER => true,
);
curl_setopt_array($ch, $options);
$result = json_decode(curl_exec($ch));
return $result->status;