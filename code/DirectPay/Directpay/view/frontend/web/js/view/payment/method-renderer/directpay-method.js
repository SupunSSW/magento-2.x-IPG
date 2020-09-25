/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'Magento_Checkout/js/view/payment/default',
        'jquery',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/action/place-order',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Customer/js/customer-data',
        'Magento_Checkout/js/model/full-screen-loader',
        'mage/url'
    ],
    function (Component,
        $,
        quote,
        customer,
        placeOrderAction,
        selectPaymentMethodAction,
        customerData,
        fullScreenLoader,
        url
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'DirectPay_Directpay/payment/directpay'
            },
            initialize: function() {
                this._super();
                self = this;
            },
            getCode: function () {
                return 'directpay';
            },
            isActive: function () {
                return true;
            },
            redirectAfterPlaceOrder: false,
            getData: function() {
                return {
                    'method': this.item.method
                };
            },
            placeMyOrder : function () {
                console.log(window.checkoutConfig.directpay);
            },
            afterPlaceOrder : function () {
                window.location.replace(url.build('directpay/payment/checkout'));
            },
            getDirectPayLogo : function(){
                var logo = window.checkoutConfig.payment.oxipay_gateway.logo;

                return logo;
            },
            dismissOrder: function () {
                fullScreenLoader.startLoader();
                customerData.invalidate(['cart']);
            }
        });
    }
);
