<?php

namespace DirectPay\Directpay\Controller\Payment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;
use Magento\Sales\Model\Order;
use Magento\Store\Model\StoreManagerInterface;


class Checkout extends Action
{
//    protected $resultJsonFactory;
//    protected $logger;
//    protected $scopeConfig;
//    protected $_orderHelper;
    protected $_checkoutSession;
    protected $orderRepository;
//    protected $checkoutHelper;
//    protected $_order;
    private $order;
    protected $_storeManager;

    protected $_orderFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        LoggerInterface $logger,
        StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \DirectPay\Directpay\Helper\OrderData $orderHelper,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Sales\Model\Order $_order,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Api\Data\OrderInterface $order


    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->checkoutHelper = $checkoutHelper;
        $this->_order = $_order;
        $this->_checkoutSession = $checkoutSession;
        $this->orderRepository = $orderRepository;
        $this->_orderFactory = $orderFactory;
        $this->order = $order;
        $this->_storeManager = $storeManager;
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
//        try {
//            $order = $this->getOrder();
//            if ($order->getState() === Order::STATE_PENDING_PAYMENT) {
//                $payload = $this->getPayload($order);
//                $this->postToCheckout($this->getGatewayConfig()->getGatewayUrl(), $payload);
//            } else if ($order->getState() === Order::STATE_CANCELED) {
//                $errorMessage = $this->getCheckoutSession()->getOxipayErrorMessage(); //set in InitializationRequest
//                if ($errorMessage) {
//                    $this->getMessageManager()->addWarningMessage($errorMessage);
//                    $errorMessage = $this->getCheckoutSession()->unsOxipayErrorMessage();
//                }
//                $this->getCheckoutHelper()->restoreQuote(); //restore cart
//                $this->_redirect('checkout/cart');
//            } else {
//                $this->getLogger()->debug('Order in unrecognized state: ' . $order->getState());
//                $this->_redirect('checkout/cart');
//            }
//        } catch (Exception $ex) {
//            $this->getLogger()->debug('An exception was encountered in oxipay/checkout/index: ' . $ex->getMessage());
//            $this->getLogger()->debug($ex->getTraceAsString());
//            $this->getMessageManager()->addErrorMessage(__('Unable to start Oxipay Checkout.'));
//        }

//        $PostValue = $this->getRequest()->getPost();
//        $this->logger->debug(json_encode($this->configDetails));
//        print_r($PostValue);
//        echo 'ss';

//        $_orderId = $this->getRequest()->getParams();
////        $_order = $this->_order->load($_orderId);
//
////        $_items = $_order->getAllItems();
//
//        $this->logger->debug(json_encode($_items));

        $paymode = $this->scopeConfig->getValue('payment/directpay/pay_mode', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $checkout_url = '';

        if ($paymode == 1) {
            $checkout_url = "https://testpay.directpay.lk";
        } else if ($paymode == 0) {
            $checkout_url = "https://testpay.directpay.lk";
        }

        $incrementId = $this->_checkoutSession->getLastRealOrderId();
//        $order       = $this->orderFactory->create()->loadByIncrementId($incrementId);


        $order = $this->getOrder();

        $this->logger->debug(json_encode($paymode));
//        $this->logger->debug(json_encode($baseUrl));
        $this->logger->debug(json_encode($order->getState()));
        $this->logger->debug(json_encode($order->getId()));
        $this->logger->debug(json_encode($order->getGrandTotal()));
//        $this->logger->debug(json_encode($order->getTotal()));
        $this->logger->debug(json_encode($incrementId));
        $this->logger->debug(json_encode($incrementId));
        $this->logger->debug(json_encode($order->getOrderCurrencyCode()));
        $this->logger->debug(json_encode($order->getTotalDue()));
        $this->logger->debug(json_encode($order->getData('customer_email')));
        $this->logger->debug(json_encode($order->getCustomerFirstname()));
        $this->logger->debug(json_encode($order->getCustomerLastname()));
        $this->logger->debug(json_encode(Order::STATE_PENDING_PAYMENT));
        $this->logger->debug(json_encode(Order::STATE_PENDING_PAYMENT));
        $this->logger->debug(json_encode($this->getPayload($order)));
        $this->logger->debug('');

        $this->postToCheckout($checkout_url, $this->getPayload($order));


//        if ($incrementId) {
//            $this->logger->debug('add');
////            $thisOrder = $this->order->loadByIncrementId($incrementId);
//            $thisOrder = $this->order->loadByIncrementId('000000011');
////            $order = $this->_orderFactory->create()->loadByIncrementId($incrementId);
//            $this->logger->debug('add');
//            $this->logger->debug(json_encode($thisOrder));
//            $this->logger->debug(json_encode($thisOrder->getShippingAddress()));
//            $this->logger->debug(json_encode($thisOrder->getId()));
//            $orderData = $this->orderRepository->get($thisOrder->getId());
//            $this->logger->debug(json_encode($orderData));
//
//
//        }

    }

