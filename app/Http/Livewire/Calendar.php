<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Services\EventService;

class Calendar extends Component
{
    //現在の日付
    public $currentDate;
    public $currentWeek;
    public $day;
    //判定用
    public $checkDay;
    //曜日

    public $dayOfWeek;
    public $sevenDaysLater;
    public $events;

    //初期値の状態を設定する
    public function mount()
    {
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek = [];

        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'),
            $this->sevenDaysLater->format('Y-m-d'),
        );

        //今日の日付を起点に0日足したり6日足しりする
        for($i = 0; $i < 7; $i++) {
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');//表示用　addDayは日付を足す
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');//日付判定用
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;//曜日を取得する　datNameはCarvbonの機能
            array_push($this->currentWeek,[
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }

        // dd($this->events);
        

    }

    public function getDate($date)
    {
        $this->currentDate = $date; //文字列
        $this->currentWeek = [];
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);

        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d'),
        );


        //今日の日付を起点に0日足したり6日足しりする
        //parseを通すことで文字列からCarbonインスタンスに変わる
        for($i = 0; $i < 7; $i++ ) {
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::parse($this->currentDate)->addDays($i)->dayName;
            array_push($this->currentWeek,[
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
    }

    // 表示先
    public function render()
    {
        return view('livewire.calendar');
    }
}
