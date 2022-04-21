<div>
    <div class="text-center text-sm"> 
        日付を選択してください。本日から最大30日先まで選択可能です。
    </div>
    {{-- getDateはCalendar.phpからとってきてる　 --}}
    {{-- wire:change 値が変更されたときにメソットを実行する　今回はgetDate  $event.target.はinputので売った情報になって　valueをつけることで引数を使える --}}
     <input id="calendar" class="block mt-1 mb-2 mx-auto " type="text" name="calendar" 
     value="{{ $currentDate }}" wire:change="getDate($event.target.value)"/>
    
    {{-- これで横並び --}}
    <div class="flex border border-green-400 mx-auto">
        <x-calendar-time />
        @for($i = 0; $i < 7; $i++)
        <div class="w-32">
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['day'] }}</div> 
            <div class="py-1 px-2 border border-gray-200 text-center">{{ $currentWeek[$i]['dayOfWeek'] }}</div> 
            @for($j = 0; $j < 21; $j++)
            {{-- イベントがあるかで分岐する --}}
            {{-- firstWhereは条件に紐づく1件目の 第一引数が検索条件--}}
                @if($events->isNotEmpty()) {{-- 空ではなかったら--}}
                    @if(!is_null($events->firstWhere('start_date',
                    $currentWeek[$i]['checkDay']." ".\Constant::EVENT_TIME[$j])))
                        @php
                         $eventName = $events->firstWhere('start_date',$currentWeek[$i]['checkDay']." ".\Constant::EVENT_TIME[$j])->name;
                         $eventInfo = $events->firstWhere('start_date',$currentWeek[$i]['checkDay']." ".\Constant::EVENT_TIME[$j]);
                         $eventPeriod = \Carbon\Carbon::parse($eventInfo->start_date)->diffInMinutes($eventInfo->end_date) / 30 - 1 ; //diffInMinutesは時間の差分をとってくれる
                        @endphp
                        <div class="py-1 px-2 h-8 border border-gray-200 text-xs bg-blue-100">
                            {{ $eventName }}
                        </div>
                        @if($eventPeriod > 0 )
                            @for($k = 0; $k < $eventPeriod ; $k++)
                               <div class="py-1 px-2 h-8 border border-gray-200 bg-blue-100"></div>
                            @endfor
                            @php $j += $eventPeriod @endphp {{--divタグが増え多分Jで増えたdivタグを減らす--}}
                        @endif
                    @else
                        <div class="py-1 px-2 h-8 border border-gray-200"></div>
                    @endif
                @else
                    <div class="py-1 px-2 h-8 border border-gray-200"></div>
                @endif
            @endfor
        </div>
        @endfor
    </div>
</div>

