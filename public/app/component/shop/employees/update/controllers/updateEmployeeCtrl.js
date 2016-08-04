/**
 * Created by dylan on 24-Jul-16.
 */
app.controller('updateEmployeeCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails

    $scope.types = ["home", "private", "company"]; //used by select

    $scope.employeeId=$stateParams.employeeId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Employee details via Json Ajax
     */
    getEmployeeData();


    $scope.updateEmployee=function () { //when the submit btn click (function call found in <form> tag on top)

        var employeeUpdateData={
            first_name:$scope.employee.first_name,  // array containing customer data
            last_name:$scope.employee.last_name,
            email:$scope.employee.email,
            date_of_birth:$scope.employee.date_of_birth,
            address:$scope.employee.address,
            home_tel:$scope.employee.home_tel,
            mobile_tel:$scope.employee.mobile_tel
        };

        var updateUrl='api/employee/'+$scope.employeeId;//using the parameter employeeId from url stored in $scope.employeeId,,this will be used to construct put url
        //put client data to server,
        serverServices.put(updateUrl,employeeUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                },
                function (result) {
                    // handle errors here

                    toaster.pop("error","Failed",result.message);
                }
            );

    };
    $scope.t="";
    function  getEmployeeData() {
        serverServices.get('api/employee/'+$scope.employeeId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.employee = result;
                    console.log(result);
                    $scope.t=$scope.employee.date_of_birth;
                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }

    $scope.createAddress=function ($event) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope. employee.address.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };


    /*
     calendar functions
     */




    $scope.opened = {};
    $scope.open = function($event, elementOpened) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened[elementOpened] = !$scope.opened[elementOpened];
    };
    $scope.dateOptions = {
        maxDate: new Date()
    };
    
});