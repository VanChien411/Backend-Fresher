define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Ui/js/modal/modal'
], function ($, Component, ko, modal) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            return this;
        },
        showAlert: function () {
            var options = {
                type: 'popup',
                responsive: true,
                title: 'Hello World',
                buttons: []
            };
            var popup = modal(options, $('#hello-modal')); // Store the modal instance
            $('#hello-modal').modal('openModal');
        },
        showLoginModal: function () {
            var options = {
                type: 'popup',
                responsive: true,
                title: 'Login',
                buttons: []
            };
            var popup = modal(options, $('#login-modal')); // Store the modal instance
            $('#login-modal').modal('openModal');
        }
    });
});