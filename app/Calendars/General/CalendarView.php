<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView
{
  private $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  function render()
  {
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
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = Carbon::today()->format("Y-m-d");
        $isPast = $day->everyDay() < $toDay;
        $isValidDay = $day->everyDay() >= $startDay && $day->everyDay() <= $this->carbon->copy()->endOfMonth()->format("Y-m-d");

        $html[] = '<td class="calendar-td" style="background-color:' . ($isPast ? '#ccc' : '#fff') . ';">';

        if ($isValidDay) {
          $html[] = $day->render();

          if ($isPast) {
            $reservations = $day->authReserveDate($day->everyDay());
            if ($reservations->isEmpty()) {
              $html[] = '<p>受付終了</p>';
            } else {
              $html[] = '<p>参加した部数: ' . $reservations->count() . '</p>';
            }
          } else {
            if (in_array($day->everyDay(), $day->authReserveDay())) {
              $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
              $reservePartText = $this->getReservePartText($reservePart);
              $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePartText . '</button>';
              $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            } else {
              $html[] = $day->selectPart($day->everyDay());
            }
          }
          $html[] = $day->getDate();
        }

        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }

    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

    return implode('', $html);
  }

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

  private function getReservePartText($reservePart)
  {
    switch ($reservePart) {
      case 1:
        return "リモ1部";
      case 2:
        return "リモ2部";
      case 3:
        return "リモ3部";
      default:
        return "";
    }
  }
}
