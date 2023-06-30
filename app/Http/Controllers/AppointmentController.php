<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $appointments = Appointment::query();

        // foreach ($request->all() as $key => $value) {
        //     $appointments = $appointments->where($key, $value);
        // }

        // return $appointments->with("employee")->with("service")->orderBy('date', 'desc')->get()->toArray();
        return Appointment::orderBy('date', 'desc')->with("employee")->with("service")->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //AppointmentRequest
    {
        $data = $request->all();    //ha megvan az AppointmentRequest, akkor a validated() metódussal kell
        Appointment::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return $appointment->load("employee")->load("service")->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AppointmentUpdateRequest  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment) //TODO: AppointmentUpdateRequest
    {
        $data = $request->all();    //ha megvan az AppointmentUpdateRequest, akkor a validated() metódussal kell
        $appointment->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response('', 204);
    }

}
