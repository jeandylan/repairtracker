/**
 * Created by dylan on 9/30/16.
 */
app.controller('customizeEstimationEmailCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter){


    $scope.tinymceOptions = {
        onChange: function(e) {
            // put logic here for keypress and cut/paste changes
        },
        inline: false,
        plugins : 'advlist autolink link  lists charmap print preview',
        skin: 'lightgray',
        theme : 'modern',
        automatic_uploads: true
    };
    function getEstimationHeader() {
        serverServices.get('api/customizeEstimationEmailHeader').then(function (result) {
            $scope.estimation_email_header=result;
        })
    }
    function getEstimationFooter() {
        serverServices.get('api/customizeEstimationEmailFooter').then(function (result) {
            $scope.estimation_email_footer=result;
        })
    }

    $scope.saveHeader=function () {
        serverServices.put('api/customizeEstimationEmailHeader', {estimation_email_header: $scope.estimation_email_header}).then(function () {
        });
    }
        
    $scope.saveFooter=function () {
        serverServices.put('api/customizeEstimationEmailFooter',{estimation_email_footer:$scope.estimation_email_footer}).then(function () {
        })
    }

    getEstimationFooter();
    getEstimationHeader()

});