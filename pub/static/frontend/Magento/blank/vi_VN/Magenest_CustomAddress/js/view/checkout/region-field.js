define([
    'uiComponent',
    'Magento_Checkout/js/checkoutData',
    'Magento_Ui/js/model/element/abstract',
    'Magento_Checkout/js/model/quote'
], function (Component, checkoutData, abstract, quote) {
    'use strict';

    return Component.extend({
        initialize: function () {
            this._super();
            var fieldHtml = `
                <div class="field">
                    <label for="vn_region" class="label">
                        <span>Miền (VN Region)</span>
                    </label>
                    <div class="control">
                        <select name="vn_region" id="vn_region" class="select">
                            <option value="1">Miền Bắc</option>
                            <option value="2">Miền Trung</option>
                            <option value="3">Miền Nam</option>
                        </select>
                    </div>
                </div>
            `;
            // Add to both shipping and billing address forms
            setTimeout(function () {
                let shipping = document.querySelector('div[name="shippingAddress.custom_attributes"]');
                let billing = document.querySelector('div[name="billingAddress.custom_attributes"]');
                if (shipping) shipping.insertAdjacentHTML('beforeend', fieldHtml);
                if (billing) billing.insertAdjacentHTML('beforeend', fieldHtml);
                

            }, 2000);
        }
    });
});
