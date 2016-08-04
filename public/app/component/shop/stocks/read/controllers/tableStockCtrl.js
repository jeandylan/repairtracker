/**
 * Created by dylan on 27-Jul-16.
 */
app.controller("tableStockCtrl",function ($scope,serverServices,$uibModal,toaster) {
    getAllStocksData();

    function getAllStocksData() {
        serverServices.get('api/stocks').then(function (response) {
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

    $scope.deleteStockBtn=function (stockId,stockName) {

        $scope.deleteUrl = "api/stock/"+stockId;
        $scope.confirmBoxMessage="do you want to delete stock  "+stockName;

        var modalInstance = $uibModal.open({
            animation:1,
            templateUrl:'app/component/shop/deleteConfirmation/view/delete-modal-template.html' ,
            controller: 'deleteModalCtrl',
            resolve: {
                deleteUrl: function () {
                    return $scope.deleteUrl;
                },
                confirmBoxMessage:function () {
                    return $scope.confirmBoxMessage;
                }

            }
        });

        modalInstance.result.then(function () {
            //btn ok(confrim delete) was clicked on popup/modal call function ,delete was done On deleteModalCtrl(return a cleint Id)...We need to refresh data..
            getAllStocksData();
        }, function () {
            toaster.pop('error', "Server Error : ", "An error ocuured ,try reload the page");

            //button cancel was click on popup/modal nothing to do
        });
    }
});