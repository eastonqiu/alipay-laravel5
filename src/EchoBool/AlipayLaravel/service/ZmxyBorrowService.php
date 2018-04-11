<?php

/* *
 * 功能：支付宝电脑网站支付
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\Request\ZhimaMerchantOrderRentCompleteRequest;
use EchoBool\AlipayLaravel\Request\ZhimaMerchantOrderRentQueryRequest;
use EchoBool\AlipayLaravel\Request\ZhimaMerchantOrderRentCancelRequest;
use EchoBool\AlipayLaravel\Request\ZhimaMerchantBorrowEntityUploadRequest;

class ZmxyBorrowService extends BaseService {
    function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }
  
    public function zhimaOrderRentComplete($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new ZhimaMerchantOrderRentCompleteRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        return $response->zhima_merchant_order_rent_complete_response;
    }

    public static function zhimaOrderRentQuery($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new ZhimaMerchantOrderRentQueryRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        return $response->zhima_merchant_order_rent_query_response;
    }

    public static function zhimaOrderRentCancel($biz) {
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new ZhimaMerchantOrderRentCancelRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        return $response->zhima_merchant_order_rent_cancel_response;
    }

    public static function zhimaBorrowEntityUpload($biz){
        $bizContent = $this->json($biz);
        //打印业务参数
        $this->writeLog($bizContent);

        $request = new ZhimaMerchantBorrowEntityUploadRequest();
        $request->setBizContent($bizContent);
        $response = $this->aopclientRequestExecute($request);
        return $response->zhima_merchant_borrow_entity_upload_response;
    }
}

?>