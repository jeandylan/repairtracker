/**
 * Created by dylan on 17-Jun-16.
 */
app.controller("readAllCustomersCtrl",function ($scope, $q, readCustomersService) {

    $scope.rowCollection = [];  // base collection
    $scope.displayedCollection = [].concat($scope.rowCollection);  // displayed collection

    readCustomersService.readAllCustomers() //using service (customer/service/clientService ) that will query Laravel for .json output
        .then(
            function (result) {
                $scope.rowCollection = result;
                $scope.displayedCollection = [].concat($scope.rowCollection);

            },
            function (error) {
                // handle errors here
                $scope.customers=error;
            }
        );



});