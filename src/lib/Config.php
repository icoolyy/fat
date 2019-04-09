<?php

namespace fat\lib;

class Config
{
    public $third_app_id;//第三方appid
    public $third_app_secret;//第三方secret
    public $third_token;//第三方token
    public $third_encoding_aes_key;//第三方会话密钥
    public $component_access_token;//第三方令牌

    public $authorizer_access_token;//授权方小程序令牌
    public $app_id;//授权方小程序appid

    public $errMsg = 'Param is error !';
    public $errCode = 40001;

    public function __construct(array $config)
    {
        if (
            !$config || !$config['third_app_id'] || !$config['third_app_secret'] || !$config['third_token'] ||
            !$config['third_encoding_aes_key'] || !$config['component_access_token'] ||
            !$config['app_id'] || !$config['authorizer_access_token']
        ) {
            Helper::throwAbnormal($this->errMsg, $this->errCode);
        }

        $this->third_app_id = $config['third_app_id'];
        $this->third_app_secret = $config['third_app_secret'];
        $this->third_token = $config['third_token'];
        $this->third_encoding_aes_key = $config['third_encoding_aes_key'];
        $this->component_access_token = $config['component_access_token'];

        $this->app_id = $config['app_id'];
        $this->authorizer_access_token = $config['authorizer_access_token'];
    }
}