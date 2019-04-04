<?php

namespace fat\lib;

class Config
{
    public static $third_app_id;//第三方appid
    public static $third_app_secret;//第三方secret
    public static $third_token;//第三方token
    public static $third_encoding_aes_key;//第三方会话密钥
    public static $component_access_token;//第三方令牌

    public static $authorizer_access_token;//授权方小程序令牌
    public static $app_id;//授权方小程序appid
}