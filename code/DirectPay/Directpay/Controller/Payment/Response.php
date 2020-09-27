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
    protected $resultRedirectFactory;
    protected $scopeConfig;
    protected $_orderFactory;
    protected $_quoteFactory;
    protected $_checkoutSession;

    public function __construct(
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        Context $context,
        LoggerInterface $logger

    )
    {
        $this->_quoteFactory = $quoteFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->scopeConfig = $scopeConfig;
        $this->_orderFactory = $orderFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->logger = $logger;
        parent::__construct($context);
    }

    public function getOrder()
    {
        if ($this->_checkoutSession->getLastRealOrderId()) {
            return $this->_orderFactory->create()->loadByIncrementId($this->_checkoutSession->getLastRealOrderId());
        }
        return false;
    }

    public function execute()
    {
        $publicKey = $this->scopeConfig->getValue('payment/directpay/publicKey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $postBody = $this->getRequest()->getParams();

        $signature = $postBody['signature'];
        $dataString = $postBody['orderId'] . $postBody['trnId'] . $postBody['status'] . $postBody['desc'];

        $signatureVerify = openssl_verify($dataString, base64_decode($signature), $publicKey, OPENSSL_ALGO_SHA256);

        if ($signatureVerify) {

            $order = $this->getOrder();

            if ($postBody['status'] === 'SUCCESS') {

                $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING, true);
                $order->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING);
                $order->addStatusToHistory($order->getStatus(), 'Payment Processed Successfully.');
                $order->save();

                $quote = $this->_quoteFactory->create()->loadByIdWithoutStore($order->getQuoteId());

                if ($quote->getId()) {
                    $quote->setIsActive(0)->setReservedOrderId(null)->save();
                    $this->_checkoutSession->replaceQuote($quote);
                }

                $this->messageManager->addSuccessMessage('Payment Successful!');
                $this->_redirect('checkout/onepage/success', array('_secure' => false));

            } elseif ($postBody['status'] === 'FAILED') {
                $this->messageManager->addErrorMessage('Payment Failed!');
                $this->_redirect('checkout/cart', array('_secure' => false));
            } else {
                $this->messageManager->addErrorMessage('Payment Failed! Invalid Payment Response.');
                $this->_redirect('checkout/cart', array('_secure' => false));
            }


        } else {
            $this->messageManager->addErrorMessage('Payment Failed! Invalid Payment.');
            $this->_redirect('checkout/cart', array('_secure' => false));
        }

    }


}
