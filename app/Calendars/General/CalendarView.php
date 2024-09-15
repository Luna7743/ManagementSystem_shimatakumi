<?php
namespace App\Calendars\General;
// ユーザーの予約情報を含んだカレンダーを生成するクラス

use Carbon\Carbon;
use Auth;

class CalendarView
{
    private $carbon;
    function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    // カレンダーのタイトル（例えば「2024年9月」）を取得
    public function getTitle()
    {
        return $this->carbon->format('Y年n月');
    }

    // カレンダーをHTML形式で生成
    function render(){
        $html = [];
        $html[] = '<div class="calendar text-center">';
        $html[] = '<table class="table">';
        $html[] = '<thead>';
        $html[] = '<tr>';
        $html[] = '<th>月</th>';
        $html[] = '<th>火</th>';
        $html[] = '<th>水</th>';
        $html[] = '<th>木</th>';
        $html[] = '<th>金</th>';
        $html[] = '<th>土</th>';
        $html[] = '<th>日</th>';
        $html[] = '</tr>';
        $html[] = '</thead>';
        $html[] = '<tbody>';
        $weeks = $this->getWeeks();

        foreach ($weeks as $week) {
            $html[] = '<tr class="' . $week->getClassName() . '">';

            $days = $week->getDays();
            foreach ($days as $day) {
                $startDay = $this->carbon->copy()->format('Y-m-01');
                $toDay = $this->carbon->copy()->format('Y-m-d');

                // 過去日判定
                if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
                    $html[] = '<td class="calendar-td past-day">';
                } else {
                    $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
                }
                $html[] = $day->render();

                // 予約があるか判定
                if (in_array($day->everyDay(), $day->authReserveDay())) {
                    $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
                    // 部の名称を設定
                    if ($reservePart == 1) {
                        $reservePart_text = 'リモ1部';
                        $reservePart_past = '1部参加';
                    } elseif ($reservePart == 2) {
                        $reservePart_text = 'リモ2部';
                        $reservePart_past = '2部参加';
                    } elseif ($reservePart == 3) {
                        $reservePart_text = 'リモ3部';
                        $reservePart_past = '3部参加';
                    }
                    // 過去日の予約は表示を変更
                    if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
                        $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'. $reservePart_past .'</p>';
                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                    } else {
                        // 現在以降の日の予約ボタンを表示
                        $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePart_text . '</button>';
                        $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                    }
                } else {
                  if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
                    //予約していない、過去の情報
                    $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
                    $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
                  } else {
                    // 予約がない場合の処理
                    $html[] = $day->selectPart($day->everyDay());
                  }
                }

                // 日付を表示
                $html[] = $day->getDate();
                $html[] = '</td>';
            }
            $html[] = '</tr>';
        }
        $html[] = '</tbody>';
        $html[] = '</table>';
        $html[] = '</div>';
        // 予約のフォーム
        $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
        // キャンセルのフォーム
        $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

        return implode('', $html);
    }

    // カレンダーに表示する週データを取得
    protected function getWeeks()
    {
        $weeks = [];
        $firstDay = $this->carbon->copy()->firstOfMonth();
        $lastDay = $this->carbon->copy()->lastOfMonth();
        $week = new CalendarWeek($firstDay->copy());
        $weeks[] = $week;
        $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
        while ($tmpDay->lte($lastDay)) {
            $week = new CalendarWeek($tmpDay, count($weeks));
            $weeks[] = $week;
            $tmpDay->addDay(7);
        }
        return $weeks;
    }
}
