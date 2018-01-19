app.controller("MessageListCtrl", function ($scope, serverServices, toaster) {

    getAllMessagesData();

    $scope.displayedCollection = [];
    $scope.rowCollection = [];

    $scope.loadingStatus = 1;

    function getAllMessagesData() {
        serverServices.get('saas/messages').then(function (response) {
                //console.log(response);
                $scope.loadingStatus = 0;
                $scope.displayedCollection = [];
                $scope.rowCollection = [];
                $scope.rowCollection = response;
                $scope.displayedCollection = [].concat($scope.rowCollection);
            },
            function (error) {
                $scope.loadingStatus = 0;
                toaster.pop('error', "Server Error : " + error.status, "An error occurred ,try reload the page");
                console.log(error);
            });

    }

    $scope.deleteBtn = function (id) {
        serverServices.delete('saas/message/' + id).then(function () {
            getAllSupporterData();
        });
    }

});