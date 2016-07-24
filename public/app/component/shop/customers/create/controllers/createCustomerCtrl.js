/**
 * Created by dylan on 26-Jun-16.
 */
app.controller("createCustomerCtrl",function ($scope,serverServices,toaster) {


    $scope.clear = function() {
        $scope.customer.date_of_birth = null;
    };


    $scope.dateOptions = {
        formatYear: 'yy',
        maxDate: new Date(),
        startingDay: 1
    };

    $scope.open1 = function() {
        $scope.popup1.opened = true;
    };
    $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[1];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    $scope.popup1 = {
        opened: false
    };
    
    
    $scope.createCustomer=function () {  //it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
        var customerData={first_name:$scope.customer.first_name,
            last_name:$scope.customer.last_name,
            email:$scope.customer.email,
            date_of_birth:$scope.customer.date_of_birth,
            address:$scope.customer.address,
            address_1:$scope.customer.address_1,
            home_tel:$scope.home_tel,
            mobile_tel_1:$scope.mobile_tel_1,
            mobile_tel:$scope.mobile_tel
        };
        serverServices.post('api/customer',customerData) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {

                    toaster.pop("success","DONE","client created ");
                },
                function (error) {
                    // handle errors here
                   toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );
    }

});
