/**
 * Created by dylan on 9/25/16.
 */
app.controller("createCompanyCtrl",function ($scope,serverServices,toaster, $state) {
console.log("mdd")
$scope.companyLocations=[];
    $scope.addCompanyLocation=function () {
        $scope.companyLocations.push({});

    };

    $scope.createCompany=function () {
        /*
        if($scope.company_form.$invalid) {
            return;
        }
        */
       $scope.owner.price_per_month = 25 + ($scope.companyLocations.length * 15) + ($scope.owner.max_customers * 0.5) + ($scope.owner.max_employees * 10);

        console.log($scope.owner);

        var companyData={
            company_details:$scope.owner,
            company_location:$scope.companyLocations
        };

        serverServices.post("saas/company",companyData).then(function (result) {
            $state.go("app.company");
        })

    }


});