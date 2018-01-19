/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("updateTicketCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {
    editableOptions.theme = 'bs3';

    $scope.qr=$location.path(); //QR have Address of ticket
    $scope.ticketId=$stateParams.ticketId;
    $scope.opened = {};
    $scope.currentUser=CacheFactory.get('appCache').get('profile'); //obtain current  login user from cache (used to know who post Comments)
    $scope.$on('changeTicketTicket',function () { //refresg data if new Txt field
        getTicketData($scope.ticketId);
    });

    $scope.status = ["repairing","waiting_confirmation","close"];


    getTicketData($scope.ticketId);

    $scope.toPdf=function (documentId) {
        $scope.hide=true;
        setTimeout(function() {
            html2canvas(document.getElementById(documentId), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500,
                        }]
                    };
                    $scope.hide = false;
                    pdfMake.createPdf(docDefinition).download("ticket.pdf");
                }
            });
        },1500);

    };


//todo recheck date setting ,not working in laravel, offset by 1 on some ctrl show back to stock on update Stock
//General
    function  getTicketData() {
        serverServices.get('api/ticket/'+$scope.ticketId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.ticket = result;
                },
                function (result) {
                    console.log(result);
                });
    }

   $scope.updateTicket=function () {
       serverServices.put('api/ticket/'+$scope.ticketId,$scope.ticket).then(
           function (result) {
               $scope.$emit('changeTicketTicket');

           },function (result) {
               console.log(result);
           })
   };
    
   
   $scope.dateNotPast=function (data) {
       if( new Date() > data ){
           return "Date cannot be in the past";

       }
   };


    $scope.open = function($event, elementOpened) {
        $event.preventDefault();
        $event.stopPropagation();
        $scope.opened[elementOpened] = !$scope.opened[elementOpened];
    }; //calendar Func


/*
    $scope.updateTicket=function () {
        var ticketUpdateData=
        {  // array containing Updated Ticket data,to be saved in db
            model:$scope.ticket.info.model,
            make:$scope.ticket.info.make,
            problem_type:$scope.ticket.info.problem_type,
            problem_definition:$scope.ticket.info.problem_definition
        };
        console.log(ticketUpdateData);

        var updateUrl='api/ticket/'+$scope.ticketId;//using the parameter TicketId from url stored in $scope.TicketId,,this will be used to construct put url
        serverServices.put(updateUrl,ticketUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                },
                function (error) {
                    // handle errors here

                    toaster.pop("error","Failed",error.message);
                }
            );
    };
    */






});
