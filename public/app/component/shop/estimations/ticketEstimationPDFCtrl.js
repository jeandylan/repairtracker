/**
 * Created by dylan on 9/20/16.
 */
app.controller('viewEstimationCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter,Upload) {
    var canvas = document.querySelector("canvas");
   // $scope.signUser=CacheFactory.get('appCache').get('profile');

    var signaturePad = new SignaturePad(canvas);
    $scope.ticketId=$stateParams.ticketId;
    $scope.stocksTotal=0;
    $scope.stockItems=[];
    $scope.labourItems=[];
    $scope.getCustomerEmail=function () {
        serverServices.get('api/ticketEmail/'+$scope.ticketId).then(function (result) {
            $scope.emailAddresses=result;

        });
    };

    $scope.getCustomerEmail(); //get All Email A customer have provide

    function getEstimationData() {
        serverServices.get('api/estimation/'+$scope.ticketId).then(function (response) {
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
    getEstimationData();

    function getEstimationEmailHeader() {
        serverServices.get('api/customizeEstimationEmailHeader').then(function (result) {
            $scope.estimation_email_header=result;
        })
    }
    function getEstimationEmailFooter() {
        serverServices.get('api/customizeEstimationEmailFooter').then(function (result) {
            $scope.estimation_email_footer=result;
        })
    }

    getEstimationEmailFooter();
    getEstimationEmailHeader();


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

    $scope.sentEmailPDF = function (file,emailAddresses) {
        Upload.upload({
            url: 'api/estimationEmail',
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
                            width: 600,
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

     $scope.clearSignature=function () {

        signaturePad.clear();
    }
});