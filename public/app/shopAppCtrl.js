
/**
 * Created by dylan on 9/3/16.
 */



angular.module('app')
    .controller("shopAppCtrl",function ($scope,serverServices,toaster,editableOptions,$rootScope,$state,CacheFactory,$auth,AclService,$timeout,$localStorage){


        function ticketNotification() {
            if($auth.isAuthenticated())
            serverServices.get('api/ticketTechnicianMyTaskNotification').then(function (result) {
                $scope.taskNotification=result;
                $timeout(ticketNotification, 10000);
            },function () {
                console.log('cannot get notif')
                $timeout(ticketNotification, 15000);

            })
        };
        
        $scope.readTicketNotification=function () {

            serverServices.get("api/ticketTechnicianMyTaskNotificationRead").then(function () {

            });
            
        };
        //ticketNotification();

        var domainName=location.host.split(".");
        console.log(domainName[0])
        var isSuperAdmin = domainName[0]=="admin";
        var profileUrl=isSuperAdmin ?'api/allEmployee/myProfile' :'api/employee/myProfile';


//Check if  Authenticated
        $scope.can = AclService.can; //Get The permission
        editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
        $scope.$on('$stateChangeSuccess', function () {
            if($auth.isAuthenticated()) { //is Login
                if (!CacheFactory.get('appCache')) { //if canche doess not exit
                    CacheFactory.createCache('appCache', {
                        deleteOnExpire: 'aggressive',
                        recycleFreq: 60000,
                        storageMode: 'localStorage'
                    });
                    serverServices.get(profileUrl) //using service (customer/service/clientService ) that will query Laravel for .json output
                        .then(function (result) {
                            console.log(result)
                                CacheFactory.get('appCache').put('profile', result);
                                $scope.profile=CacheFactory.get('appCache').get('profile');
                                $localStorage.profile=result;
                                permission($localStorage.profile.role[0]); //get Permission for role Assigned to login User
                            },
                            function (error) {
                                toaster.pop("error", "SERVER ERROR", "ooh nothing was saved error ");
                            });
                }
                else { //if Cache Exist
                    $scope.profile=CacheFactory.get('appCache').get('profile');
                }
            }
            else{ //if not logiN(cannot find Token)

                $state.go('login');
            }
        });

       function  permission(role) {
           var roleCan=[];
           serverServices.get("api/rolePermissions/"+role).then(function (result) {
               for(var i=0;i<result.length;i++){
                   roleCan.push(result[i].name);
               }
               setPermission(roleCan);
              $localStorage.permission=roleCan; //save permission in local Str for later usage

           });
       };

       function setPermission(permissions) {
           ///we will be keeping Only one Role every login we get the ability ,hence
           //fictive single Role for all user
           var aclData = {
               user:permissions
           }
           console.log(aclData);
           AclService.setAbilities(aclData);
           AclService.attachRole('user');
       }




/*
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
        */



    });


app.run(function(ticketNotification) {});