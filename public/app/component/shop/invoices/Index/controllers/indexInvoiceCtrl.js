/**
 * Created by dylan on 27-Jul-16.
 */
app.controller("suppliersIndexCtrl",function ($scope,$stateParams,$state) {
    $scope.invoiceTab   = [
        {
            heading: '<span class="fa fa-eye text-info" aria-hidden="true"></span>View Invoice',
            route:   'app.invoice.read-all'
        },
        {
            heading: '<span class="fa fa-plus text-info" aria-hidden="true" ></span>create Invoice',
            route:   'app.invoice.create'
        }
    ];



});