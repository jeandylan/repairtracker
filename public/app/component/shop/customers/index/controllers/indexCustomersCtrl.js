/**
 * Created by dylan on 01-Aug-16.
 */
app.controller("indexCustomersCtrl",function ($scope,$stateParams,$state) {
    $scope.customerTab   = [
        {
            heading: '<span class="fa fa-eye text-info"></span>Table',
            route:   'app.customer.table'
        },
        {
            heading: '<span class="fa fa-plus text-info" ></span>create Customer',
            route:   'app.customer.create'
        }
    ];



});