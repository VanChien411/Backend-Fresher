define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            return this;
        },
        showAlert: function () {
            alert('Hello World!');
        }
    });
});
