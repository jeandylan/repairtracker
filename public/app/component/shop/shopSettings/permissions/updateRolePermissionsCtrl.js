/**
 * Created by dylan on 10/3/16.
 */
app.controller('updateRolePermissionsCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {

    serverServices.get('api/allPermissions').then(function (result) {
       $scope.AllpermissionsAdmin=result;
       $scope.getCurrentAdminPermission();
    });
    serverServices.get('api/allPermissions').then(function (result) {
        $scope.AllpermissionsTechnician=result;
        $scope.getCurrentTechnicianPermission();
    });


    $scope.getCurrentTechnicianPermission=function () {
       serverServices.get('api/rolePermissions/technician').then(function (result) {
           $scope.curentTechnicianPermission=result;
          updateViewActivePermission($scope.AllpermissionsTechnician,$scope.curentTechnicianPermission);
       })
    };

    $scope.getCurrentAdminPermission=function () {
        serverServices.get('api/rolePermissions/admin').then(function (result) {
            $scope.curentAdminPermission=result;
           updateViewActivePermission($scope.AllpermissionsAdmin,$scope.curentAdminPermission);

        })
    };

    function updateViewActivePermission(arrAllPermission,arrCurrentPermission) {
        for (var i = 0; i < arrAllPermission.length; i++) {
            for (var x = 0; x < arrCurrentPermission.length; x++) {
                if (arrAllPermission[i].name == arrCurrentPermission[x].name) {
                    arrAllPermission[i].select=true;
                    console.log(arrAllPermission[i].name);
                }
            }
        }
    }



    
    $scope.updateAdminRole=function () {
        serverServices.put('/api/rolePermissions/admin',{names:findSelect($scope.AllpermissionsAdmin)}).then(function () {
        })
        
    };
    
    $scope.updateTechnicianRole=function () {
        serverServices.put('/api/rolePermissions/technician',{names:findSelect($scope.AllpermissionsTechnician)}).then(function () {
        })
    };

    function findSelect(permission) {
        selectedPermission=[];
        for(var i=0; i< permission.length;i++){
            if(permission[i].select) selectedPermission.push(permission[i].name);

        }
        return selectedPermission;
    }
});