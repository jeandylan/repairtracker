/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("createTicketCtrl",function ($scope,$stateParams,serverServices,toaster,$state) {
    $scope.customerId=$stateParams.customerId;
    $scope.createTicket=function () {

       var ticketData={model:$scope.ticket.model,
           make:$scope.ticket.make,
           problem_type:$scope.ticket.problem_type,
           problem_definition:$scope.ticket.problem_definition
          
       };


       serverServices.post('api/ticket/'+$scope.customerId,ticketData) //using service (customer/service/clientService ) that will query Laravel for .json output
           .then(
               function (result) {
                   toaster.pop("success","DONE","Ticket created ");
                   var idOfNewTicket=result; //this is the id of newly created in db
                   $state.go("app.update-ticket", {ticketId:idOfNewTicket});//go to Webpage that modify newly created ticket,so as to edit Ticket and View QR
               },
               function (error) {
                   // handle errors here
                   toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
               }
           );


   }


});
