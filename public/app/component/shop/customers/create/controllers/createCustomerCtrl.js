/**
 * Created by dylan on 26-Jun-16.
 */
app.controller("createCustomerCtrl",function ($scope,$sanitize) {


    $scope.clear = function() {
        $scope.customer.date_of_birth = null;
    };


    $scope.dateOptions = {
        formatYear: 'yy',
        maxDate: new Date(),
        startingDay: 1
    };

    $scope.open1 = function() {
        $scope.popup1.opened = true;
    };
    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    $scope.popup1 = {
        opened: false
    };
    
    
    $scope.createUser=function () {

    }

});
