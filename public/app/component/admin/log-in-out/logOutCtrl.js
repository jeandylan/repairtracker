/**
 * Created by dylan on 9/2/16.
 */
app.controller('logOutCtrl',function ($scope,$state,CacheFactory,$auth) {
    $scope.logOut=function () {
        CacheFactory.destroyAll();
        $auth.logout();
        $state.go('login');
    };
})