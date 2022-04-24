<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth; //ユーザID登録するために必要
use App\Services\MyPageService;
use Carbon\Carbon;


class MyPageController extends Controller
{
    public function index()
    {
        //ログインしているユーザ情報
        $user = User::findOrFail(Auth::id());
        $events = $user->events; //ユーザに紐づくイベント一覧を取得 Userモデルのevents関数を使用
        $fromTodayEvents = MyPageService::reservedEvent($events,'fromToday');
        $pastEvents = MyPageService::reservedEvent($events,'past');

        // dd($events,$fromTodayEvents,$pastEvents);
        return view('mypage.index',compact('fromTodayEvents','pastEvents'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $reservation = Reservation::where('user_id','=',Auth::id())
        ->where('event_id','=',$id)
        ->latest()
        ->first();

        return view('mypage.show',compact('event','reservation')) ;  
    }

    public function cancel($id)
    {
        $reservation = Reservation::where('user_id','=',Auth::id())
        ->where('event_id','=',$id)
        ->latest()
        ->first();
    
        $reservation->canceled_date = Carbon::now()->format('Y-m-d H:i:s');
        $reservation->save();

        session()->flash('status','キャンセルできました');
        return to_route('dashboard');
    }
}
