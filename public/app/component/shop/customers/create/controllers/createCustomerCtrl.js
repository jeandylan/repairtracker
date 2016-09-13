/**
 * Created by dylan on 26-Jun-16.
 */
app.controller("createCustomerCtrl",function ($scope,serverServices,toaster,$http) {


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




/*telephone sec*/
    $scope.telephones=[]; //array to contain all telephone numbers

    $scope.createTelephoneNumber=function () {
        $scope.telephones.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };

    $scope.deleteTelephoneNumber=function (telephone) {
        index=$scope.telephones.indexOf(telephone);
        if (index > -1) {
            $scope.telephones.splice(index, 1);
        }
    };
/*address sec*/
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

    $scope.addresses=[];

    $scope.createAddress=function () {
        $scope.addresses.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };

    $scope.deleteAddress=function (telephone) {
        index=$scope.addresses.indexOf(telephone);
        if (index > -1) {
            $scope.addresses.splice(index, 1);
        }
    };
/*email sec*/
    $scope.emails=[];

    $scope.createEmail=function () {
        $scope.emails.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };

    $scope.deleteEmail=function (telephone) {
        index=$scope.emails.indexOf(telephone);
        if (index > -1) {
            $scope.emails.splice(index, 1);
        }
    };

    $scope.createCustomer=function () {//it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
        console.log($scope.telephones);

        var customerData={
            first_name:$scope.customer.first_name,
            last_name:$scope.customer.last_name,
            date_of_birth:$scope.customer.date_of_birth,
            telephones:$scope.telephones,
            addresses:$scope.addresses,
            emails:$scope.emails


        };
        serverServices.post('api/customer',customerData) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {
                    toaster.pop("success","DONE",result.message);
                    $scope.newCustomerId=result.newId;
                },
                function (error) {
                    // handle errors here
                   toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );

    }

});