    private function postToCheckout($checkoutUrl, $payload)
    {
        echo
        "<html>
            <body>
            <form id='directPayCheckoutForm' action='$checkoutUrl' method='post'>";
        foreach ($payload as $key => $value) {
            echo "<input type='text' id='$key' name='$key' value='" . htmlspecialchars($value, ENT_QUOTES) . "'/>";
        }
        echo
        '</form>
            </body>';
        echo
        '<script>
                var form = document.getElementById("directPayCheckoutForm");
                form.submit();
            </script>
        </html>';
    }

    private function getPayload($order)
    {
        if ($order == null) {
            $this->logger->debug('Unable to get order from last order id.');
            $this->_redirect('checkout/onepage/error', array('_secure' => false));
        }

        $merchantId = $this->scopeConfig->getValue('payment/directpay/merchantid', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $apiKey = $this->scopeConfig->getValue('payment/directpay/apikey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $privateKey = $this->scopeConfig->getValue('payment/directpay/privateKey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);

        $grandTotal = number_format((float)$order->getGrandTotal(), 2, '.', '');
        $currency = $order->getOrderCurrencyCode();
        $orderId = $order->getId();
        $pluginName = 'magento-dp';
        $pluginVersion = '2.x';
        $firstName = $order->getCustomerFirstname();
        $lastName = $order->getCustomerLastname();
        $email = $order->getData('customer_email');
        $returnUrl = $baseUrl . 'directpay/payment/response';
        $cancelUrl = $returnUrl;
        $reference = '5';
        $description = '5';
        $responseUrl = $returnUrl;

        $data = array(
            '_mId' => $merchantId,
            'api_key' => $apiKey,
            '_returnUrl' => $returnUrl,
            '_cancelUrl' => $cancelUrl,
            '_responseUrl' => $responseUrl,
            '_amount' => $grandTotal,
            '_currency' => $currency,
            '_reference' => $reference,
            '_orderId' => $orderId,
            '_pluginName' => $pluginName,
            '_pluginVersion' => $pluginVersion,
            '_description' => $description,
            '_firstName' => $firstName,
            '_lastName' => $lastName,
            '_email' => $email
        );

        foreach ($data as $key => $value) {
            $data[$key] = preg_replace('/\r\n|\r|\n/', ' ', $value);
        }

        $dataString = $merchantId .
            $grandTotal .
            $currency .
            $pluginName .
            $pluginVersion .
            $returnUrl .
            $cancelUrl .
            $orderId .
            $reference .
            $firstName .
            $lastName .
            $email .
            $description .
            $apiKey .
            $responseUrl;


        $signature = null;
        $pkeyid = openssl_pkey_get_private($privateKey);
        //Generate signature
        $signResult = openssl_sign($dataString, $signature, $pkeyid, OPENSSL_ALGO_SHA256);
        //Base64 encode the signature
        $signature = base64_encode($signature);
        //Free the key from memory
        openssl_free_key($pkeyid);

        $data['signature'] = $signature;

        return $data;
    }

}
