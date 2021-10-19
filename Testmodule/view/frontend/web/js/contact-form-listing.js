define(['jquery',
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
], function ($,ko, Component, urlBuilder,storage) {
    'use strict';
    var id=2;
    var totalPages = 0;
    return Component.extend({

        defaults: {
            template: 'Magentomaster_Testmodule/contact-form-list',
        },
        contactformList: ko.observableArray([]),
        initialize: function () {
            this._super();
            id = 1;
            this.getProduct(1);
        },
        getProduct: function (page) {
            var body = $('body').loader();
            body.loader('show');
            var self = this;
            var serviceUrl = urlBuilder.build('magentomaster-contactform/index/contactlistpaginate?id='+id);
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    var resData = JSON.parse(response);
                    $.each(resData,function(key, val){
                        self.contactformList.push(val)
                    });
                    body.loader('hide');
                }
            ).fail(
                function (response) {
                    alert(response);
                    body.loader('hide');
                }
            );
        },

    });
});
