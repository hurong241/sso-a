<?php
/**
 * 说明:
 *
 * User: 胡熔
 * Date: 2018/11/8
 * Time: 12:21
 */
namespace app\controller;

class IndexController extends Controller
{
    private $config;
    public function index(){
        $this->config = include 'config/sso.php';
        $sso_logout_url=$this->config['sso_loginout'];
    }
}