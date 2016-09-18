/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("createTicketCtrl",function ($scope,$stateParams,serverServices,toaster,$state,ngDialog,$filter) {
    $scope.customer={}; //customer should be unique
    $scope.stocks=[]; //ticket can have many Stock item
    $scope.technicians=[]; //Ticket can have many Many Tech
    $scope.ticket = {};
    $scope.calendarOption={
        minDate:new Date()
    }

    console.log($scope.customer.id=$stateParams.customerId); //these Are Optional Only capture if pass as Params



    $scope.getFields=function () {
        serverServices.get('api/ticketCustomFields') //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {
                    toaster.pop("success","DONE","Got additional Fields ");
                    $scope.customTextFields=result;
                },
                function (error) {
                    // handle errors here
                    toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );
    };

    $scope.createTicket=function () {
        $scope.ticket.estimated_completion_date=  $filter('date')($scope.ticket.estimated_completion_date, "yyyy-MM-dd"); //need to change Dates in before Laravel sent
        serverServices.post('api/ticket/' + $scope.customer.id, $scope.ticket) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(function (result) {
                console.log(result);
                $scope.newTicketId = result.ticketId; //this is the id of newly created in db
                assignTechnicianToTicket(result.ticketId);

                }),
                function (error) {
                    console.log(error);
                    toaster.pop("error", "SERVER ERROR", "ooh nothing was saved error ");
                };
    };

   function assignTechnicianToTicket(ticketId){
       for (var i in $scope.technicians) {
           //$scope.technicians[i].ticket.estimated_completion_date=  $filter('date')($scope.technicians[i].ticket.estimated_completion_date, "yyyy-MM-dd"); //need to change Dates in before Laravel
           $scope.technicians[i].ticket.employee_id= $scope.technicians[i].id;
           serverServices.post('api/ticketTechnician/'+ticketId,$scope.technicians[i].ticket)
               .then(function () {
               }),
               function (error) {
               };
       }
   }

    $scope.selectCustomer=function () {
         ngDialog.open({
            template: 'app/component/shop/tickets/create/views/select-customer.html',
            controller:'selectCustomerCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id) $scope.customer=data.value;
         });
    };

    $scope.createCustomer=function () { //function to create Customer
        ngDialog.open({
            template: 'app/component/shop/tickets/create/views/create-customer-ticket.html',
            controller:'createCustomerTicketCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            $scope.customer=data.value;
        });


    };
    
    $scope.selectTechnician=function () {
        ngDialog.open({
            template: 'app/component/shop/tickets/create/views/select-technician.html',
            controller:'selectTechnicianCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {

            if(data.value.id) $scope.technicians.push(data.value);
        });
    };

    $scope.selectStock=function () {
        ngDialog.open({
            template: 'app/component/shop/tickets/create/views/select-stock.html',
            controller:'selectStockCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id)$scope.stocks.push(data.value);  //add item to potential Stocks
        });
    };

    $scope.changeCustomer=function () {
        delete $scope.customer; //just delete the var customer will reset fields (as per angular way of working)
    };

    $scope.getTicketStocksTotal=function () {
        var total=0;
        for (var i = 0, len = $scope.stocks.length; i < len; i++) {
            if($scope.stocks[i].selling_price >0 && $scope.stocks[i].qty_out >0){
                total+=$scope.stocks[i].selling_price * $scope.stocks[i].qty_out;
            }
        }

        return total;
    };

    $scope.getFields();

    $scope.removeTechnician=function (technician) {
        index=$scope.technicians.indexOf(technician);
        if (index > -1) {
            $scope.technicians.splice(index, 1);
        }
    };



    function getCustomTextData(name){
        return $('input[customText="'+name + '"]').val();
    }




});
