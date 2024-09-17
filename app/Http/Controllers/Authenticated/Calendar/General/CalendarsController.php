<?php
// 一般ユーザー向けのカレンダー表示や予約処理を扱います。
namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    // カレンダー画面を表示
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    // ユーザーが選択した日付・時間帯の予約を処理し、その予約枠をデータベースに保存
    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    // 予約をキャンセルするための機能
    public function delete(Request $request){
    DB::beginTransaction();
    try{
        $getDate = $request->getDate; // 予約日
        $getPart = $request->getPart; // 部数

        // 予約情報を取得
        $reserve_setting = ReserveSettings::where('setting_reserve', $getDate)
                                          ->where('setting_part', $getPart)
                                          ->first();

        // 該当の予約が見つかった場合に実行
        if ($reserve_setting) {
            // ユーザーの予約解除
            $reserve_setting->users()->detach(Auth::id());

            // 予約枠を1つ増やす
            $reserve_setting->increment('limit_users');
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        // エラーハンドリング
    }

    // 予約一覧画面にリダイレクト
    return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
}


}
