<?php

namespace App\Http\Controllers;

use App\RecommendTrip;
use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecommendTripController extends Controller
{
    public function read() {
        $trips = RecommendTrip::query()
            -> join('users', 'users.id', '=', 'recommend_trips.user_id')
            -> join('trips', 'recommend_trips.id', '=', 'trips.recommend_trip_id')
            -> get();

        $groupedTrips = $trips->groupBy('recommend_trip_id');
        // "1": {
        //   [...trips]
        // }

        $groupedTripsJson = $groupedTrips->map(function ($trips, $recommend_trip_id) {
            return [
                'recommend_trip_id' => $recommend_trip_id,
                'user_id' => $trips[0]->user_id,
                'user_name' => $trips[0]->name,
                'trips' => $trips->map(function ($trip) {
                    return [
                        'score'=>$trip->score,
                        'name'=>$trip->trip_name,
                    ];
                }),
            ];
        })->values();

        return response()->json([
            'trips' => $groupedTripsJson,
        ]);
    }

    public function getRankedTrips() {
        if(!Auth::check() || Auth::user()->role != "admin") {
            return response()->json([
                'message' => 'please, login first or login to admin',
            ], 401);
        }

        $trips = Trip::query()
            -> select('trip_name', DB::raw('SUM(score) as score'))
            -> groupBy('trip_name')
            -> orderBy('score', 'desc')
            -> limit(5)
            -> get();

        return response()->json([
            'trips' => $trips,
        ]);
    }

    public function create(Request $request) {
        if(!Auth::check()) {
            return response()->json([
                'message' => 'please, login first',
            ], 401);
        }

        $user = Auth::user();

        $recommendTrip = RecommendTrip::query()->make(['user_id' => $user->id]);
        $recommendTrip->save();

        $trips = $request->trips;

        foreach ($trips as $trip) {
            Trip::query()->create([
                'recommend_trip_id' => $recommendTrip->id,
                'score' => $trip['score'],
                'trip_name' => urldecode($trip['name']),
            ]);
        }

        return response()->json([
           'message' => 'success'
        ]);
    }
}
