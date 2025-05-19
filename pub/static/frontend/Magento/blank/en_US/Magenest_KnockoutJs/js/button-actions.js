define([
    'jquery',
    'uiComponent',
    'ko',
    'Magento_Ui/js/modal/modal'
], function ($, Component, ko, modal) {
    'use strict';

    return Component.extend({

        userName: ko.observable(''),
        password: ko.observable(''),

        initialize: function () {
            this._super();

            // Áp dụng binding vào login modal khi component đã sẵn sàng
            ko.applyBindings(this, document.getElementById('login-modal'));

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


        },
        loginUser: function () {
            alert("Logging in as: " + this.userName() + " " + this.password());
            return false; // tránh reload trang
        }
    });
});