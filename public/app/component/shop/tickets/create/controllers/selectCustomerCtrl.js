/**
 * Created by dylan on 9/4/16.
 */
app.controller('selectCustomerCtrl',function (serverServices,$scope,$rootScope) {



    $scope.getAllCustomers=function () {
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
    };



    function AJAXsearch(){
        serverServices.get('api/customerSearch?global=' + $scope.keywords).then(function (response) {
                $scope.displayedCollection = [];  // displayed collection--->used by angular scope
                $scope.rowCollection = [];  // base collection--->used to store data from Async from server , to be used by angular Scope
                $scope.rowCollection = response; //update the original Array ,this is used so as to Synchronised Scope with asynchronous data obtain from dserver
                $scope.displayedCollection = [].concat($scope.rowCollection);  ///insert the data from server with the one used by angular scope

            },
            function (error) {
                toaster.pop('error', "Server Error : " + error.status, "An error ocuured ,try reload the page");
                console.log(error);
            });
    }

    $scope.search=function () {
        if ($scope.keywords) {
            AJAXsearch();
        }
        else {
            getAllCustomers();
        }
    };


    $scope.selectThisCustomer=function (row) { //return selected data To NgDialg
        $scope.closeThisDialog(row); //close and pass The Selec data to the NgDialog promise
    }
    $scope.getAllCustomers();
});