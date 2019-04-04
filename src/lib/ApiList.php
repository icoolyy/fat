<?php
/**
 * 微信第三方平台开发部分 API
 */

namespace fat\lib;

class ApiList
{
    //代码管理获取审核结果 当小程序有审核结果后，第三方平台将可以通过开放平台上填写的回调地址，获得审核结果通知xml。
    const API_URL_PREFIX = 'https://api.weixin.qq.com/';
    const API_MODIFY_DOMAIN = 'wxa/modify_domain?access_token=';//设置小程序服务器域名
    const API_SET_WEB_VIEW_DOMAIN = 'wxa/setwebviewdomain?access_token=';//设置小程序业务域名（仅供第三方代小程序调用）
    const API_BIND_TESTER = 'wxa/bind_tester?access_token=';//绑定微信用户为小程序体验者
    const API_UNBIND_TESTER = 'wxa/unbind_tester?access_token=';//解除绑定小程序的体验者
    const API_MEMBER_AUTH = 'wxa/memberauth?access_token=';//获取体验者列表
    const API_COMMIT = 'wxa/commit?access_token=';//为授权的小程序帐号上传小程序代码
    const API_GET_QRCODE = 'wxa/get_qrcode?access_token=';//获取体验小程序的体验二维码
    const API_GET_CATEGORY = 'wxa/get_category?access_token=';//获取授权小程序帐号的可选类目
    const API_GET_PAGE = 'wxa/get_page?access_token=';//获取小程序的第三方提交代码的页面配置（仅供第三方开发者代小程序调用）
    const API_SUBMIT_AUDIT = 'wxa/submit_audit?access_token=';//将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）
    const API_GET_AUDIT_STATUS = 'wxa/get_auditstatus?access_token=';//查询某个指定版本的审核状态（仅供第三方代小程序调用）
    const API_GET_LATEST_AUDIT_STATUS = 'wxa/get_latest_auditstatus?access_token=';//查询最新一次提交的审核状态（仅供第三方代小程序调用）
    const API_RELEASE = 'wxa/release?access_token=';//发布已通过审核的小程序（仅供第三方代小程序调用）
    const API_CHANGE_VISIT_STATUS = 'wxa/change_visitstatus?access_token=';//修改小程序线上代码的可见状态（仅供第三方代小程序调用）
    const API_REVERT_CODE_RELEASE = 'wxa/revertcoderelease?access_token=';//小程序版本回退（仅供第三方代小程序调用）
    const API_GET_WEAPP_SUPPORT_VERSION = 'cgi-bin/wxopen/getweappsupportversion?access_token=';//查询当前设置的最低基础库版本及各版本用户占比 （仅供第三方代小程序调用）
    const API_SET_WEAPP_SUPPORT_VERSION = 'cgi-bin/wxopen/setweappsupportversion?access_token=';//设置最低基础库版本（仅供第三方代小程序调用）
    const API_QRCODE_JUMP_ADD = 'cgi-bin/wxopen/qrcodejumpadd?access_token=';//设置小程序“扫普通链接二维码打开小程序”能力(1) 增加或修改二维码规则
    const API_QRCODE_JUMP_GET = 'cgi-bin/wxopen/qrcodejumpget?access_token=';//(2)获取已设置的二维码规则
    const API_QRCODE_JUMP_DOWNLOAD = 'cgi-bin/wxopen/qrcodejumpdownload?access_token=';//(3)获取校验文件名称及内容
    const API_QRCODE_JUMP_DELETE = 'cgi-bin/wxopen/qrcodejumpdelete?access_token=';//(4)删除已设置的二维码规则
    const API_QRCODE_JUMP_PUBLISH = 'cgi-bin/wxopen/qrcodejumppublish?access_token=';//(5)发布已设置的二维码规则
    const API_UNDO_CODE_AUDIT = 'wxa/undocodeaudit?access_token=';//小程序审核撤回
    const API_GRAY_RELEASE = 'wxa/grayrelease?access_token=';//小程序分阶段发布 （1）分阶段发布接口
    const API_REVERT_GRAY_RELEASE = 'wxa/revertgrayrelease?access_token=';//(2)取消分阶段发布
    const API_REVERT_GRAY_RELEASE_PLAN = 'wxa/getgrayreleaseplan?access_token=';//（3）查询当前分阶段发布详情
    const API_GET_TEMPLATE_DRAFT_LIST = 'wxa/gettemplatedraftlist?access_token=';//获取草稿箱内的所有临时代码草稿
    const API_GET_TEMPLATE_LIST = 'wxa/gettemplatelist?access_token=';//获取代码模版库中的所有小程序代码模版
    const API_ADD_TO_TEMPLATE = 'wxa/addtotemplate?access_token=';//将草稿箱的草稿选为小程序代码模版
    const API_DELETE_TEMPLATE = 'wxa/deletetemplate?access_token=';//删除指定小程序代码模版
    const API_TEMPLATE_LIBRARY_LIST = 'cgi-bin/wxopen/template/library/list?access_token=';//获取小程序模板库标题列表
    const API_TEMPLATE_LIBRARY_GET = 'cgi-bin/wxopen/template/library/get?access_token=';//获取模板库某个模板标题下关键词库
    const API_TEMPLATE_ADD = 'cgi-bin/wxopen/template/add?access_token=';//组合模板并添加至帐号下的个人模板库
    const API_TEMPLATE_LIST = 'cgi-bin/wxopen/template/list?access_token=';//获取帐号下已存在的模板列表
    const API_TEMPLATE_DEL = 'cgi-bin/wxopen/template/del?access_token=';//删除帐号下的某个模板
    const API_OPEN_CREATE = 'cgi-bin/open/create?access_token=';//创建 开放平台帐号并绑定公众号/小程序
    const API_OPEN_BIND = 'cgi-bin/open/bind?access_token=';//将公众号/小程序绑定到开放平台帐号下
    const API_OPEN_UNBIND = 'cgi-bin/open/unbind?access_token=';//将公众号/小程序从开放平台帐号下解绑
    const API_OPEN_GET = 'cgi-bin/open/get?access_token=';//获取公众号/小程序所绑定的开放平台帐号
    const API_CHANGE_WXA_SEARCH_STATUS = 'wxa/changewxasearchstatus?access_token=';//设置小程序隐私设置（是否可被搜索）
    const API_GET_WXA_SEARCH_STATUS = 'wxa/getwxasearchstatus?access_token=';//查询小程序当前隐私设置（是否可被搜索）
    const API_PLUGIN = 'wxa/plugin?access_token=';//申请使用插件接口 查询已添加的插件 删除已添加的插件
    const API_JSCODE2SESSION = 'sns/component/jscode2session?appid=%s&js_code=%s&grant_type=authorization_code&component_appid=%s&component_access_token=%s';//微信登录
    const API_MEMBER_BINDTEST = 'wxa/bind_tester?access_token=';//绑定微信用户为小程序体验者
    const API_MEMBER_UNBINDTEST = 'wxa/unbind_tester?access_token=';//解绑小程序体验者
    const API_MEMBER_LISTMEMBER = 'wxa/memberauth?access_token=';//小程序体验者列表
}
