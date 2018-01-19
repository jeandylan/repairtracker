/**
 * Created by dylan on 10/1/16.
 */
app.controller("settingColorCtrl",function ($scope,serverServices) {

    $scope.saveTheme=function () {
        serverServices.put('api/setShopColor',{color:JSON.stringify($scope.app)}).then(function () {
            
        })
    };

    serverServices.get('api/getShopColor').then(function (result) {
        //console.log(result);
        $scope.app.settings=result.settings;
        console.log($scope.app);
        //$scope.app=result;
    })


});