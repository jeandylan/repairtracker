/**
 * Created by dylan on 17-Jun-16.
 */

app.controller("tableCustomersCtrl",function ($scope,serverServices,$uibModal,toaster) {

    //when the page loads query the server for all customer  data from db so as to display inside table
    getAllCustomersData();
/*
the get all customer from server function
 */
    function getAllCustomersData() {
        serverServices.get('api/customers').then(function (response) {
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
    serverServices.delete('api/customer/'+id).then(function () {
        getAllCustomersData();
    });
    }

});




