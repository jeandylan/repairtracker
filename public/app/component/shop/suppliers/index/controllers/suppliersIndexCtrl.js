/**
 * Created by dylan on 23-Jul-16.
 */
app.controller("suppliersIndexCtrl",function ($scope,$stateParams,$state) {
    $scope.supplierTab   = [
        {
            heading: '<span class="fa fa-eye text-info" aria-hidden="true"></span>View Supplier',
            route:   'app.supplier.read-all'
        },
        {
            heading: '<span class="fa fa-plus text-info" aria-hidden="true" ></span>create Supplier',
            route:   'app.supplier.create'
        }
    ];
    


});