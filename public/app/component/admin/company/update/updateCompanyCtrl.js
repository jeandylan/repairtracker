/**
 * Created by dylan on 9/25/16.
 */
app.controller("updateCompanyCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices) {
    editableOptions.theme = 'bs3';
    $scope.companyId=$stateParams.companyId;
    $scope.companyLocations=[];
    $scope.unSavedCompanyLocations=[];
    $scope.addCompanyLocation=function () {
        $scope.companyLocations.push({});
    };



    $scope.removeUnsavedCompanyLocations=function (unsavedCompanyLocation) {
        index=$scope.unsavedCompanyLocations.indexOf(technician);
        if (index > -1) {
            $scope.unsavedTechniciansTask.splice(index, 1);
        }
    };


    $scope.statuses = [
        {value: 1, text: 'valid'},
        {value: 0, text: 'invalid'}
    ];

    function getCompany() {
            serverServices.get('saas/company/'+$scope.companyId).then(
                function (result) {
                    $scope.company=result;
                },function (result) {
                    console.log(result);
                })
        }

        $scope.getCompanyLocation=function(){
            serverServices.get('saas/companyLocations/'+$scope.companyId).then(
                function (result) {
                    console.log(result);
                    $scope.companyLocations=result;

                }
            )
    }

   $scope.updateCompany=function () {
       serverServices.put('saas/company/'+$scope.companyId,$scope.company).then();
   }
   
   $scope.updateCompanyLocation=function (companyLocation) {
       serverServices.put('saas/companyLocations/'+companyLocation.id,companyLocation).then(function (result) {
           console.log(result);
       });
   };
   $scope.addCompanyLocation=function () {
       $scope.unSavedCompanyLocations.push({});
   }

   $scope.saveUnsavedCompanyLocation=function (unsavedCompany) {
       serverServices.post('saas/companyLocations/'+$scope.companyId,unsavedCompany).then(function () {

       });
   };


    getCompany();
    $scope.getCompanyLocation();



});