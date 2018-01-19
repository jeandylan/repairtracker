app.controller("CreateSupporterCtrl",function ($scope,serverServices,toaster, $state) {

    $scope.createSupporter=function () {

        console.log($scope.supporter);

        serverServices.post("saas/supporter",$scope.supporter).then(function (result) {
            //console.log("yay!");
            $state.go("app.supportersList");
        })
    }


});