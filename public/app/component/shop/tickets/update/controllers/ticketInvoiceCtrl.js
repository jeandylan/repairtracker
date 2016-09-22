app.controller('ticketInvoiceCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {
    var canvas = document.getElementById('canvas');
    // $scope.signUser=CacheFactory.get('appCache').get('profile');
    //console.log($scope.signUser)
    var signaturePad = new SignaturePad(canvas);




    $scope.ticketId=$stateParams.ticketId;
    $scope.stocksTotal=0;
    $scope.stockItems=[];
    $scope.labourItems=[];
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
    }
    function TotalStock() {
        total=0;
        for (i = 0; i < $scope.stockItems.length; i++) {
            total+=$scope.stockItems[i].qty_out*$scope.stockItems[i].selling_price;

        }
        return total;
    };
    function TotalLabour() {
        total=0;
        for (i = 0; i < $scope.labourItems.length; i++) {
            total+=$scope.labourItems[i].cost;

        }
        return total;
    };

    $scope.toPdf=function (documentId,isPrint) {
        $scope.hide=true;
        setTimeout(function() {
            html2canvas(document.getElementById(documentId), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        pageSize: 'A4',
                        content: [{
                            image: data,
                            width: 700,
                        }]
                    };
                    $scope.hide = false;
                    if(!isPrint) pdfMake.createPdf(docDefinition).download("estimation"+$scope.ticketId+".pdf");
                    if(isPrint) pdfMake.createPdf(docDefinition).print();
                }
            });
        },100);

    }

    $scope.clearSignature=function () {

        signaturePad.clear();
    }
});