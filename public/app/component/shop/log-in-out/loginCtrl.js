/**
 * Created by dylan on 8/30/16.
 */
app.controller("loginCtrl",function ($scope,$state,serverServices,$auth) {

$scope.login=function (email,password) {
    var domainName=location.host.split(".");
    var isSuperAdmin = domainName[0]=="admin";
    var credential={
        email:email,
        password:password
    };
    var loginUrl=isSuperAdmin ?'api/loginSuperAdmin' :"api/login";
    var options={
        url:loginUrl,
        method:'POST'
    };

    $auth.login(credential,options)
        .then(function(response) {
            console.log(response);
           if(response.data.successful) $state.go('app')
        })
        .catch(function(response) {
            console.log(response.data);

        });


}

});

