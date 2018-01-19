/**
 * Created by dylan on 10/1/16.
 */
app.controller('importExportDataCtrl',function (serverServices,$scope,$rootScope,$timeout) {
$scope.xmlFileStocks=null;
    $scope.xmlFileCustomers=null;
    $scope.xmlFileSuppliers=null;

    $scope.uploadStocksXml = function (e, reader, file, fileList, fileOjects, fileObj) {
        serverServices.post('api/importData/stocks/xml',fileObj).then();
    };
    $scope.uploadCustomersXml = function (e, reader, file, fileList, fileOjects, fileObj) {
        serverServices.post('api/importData/customers/xml',fileObj).then();
    };
    $scope.uploadSuppliersXml = function (e, reader, file, fileList, fileOjects, fileObj) {
        serverServices.post('api/importData/suppliers/xml',fileObj).then();
    };


});