/**
 * Created by dylan on 03-Jul-16.
 */
/*
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!this is the controller for table view of tickets
 */
app.controller("readTicketsCtrl",function ($scope,serverServices,$uibModal) {
    getAllTicketsData();

    function getAllTicketsData() {
        serverServices.get('api/tickets').then(function (response) {
                $scope.displayedCollection = [];  // displayed collection--->used by angular scope
                $scope.rowCollection = [];  // base collection--->used to store data from Async from server , to be used by angular Scope
                $scope.rowCollection = response; //update the original Array ,this is used so as to Synchronised Scope with asynchronous data obtain from dserver
                $scope.displayedCollection = [].concat($scope.rowCollection);  ///insert the data from server with the one used by angular scope
            },
            function (error) {
                toaster.pop('error', "Server Error : "+error.status, "An error ocuured ,try reload the page");
                console.log(error);
            });
    }
    
    $scope.deleteTicketBtn=function (ticketId,ticketProblem) {

        $scope.ticketId = ticketId;
        $scope.ticketProblem=ticketProblem;

        var modalInstance = $uibModal.open({
            animation:1,
            templateUrl:'app/component/shop/tickets/delete/view/delete-ticket-modal-template.html' ,
            controller: 'deleteTicketModalCtrl',
            resolve: {
                ticketId: function () {
                    return $scope.ticketId;
                },
                ticketProblem:function () {
                    return $scope.ticketProblem;
                }
            }
        });

        modalInstance.result.then(function (customerId) {
            //btn ok(confrim delete) was clicked on popup/modal call function ,delete was done On deleteModalCtrl(return a cleint Id)...We need to refresh data..
            getAllTicketsData();
        }, function () {
            //button cancel was click on popup/modal nothing to do
        });
    }
});
