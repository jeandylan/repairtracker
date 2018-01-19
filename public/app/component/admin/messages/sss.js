app.controller("MessageViewCtrl",function ($scope,serverServices,toaster, $state) {

    console.log("I;m here");
    $scope.messageId=$stateParams.messageId;

    $scope.statuses = [
        {value: 1, text: 'Active'},
        {value: 0, text: 'Inactive'}
    ];

    function getMessage() {
        serverServices.get('saas/message/'+$scope.messageId).then(
            function (result) {
                $scope.message=result;
            },function (result) {
                console.log(result);
            })
    }

    $scope.deleteBtn = function (id) {
        serverServices.delete('saas/message/' + $scope.messageId).then(function () {
            $state.go("app.messagesList");
        });
    }

    getMessage();

});