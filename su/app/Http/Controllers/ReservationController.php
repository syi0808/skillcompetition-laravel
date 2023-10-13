<?php

namespace App\Http\Controllers;

use App\Reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create(Request $request) {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'car_number' => 'required',
            'people_count' => 'required',
            'price' => 'required',
            'campground_id' => 'required',
        ]);

        if(!Auth::check()) {
            return response()->json([
               message => "failed"
            ], 401);
        }

        $input = $request->all();
        $input['user_id'] = Auth::user()->id;

        $reservation = Reservations::query()->make($input);
        $reservation->save();

        $calendar = new CalendarController();
        $calendar->setCalendarInDateRange($reservation->id, $input['start_date'], $input['end_date']);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
