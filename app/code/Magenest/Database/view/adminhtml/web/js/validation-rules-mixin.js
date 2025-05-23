// view/adminhtml/web/js/validation-rules-mixin.js
define([], function () {
    'use strict';

    return function (rules) {
        rules['validate-telephone'] = {
            handler: function (value) {
                return /^[0][0-9]{9}$/.test(value);
            },
            message: 'Please enter a valid telephone number starting with 0 and exactly 10 digits.'
        };
        return rules;
    };
});
