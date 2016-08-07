app.controller('updateCustomerCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails

    $scope.types = ["home", "private", "company"]; //used by select

    $scope.customerId=$stateParams.customerId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Customer details via Json Ajax
     */
    getCustomerData();


    $scope.updateCustomer=function () { //when the submit btn click (function call found in <form> tag on top)

        var customerUpdateData={
            first_name:$scope.customer.personal.first_name,  // array containing customer data
            last_name:$scope.customer.personal.last_name,
            date_of_birth:$scope.customer.personal.date_of_birth,
            role:$scope.customer.role
        };
        //return $http.put('api/customer/'+$scope.customerId, customerUpdateData);

        //put client data to server,

        return updateResource('api/customer/'+$scope.customerId, customerUpdateData).then(
            function (result) {
                return (result.successful) ?  true: "error "+result.message;
            }
        );


    };


    function  getCustomerData() {
        serverServices.get('api/customer/'+$scope.customerId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.customer = result;

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
    /* Customer address*/

    $scope.updateAddress=function (address) {
        console.log(address);

        if(address.hasOwnProperty('id')){

            return updateResource('api/customer/address/'+address.id,address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/customer/address',address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateAddressType=function (address) {
        if(address.hasOwnProperty('id')){
            return updateResource('api/customer/address/'+address.id,address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createAddress=function () {
        $scope.customer.addresses.push({customer_id:$stateParams.customerId}); //push empty (for now ) object  into arr of addresses. ->uniquely identify because of hash


    };

    $scope.deleteAddress =function(address) {
        deleteResource('api/customer/address/'+address.id);
        index=$scope.customer.addresses.indexOf(address);
        if (index > -1) {
            $scope.customer.addresses.splice(index, 1);
        }};

    /*email Customer*/
    $scope.updateEmail=function (email) {
        console.log(email);

        if(email.hasOwnProperty('id')){

            return updateResource('api/customer/email/'+email.id,email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/customer/email',email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateEmailType=function (email) {
        if(email.hasOwnProperty('id')){
            return updateResource('api/customer/email/'+email.id,email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createEmail=function () {
        $scope.customer.emails.push({customer_id:$stateParams.customerId}); //push empty (for now ) object  into arr of emailes. ->uniquely identify because of hash
    };

    $scope.deleteEmail =function(email) {
        deleteResource('api/customer/email/'+email.id);
        index=$scope.customer.emailes.indexOf(email);
        if (index > -1) {
            $scope.customer.emailes.splice(index, 1);
        }};

    /*customer Telephone*/
    $scope.updateTelephone=function (telephone) {
        console.log(telephone);

        if(telephone.hasOwnProperty('id')){

            return updateResource('api/customer/telephone/'+telephone.id,telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/customer/telephone',telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateTelephoneType=function (telephone) {
        if(telephone.hasOwnProperty('id')){
            return updateResource('api/customer/telephone/'+telephone.id,telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createTelephone=function () {
        $scope.customer.telephones.push({customer_id:$stateParams.customerId}); //push empty (for now ) object  into arr of telephonees. ->uniquely identify because of hash
    };

    $scope.deleteTelephone =function(telephone) {
        deleteResource('api/customer/telephone/'+telephone.id);
        index=$scope.customer.telephones.indexOf(telephone);
        if (index > -1) {
            $scope.customer.telephones.splice(index, 1);
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
