<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Employee;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::query();

        foreach ($request->all() as $key => $value) {
            $employees = $employees->where($key, $value);
        }

        return $employees->orderBy('name')->get()->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreUpdateRequest $request) //EmployeeRequest
    {
        //$data = $request->all();    //ha megvan a EmployeeRequest, akkor a validated() metódussal kell
        $validated = $request->validated();
        // if($validated)
            Employee::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return $employee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeStoreUpdateRequest $request, Employee $employee) //UpdateEmployeeRequest
    {
        //$data = $request->all();
        $validated = $request->validated();
        $employee->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, Request $request)
    {
        $employee->delete();

        return response('Delete successful', 204);
    }

}
