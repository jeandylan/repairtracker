/**
 * Created by dylan on 13-Aug-16.
 */
app.controller("formEditorCtrl",function ($scope,$stateParams,$state) {
    $scope.formName=$stateParams.formName;
    $state.current.pageTitle=$scope.formName+" form editor page";
    console.log("r");
});