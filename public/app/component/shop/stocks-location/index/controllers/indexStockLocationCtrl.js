/**
 * Created by dylan on 27-Jul-16.
 */
app.controller("indexStockLocationCtrl",function ($scope,$stateParams,$state) {
    $scope.stockTab   = [
        {
            heading: '<span class="fa fa-eye text-info" aria-hidden="true"></span>View Stocks',
            route:   'app.stockLocation.table'
        },
        {
            heading: '<span class="fa fa-plus text-info" aria-hidden="true" ></span>create Stock',
            route:   'app.stockLocation.create'
        }
    ];



});