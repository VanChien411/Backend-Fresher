define([
    'Magento_Ui/js/grid/columns/thumbnail'
], function (Thumbnail) {
    'use strict';

    return Thumbnail.extend({
        /**
         * Get image source URL
         * @param {Object} row
         * @returns {String}
         */
        getSrc: function (row) {
            return row.image || ''; // Lấy từ trường "image" trong data
        },

        /**
         * Get alt text
         * @param {Object} row
         * @returns {String}
         */
        getAlt: function (row) {
            return row.title || 'Image';
        }
    });
});
