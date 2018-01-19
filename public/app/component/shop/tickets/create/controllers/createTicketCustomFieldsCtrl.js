/**
 * Created by dylan on 10/2/16.
 */
app.controller("createTicketCustomFieldsCtrl",function ($scope,$stateParams,serverServices,toaster,$state,ngDialog,$filter,$rootScope) {

    $scope.getFields=function () {
        serverServices.get('api/ticketCustomFields') //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {
                    console.log(result);
                    $scope.customTextFields=result;
                },
                function (error) {

                }
            );
    };

    $scope.getFields();
    
    $scope.saveCustomFields=function (customField,ticketId) {
        serverServices.post('api/customTextFieldData',{custom_text_field_id:customField.id,entity_id:ticketId,field_data:customField.field_data}).then(function () {
           console.log("save")
        })
    };

    $rootScope.$on('ticketSaved', function(event, ticketId) {
       for(var i=0;i < $scope.customTextFields.length;i++){
           console.log($scope.customTextFields[i]);
           $scope.saveCustomFields($scope.customTextFields[i],ticketId);



       }
        $rootScope = $rootScope.$new(true); //can be dangerous with permissions
        $scope = $scope.$new(true); //can be dangerous
        //$scope.getFields();

    });
});