/**
 * Created by dylan on 10/2/16.
 */
app.controller('selectSuppliersForPurchaseOrdersCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http,ngDialog) {
    getStockSuppliersData();
    /*
     the get all customer from server function
     */
    function getStockSuppliersData() {
        serverServices.get('api/stockSupplier/'+$scope.stockId).then(function (response) {
                $scope.displayedCollection = [];  // displayed collection--->used by angular scope
                $scope.rowCollection = [];  // base collection--->used to store data from Async from server , to be used by angular Scope
                $scope.rowCollection = response; //update the original Array ,this is used so as to Synchronised Scope with asynchronous data obtain from dserver
                $scope.displayedCollection = [].concat($scope.rowCollection);  ///insert the data from server with the one used by angular scope
            },
            function (error) {
                toaster.pop('error', "Server Error : "+error.status, "An error ocuured ,try reload the page");
                console.log(error);
            });
    }

    $scope.selectThisSupplier=function (row) {
        $scope.closeThisDialog(row);//close and pass The Selec data to the NgDialog promise
    };
});