<?php
/**
 * Simple Hello World Module
 *
 * @category QaisarSatti
 * @package QaisarSatti_HelloWorld
 * @author Muhammad Qaisar Satti
 * @Email qaisarssatti@gmail.com
 *
 */

namespace DirectPay\Directpay\Controller\Payment;

class Failed extends \Magento\Framework\App\Action\Action
{

    /**
    * @var \Magento\Checkout\Model\Session
    */
    protected $_checkoutSession;

   
    protected $_directpay;

    protected $resultPageFactory;

    /**
     * @var \Magento\Checkout\Helper\Data
     */
    protected $checkoutHelper;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $orderFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Sales\Model\Service\InvoiceService
     */
    protected $invoiceService;

    /**
     * @var \Magento\Framework\DB\Transaction
     */
    protected $dbTransaction;
    
    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \DirectPay\Directpay\Model\DirectPay $directpay
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    
    public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Checkout\Model\Session $checkoutSession,
    \DirectPay\Directpay\Model\DirectPay $directpay,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    \Magento\Checkout\Helper\Data $checkoutHelper,
    \Magento\Sales\Model\OrderFactory $orderFactory,
    \Magento\Sales\Model\Service\InvoiceService $invoiceService,
    \Magento\Framework\DB\Transaction $dbTransaction
    ) {
        $this->_directpay = $directpay;
        $this->_checkoutSession = $checkoutSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->checkoutHelper = $checkoutHelper;
        $this->orderFactory = $orderFactory;
        $this->urlBuilder = $context->getUrl();
        $this->invoiceService = $invoiceService;
        $this->dbTransaction = $dbTransaction;
        parent::__construct($context);
    }

    /**
    * Start form Submission here
    */
    public function execute()
    {


        $session = $this->checkoutHelper->getCheckout();

        // Load Order
        $incrementId = $session->getLastRealOrderId();
        $order       = $this->orderFactory->create()->loadByIncrementId($incrementId);
        if ( ! $order->getId()) {
            $this->checkoutHelper->getCheckout()->restoreQuote();
            $this->messageManager->addError(__('No order for processing found'));
            $this->_redirect('checkout/cart');

            return;
        }

        $message = "Error";

        $order->addStatusHistoryComment($message);
        $session->restoreQuote();
        $this->messageManager->addError($message);
        $this->_redirect('checkout/cart');

        return;

    }

    /**
    * Get order object.
    *
    * @return \Magento\Sales\Model\Order
    */
    protected function getOrder()
    {
        return $this->_checkoutSession->getLastRealOrder();
    }
}