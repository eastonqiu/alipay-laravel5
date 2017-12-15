<?php

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\AopClient;

class BaseService {
    //支付宝网关地址
    public $gateway_url = "https://openapi.alipay.com/gateway.do";
    
    //支付宝公钥
    public $alipay_public_key;

    //商户私钥
    public $private_key;

    //应用id
    public $appid;

    //编码格式
    public $charset = "UTF-8";

    public $token = NULL;

    //返回数据格式
    public $format = "json";

    //签名方式
    public $signtype = "RSA2";

    function __construct($alipay_config)
    {
        //dd($alipay_config);
        $this->gateway_url = $alipay_config['gatewayUrl'];
        $this->appid = $alipay_config['app_id'];
        $this->private_key = $alipay_config['merchant_private_key'];
        $this->alipay_public_key = $alipay_config['alipay_public_key'];
        $this->charset = $alipay_config['charset'];
        $this->signtype = $alipay_config['sign_type'];

        if (empty($this->appid) || trim($this->appid) == "") {
            throw new \Exception("appid should not be NULL!");
        }
        if (empty($this->private_key) || trim($this->private_key) == "") {
            throw new \Exception("private_key should not be NULL!");
        }
        if (empty($this->alipay_public_key) || trim($this->alipay_public_key) == "") {
            throw new \Exception("alipay_public_key should not be NULL!");
        }
        if (empty($this->charset) || trim($this->charset) == "") {
            throw new \Exception("charset should not be NULL!");
        }
        if (empty($this->gateway_url) || trim($this->gateway_url) == "") {
            throw new \Exception("gateway_url should not be NULL!");
        }

    }
    
    /**
     * sdkClient
     * @param $request 接口请求参数对象。
     * @param $ispage  是否是页面接口，电脑网站支付是页面表单接口。
     * @return $response 支付宝返回的信息
     */
    protected function aopclientRequestExecute($request, $action = '', $ispage = false) {
        $aop = new AopClient ();
        $aop->gatewayUrl = $this->gateway_url;
        $aop->appId = $this->appid;
        $aop->rsaPrivateKey = $this->private_key;
        $aop->alipayrsaPublicKey = $this->alipay_public_key;
        $aop->apiVersion = "1.0";
        $aop->postCharset = $this->charset;
        $aop->format = $this->format;
        $aop->signType = $this->signtype;
        // 开启页面信息输出
        $aop->debugInfo = true;
        if ($ispage) {
            $result = $aop->pageExecute($request, "post");
            echo $result;
        } else {
            if ($action == 'tradePay') {
                $result = $aop->smtExecute($request);
            } else {
                $result = $aop->execute($request);
            }

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