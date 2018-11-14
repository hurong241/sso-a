<br/>登录了才能看到这个<br/>
<?php
if (!empty($_GET['token'])) {
    $token = trim($_GET['token']);
} else {
    $token = !empty($_COOKIE['token']) ? trim($_COOKIE['token']) : '';
}
$token=!empty($token)?urlencode($token):'';
$host = $_SERVER['HTTP_HOST'];
?>
<a href="http://user.yunindex.com/login/logout?redirect=<?php echo $host;?>&token=<?php echo $token;?>">退出</a>