/**
 * Created by dylan on 10/2/16.
 */
app.controller("updateTicketCustomFieldsCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {

    function getFieldData() {
        serverServices.get('api/ticketCustomFieldUpdating/'+$scope.ticketId).then(
            function (result) {
                $scope.txtFields = result;
                console.log(result[0])
            },
            function (result) {
                toaster.pop('error', "server Err", result.message);
                console.log(result);
            });
    }
    getFieldData();

    $scope.updateTxtData=function ($txtField) {
        console.log($txtField);
        var updateFieldData={
            field_data:$txtField.data.field_data
        };
        serverServices.put('api/customTextFieldData/'+$txtField.data.id,updateFieldData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
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
            field_data:$txtField.data.field_data,
            entity_id:$scope.ticketId,
            custom_text_field_id:$txtField.properties.id
        };
        serverServices.post('api/customTextFieldData',newTxtData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                    getFieldData();
                },
                function (error) {
                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );
    };
});