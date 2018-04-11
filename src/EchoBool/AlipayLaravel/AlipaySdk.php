<?php
/**
 * Created by PhpStorm.
 * User: luojinyi
 * Date: 2017/6/27
 * Time: 上午11:48
 */

namespace EchoBool\AlipayLaravel;

use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeCloseContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeFastpayRefundQueryContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradePagePayContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeQueryContentBuilder;
use EchoBool\AlipayLaravel\BuilderModel\AlipayTradeRefundContentBuilder;
use EchoBool\AlipayLaravel\Service\ZmxyBorrowService;
use EchoBool\AlipayLaravel\Service\GatewayService;
use EchoBool\AlipayLaravel\Service\AuthService;

class AlipaySdk
{
    public $config;

    /**
     * AlipaySdk constructor.
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function auth() {
        return new AuthService($this->config);
    }

    public function gateway() {
        return new GatewayService($this->config);
    }

    public function zmxyBorrow() {
        return new ZmxyBorrowService($this->config);
    }
}