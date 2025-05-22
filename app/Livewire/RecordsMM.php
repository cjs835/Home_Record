<?php

namespace App\Livewire;

use App\Models\RecordMM;
use App\Models\Record;
use Livewire\Component;
use Illuminate\Support\Carbon;

class RecordsMM extends Component
{
    protected $data = [];

    public function render()
    {
        // $from_date = Carbon::parse(Carbon::today())->subYears(1);
        // $from_temp = Carbon::parse($from_date)->endOfDay();
        // $latest = Carbon::parse(Carbon::today())->endOfDay();
        // while(Carbon::parse($from_temp)->subDays(1)->endofDay()!=$latest){
        //     $records = Record::selectRaw(
        //         "count(time) numbers, SUM(temperature) avg_temp,SUM(humidity) avg_hum,  DATE_FORMAT(time, '%Y-%m-%d 00:00:00') as data"
        //     )
        //         ->whereBetween('time', [$from_date, $from_temp])
        //         ->groupBy('data')
        //         ->get();
        //     if(!$records->count()){
        //         $from_date = Carbon::parse($from_date)->addDays(1);
        //         $from_temp = Carbon::parse($from_date)->endOfDay();
        //         continue;
        //     }else{
        //         echo $from_date." ".$from_temp."<br><br>";
        //         foreach ($records as $record){
        //             $data = [
        //                 'temperature' => $record->avg_temp,
        //                 'humidity' => $record->avg_hum,
        //                 'numbers' => $record->numbers,
        //                 'time' => $record->data
        //             ];
        //             var_dump($data);
        //             echo "<br>";
        //             echo "<br>";
        //             $record = RecordMM::create($data);
        //         }
        //     }
        //     $from_date = Carbon::parse($from_date)->addDays(1);
        //     $from_temp = Carbon::parse($from_date)->endOfDay();
        // }
        // dd();
        // return "asd";
        return view('livewire.records-m-m', [
            'data' => $this->read(),
        ]);
    }

    public function read()
    {
        $latest_data = RecordMM::orderBy('id', 'desc')->first();
        if (!$latest_data) {
            $latest = Carbon::now();
            $from_date = Carbon::now()->subMonths(1);
        } else {
            $latest = Carbon::parse($latest_data->time);
            $from_date = Carbon::parse($latest_data->time)->subMonths(1);
        }
        $records = RecordMM::whereBetween('time', [$from_date, $latest])
            ->orderBy('id', 'desc')
            ->get();
        return $records->map(function ($item) {
            return [
                'x' => $item->time,
                'y' => round($item->temperature / $item->numbers, 2),
            ];
        })->values();
    }
}
