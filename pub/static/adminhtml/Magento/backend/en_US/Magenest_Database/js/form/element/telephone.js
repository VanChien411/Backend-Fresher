define([
    'jquery',
    'Magento_Ui/js/form/element/abstract',  // <–– đổi
    'mage/validation'
], function ($, Abstract) {
    'use strict';

    return Abstract.extend({
        defaults: {
            listens: {
                value: 'onValueChange'
            },
            // phải khai báo template dùng cho input
            elementTmpl: 'ui/form/element/input'
        },

        initialize: function () {
            this._super();
            var self = this;
            // DOM của input đã sẵn sàng
            $(this.elem)
                .on('blur', function () {
                    self.convertTelephone();
                    self.triggerValidation();
                })
                .on('keypress', function (e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        self.convertTelephone();
                        self.triggerValidation();
                    }
                });

            return this;
        },

        onValueChange: function () {
            // convert ngay khi gõ
            this.convertTelephone();
        },

        convertTelephone: function () {
            var val = this.value();
            if (typeof val === 'string' && val.indexOf('+84') === 0) {
                this.value('0' + val.substring(3));
            }
        },

        triggerValidation: function () {
            var $input = $(this.elem);
            if ($input.length) {
                $input.valid();
            }
        }
    });
});
