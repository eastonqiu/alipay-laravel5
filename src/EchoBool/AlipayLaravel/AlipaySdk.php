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
use EchoBool\AlipayLaravel\Service\ZmxyBorrowTradeService;
use EchoBool\AlipayLaravel\Service\AuthService;

class AlipaySdk
{
    public $auth;
    public $zmxyBorrow;
    public $config;

    /**
     * AlipaySdk constructor.
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->auth = new AuthService($config);
        $this->zmxyBorrow = new ZmxyBorrowService($config);
    }
}