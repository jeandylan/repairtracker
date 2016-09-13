/**
 * Created by dylan on 9/3/16.
 */
angular.module('app')
    .controller("shopAppCtrl",function ($scope,serverServices,toaster,editableOptions,$rootScope,$state,CacheFactory,$auth){
//Check if  Authenticated

        editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
        $scope.$on('$stateChangeSuccess', function () {
            if($auth.isAuthenticated()) {
                if (!CacheFactory.get('appCache')) {
                    CacheFactory.createCache('appCache', {
                        deleteOnExpire: 'aggressive',
                        recycleFreq: 60000
                    });
                    serverServices.get('api/employee/myProfile') //using service (customer/service/clientService ) that will query Laravel for .json output
                        .then(function (result) {
                            console.log(result);
                                CacheFactory.get('appCache').put('profile', result);
                                console.log("get Cache");
                                $scope.profile = CacheFactory.get('appCache').get('profile');
                            },
                            function (error) {
                                toaster.pop("error", "SERVER ERROR", "ooh nothing was saved error ");
                            });
                }
                else { //if Cache Exist
                    console.log("cache Existed")
                }
            }
            else{

                $state.go('login');
            }

            });






        $scope.updateResource=function (url, data) {
            console.log('start updating');
            return serverServices.put(url, data)//id parameter obtain by doing state parameter (like a query)
                .then(
                    function (result) {
                        console.log(result);
                        (result.successful) ? toaster.pop("success", 'success', result.message) :
                            toaster.pop("warning", 'info:', result.message);
                        return result
                    },
                    function (result) {
                        // toaster.pop('error', "server Err", "we could not get info needed");
                        console.log(result);
                        toaster.pop('error', "server Err", result.message);
                        return result;

                        //could not get response from Server
                    });
        };










    });
