/**
 * Created by dylan on 08-Jul-16.
 */
app.controller('deleteTicketModalCtrl', function ($scope, $uibModalInstance, ticketId,ticketProblem,serverServices,toaster) {

    $scope.ticketId= ticketId;
    $scope.ticketProblem=ticketProblem;
/*
this should be called Only on HTML page with <toaster></toaster> Tag Somewhere
 */
    $scope.ok = function () {
        serverServices.delete('api/ticket/' + $scope.ticketId).then(function (response) {
                toaster.pop('success', "Ticket with problem: "+$scope.ticketProblem+" was deleted ");
        },
        function (response) {
            toaster.pop('error', " ooohps Ticket with problem: "+$scope.ticketProblem+" was not deleted ");
        });


        $uibModalInstance.close($scope.customerId);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});