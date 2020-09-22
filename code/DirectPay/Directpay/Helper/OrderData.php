<?php
/**
 * @package
 * @version
 * @author      Human-Element, Inc. <info@human-element.com>
 * @copyright   Copyright 2017 Human-Element, Inc.
 **/

namespace DirectPay\Directpay\Helper;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class OrderData extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_orderRepositoryInterface;
    protected $_searchCriteriaBuilder;

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepositoryInterface,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\Helper\Context $context
    )
    {
        $this->_orderRepositoryInterface = $orderRepositoryInterface;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
    }

    public function getOrderInfo($orderId)
    {
        $data = [];
        $this->_searchCriteriaBuilder->addFilter('increment_id', $orderId);
        $orders = $this->_orderRepositoryInterface->getList(
            $this->_searchCriteriaBuilder->create()
        )->getItems();
        if (count($orders)) {
            $order = reset($orders);
            $data = $order->getData();
            foreach ($order->getItems() as $item) {
                $data['items'][$item->getItemId()] = $item->getData();
            }
        }
        return $data;
    }
}
