define([
    'jquery',
    'ko',
    'Magento_Ui/js/form/element/date',
    'jquery/ui'
], function ($, ko, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            options: {
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    var day = date.getDate();
                    return [(day >= 8 && day <= 12), ''];
                },
                showOn: 'both',
                buttonText: 'Select Date'
            }
        },

        /**
         * Initializes datepicker instance after rendering
         */
        initializeDatePicker: function () {
            this._super();
            
            // Thêm xử lý sau khi datepicker được khởi tạo
            var element = this.element;
            if (element) {
                $(element).datepicker('option', 'beforeShowDay', function(date) {
                    var day = date.getDate();
                    return [(day >= 8 && day <= 12), ''];
                });
            }
        }
    });
});