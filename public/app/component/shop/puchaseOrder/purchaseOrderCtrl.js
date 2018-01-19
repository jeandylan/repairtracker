/**
 * Created by dylan on 10/2/16.
 */
app.controller('purchaseOrderCtrl', function($scope,serverServices,editableOptions,$filter, $state, $stateParams,toaster,$http,ngDialog,Upload) {
    $scope.stockId=$stateParams.stockId;
    var canvas = document.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas);
    $scope.selectedEmailAddresses=[];


    function getStockData() {
        serverServices.get('api/stock/' + $scope.stockId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.stock = result;
                },
                function (result) {
                    console.log(result);
                    toaster.pop('error', "server Err", result.message);
                    //could not get response from Server
                });
    };
    getStockData();

    function  getEmailAddress(supplierId) {
        serverServices.get('api/supplier/email/'+supplierId).then(function (result) {
            $scope.emailAddresses=result;
        })
    };
    $scope.sentEmailPDF = function (file,emailAddresses) {

        Upload.upload({
            url: 'api/purchaseOrderEmail',
            data: {file: file, 'emailAddresses': emailAddresses}
        }).then(function (resp) {
            console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp);
        }, function (resp) {
            console.log( resp.data);
        }, function (evt) {
            $scope.progressPercentage = parseInt(100.0 * evt.loaded / evt.total)+' %';
        });
    };

    $scope.toPdf=function (documentId,action) { //action === what to do with pdf generated ,download,print,email
        $scope.hide=true;
        setTimeout(function() {
            html2canvas(document.getElementById(documentId), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        pageSize: 'A4',
                        content: [{
                            image: data,
                            width: 400,
                        }]
                    };
                    $scope.hide = false;
                    if(action=="download") pdfMake.createPdf(docDefinition).download("estimation"+$scope.ticketId+".pdf"); //
                    if(action=="print") pdfMake.createPdf(docDefinition).print();
                    if(action=="email"){
                        pdfMake.createPdf(docDefinition).getBase64(function (data) {
                            console.log(data);
                            $scope.sentEmailPDF(data,$scope.selectedEmailAddresses);
                        });

                    };
                }
            });
        },100);
    };
    
    
    $scope.selectSupplier=function () {
        ngDialog.open({
            template: 'app/component/shop/puchaseOrder/select-suppliers-for-purchase-orders.html',
            controller:'selectSuppliersForPurchaseOrdersCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id) {
                $scope.selectedSupplier=data.value;
                getEmailAddress(data.value.id);
            } //add item to potential Stocks
        });
    };
});