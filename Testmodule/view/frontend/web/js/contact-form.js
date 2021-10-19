define(['jquery', 'uiComponent', 'ko', 'mage/url',
        'mage/storage', 'mage/mage', 'mage/validation',
    'uiRegistry', 'mage/translate'], function ($, Component, ko, urlBuilder, storage,uiRegistry, $t) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Magentomaster_Testmodule/knockout-test'
            },
            initialize: function () {
                this.customerName = '';
                this.customerEmail = '';
                this.customerPhone = '';
                this.customerMessage = '';
                this.formKey = '';
                this._super();
            },
            getFormKey: function () {
                return $.cookie('form_key');
            },

            validate: function () {
                const $form = $('#contact-form')
                $form.validation()
                return $form.valid()
            },
            addNewCustomer: function () {
                var getValidate = this.validate();
                if (getValidate == false) {
                    return false;
                }
                var jsonRequest = {
                    "name": this.customerName,
                    "email": this.customerEmail,
                    "phone": this.customerPhone,
                    "message": this.customerMessage,
                    "form_key": $.cookie('form_key')
                }
                var self = this;
                var body = $('body').loader();
                body.loader('show');

                var serviceUrl = urlBuilder.build('magentomaster-contactform/index/saveform');
                var saveData = $.ajax({
                    type: 'POST',
                    url: serviceUrl,
                    data: jsonRequest,
                    dataType: "text",
                    success: function(resultData) {
                    console.log(resultData)
                        $('#contact-form')[0].reset();
                        body.loader('hide');

                    }
                });
                saveData.error(function() { alert("Something went wrong, Please try again later"); body.loader('hide');
                });


            }
        });
    }
);
