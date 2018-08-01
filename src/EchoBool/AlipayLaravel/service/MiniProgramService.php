<?php

/* *
 * 功能：支付宝电脑网站支付
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\Request\AlipayOpenAppMiniTemplatemessageSendRequest;

class MiniProgramService extends BaseService {
    function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }

    public function sendTemplate($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayOpenAppMiniTemplatemessageSendRequest();
        $request->setBizContent($bizContent);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $response = $this->aopclientRequestExecute($request);
        return $response->$responseNode;
    }
}

?>