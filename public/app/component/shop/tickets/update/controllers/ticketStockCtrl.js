/**
 * Created by dylan on 9/21/16.
 */
app.controller("ticketStockCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {
    $scope.unsavedStocks=[];
    //function Stocks

    getStockUsed();

    $scope.$on('changeStockTicket',function (event,data) {
        getStockUsed();

    });

    function getStockUsed(){
        serverServices.get('api/ticketStock/'+$scope.ticketId).then(
            function (result) {
                $scope.usedStocks=result;
            },function (result) {
                console.log(result);
            })
    };

    $scope.saveStock=function (stock) {
        serverServices.post('api/ticketStock/'+$scope.ticketId,stock).then(
            function (result) {
                $scope.removeUnsavedStock(stock);
                $scope.$emit("changeStockTicket");
            },function (result) {

            })
    };

    $scope.updateStock=function(stock){
        serverServices.put('api/ticketStock/'+stock.stock_ticket.id,stock.stock_ticket).then(
            function (result) {
                $scope.$emit("changeStockTicket");
            },function (result) {
                console.log(result);
            })
    };
    $scope.selectStock=function () {
        ngDialog.open({
            template: 'app/component/shop/tickets/update/views/select-stock.html',
            controller:'selectStockCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id) $scope.unsavedStocks.push(data.value);  //add item to potential Stocks
        });
    };
    $scope.removeUnsavedStock=function (stock) {
        index=$scope.unsavedStocks.indexOf(stock);
        if (index > -1) {
            $scope.unsavedStocks.splice(index, 1);
        }
    };

});