<?php
/**
 * 微信第三方平台开发部分 API
 */

namespace fat\program;

use fat\http\Http;
use fat\lib\ApiList;

class Program
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
     * WechatThird constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        self::$third_app_id = $config['third_app_id'];
        self::$third_app_secret = $config['third_app_secret'];
        self::$third_token = $config['third_token'];
        self::$third_encoding_aes_key = $config['third_encoding_aes_key'];
        self::$component_access_token = $config['component_access_token'];

        $this->app_id = $config['app_id'];
        $this->authorizer_access_token = $config['authorizer_access_token'];
    }

    /**
     * access_token    请使用第三方平台获取到的该小程序授权的authorizer_access_token
     *
     * @param array $data
     *
     * action    add添加, delete删除, set覆盖, get获取。当参数是get时不需要填四个域名字段
     * requestdomain    request合法域名，当action参数是get时不需要此字段
     * wsrequestdomain    socket合法域名，当action参数是get时不需要此字段
     * uploaddomain    uploadFile合法域名，当action参数是get时不需要此字段
     * downloaddomain    downloadFile合法域名，当action参数是get时不需要此字段
     *
     * @return mixed
     * @throws \Exception
     */
    public function modifyDomain(array $data)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_MODIFY_DOMAIN . $this->authorizer_access_token;

        $r = Http::httpPost($url, $data, true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 添加授权方小程序服务器域名
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function addModifyDomain(array $data)
    {
        $data['action'] = 'add';
        $json = $this->modifyDomain($data);

        return $json['errcode'] ? false : true;
    }

    /**
     * 删除授权方小程序服务器域名
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function delModifyDomain(array $data)
    {
        $data['action'] = 'delete';
        $json = $this->modifyDomain($data);

        return $json['errcode'] ? false : true;
    }

    /**
     * 覆盖设置授权方小程序服务器域名
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function setModifyDomain(array $data)
    {
        $data['action'] = 'set';
        $json = $this->modifyDomain($data);

        return $json['errcode'] ? false : true;
    }

    /**
     * 获取授权方小程序服务器域名
     *
     * @return mixed
     * @throws \Exception
     */
    public function getModifyDomain()
    {
        return $this->modifyDomain([
            'action' => 'get',
        ]);
    }

    /**
     * access_token    请使用第三方平台获取到的该小程序授权的authorizer_access_token
     *
     * @param array $data
     *
     * action    add添加, delete删除, set覆盖, get获取。当参数是get时不需要填四个域名字段
     * requestdomain    request合法域名，当action参数是get时不需要此字段
     * wsrequestdomain    socket合法域名，当action参数是get时不需要此字段
     * uploaddomain    uploadFile合法域名，当action参数是get时不需要此字段
     * downloaddomain    downloadFile合法域名，当action参数是get时不需要此字段
     *
     * @return mixed
     * @throws \Exception
     */
    public function modifyWebViewDomain(array $data)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_SET_WEB_VIEW_DOMAIN . $this->authorizer_access_token;

        $r = Http::httpPost($url, $data, true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");
        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 添加授权方小程序业务域名 仅供第三方代小程序调用
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function addModifyWebViewDomain(array $data)
    {
        $data['action'] = 'add';
        $json = $this->modifyWebViewDomain($data);

        return $json['errcode'] ? false : true;
    }

    /**
     * 删除授权方小程序业务域名
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function delModifyWebViewDomain(array $data)
    {
        $data['action'] = 'delete';
        $json = $this->modifyWebViewDomain($data);

        return $json['errcode'] ? false : true;
    }

    /**
     * 覆盖设置授权方小程序业务域名
     *
     * @param array $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function setModifyWebViewDomain(array $data)
    {
        $data['action'] = 'set';
        $json = $this->modifyWebViewDomain($data);

        return $json['errcode'] ? false : true;
    }

    /**
     * 获取授权方小程序业务域名
     *
     * @return mixed
     * @throws \Exception
     */
    public function getModifyWebViewDomain()
    {
        return $this->modifyWebViewDomain([
            'action' => 'get',
        ]);
    }

    /**
     * 查询小程序当前隐私设置（是否可被搜索）
     *
     * 接口返回说明
     * {
     * "status":1, //1表示不可搜索，0表示可搜索
     * "errcode":0,
     * "errmsg":"ok",
     * }
     *
     * @return mixed
     * @throws \Exception
     */
    public function getWxaSearchStatus()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_WXA_SEARCH_STATUS . $this->authorizer_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 设置小程序隐私设置（是否可被搜索）
     *
     * @param $status 1表示不可搜索，0表示可搜索
     *
     *  错误码
     *  0        成功
     *  -1        系统错误
     *  85083    搜索标记位被封禁，无法修改
     *  85084    非法的status值，只能填0或者1
     *
     * @return mixed
     * @throws \Exception
     */
    public function changeWxaSearchStatus($status)
    {
        if (!in_array($status, [0, 1]))
            exception('status error !', ABNORMAL);

        $url = ApiList::API_URL_PREFIX . ApiList::API_CHANGE_WXA_SEARCH_STATUS . $this->authorizer_access_token;

        $r = Http::httpPost($url, ['status' => $status], true);//1表示不可搜索，0表示可搜索
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 获取体验者列表
     *
     * 0        成功
     * members    人员列表
     * userstr    人员对应的唯一字符串
     *
     * 错误码
     * 0    成功
     * -1    系统错误
     *
     * @return mixed
     * @throws \Exception
     */
    public function memberAuth()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_MEMBER_AUTH . $this->authorizer_access_token;

        $r = Http::httpPost($url, ['action' => 'get_experiencer'], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 绑定微信用户为小程序体验者
     *
     * @param $wechat_id 微信号
     *
     * @return mixed
     * userstr    人员对应的唯一字符串
     *
     * -1        系统繁忙
     * 85001    微信号不存在或微信号设置为不可搜索
     * 85002    小程序绑定的体验者数量达到上限
     * 85003    微信号绑定的小程序体验者达到上限
     * 85004    微信号已经绑定
     *
     * @throws \Exception
     */
    public function bindTester($wechat_id)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_BIND_TESTER . $this->authorizer_access_token;

        $r = Http::httpPost($url, ['wechatid' => $wechat_id], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 解除绑定小程序的体验者
     *
     * @param array $data
     * wechatid    微信号
     * userstr    人员对应的唯一字符串（可通过获取体验者api获取已绑定人员的字符串，userstr和wechatid填写其中一个即可）
     *
     * @return mixed
     * @throws \Exception
     */
    public function unbindTester(array $data)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_UNBIND_TESTER . $this->authorizer_access_token;

        $r = Http::httpPost($url, $data, true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 获取草稿箱内的所有临时代码草稿
     *
     * create_time    说开发者上传草稿时间
     * user_version    模版版本号，开发者自定义字段
     * user_desc    模版描述 开发者自定义字段
     * draft_id        草稿id
     *
     * @return mixed
     * -1        系统繁忙
     * 85064    找不到模版
     * @throws \Exception
     */
    public function getTemplateDraftList()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_TEMPLATE_DRAFT_LIST . ApiList::$component_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tcomponent_access_token=" . ApiList::$component_access_token . "\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);
        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
    }

    /**
     * 获取代码模版库中的所有小程序代码模版
     *
     * create_time    说开发者上传草稿时间
     * user_version    模版版本号，开发者自定义字段
     * user_desc    模版描述 开发者自定义字段
     * template_id    模版id
     *
     * @return mixed
     * -1        系统繁忙
     * 85064    找不到模版
     * @throws \Exception
     */
    public function getTemplateList()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_TEMPLATE_LIST . ApiList::$component_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tcomponent_access_token=" . ApiList::$component_access_token . "\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 将草稿箱的草稿选为小程序代码模版
     *
     * @param $draft_id
     *
     * @return bool
     * -1        系统繁忙
     * 85064    找不到草稿
     * 85065    模版库已满
     *
     * @throws \Exception
     */
    public function addToTemplate($draft_id)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_ADD_TO_TEMPLATE . ApiList::$component_access_token;

        $r = Http::httpPost($url, ['draft_id' => $draft_id], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tcomponent_access_token=" . ApiList::$component_access_token . "\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);
        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            return array($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
    }

    /**
     * 删除指定小程序代码模版
     *
     * @param $template_id
     *
     * @return bool
     * -1        系统繁忙
     * 85064    找不到模板
     * @throws \Exception
     */
    public function deleteTemplate($template_id)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_DELETE_TEMPLATE . ApiList::$component_access_token;
        $r = Http::httpPost($url, ['template_id' => $template_id], true);
        if (!$r)
            exception('post request send fail !', ABNORMAL);
        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            return array($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
    }

    /**
     * 为授权的小程序帐号上传小程序代码
     *
     * @param array $data
     *
     * template_id    代码库中的代码模版ID
     * ext_json        第三方自定义的配置
     * user_version    代码版本号，开发者可自定义
     * user_desc    代码描述，开发者可自定义
     *
     * @return bool
     *
     * -1    系统繁忙
     * 85013    无效的自定义配置
     * 85014    无效的模版编号
     * 85043    模版错误
     * 85044    代码包超过大小限制
     * 85045    ext_json有不存在的路径
     * 85046    tabBar中缺少path
     * 85047    pages字段为空
     * 85048    ext_json解析失败
     *
     * @throws \Exception
     */
    public function commitCode(array $data)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_COMMIT . $this->authorizer_access_token;

        $r = Http::httpPost($url, $data, true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 获取体验小程序的体验二维码
     *
     * @param $path 指定体验版二维码跳转到某个具体页面（如果不需要的话，则不需要填path参数，可在路径后以“?参数”方式传入参数）
     *              具体的路径加参数需要urlencode，比如page/index?action=1编码后得到page%2Findex%3Faction%3D1
     *
     * @return bool|mixed
     *
     * 返回说明（正确情况下的返回HTTP头如下）：
     * HTTP/1.1 200 OK
     * Connection: close
     * Content-Type: image/jpeg
     * Content-disposition: attachment; filename="QRCode.jpg"
     * Date: Sun, 06 Jan 2013 10:20:18 GMT
     * Cache-Control: no-cache, must-revalidate
     * Content-Length: 339721
     *
     * @throws \Exception
     */
    public function getQrcode($path)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_QRCODE . $this->authorizer_access_token . '&path=' . urlencode($path);

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        $r_json = json_decode($r, true);
        if ($r && $r_json && isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r;
    }

    /**
     * 获取授权小程序帐号的可选类目
     *
     * @return mixed
     *
     * 参数    说明
     * category_list    可填选的类目列表
     * first_class    一级类目名称
     * second_class    二级类目名称
     * third_class    三级类目名称
     * first_id        一级类目的ID编号
     * second_id    二级类目的ID编号
     * third_id        三级类目的ID编号
     *
     * -1    系统繁忙
     * @throws \Exception
     */
    public function getCategory()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_CATEGORY . $this->authorizer_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 获取小程序的第三方提交代码的页面配置（仅供第三方开发者代小程序调用）
     *
     * @return mixed
     * page_list    page_list 页面配置列表
     *
     * -1        系统繁忙
     * 86000    不是由第三方代小程序进行调用
     * 86001    不存在第三方的已经提交的代码
     *
     * @throws \Exception
     */
    public function getPage()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_PAGE . $this->authorizer_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）
     *
     * @param array $data
     *
     * item_list    提交审核项的一个列表（至少填写1项，至多填写5项）
     * address        小程序的页面，可通过“获取小程序的第三方提交代码的页面配置”接口获得
     * tag            小程序的标签，多个标签用空格分隔，标签不能多于10个，标签长度不超过20
     * first_class    一级类目名称，可通过“获取授权小程序帐号的可选类目”接口获得
     * second_class    二级类目(同上)
     * third_class    三级类目(同上)
     * first_id        一级类目的ID，可通过“获取授权小程序帐号的可选类目”接口获得
     * second_id    二级类目的ID(同上)
     * third_id        三级类目的ID(同上)
     * title        小程序页面的标题,标题长度不超过32
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "auditid":1234567 审核编号
     * }
     *
     * @return bool
     *
     * -1       系统繁忙
     * 86000    不是由第三方代小程序进行调用
     * 86001    不存在第三方的已经提交的代码
     * 85006    标签格式错误
     * 85007    页面路径错误
     * 85008    类目填写错误
     * 85009    已经有正在审核的版本
     * 85010    item_list有项目为空
     * 85011    标题填写错误
     * 85023    审核列表填写的项目数不在1-5以内
     * 85077    小程序类目信息失效（类目中含有官方下架的类目，请重新选择类目）
     * 86002    小程序还未设置昵称、头像、简介。请先设置完后再重新提交。
     * 85085    近7天提交审核的小程序数量过多，请耐心等待审核完毕后再次提交
     *
     * @throws \Exception
     */
    public function submitAudit(array $data)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_SUBMIT_AUDIT . $this->authorizer_access_token;

        $r = Http::httpPost($url, $data, true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 查询某个指定版本的审核状态（仅供第三方代小程序调用）
     *
     * @param $audit_id
     *
     * {
     * "errcode":0,
     * "errmsg","ok",
     * "status"：1,审核状态，其中0为审核成功，1为审核失败，2为审核中
     * “reason”:"帐号信息不合规范"当status=1，审核被拒绝时，返回的拒绝原因
     * }
     * @return bool
     * -1    系统繁忙
     * 86000    不是由第三方代小程序进行调用
     * 86001    不存在第三方的已经提交的代码
     * 85012    无效的审核id
     *
     * @throws \Exception
     */
    public function getAuditStatus($audit_id)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_AUDIT_STATUS . $this->authorizer_access_token;

        $r = Http::httpPost($url, ['auditid' => $audit_id], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 查询某个指定版本的审核状态（仅供第三方代小程序调用）
     *
     * {
     * "errcode":0,
     * "errmsg","ok",
     * "status"：1,审核状态，其中0为审核成功，1为审核失败，2为审核中
     * “reason”:"帐号信息不合规范"当status=1，审核被拒绝时，返回的拒绝原因
     * }
     * @return bool
     * -1    系统繁忙
     * 86000    不是由第三方代小程序进行调用
     * 86001    不存在第三方的已经提交的代码
     * 85012    无效的审核id
     *
     * @throws \Exception
     */
    public function getLatestAuditStatus()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_GET_LATEST_AUDIT_STATUS . $this->authorizer_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }

    /**
     * 发布已通过审核的小程序（仅供第三方代小程序调用）
     *
     * @return bool
     *
     * -1    系统繁忙
     * 85019    没有审核版本
     * 85020    审核状态未满足发布
     * @throws \Exception
     */
    public function release()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_RELEASE . $this->authorizer_access_token;

        $r = Http::httpPost($url, '{}');
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 修改小程序线上代码的可见状态（仅供第三方代小程序调用）
     *
     * @param $access_status
     *
     * action    设置可访问状态，发布后默认可访问，close为不可见，open为可见
     *
     * @return bool
     *
     * -1        系统繁忙
     * 85021    状态不可变
     * 85022    action非法
     *
     * @throws \Exception
     */
    public function changeVisitStatus($access_status)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_CHANGE_VISIT_STATUS . $this->authorizer_access_token;

        $r = Http::httpPost($url, ['action' => $access_status], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 小程序版本回退
     *
     * @return bool
     *
     * 0        成功
     * -1        系统错误
     * 87011    现网已经在灰度发布，不能进行版本回退
     * 87012    该版本不能回退，可能的原因：1:无上一个线上版用于回退 2:此版本为已回退版本，不能回退 3:此版本为回退功能上线之前的版本，不能回退
     *
     * @throws \Exception
     */
    public function revertCodeRelease()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_REVERT_CODE_RELEASE . $this->authorizer_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 小程序审核撤回
     *
     * 单个帐号每天审核撤回次数最多不超过1次，一个月不超过10次。
     *
     * @return bool
     * 0        成功
     * -1        系统错误
     * 87013    撤回次数达到上限（每天一次，每个月10次）
     *
     * @throws \Exception
     */
    public function undoCodeAudit()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_UNDO_CODE_AUDIT . $this->authorizer_access_token;

        $r = $this->httpGet($url);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return true;
    }

    /**
     * 绑定微信用户为小程序体验者
     *
     *access_token    请使用第三方平台获取到的该小程序授权的authorizer_access_token
     *wechatid    微信号
     * @return json
     * {
     * errcode    错误码
     * errmsg    错误信息
     * userstr    人员对应的唯一字符串
     * }
     *
     * @throws \Exception
     */
    public function bindmember($wechatid)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_MEMBER_BINDTEST . $this->authorizer_access_token;
        $r = Http::httpPost($url, ['wechatid' => $wechatid], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            return array($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
    }

    /**
     * 解除绑定小程序体验者微信用户
     *
     *access_token    请使用第三方平台获取到的该小程序授权的authorizer_access_token
     *wechatid    微信号
     * @return json
     * {
     * errcode    错误码
     * errmsg    错误信息
     * userstr    人员对应的唯一字符串
     * }
     *
     * @throws \Exception
     */
    public function unbindmember($user_str)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_MEMBER_UNBINDTEST . $this->authorizer_access_token;
        $r = Http::httpPost($url, ['userstr' => $user_str], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);
        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            return array($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
    }

    /**
     * 解除绑定小程序体验者微信用户
     *
     *access_token    请使用第三方平台获取到的该小程序授权的authorizer_access_token
     *wechatid    微信号
     * @return json
     * {
     * errcode    错误码
     * errmsg    错误信息
     * userstr    人员对应的唯一字符串
     * }
     *
     * @throws \Exception
     */
    public function unbindmember_null($userstr)
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_MEMBER_UNBINDTEST . $this->authorizer_access_token;
        $r = Http::httpPost($url, ['userstr' => $userstr], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);
        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            return array($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
    }

    /**
     * 体验者列表
     *
     *access_token    请使用第三方平台获取到的该小程序授权的authorizer_access_token
     *wechatid    微信号
     * @return json
     * {
     * errcode    错误码
     * errmsg    错误信息
     * userstr    人员对应的唯一字符串
     * }
     *
     * @throws \Exception
     */
    public function memberauthlist()
    {
        $url = ApiList::API_URL_PREFIX . ApiList::API_MEMBER_LISTMEMBER . $this->authorizer_access_token;
        $r = Http::httpPost($url, ['action' => 'get_experiencer'], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('get request send fail !', ABNORMAL);
        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            return array($r_json['errmsg'], $r_json['errcode']);
        return $r_json;
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

        $r = Http::httpPost($url, ['appid' => $auth_appid], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

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

        $r = Http::httpPost($url, ['appid' => $auth_appid, 'open_appid' => $open_appid], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

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

        $r = Http::httpPost($url, ['appid' => $auth_appid, 'open_appid' => $open_appid], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

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

        $r = Http::httpPost($url, ['appid' => $auth_appid,], true);
        log_w(__CLASS__ . "\t" . __FUNCTION__ . "\tauthorizer_access_token={$this->authorizer_access_token}\tresult={$r}");

        if (!$r)
            exception('post request send fail !', ABNORMAL);

        $r_json = json_decode($r, true);
        if (isset($r_json['errcode']) && $r_json['errcode'])
            exception($r_json['errmsg'], $r_json['errcode']);

        return $r_json;
    }
}
