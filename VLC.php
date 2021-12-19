<?php
/*
    Website http://www.alphacyprus.com.cy/
*/

error_reporting(0);
function get_data($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)");
    curl_setopt($ch, CURLOPT_REFERER, "http://www.alphacyprus.com.cy/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$link = get_data("https://www.alphacyprus.com.cy/live");
preg_match_all('/hls.*\'(http.*?m3u8.*?)\'/',$link,$matches);
$stream = $matches[1][0];
$stream = str_replace("\/", "/", $stream);
preg_match_all("/title>(.*?)</",$link,$title_matches);
$title = $title_matches[1][0];
$title = str_replace($title, "Alpha Cyprus", $title);

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo "#EXTM3U\n";
echo "#EXTINF:-1,".$title."\n";
echo $stream;
?>
