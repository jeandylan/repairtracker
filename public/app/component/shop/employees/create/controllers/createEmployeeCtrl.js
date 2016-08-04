/**
 * Created by dylan on 24-Jul-16.
 */
app.controller("createEmployeeCtrl",function ($scope,serverServices,toaster,$http) {


    $scope.clear = function() {
        $scope.employee.date_of_birth = null;
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
/* telephone add Section*/
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
/*address Add Section*/
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

    /*email add Section*/
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
/*Sent to server sect*/

    $scope.createEmployee=function () {  //it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
        var employeeData={
            first_name:$scope.employee.first_name,
            last_name:$scope.employee.last_name,
            email:$scope.employee.email,
            date_of_birth:$scope.employee.date_of_birth,
            role:$scope.employee.role,
            telephones:$scope.telephones,
            addresses:$scope.addresses,
            emails:$scope.emails
        };
        serverServices.post('api/employee',employeeData) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {
                    console.log(result);

                    toaster.pop("success","DONE",result.message);
                },
                function (error) {
                    // handle errors here
                    toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );
    }

});