var config = {
    paths: {
        'fa': 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min'
    },
    shim: {
        'fa': {
            deps: ['jquery']
        }
    },
    map: {
        '*': {
            'Magenest_Movie/js/custom_datepicker': 'Magenest_Movie/js/custom_datepicker'
        }
    }
};