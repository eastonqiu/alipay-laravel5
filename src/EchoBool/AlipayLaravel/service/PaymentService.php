<?php

/* *
 * 功能：支付宝电脑网站支付
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\Request\AlipayDataDataserviceBillDownloadurlQueryRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeCloseRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeFastpayRefundQueryRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeAppPayRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeQueryRequest;
use EchoBool\AlipayLaravel\Request\AlipayTradeRefundRequest;

class PaymentService extends BaseService
{
    function __construct($alipay_config)
    {
        parent::__construct($alipay_config);
    }

    /**
     * @param $biz 业务参数
     * alipay.trade.app.pay
     */
    function appPay($biz, $notify_url) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new AlipayTradeAppPayRequest();
        $request->setNotifyUrl($notify_url);
        $request->setBizContent($bizContent);

        // 调用支付api
        $response = $this->aopclientRequestExecute($request, 'appPay');
        //return htmlspecialchars($response);
        return $response;
    }

    /**
     * alipay.trade.query (统一收单线下交易查询)
     * @param $biz 业务参数
     * @return $response 支付宝返回的信息
     */
    function query($biz)
    {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);
        $request = new AlipayTradeQueryRequest();
        $request->setBizContent($bizContent);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_trade_query_response;
        return $response;
    }

    /**
     * alipay.trade.refund (统一收单交易退款接口)
     * @param $biz 业务参数
     * @return $response 支付宝返回的信息
     */
    function refund($biz)
    {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);
        $request = new AlipayTradeRefundRequest();
        $request->setBizContent($bizContent);

        $response = $this->aopclientRequestExecute($request);

        $response = $response->alipay_trade_refund_response;
        return $response;
    }

    /**
     * alipay.trade.close (统一收单交易关闭接口)
     * @param $biz 业务参数
     * @return $response 支付宝返回的信息
     */
    function close($biz)
    {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);
        $request = new AlipayTradeCloseRequest();
        $request->setBizContent($bizContent);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_trade_close_response;
        return $response;
    }

    /**
     * 退款查询   alipay.trade.fastpay.refund.query (统一收单交易退款查询)
     * @param $biz 业务参数
     * @return $response 支付宝返回的信息
     */
    function refundQuery($biz)
    {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);
        $request = new AlipayTradeFastpayRefundQueryRequest();
        $request->setBizContent($bizContent);

        $response = $this->aopclientRequestExecute($request);
        return $response;
    }

    /**
     * alipay.data.dataservice.bill.downloadurl.query (查询对账单下载地址)
     * @param $biz 业务参数
     * @return $response 支付宝返回的信息
     */
    function downloadurlQuery($biz)
    {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);
        $request = new AlipayDataDataserviceBillDownloadurlQueryRequest();
        $request->setBizContent($bizContent);

        $response = $this->aopclientRequestExecute($request);
        $response = $response->alipay_data_dataservice_bill_downloadurl_query_response;
        return $response;
    }
}

?>
