/**
 * Created by dylan on 29-Jun-16.
 */
app.controller('updateCustomerCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
    $scope.customerId=$stateParams.customerId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get customer details via Json Ajax
     */
    getCustomerData($scope.customerId);


    $scope.updateCustomer=function () { //when the submit btn click (function call found in <form> tag on top)

        var customerUpdateData={first_name:$scope.customer.first_name,  // array containing customer data
            last_name:$scope.customer.last_name,
            email:$scope.customer.email,
            date_of_birth:$scope.customer.date_of_birth,
            address:$scope.customer.address,
            address_1:$scope.customer.address_1,
            home_tel:$scope.customer.home_tel,
            mobile_tel_1:$scope.customer.mobile_tel_1,
            mobile_tel:$scope.customer.mobile_tel
        };

        var updateUrl='api/customer/'+$scope.customerId;//using the parameter CustomerId from url stored in $scope.customerId,,this will be used to construct put url
        //put client data to server,
        serverServices.put(updateUrl,customerUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done","Client update Sucessful");
                },
                function (error) {
                    // handle errors here
                    
                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );

    };
    
    function  getCustomerData(id) {
        serverServices.get('api/customer/'+$scope.customerId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.customer = result;
                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    //console.log(result);
                    //could not get response from Server
                });
    }




/*
calendar functions
 */
    $scope.opened = {};
    $scope.formats = ['dd-MMMM-yyyy', 'yyyy-MM-dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    $scope.popup1 = {
        opened: false
    };


    $scope.open = function($event, elementOpened) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened[elementOpened] = !$scope.opened[elementOpened];
    };
    $scope.dateOptions = {
        maxDate: new Date()
    };

    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];
    $scope.altInputFormats = ['M!/d!/yyyy'];
});



