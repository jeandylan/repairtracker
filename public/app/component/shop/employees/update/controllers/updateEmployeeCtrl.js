/**
 * Created by dylan on 24-Jul-16.
 */
app.controller('updateEmployeeCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http) {
    editableOptions.theme = 'bs3';  //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails
    $scope.statuses = [
        {value: 1, text: 'Active'},
        {value: 0, text: 'Inactive'}
    ];
    $scope.roles = [
        {value: "admin", text: 'admin'},
        {value: "superAdmin", text: 'superAdmin'},
        {value:"technician",text:'technician'}
    ];

    $scope.updatePassword=function () {
        serverServices.put('api/employeePassword/'+$scope.employeeId,{newPassword:$scope.newPassword}).then(function (result) {
            console.log(result)
            $scope.newPassword='';
        });
    };

$scope.newPassword='';

    $scope.employeeId=$stateParams.employeeId; // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer),same as in db
    /*
     get Employee details via Json Ajax
     */
    function  getEmployeeData() {
        serverServices.get('api/employee/'+$scope.employeeId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.employee = result;
                    console.log(result)

                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    }
    getEmployeeData();

    $scope.updateEmployee=function () { //when the submit btn click (function call found in <form> tag on top)
        serverServices.put('api/employee/'+$scope.employeeId,$scope.employee).then(function (result) {
            console.log(result);
        })
    };
    $scope.updateEmployeeRole=function () {
        serverServices.post('api/employeeAssignRole/'+$scope.employeeId,{role:$scope.employee.role}).then(function () {

        })
    };

/*role function Assign update Functions*/


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


    


    
});