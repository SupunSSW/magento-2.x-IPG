<?php

namespace DirectPay\Directpay\Controller\Page;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Psr\Log\LoggerInterface;


class View extends Action
{
    protected $resultJsonFactory;
    protected $logger;
    protected $scopeConfig;
    protected $_orderHelper;
    protected $_checkoutSession;
    protected $checkoutHelper;
    protected $_order;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        LoggerInterface $logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \DirectPay\Directpay\Helper\OrderData $orderHelper,
        \Magento\Checkout\Helper\Data $checkoutHelper,
        \Magento\Sales\Model\Order $_order
    )
    {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
        $this->checkoutHelper = $checkoutHelper;
        $this->_order = $_order;
        parent::__construct($context);
    }


    public function execute()
    {
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


        $_orderId = $this->getRequest()->getParams();
//        $_order = $this->_order->load($_orderId);

//        $_items = $_order->getAllItems();

        $this->logger->debug(json_encode($_orderId));


//        $session = $this->checkoutHelper->getCheckout();

//        // Load Order
//        $incrementId = $session->getLastRealOrderId();
//        $order       = $this->orderFactory->create()->loadByIncrementId($incrementId);



        return;


        $merchantId = $this->scopeConfig->getValue('payment/directpay/merchantid', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $apiKey = $this->scopeConfig->getValue('payment/directpay/apikey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $paymode = $this->scopeConfig->getValue('payment/directpay/pay_mode', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $privateKey = $this->scopeConfig->getValue('payment/directpay/privateKey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        $this->logger->debug(json_encode($merchantId));
        $this->logger->debug(json_encode($apiKey));
        $this->logger->debug(json_encode($paymode));
        $this->logger->debug(json_encode($privateKey));

        echo '<script>console.log(' . json_encode($merchantId) . ')</script>';


//        $result = $this->resultJsonFactory->create();
//        $data = ['message' => 'Hello World!'];
//        return$result->setData($data);

//        $_order = new Mage_Sales_Model_Order();
//        $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
//        $_order->loadByIncrementId($orderId);
//
//        $sales_order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
//
//        if ($sales_order->getCustomerId() == '') {
//
////guests
//            $first_name = $sales_order->getBillingAddress()->getFirstname();
//            $last_name = $sales_order->getBillingAddress()->getLastname();
//            $email = $sales_order->getBillingAddress()->getEmail();
//            $phone = $sales_order->getBillingAddress()->getTelephone();
//            $address = $sales_order->getBillingAddress()->getStreet();
//            $city = $sales_order->getBillingAddress()->getCity();
//            $country = $sales_order->getBillingAddress()->getCountry();
//
//        } else {
//
////registered users
//            $customer = Mage::getModel('customer/customer')->load($sales_order->getCustomerId());
//            $first_name = $customer->getDefaultBillingAddress()->getFirstname();
//            $last_name = $customer->getDefaultBillingAddress()->getLastname();
//            $email = $customer->getEmail();
//            $phone = $customer->getDefaultBillingAddress()->getTelephone();
//            $address = $customer->getDefaultBillingAddress()->getStreet();
//            $city = $customer->getDefaultBillingAddress()->getCity();
//            $country = $customer->getDefaultBillingAddress()->getCountry();
//
//        }
//
//
//        $base_url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
//        $merchant_id = Mage::getStoreConfig('payment/directpay/merchant_id');
//        $apiKey = Mage::getStoreConfig('payment/directpay/secret_key');
//        $privateKey = Mage::getStoreConfig('payment/directpay/private_key');
//        $test_mode = Mage::getStoreConfig('payment/directpay/test_mode');
//        $currency = Mage::app()->getStore()->getCurrentCurrencyCode();
//
//        if ($test_mode == 1) {
//            $checkout_url = "https://testpay.directpay.lk";
//        } else if ($test_mode == 0) {
//            $checkout_url = "https://pay.directpay.lk";
//        }
//
//
//        $items = $sales_order->getAllVisibleItems();
//        $item_names = array();
//        $item_count = 1;
//        foreach ($items as $i):
//            $item_names[] = $i->getName();
//            $optional_params .=
//                '
//		   <input type="hidden" name="item_name_' . $item_count . '" value="' . $i->getName() . '">
//		   <input type="hidden" name="item_number_' . $item_count . '" value="' . $i->getProductId() . '">
//		   <input type="hidden" name="amount_' . $item_count . '" value="' . number_format((float)$i->getPrice(), 2, '.', '') . '">
//		   <input type="hidden" name="quantity_' . $item_count . '" value="' . round($i->getData('qty_ordered')) . '">
//		  ';
//            $item_count++;
//        endforeach;
//
//
//        $amount = number_format((float)$_order->getBaseGrandTotal(), 2, '.', '');
//        $item_names = implode(", ", $item_names);
//
//
//        $pluginName = "Magento";
//        $pluginVersion = 1.9;
//
//        $success_url = $base_url . "directpay/payment/response";
//
//        $returnUrl = $success_url;
//        $cancelUrl = $base_url . "directpay/payment/cancel";
//        $reponseUrl = $success_url;
//
////data string concat order
//// $dataString = $merchant . $amount . $currency . $pluginName . $pluginVersion . $returnUrl . $cancelUrl . $orderId . $reference . $firstName . $lastName . $email . $description . $apiKey.$reponseUrl;


////data string concat order
//        $dataString = $merchant_id .
//            $amount .
//            $currency .
//            $pluginName .
//            $pluginVersion .
//            $returnUrl .
//            $cancelUrl .
//            $orderId .
//            $orderId .
//            $first_name .
//            $last_name .
//            $email .
//            $item_names .
//            $apiKey .
//            $reponseUrl;
//
//
//        $signature = null;
//        $pkeyid = openssl_pkey_get_private($privateKey);
////Generate signature
//        $signResult = openssl_sign($dataString, $signature, $pkeyid, OPENSSL_ALGO_SHA256);
////Base64 encode the signature
//        $signature = base64_encode($signature);
////Free the key from memory
//        openssl_free_key($pkeyid);

//        $merchantId = $this->scopeConfig->getValue('payment/directpay/merchantid', Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//        $apiKey = $this->scopeConfig->getValue('payment/directpay/apikey', Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//        $paymode = $this->scopeConfig->getValue('payment/directpay/pay_mode', Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//        $privateKey = $this->scopeConfig->getValue('payment/directpay/privateKey', Magento\Store\Model\ScopeInterface::SCOPE_STORE);


        echo '
<form name="directpaycheckoutform" method="post" action="">
    <input type="hidden" name="_mId" value="">
    <input type="hidden" name="api_key" value="">
    <input type="hidden" name="_returnUrl" value="">
    <input type="hidden" name="_cancelUrl" value="">
    <input type="hidden" name="_responseUrl" value="">
    <input type="hidden" name="_amount" value="">
    <input type="hidden" name="_currency" value="">
    <input type="hidden" name="_reference" value="">
    <input type="hidden" name="_orderId" value="">
    <input type="hidden" name="_pluginName" value="">
    <input type="hidden" name="_pluginVersion" value="">
    <input type="hidden" name="_description" value="">
    <input type="hidden" name="_firstName" value="">
    <input type="hidden" name="_lastName" value="">
    <input type="hidden" name="_email" value="">
    <input type="hidden" name="signature" value="">
</form>
<script type="text/javascript">
//    document.directpaycheckoutform.submit();
</script>';
    }

}
