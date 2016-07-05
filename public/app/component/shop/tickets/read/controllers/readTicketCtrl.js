/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("readTicketCtrl",function ($scope,editableOptions) {
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
