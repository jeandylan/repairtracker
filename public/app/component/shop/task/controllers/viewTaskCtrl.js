/**
 * Created by dylan on 9/23/16.
 */
app.controller("viewTaskCtrl",function ($scope,$stateParams,serverServices,toaster,$state,ngDialog,$filter) {
    getMyTask();

    function getMyTask() {
        serverServices.get('api/ticketTechnicianMyTask',{uncompletedTicket:1}).then(function (response) {
            console.log(response);
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



   $scope.dateStyle=function (date) {
       var diff =  Math.floor(( new Date(date)- new Date() ) / 86400000);

       if (diff >=7) return;
       if(diff < 0) return $scope.past;
       if(diff=0) return $scope.now;
       if(diff < 7) return $scope.near;
   };
    $scope.past = {
        "background-color" : "#EF9A9A",
    }
    $scope.now = {
        "background-color" : "coral",
    }
    $scope.near={
        "background-color":"#E6EE9C"
    }
});