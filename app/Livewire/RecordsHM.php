<?php

namespace App\Livewire;

use App\Models\RecordY;
use App\Models\Record;
use Livewire\Component;
use Illuminate\Support\Carbon;

class RecordsHM extends Component
{
    protected $data=[];

    public function render()
    {
        // $from_date = Carbon::parse(Carbon::today())->subYears(1);
        // $from_temp = Carbon::parse($from_date)->endOfDay();
        // $latest = Carbon::parse(Carbon::today())->endOfDay();
        // $temp=Carbon::parse($from_date)->subDays(1)->format('Y-m')."-01 00:00:00";
        // $data=[
        //     'temperature' => 0,
        //     'humidity' => 0,
        //     'numbers' => 0,
        //     'time' => $temp
        // ];
        // while(Carbon::parse($from_temp)->subDays(1)->endofDay()!=$latest){
        //     $records = Record::selectRaw(
        //         "count(time) numbers, SUM(temperature) avg_temp,SUM(humidity) avg_hum,  DATE_FORMAT(time, '%Y-%m-01 00:00:00') as data"
        //     )
        //         ->whereBetween('time', [$from_date, $from_temp])
        //         ->groupBy('data')
        //         ->get();
        //     if(!$records->count()){
        //         $temp=Carbon::parse($from_date)->format('Y-m')."-01 00:00:00";
        //         $from_date = Carbon::parse($from_date)->addDays(1);
        //         $from_temp = Carbon::parse($from_date)->endOfDay();
        //         continue;
        //     }else{
        //         foreach ($records as $record){
        //             if($temp==$record->data){
        //                 $data=[
        //                     'temperature' => ($data['temperature']+$record->avg_temp),
        //                     'humidity' => ($data['humidity']+$record->avg_hum),
        //                     'numbers' => ($data['numbers']+$record->numbers),
        //                     'time' => $temp
        //                 ];
        //             }else{
        //                 echo $from_date." ".$from_temp."<br><br>";
        //                 var_dump($data);
        //                 echo "<br>";
        //                 echo "<br>";
        //                 RecordY::create($data);
        //                 $data=[
        //                     'temperature' => $record->avg_temp,
        //                     'humidity' => $record->avg_hum,
        //                     'numbers' => $record->numbers,
        //                     'time' => $temp
        //                 ];
        //             }
        //         }
        //     }
        //     $temp=Carbon::parse($from_date)->format('Y-m')."-01 00:00:00";
        //     $from_date = Carbon::parse($from_date)->addDays(1);
        //     $from_temp = Carbon::parse($from_date)->endOfDay();
        // }
        // echo $from_date." ".$from_temp."<br><br>";
        // var_dump($data);
        // echo "<br>";
        // echo "<br>";
        // RecordY::create($data);
        // dd();
        // return "asd";
        $data = $this->read();
        return view('livewire.records-h-m', [
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
        ]);
    }

    public function read()
    {
        $latest_data=RecordY::orderBy('id', 'desc')->first();
        if(!$latest_data){
            $latest = Carbon::now();
            $from_date = Carbon::now()->subMonths(6);
        }else{
            $latest = Carbon::parse($latest_data->time);
            $from_date = Carbon::parse($latest_data->time)->subMonths(6);
        }
        $records = RecordY::whereBetween('time', [$from_date, $latest])
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
