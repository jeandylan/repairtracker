app.controller("UpdateSupporterCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices) {
    editableOptions.theme = 'bs3';
    $scope.supporterId=$stateParams.supporterId;

    $scope.statuses = [
        {value: 1, text: 'Active'},
        {value: 0, text: 'Inactive'}
    ];

    function getSupporter() {
        console.log($scope.supporterId);
        serverServices.get('saas/supporter/'+$scope.supporterId).then(
            function (result) {
                $scope.supporter=result;
            },function (result) {
                console.log(result);
            })
    }

    $scope.updateSupporter=function () {
        serverServices.put('saas/supporter/'+$scope.supporterId,$scope.supporter).then();
    };

    getSupporter();
});