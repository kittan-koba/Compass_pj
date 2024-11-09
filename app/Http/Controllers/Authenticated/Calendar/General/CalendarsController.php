<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\Users\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show()
    {
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request)
    {
        DB::beginTransaction();
        try {
            $getPart = $request->getPart;
            $getDate = $request->getDate;
            // DD($request);
            dd(count($getDate), count($getPart));
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            // dd($reserveDays);
            foreach ($reserveDays as $key => $value) {
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
    public function delete(Request $request)
    {
        $setting_reserve = $request->input('reserve_date');
        $setting_part = $request->input('reserve_part');

        $setting_reserve = ReserveSettings::where('setting_reserve', $setting_reserve)->where('setting_part', $setting_part)->first();
        $setting_reserve->increment('limit_users');
        $setting_reserve->users()->detach(Auth::id());
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}