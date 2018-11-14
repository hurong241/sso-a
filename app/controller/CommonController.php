<?php
/**
 * 说明:
 *
 * User: 胡熔
 * Date: 2018/11/7
 * Time: 10:18
 */

namespace app\controller;

use Predis;

class commonController extends Controller
{

    private $config;
    private $token;
    protected $redis;

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        date_default_timezone_set('PRC');
        $this->config = include 'config/sso.php';
        $this->redis = new Predis\Client($this->config['redis']);
        $this->_inputHandle();
        $this->_checkLogin();
    }

    /**
     * 接收数据校验
     */
    private function _inputHandle()
    {
        if (!empty($_GET['token'])) {
            //从sso获得token
            $token = trim($_GET['token']);
        } else {
            //之前从sso获得过，后来直接输入网址打开本站
            $token = isset($_COOKIE['token']) ? trim($_COOKIE['token']) : '';
        }
        //@todo token格式检查
        if ($token) {
            if (!$this->_isLegalToken($token)) {
                die('非法操作');
            }
            $tokenValue = $this->redis->get($token);
            if(empty($tokenValue)){
                $token='';
            }

        }
        $this->token = $token;
    }

    /**
     * 是否合法token,由于本地测试无法调sso中心接口，改为在子站点验证
     *
     * @param $token
     * @return bool
     */
    private function _isLegalToken($token)
    {
        //@todo 可以弄个配置，修改此程序，使之兼容本地及线上
        $result = false;
        if (empty($token)) {
            return $result;
        }
        $key = $this->config['aes_key'];
        $aes = new \Aes($key);
        $arr = json_decode($aes->decrypt($token), true);
        if (!empty($arr) && ($arr['key'] == $key)) {
            $result = true;
        }
        return $result;
    }

    /**
     * 检查登录：
     * 如果token非法，则转到sso登录，合法则创建局部会话
     */
    private function _checkLogin()
    {
        $sso_login_url = $this->config['sso_login'];
        if (!$this->token) {
            //token无效，跳到sso登录
            $currentUrl = getHost();
            $goUrl = $sso_login_url . '?redirect=' . urlencode($currentUrl);
            redirect($goUrl);
        } else {
            //创建局部会话
            $this->_createLocalConversation();
        }
    }

    /**
     * 创建局部会话
     */
    private function _createLocalConversation()
    {
        print_r($this->token);
        $sessionId = session_id();
        $redisExpire = $this->config['redis_expire'];
        $host = $_SERVER['HTTP_HOST'];
        $p = stripos($host, 'www');
        if ($p !== false) {
            $host = substr($host, $p + 4);
        }
      //  setcookie('PHPSESSID', $sessionId, time() + $redisExpire, '/', $host);
        setcookie('token', $this->token, time() + $redisExpire, '/', $host);
        $this->redis->setex($this->token, $redisExpire, 1);
    }
}