define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate',
], function($){
    'use strict';
    return function(param) {
        $.validator.addMethod(
            "tableExistRule",
            function(value) {
                $.ajax({
                    url: param.url,
                    data: {value:value},
                    type: 'post',
                    dataType: 'json',
                    success: function (ajax) {
                        localStorage.setItem("tableExistRule",ajax.result);
                    }
                });
                return getFromStorage();
            },
            $.mage.__("Таблица или первичный ключь введены не верно")
        );
    };



    function getFromStorage(){
        let result = localStorage.getItem("tableExistRule");
        localStorage.removeItem("tableExistRule");
        return JSON.parse(result);
    }
});
