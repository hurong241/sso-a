<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13/8/2018
 * Time: 11:30 AM
 */

namespace app\controller;

class IndexController extends commonController
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
    }

    /**
     * 首页
     */
    public function index()
    {   
        $this->view('usercenter.index');
    }
}