/**
 * Created by dylan on 24-Jul-16.
 */
app.controller("createEmployeeCtrl",function ($scope,serverServices,toaster,$http) {
$scope.employee={};

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
    $scope.options = [
        {
            name: 'superAdmin',
            value: 'superAdmin'
        },
        {
            name: 'admin',
            value: 'admin'
        },
        {
            name: 'technician',
            value: 'technician'
        }
    ];


    $scope.createEmployee=function () {  //it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
console.log($scope.employee);
        serverServices.post('api/employee',$scope.employee) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {
                    serverServices.post('api/employeeAssignRole/'+result.id,{role:$scope.employee.role}).then(); //now we update The role by using The New Id obtain from server
                },
                function (error) {
                    // handle errors here
                    toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );
    }

});