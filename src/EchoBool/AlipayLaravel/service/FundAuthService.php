<?php

/* *
 * 功能：支付宝电脑网站支付
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\Request\AlipayFundAuthOrderAppFreezeRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradePayRequest;
use EchoBool\AlipayLaravel\Request\AlipayFundAuthOperationCancelRequest;
use EchoBool\AlipayLaravel\Request\AlipayFundAuthOrderUnfreezeRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeRefundRequest;
use EchoBool\AlipayLaravel\Request\AlipayFundAuthOperationDetailQueryRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeQueryRequest;

class FundAuthService extends BaseService {
    function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }
  
    public function freeze($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayFundAuthOrderAppFreezeRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }

    public static function pay($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayTradePayRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }

    public static function cancel($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayFundAuthOperationCancelRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }

    public static function unfreeze($biz){
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayFundAuthOrderUnfreezeRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }

    public static function refund($biz){
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayTradeRefundRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }

    public static function operationDetailQuery($biz){
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayFundAuthOperationDetailQueryRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }

    public static function tradeQuery($biz){
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayTradeQueryRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        return $response->responseNode;
    }
}

?>