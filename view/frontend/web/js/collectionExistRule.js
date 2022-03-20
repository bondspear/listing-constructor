define([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate',
], function($){
    'use strict';
    return function(param) {
        $.validator.addMethod(
            "collectionExistRule",
            function(value) {
                let module = $("#listing_module").val();
                $.ajax({
                    url: param.url,
                    data: {
                        value:value,
                        module:module
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function (ajax) {
                        localStorage.setItem("collectionExistRule",ajax.result);
                    }
                });
                return getFromStorage();
            },
            $.mage.__("Имя модели введено не верно или модель не существует")
        );
    };



    function getFromStorage(){
        let result = localStorage.getItem("collectionExistRule");
        localStorage.removeItem("collectionExistRule");
        return JSON.parse(result);
    }
});
