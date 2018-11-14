<?php
function getHost()
{
    $server = $_SERVER;
    $port = $server['SERVER_PORT'];
    $port = $port != 80 ?: '';
    $host = $server['REQUEST_SCHEME'] . '://' . $server['HTTP_HOST'] . $port;
    return $host;
}

function redirect($url)
{
    header('Location:' . $url);
}

function get_url_contents($url)
{
//先判断allow_url_fopen是否打开，如果打开则用file_get_contents获取，如果没打开用curl_init获取
    if (ini_get("allow_url_fopen") == "1")
        return file_get_contents($url);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}