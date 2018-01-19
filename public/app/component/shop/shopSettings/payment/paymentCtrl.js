/**
 * Created by dylan on 10/4/16.
 */

var app =
    angular.module('app').config(function (stripeProvider) {
        stripeProvider.setPublishableKey('pk_test_8hNQcjN6V2nZDepb55sXeMSt');
});
app.controller('paymentCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter,stripe) {
    Stripe.setPublishableKey('pk_test_8hNQcjN6V2nZDepb55sXeMSt');

    $scope.dateOptions = {
        formatYear: 'yy',
        maxDate: new Date(),
        startingDay: 1
    };

$scope.token='';
//424242424242 4242
    $scope.pay = function () {
        $scope.car={
            number:4242424242424242,
            cvc: $scope.card.cvc,
            exp_month: 04,
            exp_year: 2020
        };
        return stripe.card.createToken($scope.car)
            .then(function (response) {
                $scope.token=response.id;

            }).then(function (token) {
                serverServices.post('api/payment',{token:$scope.token}).then(function (result) {
                    console.log(result);
                })
            })

            .catch(function (err) {
                if (err.type && /^Stripe/.test(err.type)) {
                   toaster.pop('warning',"card err",err.message)
                }
                else {
                    toaster.pop('warning',"card err",err.message)
                    console.log('Other error occurred, possibly with your API', err.message);
                }
            });
    };


});