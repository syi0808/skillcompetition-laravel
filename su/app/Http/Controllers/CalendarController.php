<?php

namespace App\Http\Controllers;

use App\Calendar;
use Illuminate\Http\Request;
use DateTime, DatePeriod, DateInterval;

class CalendarController extends Controller
{
    public function setCalendarInDateRange($reservationId, $start_date, $end_date, $format = 'Y-m-d') {
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end_date);
        $realEnd->add($interval);

        $period = new DatePeriod(new DateTime($start_date), $interval, $realEnd);

        foreach($period as $date) {
            $currentDate = $date->format($format);

            Calendar::query()->create(["reservation_id" => $reservationId, "reserve_date" => $currentDate]);
        }
    }

    public function getCalendarByMonth(Request $request) {
        $request->validate([
            "month" => 'required',
            "campground" => 'required',
        ]);

        $year = Date('Y');
        $month = $request->get("month");

        $firstDayOfMonth = new DateTime("$year-$month-01");
        $lastDayOfMonth = new DateTime("$year-$month-" . $firstDayOfMonth->format('t'));

        $currentDate = clone $firstDayOfMonth;

        $calendar = [];

        while ($currentDate <= $lastDayOfMonth) {
            $date = $currentDate->format('Y-m-d');

            $calendar[$date] = Calendar::query()
                ->join("reservations", "calendars.reservation_id", "=", "reservations.id")
                ->join("campgrounds", "reservations.campground_id", "campgrounds.id")
                ->where(["calendars.reserve_date" => $date, "campgrounds.name" => urldecode($request->campground)])
                ->count();

            $currentDate->modify('+1 day');
        }

        return response()->json($calendar);
    }
}
