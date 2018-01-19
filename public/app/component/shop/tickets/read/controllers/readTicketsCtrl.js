/**
 * Created by dylan on 03-Jul-16.
 */
/*
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!this is the controller for table view of tickets
 */
app.controller("readTicketsCtrl",function ($scope,serverServices,$uibModal,toaster) {
    getAllTicketsData();
    $scope.today=new Date();

    function getAllTicketsData() {
        serverServices.get('api/tickets').then(function (response) {
                $scope.displayedCollection = [];  // displayed collection--->used by angular scope
                $scope.rowCollection = [];  // base collection--->used to store data from Async from server , to be used by angular Scope
                $scope.rowCollection = response; //update the original Array ,this is used so as to Synchronised Scope with asynchronous data obtain from dserver
                $scope.displayedCollection = [].concat($scope.rowCollection);  ///insert the data from server with the one used by angular scope
            },
            function (error) {
                toaster.pop('error', "Server Error : "+error.status, "An error ocuured ,try reload the page");
                console.log(error);
            });
    }

    $scope.deleteBtn=function (id) {
        serverServices.delete('api/ticket/'+id).then(function () {
            getAllTicketsData();

        });
    }
});
