/**
 * Created by dylan on 9/30/16.
 */
app.controller('customizeInvoiceEmailCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter){


    $scope.tinymceOptions = {
        onChange: function(e) {
            // put logic here for keypress and cut/paste changes
        },
        inline: false,
        plugins : 'advlist autolink link lists charmap print preview',
        skin: 'lightgray',
        theme : 'modern',
        automatic_uploads: true
    };
    function getInvoiceEmailHeader() {
        serverServices.get('api/customizeInvoiceEmailHeader').then(function (result) {
            $scope.invoice_email_header=result;
        })
    }
    function getInvoiceEmailFooter() {
        serverServices.get('api/customizeInvoiceEmailFooter').then(function (result) {
            $scope.invoice_email_footer=result;
        })
    }

    $scope.saveHeader=function () {
        serverServices.put('api/customizeInvoiceEmailHeader', {invoice_email_header: $scope.invoice_email_header}).then(function () {
        });
    }

    $scope.saveFooter=function () {
        serverServices.put('api/customizeInvoiceEmailFooter',{invoice_email_footer:$scope.invoice_email_footer}).then(function () {
        })
    }

    getInvoiceEmailFooter();
    getInvoiceEmailHeader();

});