/**
 * Created by dylan on 29-Jun-16.
 */
app.controller('updateCustomerCtrl', function($scope,updateCustomerService,editableOptions,$filter, $state, $stateParams) {
    editableOptions.theme = 'bs3'; //the editable theme for xeditable injection should always be used else calendar and type ahead for address fails

    /*
    get customer details via Json Ajax
     */
    // $stateParams parameters validation have been done during routing (only Type check was done i.e id should be  Integer)
    updateCustomerService.readCustomerById( $stateParams.customerId) //parameter obtain via stateParam from link or state
        .then(
            function (result) {
                $scope.customer = result;

            },
            function (result) {
                console.log(result)
                //could not get response from Server
            });



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



