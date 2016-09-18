/**
 * Created by dylan on 03-Jul-16.
 */

app.controller("updateTicketCtrl",function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,ngDialog,$filter) {
    editableOptions.theme = 'bs3';
    $scope.newComment={}; //new Comment that is supposed to be posted On ticket
    $scope.qr=$location.path(); //QR have Address of ticket
    $scope.ticketId=$stateParams.ticketId;
    $scope.minDate=new Date();
    $scope.opened = {};
    $scope.unsavedStocks=[];
    $scope.unsavedTechniciansTask=[];
    $scope.currentUser=CacheFactory.get('appCache').get('profile'); //obtain current  login user from cache (used to know who post Comments)
    getTicketData($scope.ticketId);
    getStockUsed();
    getComments();
   /// getFieldData($scope.ticketId);
    getTaskAssign();

    $scope.$on('fieldDataChanged',function () { //refresg data if new Txt field
        getFieldData($scope.ticketId);
    });

    $scope.$on('newCommentPosted',function () {
        $scope.newComment={};
        getComments();
    });

    $scope.$on('changeTask',function () {
        $scope.unsavedTechniciansTask=[];
        getTaskAssign();
    });

//General
    function  getTicketData() {
        serverServices.get('api/ticket/'+$scope.ticketId)//id parameter obtain by doing state parameter (like a query)
            .then(
                function (result) {
                    $scope.ticket = result;
                    console.log(result)
                },
                function (result) {
                    console.log(result);
                });
    }
    $scope.open = function($event, elementOpened) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.opened[elementOpened] = !$scope.opened[elementOpened];
    }; //calendar Func

    ///Function definition Task
    function getTaskAssign(){
        serverServices.get('api/ticketTechnician/'+$scope.ticketId).then(
            function (result) {
                $scope.tasks=result;
               console.log(result)
            },function (result) {
                console.log(result);
            })
    }
    $scope.createTask=function () {
        for (var i in $scope.unsavedTechniciansTask) {
            (!$scope.unsavedTechniciansTask[i].ticket)?toaster.pop('warning', 'error at Task'+(i+1), "Job Assign Canoot be blank"):
                $scope.unsavedTechniciansTask[i].ticket.employee_id= $scope.unsavedTechniciansTask[i].id;
            serverServices.post('api/ticketTechnician/'+$scope.ticketId,$scope.unsavedTechniciansTask[i].ticket)
                .then(function () {
                    if(i==$scope.unsavedTechniciansTask.length-1)$scope.$emit("changeTask");
                }),
                function (error) {
                };
        }
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
                $scope.$emit("changeTask");
            },function () {
            })
    };

    //function Stocks
    function getStockUsed(){
        serverServices.get('api/ticketStock/'+$scope.ticketId).then(
            function (result) {
                $scope.usedStocks=result;
                //console.log(result)
            },function (result) {
                console.log(result);
            })
    }
    $scope.saveStock=function (stock) {
        serverServices.post('api/ticketStock/'+$scope.ticketId,stock).then(
            function (result) {
                console.log(result);
                $scope.removeUnsavedStock(stock);
                getStockUsed();
            },function (result) {
                
            })


    };
    $scope.selectStock=function () {
        ngDialog.open({
            template: 'app/component/shop/tickets/update/views/select-stock.html',
            controller:'selectStockCtrl',
            className: 'ngdialog-theme-default',
            scope:$scope
        }).closePromise.then(function (data) {
            if(data.value.id) $scope.unsavedStocks.push(data.value);  //add item to potential Stocks
        });
    };
    $scope.removeUnsavedStock=function (stock) {
        index=$scope.unsavedStocks.indexOf(stock);
        if (index > -1) {
            $scope.unsavedStocks.splice(index, 1);
        }
    };

    //comments
    function getComments() {
        serverServices.get('api/ticketComments/'+$scope.ticketId).then(
            function (result) {
                $scope.comments=result;
                console.log(result)
            },function (result) {
                console.log(result);

            }
        )

    }
    $scope.postComment=function () {
        serverServices.post('api/ticketComments/'+$scope.ticketId,$scope.newComment).then(
            function (result) {
                $scope.$emit("newCommentPosted");
            },function (result) {

            });
    };


    function getFieldData() {
        serverServices.get('api/ticketfieldsdata/'+$scope.ticketId).then(
            function (result) {
                $scope.txtFields = result;

            },
            function (result) {
               toaster.pop('error', "server Err", result.message);
                console.log(result);
            });
    }

    $scope.updateTicket=function () {
        var ticketUpdateData=
        {  // array containing Updated Ticket data,to be saved in db
            model:$scope.ticket.info.model,
            make:$scope.ticket.info.make,
            problem_type:$scope.ticket.info.problem_type,
            problem_definition:$scope.ticket.info.problem_definition
        };
        console.log(ticketUpdateData);

        var updateUrl='api/ticket/'+$scope.ticketId;//using the parameter TicketId from url stored in $scope.TicketId,,this will be used to construct put url
        serverServices.put(updateUrl,ticketUpdateData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                },
                function (error) {
                    // handle errors here

                    toaster.pop("error","Failed",error.message);
                }
            );
    };
    $scope.updateTxtData=function ($txtField) {
        console.log($txtField);
        var updateFieldData={
            field_data:$txtField.data[0].field_data
        };
        serverServices.put('api/fielddata/'+$txtField.data[0].id,updateFieldData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                },
                function (error) {
                    // handle errors here

                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );
    };

    $scope.createTxtData=function ($txtField) {
        console.log('creating');
        var newTxtData={
            field_data:$txtField.data[0].field_data,
            entity_id:$scope.ticketId,
            field_id:$txtField.properties.id
        };
        serverServices.post('api/fielddata',newTxtData) //using service (public/app/component/core/services/serverServices.js) that will query Laravel for .json output/Input
            .then(
                function (result) {
                    toaster.pop("success","Done",result.message);
                    $scope.$emit("fieldDataChanged");
                },
                function (error) {
                    toaster.pop("error","Failed","ooh nothing was saved error ");
                }
            );
    };





});
