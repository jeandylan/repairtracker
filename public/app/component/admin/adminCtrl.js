/**
 * Created by dylan on 9/25/16.
 */
angular.module('app')
    .controller("adminCtrl",function ($scope,serverServices,toaster,editableOptions,$rootScope,$state,CacheFactory,$auth) {
        $scope.$on('$stateChangeSuccess', function () {
            if($auth.isAuthenticated()) { //is Login
                // $state.go('app.company');
                /*
                if (!CacheFactory.get('appCache')) { //if canche doess not exit
                    CacheFactory.createCache('appCache', {
                        deleteOnExpire: 'aggressive',
                        recycleFreq: 60000,
                        storageMode: 'localStorage'
                    });

                    serverServices.get('api/employee/myProfile') //using service (customer/service/clientService ) that will query Laravel for .json output
                        .then(function (result) {
                                CacheFactory.get('appCache').put('profile', result);
                                $scope.profile=CacheFactory.get('appCache').get('profile');
                            },
                            function (error) {
                                toaster.pop("error", "SERVER ERROR", "ooh nothing was saved error ");
                            });
                }
                else { //if Cache Exist
                    $scope.profile=CacheFactory.get('appCache').get('profile');


                }
                */
            }

            else{ //if not logiN(cannot find Token)

                $state.go('login');
            }

        });
    });