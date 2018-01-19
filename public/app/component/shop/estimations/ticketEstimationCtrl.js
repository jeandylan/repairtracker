/**
 * Created by dylan on 9/20/16.
 */
app.controller('ticketEstimationCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog) {
    $scope.ticketId=$stateParams.ticketId;
    $scope.unsavedEstimationLabours=[];
    $scope.unsavedEstimationStocks=[];
    getEstimates();
    $scope.$on('changeEstimation',function () {
       getEstimates();


    });
    function getEstimates(){
        serverServices.get('api/estimation/'+$scope.ticketId).then(function (result) {
            $scope.estimationStocks=[];
            $scope.estimationLabours=[];
            $scope.estimationStocks=result.stocks;
            $scope.estimationLabours=result.labours;
            console.log(result);

        })
    }
    $scope.deleteEstimationLabour=function (estimationLabour) {

        serverServices.delete('api/estimationLabour/'+estimationLabour.id).then(function (result) {
            $scope.$emit("changeEstimation");
        },function (result) {

        })
    };

    $scope.deleteEstimationStock=function (estimationStock) {

        serverServices.delete('api/estimationItem/'+estimationStock.id).then(function (result) {
            $scope.$emit("changeEstimation");
        },function (result) {

        })
    };

    $scope.updateEstimationStock=function (stock) {
        serverServices.put('api/estimationItem/'+stock.id,stock).then(function () {
            $scope.$emit("changeEstimation");
        },function (result) {

        });

    };

    $scope.updateEstimationLabour=function (labour) {
        serverServices.put('api/estimationLabour/'+labour.id,labour).then(function () {
            $scope.$emit("changeEstimation");
        },function (result) {

        });

    };


    $scope.addUnsavedEstimationLabour=function () {
        $scope.unsavedEstimationLabours.push({});
    };


    $scope.selectStock=function () {

        ngDialog.open({
            template: 'app/component/shop/estimations/select-stock.html',
            controller:'selectStockCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id) $scope.unsavedEstimationStocks.push(data.value);  //add item to potential Stocks
        });
    };

    $scope.createEstimationLabour=function (labour) {
        serverServices.post('api/estimationLabour/'+$scope.ticketId,labour).then(function (result) {
            console.log(result);
            $scope.removeLocally($scope.unsavedEstimationLabours,labour);
            $scope.$emit("changeEstimation");
        },function (result) {
            console.log(result);

        })

    };
    $scope.createEstimationStock=function (stock) {
        if(stock.qty_out) {
            console.log($scope.ticketId)
            serverServices.post('api/estimationItem/' + $scope.ticketId, stock).then(function (result) {
                console.log(result);
                $scope.removeLocally($scope.unsavedEstimationLabours, stock);
                $scope.$emit("changeEstimation");
            })
        }

    };


    $scope.removeLocally=function (arrayObjects,object) {
        index=arrayObjects.indexOf(object);
        if (index > -1) {
            arrayObjects.splice(index, 1);
        }
    };


});