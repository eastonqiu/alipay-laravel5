<?php

/* *
 * 功能：支付宝电脑网站支付
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\Request\AlipaySystemOauthTokenRequest;
use EchoBool\AlipayLaravel\Request\AlipayUserUserinfoShareRequest;

class AuthService extends BaseService {
    function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }
  
    public static function getAuthTokenAndUserId($authCode) {
        $request = new AlipaySystemOauthTokenRequest();
        $request->setCode($authCode);
        $request->setGrantType("authorization_code");
        $response = $this->aopclientRequestExecute($request);
        return $response->alipay_system_oauth_token_response;
    }

    public static function getUserInfo($accessToken) {
        $request = new AlipayUserUserinfoShareRequest();
        $response = $this->aopclientRequestExecute($request, '', $accessToken);
        return $response->alipay_user_userinfo_share_response;
    }
}

?>