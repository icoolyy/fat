<?php
/**
 * 微信开放平台管理
 */

namespace fat\open;

use fat\http\Http;
use fat\lib\ApiList;
use fat\lib\Config;

class Open
{
    private static $third_app_id;//第三方appid
    private static $third_app_secret;//第三方secret
    private static $third_token;//第三方token
    private static $third_encoding_aes_key;//第三方会话密钥
    private static $component_access_token;//第三方令牌

    private $authorizer_access_token;//授权方小程序令牌
    private $app_id;//授权方小程序appid

    public $errCode = 40001;
    public $errMsg = "no access";

    /**
     * Program constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        self::$third_app_id = $config->third_app_id;
        self::$third_app_secret = $config->third_app_secret;
        self::$third_token = $config->third_token;
        self::$third_encoding_aes_key = $config->third_encoding_aes_key;
        self::$component_access_token = $config->component_access_token;

        $this->app_id = $config->app_id;
        $this->authorizer_access_token = $config->authorizer_access_token;
    }

    /**
     * 创建 开放平台帐号并绑定公众号/小程序
     *
     * 该API用于创建一个开放平台帐号，并将一个尚未绑定开放平台帐号的公众号或小程序绑定至该开放平台帐号上。
     * 新创建的开放平台帐号的主体信息将设置为与之绑定的公众号或小程序的主体。
     *
     * 返回结果示例
     *     {
     *     "open_appid":"appid_value",
     *     "errcode":0,
     *     "errmsg":"ok"
     *     }
     *     结果参数说明
     *     参数    说明
     *     open _appid    所创建的开放平台帐号 的appid
     *     errcode    错误码
     *     errmsg    错误信息
     *     返回码 说明
     *     返回码    说明
     *     0    ok
     *     -1    system error ， 系统错误
     *     40013    invalid appid ， appid 无效。
     *     89000    account has bound open ，该公众号 / 小程序 已经绑定了开放平台帐号
     *
     * @param $auth_appid 授权公众号或小程序的appid
     *
     * @return mixed
     * @throws \Exception
     */
    public function createOpen($auth_appid)
    {
        $url = ApiList::API_URL_PREFIX . self::API_OPEN_CREATE . $this->authorizer_access_token;

        $r = Http::post($url, ['appid' => $auth_appid], true);

        if (!$r) Helper::throwAbnormal();

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode']) Helper::throwAbnormal($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 将 公众号/小程序绑定到开放平台帐号下
     *
     * 该API用于将一个尚未绑定开放平台帐号的公众号或小程序绑定至指定开放平台帐号上。二者须主体相同。
     *
     * 返回结果示例
     *     {
     *     "errcode":0,
     *     "errmsg":"ok"
     *     }
     *     结果参数说明
     *     参数    说明
     *     errcode    错误码
     *     errmsg    错误信息
     *     返回码说明
     *     返回码    说明
     *     0    ok
     *     -1    system error，系统错误
     *     40013    invalid appid，appid或open_appid无效。
     *     89000    account has bound open，该公众号/小程序已经绑定了开放平台帐号
     *     89001    not same contractor，Authorizer与开放平台帐号主体不相同
     *     89003    该开放平台帐号并非通过api创建，不允许操作
     *     89004    该开放平台帐号所绑定的公众号/小程序已达上限（100个）
     *
     * @param $auth_appid 授权公众号或小程序的appid
     * @param $open_appid 开放平台帐号appid
     *
     * @return bool
     * @throws \Exception
     */
    public function bindOpen($auth_appid, $open_appid)
    {
        $url = self::API_URL_PREFIX . self::API_OPEN_BIND . $this->authorizer_access_token;

        $r = Http::post($url, ['appid' => $auth_appid, 'open_appid' => $open_appid], true);

        if (!$r) Helper::throwAbnormal();

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode']) Helper::throwAbnormal($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 将公众号/小程序从开放平台帐号下解绑
     *
     * 该API用于将一个公众号或小程序与指定开放平台帐号解绑。开发者须确认所指定帐号与当前该公众号或小程序所绑定的开放平台帐号一致。
     *
     * 返回结果示例
     *     {
     *     "errcode":0,
     *     "errmsg":"ok"
     *     }
     *     结果参数说明
     *     参数    说明
     *     errcode    错误码
     *     errmsg    错误信息
     *     返回码说明
     *     返回码    说明
     *     0    ok
     *     -1    system error，系统错误
     *     40013    invalid appid，appid或open_appid无效。
     *     89001    not same contractor，Authorizer与开放平台帐号主体不相同
     *     89003    该开放平台帐号并非通过api创建，不允许操作
     *
     * @param $auth_appid 授权公众号或小程序的appid
     * @param $open_appid 开放平台帐号appid
     *
     * @return bool
     * @throws \Exception
     */
    public function unbindOpen($auth_appid, $open_appid)
    {
        $url = self::API_URL_PREFIX . self::API_OPEN_UNBIND . $this->authorizer_access_token;

        $r = Http::post($url, ['appid' => $auth_appid, 'open_appid' => $open_appid], true);

        if (!$r) Helper::throwAbnormal();

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode']) Helper::throwAbnormal($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 获取公众号/小程序所绑定的开放平台帐号
     *
     *该API用于获取公众号或小程序所绑定的开放平台帐号。
     *
     * 返回结果示例
     *     {
     *     "errcode":0,
     *     "errmsg":"ok"
     *     "open_appid":"appid_value",//公众号或小程序所绑定的开放平台帐号的appid
     *     }
     *     结果参数说明
     *     参数    说明
     *     errcode    错误码
     *     errmsg    错误信息
     *     返回码说明
     *     返回码    说明
     *     0    ok
     *     -1    system error，系统错误
     *     40013    invalid appid，appid或open_appid无效。
     *     89002    open not exists，该公众号/小程序未绑定微信开放平台帐号。
     *
     * @param $auth_appid 授权公众号或小程序的appid
     *
     * @return bool
     * @throws \Exception
     */
    public function getOpen($auth_appid)
    {
        $url = self::API_URL_PREFIX . self::API_OPEN_GET . $this->authorizer_access_token;
        $r = Http::post($url, ['appid' => $auth_appid,], true);

        if (!$r) Helper::throwAbnormal();

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode']) Helper::throwAbnormal($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }
}