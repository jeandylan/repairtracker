'use strict';

/* Filters */
// need load the moment.js to use this filter. 
angular.module('app').filter('fromNow', function() {
    return function(date) {
      return moment(date).fromNow();
    }
  });
angular.module('app').filter('booleanToString', function() {
    return function(boolean) {
        if (boolean==1){
            return "yes"
        }
        if(boolean==0){
            return 'no'
        }
        return null

    }
    });

angular.module('app')
    .filter('to_trusted', ['$sce', function($sce){
        return function(text) {
            return $sce.trustAsHtml(text);
        };
    }]);
