define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate',
], function($){
    'use strict';
    return function(param) {
        $.validator.addMethod(
            "columnExistRule",
            function(value) {
                let db = $("#listing_db").val();
                $.ajax({
                    url: param.url,
                    data: {
                        value:value,
                        db:db
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function (ajax) {
                        localStorage.setItem("columnExistRule",ajax.result);
                    }
                });
                return getFromStorage();
            },
            $.mage.__("Имя колонки указанно не верно. (вы указали имя таблицы?)")
        );
    };



    function getFromStorage(){
        let result = localStorage.getItem("columnExistRule");
        localStorage.removeItem("columnExistRule");
        return JSON.parse(result);
    }
});
