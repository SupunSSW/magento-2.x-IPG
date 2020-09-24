<?php

namespace DirectPay\Directpay\Controller\Payment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Magento\Sales\Model\Order;


class Response extends Action
{
    protected $logger;

    protected $_orderFactory;

    public function __construct(
        Context $context,
        LoggerInterface $logger

    )
    {
        $this->logger = $logger;
        parent::__construct($context);
    }


    public function execute()
    {

        $this->logger->debug('debug response');

//        https://127.0.1.1/directpay/payment/response?orderId=17&trnId=78512&status=FAILED&desc=Issuer%20or%20switch%20inoperative&type=ONE_TIME&signature=fP1snUR1pT6jK1AH1ZAXY032icCFp7eIoIBQoP1TFwoOZJjqBghMObf%2BmX48mv8ONDPk7s%2FVvdxIlo6lz8%2F5Vw%3D%3D
//        orderId=17&
//          trnId=78512&
//          status=FAILED&
//          desc=Issuer%20or%20switch%20inoperative&
//          type=ONE_TIME&
//          signature=fP1snUR1pT6jK1AH1ZAXY032icCFp7eIoIBQoP1TFwoOZJjqBghMObf%2BmX48mv8ONDPk7s%2FVvdxIlo6lz8%2F5Vw%3D%3D

//        if($this->getRequest()->isPost()) {
//
//            // If post request came from directpay server
//
//            // if($_SERVER['REMOTE_ADDR']=="18.216.3.222"){
//
//            // 	$postBody = $this->getRequest()->getRawBody();
//            // 	$postBoj = json_decode($postBody);
//
//            // 	$order = Mage::getModel('sales/order');
//            // 	$order->loadByIncrementId($postBoj->orderId);
//            // 	$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Gateway has authorized the payment.');
//
//            // 	$order->sendNewOrderEmail();
//            // 	$order->setEmailSent(true);
//
//            // 	$order->save();
//
//            // }
//
//            $postBody = $this->getRequest()->getRawBody();
//            $postObject = json_decode($postBody);
//
//            $pubKeyid = "-----BEGIN PUBLIC KEY-----
//			MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1Jc9tLbi1OIxpFzJX0DE
//			sMh8J9VyVV67Rqp/qb8YJfK6QOSl7r0/6eOXhemxjGsXzs6RyaJ8Iqn4xr4H0jJs
//			1kEIWyr0s2pOzyb/rovHDsITJkHadaYiNqOWWzeeozATi518bcBoyRaGnmspaWsF
//			AGkVyXroEi/ZnjFXkLlwY5cKXDwyMeJSeTwNsklkiiVW7/moAINId4Gz/bCMDIZh
//			T5kxbEL1xlX+wFvxLpAKweUWS2yNoxcP8DrlvjKfCLHIpzHpHVKmdO9OE0DXpLCZ
//			9PtufTvDWQV2ZftL4POvwF47kCpRUE+6qFzw8//dQONKRTmy4alPls0jZu0tfGcw
//			OQIDAQAB
//			-----END PUBLIC KEY-----";
//
//            $signature = $postObject->signature;
//
//            $dataString =  $postObject->orderId.$postObject->trnId.$postObject->status.$postObject->desc;
//
//            $signatureVerify = openssl_verify($dataString, base64_decode($signature), $pubKeyid, OPENSSL_ALGO_SHA256);
//
//            // if ($signatureVerify == 1) {
//            $order = Mage::getModel('sales/order');
//            $order->loadByIncrementId($postObject->orderId);
//            $order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true, 'Gateway has authorized the payment.');
//
//            $order->sendNewOrderEmail();
//            $order->setEmailSent(true);
//
//            $order->save();
//            // }
//
//        }
//        else{
//            Mage::getSingleton('checkout/session')->unsQuoteId();
//            Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success', array('_secure'=>true));
//        }


//        $postBody = $this->getRequest();
        $postBody = $this->getRequest()->getContent();
        $this->logger->debug('res');
        $this->logger->debug($postBody);


    }


}
