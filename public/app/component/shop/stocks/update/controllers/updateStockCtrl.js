/**
 * Created by dylan on 27-Jul-16.
 */
app.controller('updateStockCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
    $scope.stockId = $stateParams.stockId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Stock details via Json Ajax
     */
    getStockData();


    $scope.updateStock = function () { //when the submit btn click (function call found in <form> tag on top)
        var stockUpdateData = {
            product_name: $scope.stock.product_name,  // array containing customer data
            selling_price: $scope.stock.selling_price,
            reorder_level: $scope.stock.reorder_level,
            barcode: $scope.stock.barcode

        };
        var updateUrl = 'api/stock/' + $scope.stockId;//using the parameter employeeId from url stored in $scope.employeeId,,this will be used to construct put url
        //put client data to server,
        serverServices.put(updateUrl, stockUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
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

    function getStockData() {
        serverServices.get('api/stock/' + $scope.stockId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.stock = result;
                    console.log(result);
                },
                function (result) {
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
});