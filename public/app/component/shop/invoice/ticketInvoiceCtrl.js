app.controller('ticketInvoiceCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter,Upload) {
    var canvas = document.getElementById('canvas');
    // $scope.signUser=CacheFactory.get('appCache').get('profile');
    //console.log($scope.signUser)
    var signaturePad = new SignaturePad(canvas);
    $scope.ticketId=$stateParams.ticketId;
    $scope.stocksTotal=0;
    $scope.stockItems=[];
    $scope.labourItems=[];
    $scope.unSavedLabourItems=[];
    $scope.selectedEmailAddresses=[];
    $scope.$on('invoiceChanged', function(event) {
        $scope.unSavedLabourItems=[];
        getInvoiceData();
    });


    getInvoiceData();

    function getInvoiceData() {
        serverServices.get('api/invoice/'+$scope.ticketId).then(function (response) {
                console.log(response);
                $scope.displayedCollection = [];  // displayed collection--->used by angular scope
                $scope.rowCollection = [];  // base collection--->used to store data from Async from server , to be used by angular Scope
                $scope.rowCollection = response; //update the original Array ,this is used so as to Synchronised Scope with asynchronous data obtain from dserver
                $scope.displayedCollection = [].concat($scope.rowCollection);
                $scope.stockItems=response.stocks;///insert the data from server with the one used by angular scope
                $scope.labourItems=response.labours;

                $scope.stocksTotal=TotalStock();
                $scope.labourTotal=TotalLabour();
            },
            function (error) {
                console.log(error);
            });
    };

    $scope.getCustomerEmail=function () {
        serverServices.get('api/ticketEmail/'+$scope.ticketId).then(function (result) {
            $scope.emailAddresses=result;
            
        });
    };

    $scope.getCustomerEmail(); //get All Email A customer have provide

    function getInvoiceEmailHeader() {
        serverServices.get('api/customizeInvoiceEmailHeader').then(function (result) {
            $scope.invoice_email_header=result;

        })
    };

    getInvoiceEmailHeader();

    function getInvoiceEmailFooter() {
        serverServices.get('api/customizeInvoiceEmailFooter').then(function (result) {
             $scope.invoice_email_footer=result;
        })
    }
    getInvoiceEmailFooter();




    /*labour iNvoice func*/

    $scope.deleteLabourInvoice=function(labour){
        serverServices.delete('api/invoiceLabour/'+labour.id).then(function (result) {
            $scope.$emit('invoiceChanged');
        })
    };
    
    $scope.updateLabourInvoice=function (labour) {
        if(labour.cost && labour.name)
            serverServices.put('api/invoiceLabour/' + labour.id, labour).then(function () {
                $scope.$emit('invoiceChanged');

            });

    };
    $scope.addUnsavedLabour=function () {
        $scope.unSavedLabourItems.push({});
    };
    
    $scope.saveLabourInvoice=function (labour) {
        if(labour.cost && labour.name)
        serverServices.post('api/invoiceLabour/'+$scope.ticketId,labour).then(function () {
            $scope.$emit('invoiceChanged');
        });
    };
    
    

    $scope.removeLocally=function (arrayObjects,object) {
        index=arrayObjects.indexOf(object);
        if (index > -1) {
            arrayObjects.splice(index, 1);
        }
    };
    

    /*pdf Calculationss*/
    
    function TotalStock() {
        total=0;
        for (i = 0; i < $scope.stockItems.length; i++) {
            total+=$scope.stockItems[i].qty_out*$scope.stockItems[i].selling_price;}
        return total;
    };
    function TotalLabour() {
        total=0;
        for (i = 0; i < $scope.labourItems.length; i++) {
            total+=$scope.labourItems[i].cost;
        }
        return total;
    };

    $scope.sentEmailPDF = function (file,emailAddresses) {
        Upload.upload({
            url: 'api/invoiceEmail',
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
            html2canvas(document.getElementById(documentId) ,{
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    console.log(data)
                    var docDefinition = {
                        pageSize: 'A4',
                        content: [{
                            image: data,
                            width: document.getElementById(documentId).offsetWidth,
                            height:document.getElementById(documentId).offsetHeight
                        }],
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
                    //console.log(pdfMake.createPdf(docDefinition))
                       // $scope.sentEmailPDF(pdfMake.createPdf(docDefinition),$scope.selectedEmailAddresses);
                        //$scope.sentEmailPDF(docDefinition,$scope.selectedEmailAddresses);
                }
            });
        },100);

    };


    $scope.clearSignature=function () {

        signaturePad.clear();
    }

});