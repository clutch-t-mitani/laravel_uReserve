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
        for($i = 0; $i < 7; $i++ ) {
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            array_push($this->currentWeek,$this->day);
        }

        // dd($this->currenWeek);

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
            array_push($this->currentWeek,$this->day);
        }

    }


    public function render()
    {
        return view('livewire.calendar');
    }
}
