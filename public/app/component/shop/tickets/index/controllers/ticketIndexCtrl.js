/**
 * Created by dylan on 27-Jul-16.
 */
app.controller("ticketIndexCtrl",function ($scope,$stateParams,$state) {
    $scope.ticketTab   = [
        {
            heading: '<span class="fa fa-eye text-info" aria-hidden="true"></span>View Ticket',
            route:   'app.ticket.read-all'
        },
        {
            heading: '<span class="fa fa-plus text-info" aria-hidden="true" ></span>create Ticket',
            route:   'app.ticket.create'
        }
    ];



});