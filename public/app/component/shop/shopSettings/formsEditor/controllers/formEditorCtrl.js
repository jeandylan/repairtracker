/**
 * Created by dylan on 13-Aug-16.
 */
app.controller("formEditorCtrl",function ($scope,$stateParams,$state,serverServices,toaster,editableOptions) {
    var vm = this;
    vm.formName=$stateParams.formName;
    $state.current.pageTitle=vm.formName+" form editor page";
    getFormField();
    vm.yesNo= [
        {value: 1, text: 'yes'},
        {value: 0, text: 'no'}
    ];

    $scope.$on('fieldDataChanged',function () { //refresg data if new Txt field
        getFormField();
    });


    function  getFormField() {
        serverServices.get('api/customTextField/'+vm.formName)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    vm.txtFormFields = result;
                },
                function (result) {
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);//could not get response from Server
                });
    }

    vm.deleteTextField=function (txtField) {
        serverServices.delete('api/customTextField/'+txtField.id)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.$emit("fieldDataChanged");
                    toaster.pop('success', "done", result.message);
                },
                function (result) {
                    // toaster.pop('error', "server Err", "we could not get info needed");
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    };

    vm.updateTextField=function (txtField) { //when the submit btn click (function call found in <form> tag on top)
            return serverServices.put('api/customTextField/' + txtField.id, txtField).then(
                function (result) {
                    toaster.pop('success', "done", result.message);
                },function (result) {
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                });
    };

   

});

app.controller("newFieldCtrl",function ($scope,$stateParams,$state,serverServices,toaster,editableOptions) {
   var vmNewField=this;
    vmNewField.newTextFormFields=[];

    vmNewField.createTextField=function ($e) {
        $e.preventDefault();
        vmNewField.newTextFormFields.push({form_name:'ticket'});
    };
    vmNewField.deleteNewTextField=function (newTextField) {
        index=vmNewField.newTextFormFields.indexOf(newTextField);
        if (index > -1) {
            vmNewField.newTextFormFields.splice(index, 1);
        }
    };

    vmNewField.saveNewTextField=function (newTextField) {
        console.log(newTextField);
       serverServices.post('api/customTextField',newTextField).then(
            function (result) {
                if (result.successful){
                    $scope.$emit("fieldDataChanged");
                    toaster.pop('success', "done", result.message);
                    vmNewField.deleteNewTextField(newTextField);

                }

            }
        )

    };

    vmNewField.deleteNewTextField=function (newTextField,$e) {
        if(typeof $e !== "undefined")$e.preventDefault();

        index=vmNewField.newTextFormFields.indexOf(newTextField);
        if (index > -1) {
            vmNewField.newTextFormFields.splice(index, 1);
        }
    };

    vmNewField.required=function ($data) {
        return (!$data )? "field required": null;
    };



});
