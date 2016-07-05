/**
 * Created by dylan on 03-Jul-16.
 */
/*
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!this is the controller for table view of tickets
 */
app.controller("readTicketsCtrl",function ($scope,editableOptions) {
    editableOptions.theme = 'bs3';
    $scope.user = {
        dob: new Date(1984, 4, 15)
    };

    $scope.opened = {};

    $scope.open = function($event, elementOpened) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened[elementOpened] = !$scope.opened[elementOpened];
    };
});
