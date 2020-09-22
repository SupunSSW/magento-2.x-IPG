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
            placeOrder: function () {
                var self = this;
                selectPaymentMethodAction(this.getData());
                placeOrderAction(self.getData(), self.messageContainer).done(function () {
                    fullScreenLoader.startLoader();
                    customerData.invalidate(['cart']);
                });
                return false;
            },
            placeMyOrder : function () {
                location.replace(url.build('directpay/page/view'))
                $('#payment-form-submit').html('' +
                    '<form id="directpaycheckoutform" method="post" action="'+ ('directpay/page/view') +'">\n' +
                    '    <input type="hidden" name="_mId" value="'+ window.checkoutConfig.directpay.merchant_id +'">\n' +
                    '    <input type="hidden" name="api_key" value="'+ window.checkoutConfig.directpay.api_key +'">\n' +
                    '    <input type="hidden" name="_returnUrl" value="'+ 'ss' +'">\n' +
                    '    <input type="hidden" name="_cancelUrl" value="">\n' +
                    '    <input type="hidden" name="_responseUrl" value="">\n' +
                    '    <input type="hidden" name="_amount" value="'+ quote.totals().grand_total +'">\n' +
                    '    <input type="hidden" name="_currency" value="'+ quote.totals().base_currency_code +'">\n' +
                    '    <input type="hidden" name="_reference" value="'+ quote.billingAddress().firstname + '|' + quote.billingAddress().lastname + '|' + quote.billingAddress().street + '|' + quote.billingAddress().postcode + '|' + quote.billingAddress().city +'">\n' +
                    '    <input type="hidden" name="_orderId" value="'+ quote.getQuoteId() +'">\n' +
                    '    <input type="hidden" name="_pluginName" value="">\n' +
                    '    <input type="hidden" name="_pluginVersion" value="">\n' +
                    '    <input type="hidden" name="_description" value="payment">\n' +
                    '    <input type="hidden" name="_firstName" value="'+ quote.billingAddress().firstname +'">\n' +
                    '    <input type="hidden" name="_lastName" value="' + quote.billingAddress().lastname + '">\n' +
                    '    <input type="hidden" name="_email" value="'+ customer.customerData.email +'">\n' +
                    '</form>' +
                    '');

                // document.getElementById('directpaycheckoutform').submit();


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
            },
            // initDirectay: function () {
            //     window.componentInst = this;
            //     window.quote = quote;
            //     var tel = quote.billingAddress().telephone;
            //     if (tel.length == 10) {
            //         tel = tel.substr(1);
            //         tel = '+94' + tel;
            //     }
            //     window.DirectPayCardPayment.init({
            //         container: 'card_container',
            //         merchantId: window.checkoutConfig.directpay.merchant_id,
            //         amount: quote.totals().grand_total,
            //         refCode: quote.getQuoteId(),
            //         currency: quote.totals().base_currency_code,
            //         type: 'ONE_TIME_PAYMENT',
            //         customerEmail: customer.customerData.email,
            //         customerMobile: tel,
            //         description: quote.billingAddress().firstname + ' ' + quote.billingAddress().lastname + ', ' + quote.billingAddress().street + ', ' + quote.billingAddress().postcode + ', ' + quote.billingAddress().city,  //product or service description
            //         debug: window.checkoutConfig.directpay.pay_mode == '0' ? false : true,
            //         responseCallback: this.responseCallback,
            //         errorCallback: this.errorCallback,
            //         logo: 'https://s3.us-east-2.amazonaws.com/directpay-ipg/directpay_logo.png',
            //         apiKey: window.checkoutConfig.directpay.api_key
            //     });
            //     return "initialized";
            // },
            responseCallback: function (result) {
                console.log('result')
                console.log(result)
                console.log(result.data)
                // if (result.data.status == 'SUCCESS') {
                //     window.componentInst.placeOrder();
                //     $.mage.redirect(url.build("checkout/onepage/success"));
                // } else {
                //     $.mage.redirect(url.build("checkout/onepage/failure"));
                // }
            },
            errorCallback: function (result) {
                window.componentInst.dismissOrder();
            }
        });
    }
);
