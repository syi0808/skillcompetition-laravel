<?php

namespace App\Http\Controllers;

use App\Campgrounds;
use Illuminate\Http\Request;

class CampgroundController extends Controller
{
    public function getCampground(Request $request) {
        $request->validate([
            "campground" => 'required',
            "number" => 'required',
        ]);

        return response()->json(Campgrounds::query()->where([
            'name'=>urldecode($request->campground),
            'number'=>$request->number
        ])->first());
    }

    public function getCampgrounds(Request $request) {
        $request->validate([
            "date" => 'required',
            "campground" => 'required',
        ]);

        $campgrounds = Campgrounds::query()
            ->join("reservations", "reservations.campground_id", "=", "campgrounds.id")
            ->join("calendars", "calendars.reservation_id", "=", "reservations.id")
            ->where(["campgrounds.name" => urldecode($request->campground), "calendars.reserve_date" => urldecode($request->date)])
            ->select("campgrounds.*")
            ->get();

        return response()->json($campgrounds);
    }
}
