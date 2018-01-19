/**
 * Created by dylan on 10/2/16.
 */
app.controller('updateSuppliedStockCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http,ngDialog) {

    $scope.$on('suppliedStockChanged', function(event) {
        $scope.getSuppliedStock();
    });

    $scope.getSuppliedStock=function () {
        serverServices.get('api/suppliedStock/'+$scope.supplierId).then(function (result) {
            $scope.suppliedStocks=result;
        })
    };
    $scope.getSuppliedStock();

    $scope.deleteSuppliedStock=function (suppliedStock) {
        serverServices.delete('api/suppliedStock/'+$scope.supplierId,{stock_id:suppliedStock.id}).then(function(){
            $scope.$emit('suppliedStockChanged')
        })
    };
    $scope.addSuppliedStock=function (stock) {
        serverServices.post('api/suppliedStock/'+$scope.supplierId,{stock_id:stock.id}).then(function (result) {
            $scope.$emit('suppliedStockChanged');
        })
    }


    $scope.selectStock=function () {
        ngDialog.open({
            template: 'app/component/shop/suppliers/update/views/select-stock.html',
            controller:'selectStockCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id) $scope.addSuppliedStock(data.value);  //add item to potential Stocks
        });
    };
});