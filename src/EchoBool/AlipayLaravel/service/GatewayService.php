<?php

/* *
 * 功能：支付宝电脑网站支付
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace EchoBool\AlipayLaravel\Service;

use EchoBool\AlipayLaravel\Request\AlipayMobilePublicMessageCustomSendRequest;
use Log;

class GatewayService extends BaseService {
    function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }
  
    public function valid($isVerifyGW) {
        if (empty ( $_REQUEST["sign"] ) || empty ( $_REQUEST["sign_type"] ) || empty ( $_REQUEST["biz_content"] ) || empty ( $_REQUEST["service"] ) || empty ( $_REQUEST["charset"] )) {
            // 验证芝麻信用的通知
            if(empty($_REQUEST['notify_type']) || empty($_REQUEST["sign"]) || empty($_REQUEST["sign_type"]) || empty($_REQUEST["order_no"])) {
                return false;
            }
        }
        // 先验证签名
        $signVerify = $this->aop->rsaCheckV2 ( $_REQUEST, null, $this->aop->signType);
        if (! $signVerify) {
            // 如果验证网关时，请求参数签名失败，则按照标准格式返回，方便在服务窗后台查看。
            if ($isVerifyGW) {
                $this->verifygw ( false );
            } else {
                return false;
            }
        }
    
        // 验证网关请求
        if ($isVerifyGW) {
            $this->verifygw ( true );
        }
      
        return true;
    }

    public function verifygw($is_sign_success) {
        $biz_content = $_REQUEST["biz_content"];
        $xml = simplexml_load_string ( $biz_content );
        // print_r($xml);
        $EventType = ( string ) $xml->EventType;
        // echo $EventType;
        if ($EventType == "verifygw") {
          if ($is_sign_success) {
            $response_xml = "<success>true</success><biz_content>" . $this->merchantPublicKey . "</biz_content>";
          } else { // echo $response_xml;
            $response_xml = "<success>false</success><error_code>VERIFY_FAILED</error_code><biz_content>null</biz_content>";
          }
          $mysign = $this->aop->alonersaSign($response_xml, $this->aop->rsaPrivateKey, $this->aop->signType);
          $return_xml = "<?xml version=\"1.0\" encoding=\"".$this->aop->postCharset."\"?><alipay><response>".$response_xml."</response><sign>".$mysign."</sign><sign_type>".$this->aop->signType."</sign_type></alipay>";
          echo $return_xml;
          exit ();
        }
      }

    public function getMsg() {
        $biz_content = $_REQUEST["biz_content"];
    
        if(empty($biz_content)) {
          return false;
        }
    
        self::$msgData = array(
          'userinfo' => self::getNode($biz_content, "UserInfo"),
          'client' => self::getNode($biz_content, "FromAlipayUserId"),
          'me' => self::getNode($biz_content, "AppId"),
          'createtime' => self::getNode($biz_content, "CreateTime"),
          'type' => self::getNode($biz_content, "MsgType"),
          'event' => self::getNode($biz_content, "EventType"),
        );
    
        switch ( self::$msgData['type'] ) {
          case 'text':
            self::$msgData['content'] = self::getNode($biz_content, "Text");
            break;
    
          case 'image':
            self::$msgData['mediaid'] = self::getNode($biz_content, "MediaId");
            self::$msgData['format'] = self::getNode($biz_content, "Format");
            break;
    
          case 'event':
            switch ( self::$msgData['event'] ) {
              case 'follow':
              case 'enter':
              // 二维码进入
                $actionParam = self::getNode($biz_content, "ActionParam") ;
                $arr = json_decode ($actionParam);
                $sceneId = $arr->scene->sceneId;
                self::$msgData['eventkey'] = $sceneId;
                break;
              case 'click':
                self::$msgData['eventkey'] = self::getNode($biz_content, "ActionParam") ;
                break;
    
              case 'unfollow':
                # code...
                break;
              default:
                # code...
                break;
            }
    
            break;
    
          default:
            self::$msgData['type'] = 'unknown';
            break;
        }
    
        return true;
      }
    
      public function replyTextMsg( $replyMsg ) {
        $replyMsg = $replyMsg ? : 'Nice to meet you, What can I do for you?';
    
        $biz_content = array (
          'toUserId' => self::$msgData['client'],
          'msgType' => 'text',
          'text' => ['content' => $replyMsg]
        );
        $biz_content = self::$aop->JSON($biz_content);
        $custom_send = new AlipayMobilePublicMessageCustomSendRequest ();
        $custom_send->setBizContent($biz_content);
        self::$aop->execute($custom_send);
      }
    
      public function replyPicTextMsg ( $replyMsg ) {
        foreach ($replyMsg as $item) {
          $articles[] = array(
            'title' => $item['title'],
            'desc' => $item['description'],
            'imageUrl' => $item['picurl'],
            'url' => $item['url'],
            // 'action_name' => $item['action_name']
          );
        }
    
        $biz_content = array (
          'toUserId' => self::$msgData['client'],
          'msgType' => 'image-text',
          'createTime' => time (),
          'articles' => $articles
        );
        $biz_content = self::$aop->JSON($biz_content);
        $custom_send = new AlipayMobilePublicMessageCustomSendRequest ();
        $custom_send->setBizContent($biz_content);
        self::$aop->execute($custom_send);
      }
    
      public function mkAckMsg() {
        $response_xml = "<XML><ToUserId><![CDATA[" . self::$msgData['client'] . "]]></ToUserId><AppId><![CDATA[" . ALIPAY_APPID . "]]></AppId><CreateTime>" . time () . "</CreateTime><MsgType><![CDATA[ack]]></MsgType></XML>";
        $return_xml = self::$aop->signResponse( $response_xml, "UTF-8", ALIPAY_MERCHANT_PRIVATE_KEY_FILE );
        return $return_xml;
      }
}

?>