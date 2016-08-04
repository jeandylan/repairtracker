/**
 * Created by dylan on 26-Jul-16.
 */
app.controller('updateSupplierCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
    $scope.supplierId = $stateParams.supplierId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Supplier details via Json Ajax
     */
    getSupplierData();


    $scope.updateSupplier = function () { //when the submit btn click (function call found in <form> tag on top)

        var supplierUpdateData = {
            first_name: $scope.supplier.first_name,  // array containing customer data
            last_name: $scope.supplier.last_name,
            email: $scope.supplier.email,
            address: $scope.supplier.address,
            home_tel: $scope.supplier.home_tel,
            mobile_tel: $scope.supplier.mobile_tel,
            company: $scope.supplier.company
        };

        var updateUrl = 'api/supplier/' + $scope.supplierId;//using the parameter employeeId from url stored in $scope.employeeId,,this will be used to construct put url
        //put client data to server,
        serverServices.put(updateUrl, supplierUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success", "Done", result.message);
                },
                function (result) {
                    // handle errors here

                    toaster.pop("error", "Failed", result.message);
                }
            );

    };

    function getSupplierData() {

        serverServices.get('api/supplier/' + $scope.supplierId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.supplier = result;
                    console.log(result);
                },
                function (result) {
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
});