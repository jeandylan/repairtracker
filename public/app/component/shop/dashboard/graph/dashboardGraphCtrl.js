/**
 * Created by dylan on 9/23/16.
 */
app.controller("dashboardGraphCtrl",function ($scope,$stateParams,$state,$timeout,serverServices,$filter) {
    /*genreal function*/
    $scope.series = ['amount '];
    $scope.transformData=function (data,statData,stateLabel) {
        for(var i=0;i<data.length;i++){
            statData[0].push(data[i].amount);
            stateLabel.push($filter('date')(data[i].endDate, "MMMM"));
        }
    };

    /*ticket count*/
    $scope.ticketCountStatData=[[]];
    $scope.ticketCountStatLabels=[];
    $scope.ticketCountStat=function () {
        serverServices.get('api/dashboard/ticket/count',{startDate:$scope.ticketCountStatStartDate}).then(function (result) {
            $scope.transformData(result,$scope.ticketCountStatData,$scope.ticketCountStatLabels);

        })
    };

    /*invoice Count*/
    $scope.invoiceCountStatData=[[]];
    $scope.invoiceCountStatLabels=[];
    $scope.invoiceCountStat=function () {
        serverServices.get('api/dashboard/invoice/count',{startDate:$scope.invoiceCountStatStartDate}).then(function (result) {
            $scope.transformData(result,$scope.invoiceCountStatData,$scope.invoiceCountStatLabels);

        })
    };
    /*estimation count*/
    $scope.estimationCountStatData=[[]];
    $scope.estimationCountStatLabels=[];
    $scope.estimationCountStat=function () {
        serverServices.get('api/dashboard/estimation/count',{startDate:$scope.estimationCountStatStartDate}).then(function (result) {
            $scope.transformData(result,$scope.estimationCountStatData,$scope.estimationCountStatLabels);

        })
    };
    /*new Customer Count*/
    $scope.newCustomerCountStatData=[[]];
    $scope.newCustomerCountStatLabels=[];
    $scope.newCustomerCountStat=function () {
        serverServices.get('api/dashboard/newCustomer/count',{startDate:$scope.newCustomerCountStatStartDate}).then(function (result) {
            $scope.transformData(result,$scope.newCustomerCountStatData,$scope.newCustomerCountStatLabels);

        })
    };

    /*Invoice Amount totoal*/
    $scope.invoiceAmountStatData=[[]];
    $scope.invoiceAmountStatLabels=[];
    $scope.invoiceAmountStat=function () {
        serverServices.get('api/dashboard/invoiceAmount',{startDate:$scope.invoiceAmountStatStartDate}).then(function (result) {
            $scope.transformData(result,$scope.invoiceAmountStatData,$scope.invoiceAmountStatLabels);

        })
    };


    $scope.dateOptions = {
        maxDate: new Date(),
    };


})