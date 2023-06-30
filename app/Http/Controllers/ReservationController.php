<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Reservation;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $reservations = Reservation::query();

        foreach ($request->all() as $key => $value) {
            $reservations = $reservations->where($key, $value);
        }

        $response = $reservations
            ->where("user_id", $request->user()->id)
            ->with(["appointment", "appointment.service", "appointment.employee"])
            ->get()
            ->sortByDesc("appointment.date")
            ->toArray();

        return array_values($response);
    }

    public function getAll(Request $request)
    {
        $reservations = Reservation::query();

        foreach ($request->all() as $key => $value) {
            $reservations = $reservations->where($key, $value);
        }

        $response = $reservations
            ->with(["appointment", "appointment.service", "appointment.employee"])
            ->get()
            ->sortByDesc("appointment.date")
            ->toArray();

        return array_values($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReservationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //ReservationRequest
    {
        $data = $request->all();    //ha megvan a ReservationRequest, akkor a validated() metódussal kell
        Reservation::create($data);

        $reservations = Reservation::query();

        foreach ($request->all() as $key => $value) {
            $reservations = $reservations->where($key, $value);
        }

        $response = $reservations
            ->where("appointment_id", $request->appointment_id)
            ->with(["appointment", "appointment.service", "appointment.employee"])
            ->get()
            ->sortBy("appointment.date")
            ->toArray();

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $reservation->user_id) {
            return abort(403, 'Unauthorized action');
        }

        return $reservation->load('appointment', 'appointment.service');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ReservationRequest  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation) //ReservationRequest
    {
        $data = $request->all();
        $reservation->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation, Request $request)
    {
        $response = $reservation
            ->where("appointment_id", $reservation->appointment_id)
            ->with(["appointment", "appointment.service", "appointment.employee"])
            ->get();

        $reservation->delete();

        return $response;
    }

}
