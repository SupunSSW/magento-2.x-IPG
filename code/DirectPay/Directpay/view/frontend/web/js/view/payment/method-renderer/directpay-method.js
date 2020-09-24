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
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            getCode: function () {
                return 'directpay';
            },
            isActive: function () {
                return true;
            },
            redirectAfterPlaceOrder: false,
            // placeOrder: function () {
            //     var self = this;
            //     selectPaymentMethodAction(this.getData());
            //     placeOrderAction(self.getData(), self.messageContainer).done(function () {
            //         fullScreenLoader.startLoader();
            //         customerData.invalidate(['cart']);
            //     });
            //     return false;
            // },
            getData: function() {
                return {
                    'method': this.item.method
                };
            },
            placeMyOrder : function () {
                console.log(this.placeOrder())
                location.replace(url.build('directpay/payment/checkout'))

                console.log(window.checkoutConfig.directpay.merchant_id)
                console.log(window.checkoutConfig.directpay.pay_mode)
                console.log(window.checkoutConfig.directpay.api_key)
                console.log(window.checkoutConfig.directpay.privateKey)
                console.log(window.checkoutConfig.directpay.pay_mode == '0' ? false : true)
                console.log(quote.totals().grand_total)
                console.log(quote.getQuoteId())
                console.log(customer.customerData.email)
                console.log(quote.totals().base_currency_code)
                console.log(quote.billingAddress().telephone)
                console.log(quote.billingAddress().firstname + ' ' + quote.billingAddress().lastname + ', ' + quote.billingAddress().street + ', ' + quote.billingAddress().postcode + ', ' + quote.billingAddress().city)
            },
            dismissOrder: function () {
                fullScreenLoader.startLoader();
                customerData.invalidate(['cart']);
            }
        });
    }
);
