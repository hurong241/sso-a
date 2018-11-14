<?php
/**
 * 说明:
 *
 * User: 胡熔
 * Date: 2018/11/7
 * Time: 10:49
 */

return [
    'sso_login'=>'http://www.sso.com/login',
    'sso_loginout'=>'http://www.sso.com/loginout',
    'sso_check_token'=>'http://www.sso.com/token',
    'redis'=>'tcp://127.0.0.1:6379',
    'redis_expire'=>86400*2,//redis过期时间：秒,建议设置一天以上,子站点务必设置为一样
    'aes_key'=>'Http://www.yunIndex.com@4806',//aes加密Key
];