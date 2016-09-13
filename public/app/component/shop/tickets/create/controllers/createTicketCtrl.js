/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("createTicketCtrl",function ($scope,$stateParams,serverServices,toaster,$state,ngDialog) {
    $scope.customer={}; //customer should be unique
    $scope.stocks=[]; //ticket can have many Stock item
    $scope.technicians=[]; //Ticket can have many Many Tech



    console.log($scope.customer.id=$stateParams.customerId); //these Are Optional Only capture if pass as Params

    $scope.getFields=function () {
        console.log("r");
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
        console.log($scope.isEmail);
        var ticketData = {
            model: $scope.model,
            make: $scope.make,
            problem_type: "fgfr",
            problem_definition: $scope.problem_definition,
           // technician_id: $scope.technician.id
        };

        $scope.customTextFieldsData = [];

        angular.forEach($scope.customTextFields, function (value, index) {
            $scope.customTextFieldsData.push({
                custom_text_field_id: value.id,
                field_data: getCustomTextData(value.field_name)
            })
        });
        $scope.serverData = {
            text_field:[ticketData],
            custom_text_fields_data: $scope.customTextFieldsData,
            email:$scope.customEmail
    };

        serverServices.post('api/ticket/' + $scope.customer.id, $scope.serverData) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(function (result) {
                    toaster.pop("success", "DONE", result.message);
                console.log(result)
                    var idOfNewTicket = result; //this is the id of newly created in db
                    $state.go("app.update-ticket", {ticketId: idOfNewTicket});//go to Webpage that modify newly created ticket,so as to edit Ticket and View QR
                }),
                function (error) {
                    console.log(error);
                    toaster.pop("error", "SERVER ERROR", "ooh nothing was saved error ");
                };

   };

   function assignToTechnicianToTicket(ticketId,ticketAssignData){
       serverServices.post('/ticketSetTechnician/'+ticketId,ticketAssignData)
           .then(function () {
               console.log("valis");
           }).
           catch(function (e) {
               console.log(e);
       });
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
            $scope.stocks.push(data.value);  //add item to potential Stocks
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
        };

        return total;
    }

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
