/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("updateTicketCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster) {
    editableOptions.theme = 'bs3';
    $scope.qr=$location.path();
    $scope.ticketId=$stateParams.ticketId;
    getTicketData($scope.ticketId);
    getFieldData($scope.ticketId);


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

    function getFieldData(id) {
        serverServices.get('api/ticketfieldsdata/'+id).then(
            function (result) {
                $scope.txtFields = result;

            },
            function (result) {
               toaster.pop('error', "server Err", result.message);
                console.log(result);
            });

    }

    $scope.$on('fieldDataChanged',function () { //refresg data if new Txt field
       getFieldData($scope.ticketId);
    });

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
    $scope.updateTxtData=function ($txtField) {
        console.log($txtField);
        var updateFieldData={
            field_data:$txtField.data[0].field_data
        };
        serverServices.put('api/fielddata/'+$txtField.data[0].id,updateFieldData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                },
                function (error) {
                    // handle errors here

                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );
    };

    $scope.createTxtData=function ($txtField) {
        console.log('creating');
        var newTxtData={
            field_data:$txtField.data[0].field_data,
            entity_id:$scope.ticketId,
            field_id:$txtField.properties.id
        };

        serverServices.post('api/fielddata',newTxtData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                    $scope.$emit("fieldDataChanged");
                },
                function (error) {
                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );
    }


});
