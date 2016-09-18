<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeTicket;
use App\Ticket;
use App\Employee;
use App\AllEmployee;
use App\Http\Requests;

class EmployeeTaskController extends Controller
{
    public function delete($taskId){
        $task=EmployeeTicket::find($taskId);
        if(!$task)  return response()->json(['error' => "Task not found :-or other reasons"], 404);
        $task->delete();
        return  array("successful"=>true, "message"=>"Technican Job Deleted");


    }

    public function create($ticketId,Request $request){
        $ticket=Ticket::find($ticketId);
        $technician = Employee::find($request->input('employee_id'));
        if(!$ticket || !$technician) return response()->json(['error' => "Ticket /Technician not in this location/does not exist :-or other reasons"], 404);

        // $EmployeeTicket=new EmployeeTicket();
        $ticket->employee()->attach($technician->id,$request->all());
        return  array("successful"=>true, "message"=>"Technican Job created");
    }

    public function update($taskId,Request $request){
        $task=EmployeeTicket::find($taskId);
        if(!$task) return response()->json(['error' => "task not in this location/does not exist :-or other reasons"], 404);
        $task->job_assign=$request->input('job_assign');
        $task->completed_percentage=$request->input('completed_percentage');
        $task->hours_work_on=$request->input('hours_work_on');
        $task->estimated_completed_date=$request->input('estimated_completed_date');
        $task->save();
        return  array("successful"=>true, "message"=>"Technican Job updated");
    }

    public function get($ticketId){
        $ticket=Ticket::find($ticketId);
        $output = [];
        if($ticket) {
            $tasks = $ticket->technician()->get();
            foreach ($tasks as $task) {
                if ($employee = Employee::find($task->employee_id)) {
                    $employeeDet = ['id' => $employee->id, 'first_name' => $employee->first_name, 'last_name' => $employee->last_name];
                    array_push($output, ['task' => $task,
                        'employee' => $employeeDet]);
                }
                else { //look for Employee no more In this Location
                    if ($allEmployee = AllEmployee::find($task->employee_id)) {
                        $AllEmployeeDet = ['id' => $allEmployee->id, 'first_name' => $allEmployee->first_name, 'last_name' => $allEmployee->last_name,
                            'transferred' => true, 'shop_location' => $allEmployee->shop_location];

                        array_push($output,['task' => $task,
                            'employee' => $AllEmployeeDet]);
                    }
                }
            }
        }
        return $output;

    }
}
