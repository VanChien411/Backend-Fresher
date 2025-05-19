define([
    'Magento_Ui/js/grid/columns/column',
    'ko'
], function (Column, ko) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Magenest_Movie/ui/grid/cells/star-rating'
        },
        getStars: function (value) {
           
            let rating = parseFloat(value) || 0; // Xử lý giá trị không hợp lệ
            let stars = Math.round((rating / 10) * 5);
            let html = '';
            for (let i = 1; i <= 5; i++) {
                html += i <= stars
                    ? '<span class="fa-solid fa-star" style="color: #FFD43B;"></span>'
                    : '<span class="fa-regular fa-star" style="color: #FFD43B;"></span>';

            }
            return html;
        }
    });
});