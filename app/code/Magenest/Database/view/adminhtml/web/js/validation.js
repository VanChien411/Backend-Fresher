require([
    'jquery',
    'jquery/ui',
    'jquery/validate'
], function ($) {
    $.validator.addMethod(
        'validate-telephone',
        function (value) {
            if (value.startsWith('+84')) {
                value = '0' + value.substring(3);
                $('#telephone').val(value);
            }
            return /^[0][0-9]{9}$/.test(value);
        },
        'Please enter a valid telephone number starting with 0 or +84, with exactly 10 digits.'
    );
});