/**
 * Created by dylan on 9/21/16.
 */
app.controller("ticketCommentCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {
    $scope.newComment={}; //new Comment that is supposed to be posted On ticket
    $scope.$on('changeCommentTicket',function () { //refresg data if new Txt field
       getComments();
    });

    getComments();
    //comments
    function getComments() {
        serverServices.get('api/ticketComments/'+$scope.ticketId).then(
            function (result) {
                $scope.comments=result;
            },function (result) {
                console.log(result);
            }
        )

    }
    $scope.postComment=function () {
        serverServices.post('api/ticketComments/'+$scope.ticketId,$scope.newComment).then(
            function (result) {
                $scope.$emit("changeCommentTicket");
            },function (result) {

            });
    };
});