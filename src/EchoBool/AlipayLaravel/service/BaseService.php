<?php

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\AopClient;

class BaseService {

    protected $merchantPublicKey;
    protected $aop;

    function __construct($alipay_config)
    {
        $this->aop = new AopClient ();
        $this->aop->gatewayUrl = $alipay_config['gateway_url'];
        $this->aop->appId = $alipay_config['app_id'];
        $this->aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $this->aop->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
        $this->aop->apiVersion = "1.0";
        $this->aop->postCharset = $alipay_config['charset'];
        $this->aop->format = 'json';
        $this->aop->signType = $alipay_config['sign_type'];

        $this->merchantPublicKey = $alipay_config['merchant_public_key'];

        // 开启页面信息输出
        $this->aop->debugInfo = true;

        if (empty($this->aop->appId) || trim($this->aop->appId) == "") {
            throw new \Exception("appid should not be NULL!");
        }
        if (empty($this->aop->rsaPrivateKey) || trim($this->aop->rsaPrivateKey) == "") {
            throw new \Exception("private_key should not be NULL!");
        }
        if (empty($this->aop->alipayrsaPublicKey) || trim($this->aop->alipayrsaPublicKey) == "") {
            throw new \Exception("alipay_public_key should not be NULL!");
        }
        if (empty($this->aop->postCharset) || trim($this->aop->postCharset) == "") {
            throw new \Exception("charset should not be NULL!");
        }
        if (empty($this->aop->gatewayUrl) || trim($this->aop->gatewayUrl) == "") {
            throw new \Exception("gateway_url should not be NULL!");
        }

    }
    
    /**
     * sdkClient
     * @param $request 接口请求参数对象。
     * @param $ispage  是否是页面接口，电脑网站支付是页面表单接口。
     * @return $response 支付宝返回的信息
     */
    protected function aopclientRequestExecute($request, $action = '', $authToken = null) {
        if ($action == 'appPay') {
            $result = $this->aop->sdkExecute($request);
        } else {
            $result = $this->aop->execute($request, $authToken);
        }

        //打开后，将报文写入log文件
        $this->writeLog("romotresponse: " . var_export($result, true));
        return $result;
    }

    /**
     * 请确保项目文件有可写权限，不然打印不了日志。
     */
    protected function writeLog($text) {
        \Illuminate\Support\Facades\Log::info($text);
    }

    protected function json($arr) {
        return json_encode($arr,JSON_UNESCAPED_UNICODE);
    }
}