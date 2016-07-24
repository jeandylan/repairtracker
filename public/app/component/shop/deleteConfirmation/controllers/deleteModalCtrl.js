/**
 * Created by dylan on 08-Jul-16.
 */
app.controller('deleteModalCtrl', function ($scope, $uibModalInstance, deleteUrl,confirmBoxMessage,serverServices,toaster) {

    $scope.deleteUrl= deleteUrl;
    $scope.confirmBoxMessage=confirmBoxMessage;

/*
this should be called Only on HTML page with <toaster></toaster> Tag Somewhere,pretty much every page in this webapp have <toast>
because app.html the base html have a <toast> tag
 */
    $scope.ok = function () {
        serverServices.delete(deleteUrl).then(function (response) {
                toaster.pop('success', response.message);
        },
        function (response) {
            toaster.pop('error', response.message);

        });


        $uibModalInstance.close($scope.deleteUrl);
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});