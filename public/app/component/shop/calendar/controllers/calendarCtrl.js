/**
 * Created by dylan on 9/22/16.
 */
app.controller('calendarCtrl',function ($scope,$location,editableOptions,$stateParams,serverServices,toaster,CacheFactory,$state) {
    $scope.calendarView = 'month';
    $scope.viewDate=new Date();
    $scope.events = [
    ];

    $scope.viewLocationAppointment=function () {
        serverServices.get('api/calendar/locationAppointment').then(function (result) {
            $scope.events=FormatTicketRelatedCalendar(result,"#EF5350","#FFCDD2");
        });
    };

    $scope.viewLocationEstimationCompletionDates=function () {
        serverServices.get('api/calendar/locationTicketEstimationCompletionDates').then(function (result) {
            $scope.events=FormatTicketRelatedCalendar(result,"#CDDC39","#827717");
        });

    };

    $scope.viewLocationTicketTaskEstimationCompletionDate=function () {
            serverServices.get('api/calendar/LocationTicketTaskEstimationCompletionDate').then(function (result) {
                console.log(result);
                $scope.events=FormatTicketRelatedCalendar(result,"#9E9E9E","#BCAAA4");
            });
    };




    function FormatTicketRelatedCalendar(array,primaryColor,secondaryColor){
        array.forEach(function myFunction(item, index) {
            item.startsAt=new Date(item.startsAt);
            item.color= { // can also be calendarConfig.colorTypes.warning for shortcuts to the deprecated event types
                primary: primaryColor, // the primary event color (should be darker than secondary)
                secondary: secondaryColor // the secondary event color (should be lighter than primary)
            };
            item.actions=[{
                label:'<i class="fa fa-link" aria-hidden="true">Lets See</i>',
                onClick: function(args) { // the action that occurs when it is clicked. The first argument will be an object containing the parent event
                    //$location.url('/update/ticket/1');
                    $state.go('app.ticket.update',{ticketId:item.url})
                }
            }]
        });
        return array;
    }
    $scope.viewLocationAppointment();

});
