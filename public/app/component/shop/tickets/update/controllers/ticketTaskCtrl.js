/**
 * Created by dylan on 9/21/16.
 */
app.controller('ticketTaskCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {
    $scope.unsavedTechniciansTask=[];
    getTaskAssign();
    $scope.dateNotPast=function (data) {
        if( new Date() > data ){
            return "Date cannot be in the past";

        }
    };

    $scope.$on('changeTaskTicket',function () {
        console.log('task vhaneg');
        getTaskAssign();
    });

    ///Function definition Task
    function getTaskAssign(){
        serverServices.get('api/ticketTechnician/'+$scope.ticketId).then(
            function (result) {
                $scope.tasks=result;
            },function (result) {
                console.log(result);
            })
    }

    $scope.createTask=function () {
        for (var i in $scope.unsavedTechniciansTask) {
            (!$scope.unsavedTechniciansTask[i].ticket) ? toaster.pop('warning', 'error at Task' + (i + 1), "Job Assign Canoot be blank") :
                $scope.unsavedTechniciansTask[i].ticket.employee_id = $scope.unsavedTechniciansTask[i].id;
            serverServices.post('api/ticketTechnician/' + $scope.ticketId, $scope.unsavedTechniciansTask[i].ticket)
                .then(function () {
                    if (i == $scope.unsavedTechniciansTask.length - 1){
                        $scope.$emit('changeTaskTicket'); //do emit when array
                        $scope.unsavedTechniciansTask=[];
                    }
                    // iterator reach last unsavedTech.Task element
                }),
                function (error) {
                };
        }

    };
    $scope.updateTask=function(task){
        serverServices.put('api/ticketTechnician/'+task.id,task).then(
            function (result) {
                $scope.$emit('changeTaskTicket');
            },function (result) {
                console.log(result);
            })

    };
    $scope.selectTechnician=function () {
        ngDialog.open({
            template: 'app/component/shop/tickets/update/views/select-technician.html',
            controller:'selectTechnicianCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {

            if(data.value.id) $scope.unsavedTechniciansTask.push(data.value);
        });
    };
    $scope.removeTechnician=function (technician) {
        index=$scope.unsavedTechniciansTask.indexOf(technician);
        if (index > -1) {
            $scope.unsavedTechniciansTask.splice(index, 1);
        }
    };

    $scope.deleteTask=function (task) {
        serverServices.delete('api/ticketTechnician/'+task.task.id).then(
            function () {
                $scope.$emit("changeTaskTicket");
            },function () {
            })
    };
});