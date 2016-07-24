/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("updateTicketCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster) {
    editableOptions.theme = 'bs3';
    $scope.qr=$location.path();
    $scope.ticketId=$stateParams.ticketId;
    getTicketData($scope.ticketId);


    function  getTicketData(id) {
        serverServices.get('api/ticket/'+id)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.ticket = result;
                    console.log(result)
                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    //could not get response from Server
                });
    }
    
    $scope.updateTicket=function () {
        var ticketUpdateData=
        {  // array containing Updated Ticket data,to be saved in db
            model:$scope.ticket.model,
            make:$scope.ticket.make,
            problem_type:$scope.ticket.problem_type,
            problem_definition:$scope.ticket.problem_definition
        };

        var updateUrl='api/ticket/'+$scope.ticketId;//using the parameter TicketId from url stored in $scope.TicketId,,this will be used to construct put url
        serverServices.put(updateUrl,ticketUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done","Ticket update Sucessful");
                },
                function (error) {
                    // handle errors here

                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );
    }

});
