<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * !!!!!!!!!!!!very import do import the model first!!!!!!!!!!!!!!!!
     *
     * @return Response
     */
    public function index()
    {
        return Customer::all();


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = array(
            'first_name'       => 'required',
            'last_name'      => 'required',
            'email' => 'email'
        );
        $validator = Validator::make(Input::all(), $rules);

        $customer = new Customer();
        $customer->first_name=Input::get('first_name');
        $customer->last_name=Input::get('last_name');
        $customer->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function get($id)
    {
        
        return Customer::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
