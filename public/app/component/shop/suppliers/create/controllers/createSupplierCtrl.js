/**
 * Created by dylan on 03-Aug-16.
 */
app.controller("createsupplierCtrl",function ($scope,serverServices,toaster,$http) {

    /*telephone sec*/
    $scope.telephones=[]; //array to contain all telephone numbers

    $scope.createTelephoneNumber=function () {
        $scope.telephones.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };

    $scope.deleteTelephoneNumber=function (telephone) {
        index=$scope.telephones.indexOf(telephone);
        if (index > -1) {
            $scope.telephones.splice(index, 1);
        }
    };
    /*address sec*/
    /*address Autocomplete*/
    $scope.getLocation = function(val) {
        return $http.get('//maps.googleapis.com/maps/api/geocode/json', {
            params: {
                address: val,
                sensor: false
            }
        }).then(function(response){
            return response.data.results.map(function(item){
                return item.formatted_address;
            });
        });
    };

    $scope.addresses=[];

    $scope.createAddress=function () {
        $scope.addresses.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };

    $scope.deleteAddress=function (telephone) {
        index=$scope.addresses.indexOf(telephone);
        if (index > -1) {
            $scope.addresses.splice(index, 1);
        }
    };
    /*email sec*/
    $scope.emails=[];

    $scope.createEmail=function () {
        $scope.emails.push({}); //push empty (for now ) object ->uniquely identify because of hash

    };

    $scope.deleteEmail=function (telephone) {
        index=$scope.emails.indexOf(telephone);
        if (index > -1) {
            $scope.emails.splice(index, 1);
        }
    };

    $scope.createSupplier=function () {//it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
        console.log($scope.telephones);

        var supplierData={
            first_name:$scope.supplier.first_name,
            last_name:$scope.supplier.last_name,
            company:$scope.supplier.compnay_name,
            telephones:$scope.telephones,
            addresses:$scope.addresses,
            emails:$scope.emails


        };
        serverServices.post('api/supplier',supplierData) //using service (supplier/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {

                    toaster.pop("success","DONE",result.message);
                },
                function (error) {
                    // handle errors here
                    toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );

    }

});
