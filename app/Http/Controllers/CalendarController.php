<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use App\EmployeeTicket;
use App\Http\Requests;

class CalendarController extends Controller
{
    public function getAllEventDates(){
        $tickets=Ticket::all();
        $output=[];
        foreach ($tickets as $ticket){
            $expectedCompletionDate=[];
            foreach ($ticket->technician()->get() as $technicianTask){
                array_push($expectedCompletionDate,["estimated_completion_date"=>$technicianTask->estimated_completion_date]);
            }
            array_push($output,["ticket_id"=>$ticket->id,
                "customer_appointment_date"=>$ticket->customer_appointment_date,
                "estimated_completed_date"=>$ticket->estimated_completion_date,"task_estimated_completion_date"=>$expectedCompletionDate]);
        }
        return $output;
    }

    public function getLocationAppointmentDates(){
        $tickets=Ticket::all();
        $output=[];
        foreach ($tickets as $ticket){
            array_push($output,["url"=>$ticket->id,"title"=>"appointment",
                "startsAt"=>$ticket->customer_appointment_date]);
        }
        return $output;
    }

    public function getLocationTicketTaskEstimationCompletionDate(){  ///Task Assign to employee Estimated Completion
        $tickets=Ticket::all();
        $output=[];
        foreach ($tickets as $ticket){
            $tasks= $ticket->employeeTask()->get();
            foreach ($tasks as $task){
                array_push($output,["url"=>$ticket->id,"title"=>"ticket task Completion",
                    "startsAt"=>$task->estimated_completion_date]);
            }
        }
        return $output;
    }

    public function getTicketEstimatedCompletionDates(){ //ticket Estimation Completed
        $tickets=Ticket::all();
        $output=[];
        foreach ($tickets as $ticket){

            array_push($output,["title"=>"ticket Expected Completion","url"=>$ticket->id,
                "startsAt"=>$ticket->estimated_completion_date]);
        }
        return $output;
    }


}
