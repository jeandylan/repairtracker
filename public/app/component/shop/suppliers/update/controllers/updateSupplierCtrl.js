app.controller('updateSupplierCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails

    $scope.types = ["home", "private", "company"]; //used by select

    $scope.supplierId=$stateParams.supplierId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Supplier details via Json Ajax
     */
    getSupplierData();


    $scope.updateSupplier=function () { //when the submit btn click (function call found in <form> tag on top)

        var supplierUpdateData={
            first_name:$scope.supplier.personal.first_name,  // array containing customer data
            last_name:$scope.supplier.personal.last_name,
            date_of_birth:$scope.supplier.personal.date_of_birth,
            role:$scope.supplier.role
        };
        //return $http.put('api/supplier/'+$scope.supplierId, supplierUpdateData);

        //put client data to server,

        return updateResource('api/supplier/'+$scope.supplierId, supplierUpdateData).then(
            function (result) {
                return (result.successful) ?  true: "error "+result.message;
            }
        );


    };


    function  getSupplierData() {
        serverServices.get('api/supplier/'+$scope.supplierId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.supplier = result;

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
    /* Supplier address*/

    $scope.updateAddress=function (address) {
        console.log(address);

        if(address.hasOwnProperty('id')){

            return updateResource('api/supplier/address/'+address.id,address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/supplier/address',address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateAddressType=function (address) {
        if(address.hasOwnProperty('id')){
            return updateResource('api/supplier/address/'+address.id,address).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createAddress=function () {
        $scope.supplier.addresses.push({supplier_id:$stateParams.supplierId}); //push empty (for now ) object  into arr of addresses. ->uniquely identify because of hash


    };

    $scope.deleteAddress =function(address) {
        deleteResource('api/supplier/address/'+address.id);
        index=$scope.supplier.addresses.indexOf(address);
        if (index > -1) {
            $scope.supplier.addresses.splice(index, 1);
        }};

    /*email Supplier*/
    $scope.updateEmail=function (email) {
        console.log(email);

        if(email.hasOwnProperty('id')){

            return updateResource('api/supplier/email/'+email.id,email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/supplier/email',email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateEmailType=function (email) {
        if(email.hasOwnProperty('id')){
            return updateResource('api/supplier/email/'+email.id,email).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createEmail=function () {
        $scope.supplier.emails.push({supplier_id:$stateParams.supplierId}); //push empty (for now ) object  into arr of emailes. ->uniquely identify because of hash
    };

    $scope.deleteEmail =function(email) {
        deleteResource('api/supplier/email/'+email.id);
        index=$scope.supplier.emailes.indexOf(email);
        if (index > -1) {
            $scope.supplier.emailes.splice(index, 1);
        }};

    /*supplier Telephone*/
    $scope.updateTelephone=function (telephone) {
        console.log(telephone);

        if(telephone.hasOwnProperty('id')){

            return updateResource('api/supplier/telephone/'+telephone.id,telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            })
        }
        else{
            return createResource('api/supplier/telephone',telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });

        }
    };

    $scope.updateTelephoneType=function (telephone) {
        if(telephone.hasOwnProperty('id')){
            return updateResource('api/supplier/telephone/'+telephone.id,telephone).then(function (result){
                return (result.successful) ?  true: "error "+result.message;
            });
        }

    };


    $scope.createTelephone=function () {
        $scope.supplier.telephones.push({supplier_id:$stateParams.supplierId}); //push empty (for now ) object  into arr of telephonees. ->uniquely identify because of hash
    };

    $scope.deleteTelephone =function(telephone) {
        deleteResource('api/supplier/telephone/'+telephone.id);
        index=$scope.supplier.telephones.indexOf(telephone);
        if (index > -1) {
            $scope.supplier.telephones.splice(index, 1);
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
