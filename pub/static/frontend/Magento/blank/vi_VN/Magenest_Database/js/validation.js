define([
    'jquery',
    'uiComponent',
    'ko',
    'jquery/validate'
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magenest_Database/telephone-field',
            telephone: '', // default value
            config: {
                telephone: ''
            }
        },

        initialize: function () {
            this._super();
            
            // Initialize the observable with the value from options
            this.telephone = ko.observable(this.telephone || '');
            
           // Apply validation method
           $.validator.addMethod(
            'validate-telephone',
            function (value) {
                return /^[0][0-9]{9}$/.test(value);
            },
            'Please enter a valid telephone number starting with 0, with exactly 10 digits.'
        );

            // Subscribe to telephone changes
            this.telephone.subscribe(function (newValue) {
                if (newValue && newValue.startsWith('+84')) {
                    var converted = '0' + newValue.substring(3);
                    this.telephone(converted);
                }
            }, this);

            return this;
        },

        validatePhone: function () {
            var value = this.telephone();
            return /^[0][0-9]{9}$/.test(value);
        }
    });
});