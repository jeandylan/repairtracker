/**
 * Created by dylan on 9/23/16.
 */
app.controller("indexDashboardCtrl",function ($scope,$stateParams,$state) {
    $scope.customerTab   = [
        {
            heading: 'graph',
            route:   'app.dashboard.graph'
        },
        {
            heading: 'Customer',
            route:   'app.customer.customer'
        },
        {
            heading: 'technician',
            route:   'app.customer.technician'
        }
    ];


})