/**
 * Created by dylan on 24-Jul-16.
 */
app.controller("createEmployeeCtrl",function ($scope,serverServices,toaster) {


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


    $scope.createEmployee=function () {  //it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
        var employeeData={
            first_name:$scope.employee.first_name,
            last_name:$scope.employee.last_name,
            email:$scope.employee.email,
            date_of_birth:$scope.employee.date_of_birth,
            address:$scope.employee.address,
            home_tel:$scope.employee.home_tel,
            mobile_tel:$scope.mobile_tel,
            role:$scope.employee.role
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