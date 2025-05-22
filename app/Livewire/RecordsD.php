<?php

namespace App\Livewire;

use App\Models\RecordD;
use App\Models\Record;
use Livewire\Component;
use Illuminate\Support\Carbon;

class RecordsD extends Component
{

    protected $data=[];

    public function render()
    {
        // $from_date = Carbon::parse(Carbon::today())->subYears(1);
        // $from_temp = Carbon::parse($from_date)->endOfDay();
        // $latest = Carbon::parse(Carbon::today())->endOfDay();
        // while(Carbon::parse($from_temp)->subDays(1)->endofDay()!=$latest){
        //     $records = Record::selectRaw(
        //         "count(time) numbers, SUM(temperature) avg_temp,SUM(humidity) avg_hum,  DATE_FORMAT(time, '%Y-%m-%d %H:00:00') as data"
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
        //             $record = RecordD::create($data);
        //         }
        //     }
        //     $from_date = Carbon::parse($from_date)->addDays(1);
        //     $from_temp = Carbon::parse($from_date)->endOfDay();
        // }
        // dd();
        // return "asd";
        $data = $this->read();
        return view('livewire.records-d', [
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
        ]);
    }

    public function read()
    {
        $latest_data=RecordD::orderBy('id', 'desc')->first();
        if(!$latest_data){
            $latest = Carbon::now();
            $from_date = Carbon::now()->subDays(1);
        }else{
            $latest = Carbon::parse($latest_data->time);
            $from_date = Carbon::parse($latest_data->time)->subDays(1);
        }
        $records = RecordD::whereBetween('time', [$from_date, $latest])
            ->orderBy('id', 'desc')
            ->get();
        $temperature = [];
        $humidity = [];
        foreach ($records as $item) {
            $temperature[] = [
                'x' => $item->time,
                'y' => round($item->temperature/$item->numbers,2),
            ];
            $humidity[] = [
                'x' => $item->time,
                'y' => round($item->humidity/$item->numbers,2),
            ];
        }
        return [
            'temperature' => $temperature,
            'humidity' => $humidity,
        ];
    }
}
