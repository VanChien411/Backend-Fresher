define([
    'jquery',
    'uiComponent',
    'ko'
], function ($, Component, ko) {
    'use strict';

    /**
     * Convert RGB string "rgb(r, g, b)" to "#rrggbb"
     */
    function rgbToHex(rgb) {
        var parts = /^rgba?\(\s*([0-9]+),\s*([0-9]+),\s*([0-9]+)/i.exec(rgb);
        if (!parts) {
            return '#ffffff';
        }
        var r = parseInt(parts[1], 10),
            g = parseInt(parts[2], 10),
            b = parseInt(parts[3], 10),
            hex = '#' + ((1 << 24) | (r << 16) | (g << 8) | b)
                .toString(16)
                .slice(1);
        return hex;
    }

    return Component.extend({
        defaults: {
            template: 'Magenest_ColorSwitch/switcher',
            // nhận các option từ PHP qua đây
            configOptions: []
        },

        /** nơi chứa observableArray thực sự bind vào <select> */
        options: ko.observableArray([]),

        /** giá trị đang chọn */
        selectedColor: ko.observable(''),

        initialize: function () {
            this._super();

            // 1. Lấy màu mặc định của <body>
            var defaultWebColor = rgbToHex(
                window.getComputedStyle(document.body).backgroundColor
            );

            // 2. Merge: đưa màu mặc định lên đầu, rồi nối configOptions (đã truyền từ PHTML)
            var merged = [{label: 'Default color', value: defaultWebColor}]
                .concat(this.configOptions);

            // 3. Khởi tạo observableArray
            this.options(merged);

            // 4. Lấy giá trị đã lưu trong localStorage (nếu có), else default
            var saved = localStorage.getItem('mageBgColor') || defaultWebColor;
            this.selectedColor(saved);

            // 5. Khi user chọn màu mới → subscribe sẽ đổi nền & lưu lại
            this.selectedColor.subscribe(function (newColor) {
                $('body').css('background-color', newColor || '');
                localStorage.setItem('mageBgColor', newColor);
            });

            // 6. Áp dụng màu lần đầu
            $('body').css('background-color', this.selectedColor());

            return this;
        }
    });
});
