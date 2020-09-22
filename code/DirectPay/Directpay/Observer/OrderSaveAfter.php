<?php

namespace DirectPay\Directpay\Observer; 

use Magento\Framework\Event\ObserverInterface; 

class OrderSaveAfter implements ObserverInterface
{

	protected $_invoiceService;
	protected $_transactionFactory;
	
	public function __construct(
	  \Magento\Sales\Model\Service\InvoiceService $invoiceService,
	  \Magento\Framework\DB\TransactionFactory $transactionFactory
	) {
	   $this->_invoiceService = $invoiceService;
	   $this->_transactionFactory = $transactionFactory;
	}
	
	public function execute(\Magento\Framework\Event\Observer $observer)
	{
		$order = $observer->getEvent()->getOrder();
		$order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING, true);
		$order->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING);
		$order->addStatusToHistory($order->getStatus(), 'Order processed successfully');
		$order->save();
	}
}