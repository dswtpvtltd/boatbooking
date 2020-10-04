define(
  [
      'jquery',
      'ko',
      'uiComponent',
      'jquery/ui',
      'mage/url'
  ],
  function ($,ko, Component,ui,urlBuilder) {
      "use strict";
      
      var listCustomers = ko.observableArray([]);
      
      //Start loader
      var body = $('body').loader();
      body.loader('show');
      
      return Component.extend({

          getProductList : function(){
             if(!listCustomers().length) {
                 var url = urlBuilder.build("boatbooking/boat/productlist");
                  jQuery.ajax({
                      url: url,//'http://localhost:8888/MagentoCE226/boatbooking/boat/productlist',
                      type: 'POST',
                      dataType: 'json',
                      showLoader: true,
                      complete: function (data) {
                          listCustomers(JSON.parse(data.responseText));
                      },
                  });
              }
              
              //Stop loader
              body.loader('hide');
              
              return listCustomers;
          }
      });
  }
);