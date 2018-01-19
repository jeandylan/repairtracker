/**
 * Created by dylan on 9/28/16.
 */
app.controller('updateStockLocationCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
    $scope.stockLocationId = $stateParams.stockLocationId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Stock details via Json Ajax
     */
    getStockLocationData();

    function getStockLocationData() {
        console.log($scope.stockLocationId);
        serverServices.get('api/stockLocation/' + $scope.stockLocationId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.stockLocation = result;
                    console.log(result);
                },
                function (result) {
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }

    $scope.updateStockLevel=function () {
        console.log($scope.stockLocation.current_level);
        serverServices.put('api/stockLocation/' + $scope.stockLocationId, {current_level: $scope.stockLocation.current_level})
            .then(function () {

            })
    }


});