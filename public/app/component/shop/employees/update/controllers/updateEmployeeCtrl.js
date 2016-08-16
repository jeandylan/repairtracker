/**
 * Created by dylan on 24-Jul-16.
 */
app.controller('updateEmployeeCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails

    $scope.types = ["home", "private", "company"]; //used by select

    $scope.employeeId=$stateParams.employeeId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Employee details via Json Ajax
     */
    getEmployeeData();


    $scope.updateEmployee=function () { //when the submit btn click (function call found in <form> tag on top)
        var employeeUpdateData={
            first_name:$scope.employee.personal.first_name,  // array containing customer data
            last_name:$scope.employee.personal.last_name,
            date_of_birth:$scope.employee.personal.date_of_birth,
            role:$scope.employee.role
        };
        //return $http.put('api/employee/'+$scope.employeeId, employeeUpdateData);

        //put client data to server,

        return updateResource('api/employee/'+$scope.employeeId, employeeUpdateData).then(
            function (result) {
                return (result.successful) ?  true: "error "+result.message;
            }
        );
    };


    function  getEmployeeData() {
        serverServices.get('api/employee/'+$scope.employeeId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.employee = result;

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
/* Employee address*/

    $scope.updateAddress=function (address) {
        console.log(address);

        if(address.hasOwnProperty('id')){

            return updateResource('api/employee/address/'+address.id,address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/employee/address',address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateAddressType=function (address) {
        if(address.hasOwnProperty('id')){
            return updateResource('api/employee/address/'+address.id,address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createAddress=function () {
        $scope.employee.addresses.push({employee_id:$stateParams.employeeId}); //push empty (for now ) object  into arr of addresses. ->uniquely identify because of hash


    };

    $scope.deleteAddress =function(address) {
        deleteResource('api/employee/address/'+address.id);
        index=$scope.employee.addresses.indexOf(address);
        if (index > -1) {
            $scope.employee.addresses.splice(index, 1);
        }};

    /*email Employee*/
    $scope.updateEmail=function (email) {
        console.log(email);

        if(email.hasOwnProperty('id')){

            return updateResource('api/employee/email/'+email.id,email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/employee/email',email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateEmailType=function (email) {
        if(email.hasOwnProperty('id')){
            return updateResource('api/employee/email/'+email.id,email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createEmail=function () {
        $scope.employee.emails.push({employee_id:$stateParams.employeeId}); //push empty (for now ) object  into arr of emailes. ->uniquely identify because of hash
    };

    $scope.deleteEmail =function(email) {
        deleteResource('api/employee/email/'+email.id);
        index=$scope.employee.emailes.indexOf(email);
        if (index > -1) {
            $scope.employee.emailes.splice(index, 1);
        }};

    /*employee Telephone*/
    $scope.updateTelephone=function (telephone) {
        console.log(telephone);

        if(telephone.hasOwnProperty('id')){

            return updateResource('api/employee/telephone/'+telephone.id,telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/employee/telephone',telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateTelephoneType=function (telephone) {
        if(telephone.hasOwnProperty('id')){
            return updateResource('api/employee/telephone/'+telephone.id,telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createTelephone=function () {
        $scope.employee.telephones.push({employee_id:$stateParams.employeeId}); //push empty (for now ) object  into arr of telephonees. ->uniquely identify because of hash
    };

    $scope.deleteTelephone =function(telephone) {
        deleteResource('api/employee/telephone/'+telephone.id);
        index=$scope.employee.telephones.indexOf(telephone);
        if (index > -1) {
            $scope.employee.telephones.splice(index, 1);
        }};



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
    /*address Autocomplete*/
    $scope.getLocation = function(val) {
        return $http.get('//maps.googleapis.com/maps/api/geocode/json', {
            params: {
                address: val,
                sensor: false
            }
        }).then(function(response){
            return response.data.results.map(function(item){
                return item.formatted_address;
            });
        });
    };

    function deleteResource(url) {
        serverServices.delete(url)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    (result.successful)?toaster.pop("success",'success',result.message):
                        toaster.pop("warning",'info:',result.message);

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });

    }

    function createResource(url,data){
        return serverServices.post(url,data)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    (result.successful)?toaster.pop("success",'success',result.message):
                        toaster.pop("warning",'info:',result.message);
                   return result;

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }

    function updateResource(url,data) {
        return serverServices.put(url,data)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    (result.successful)?toaster.pop("success",'success',result.message):
                        toaster.pop("warning",'info:',result.message);
                    return result

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    return result;
                    //could not get response from Server

                });
    }
    
    


    
});