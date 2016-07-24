/**
 * Created by dylan on 08-Jul-16.
 */
app.controller('deleteCustomerModalCtrl', function ($scope, $uibModalInstance, customerId,customerName,serverServices,toaster) {

    $scope.customerId= customerId;
    $scope.customerName=customerName;
/*
this should be called Only on HTML page with <toaster></toaster> Tag Somewhere
 */
    $scope.ok = function () {
        serverServices.delete('api/customer/' + $scope.customerId).then(function (response) {
                toaster.pop('success', "cleint "+$scope.customerName+" was deleted ");
        },
        function (response) {

        });


        $uibModalInstance.close($scope.customerId);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});