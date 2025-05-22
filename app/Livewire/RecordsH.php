<?php

namespace App\Livewire;

use App\Models\RecordH;
use Illuminate\Support\Carbon;
use Livewire\Component;

class RecordsH extends Component
{

    protected $data = [];

    public function render()
    {
        // $from_date = Carbon::parse(Carbon::today())->subYears(1);
        // $from_temp = Carbon::parse($from_date)->endOfDay();
        // $latest = Carbon::parse(Carbon::today())->endOfDay();
        // while(Carbon::parse($from_temp)->subDays(1)->endofDay()!=$latest){
        //     $records = Record::selectRaw(
        //         "count(time) numbers, SUM(temperature) avg_temp,SUM(humidity) avg_hum, DATE_FORMAT(concat(date(time),' ',hour(time),':',floor( minute(time)/5 )*5) ,'%Y-%m-%d %H:%i:00') as data"
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
        //             $record = RecordH::create($data);
        //         }
        //     }
        //     $from_date = Carbon::parse($from_date)->addDays(1);
        //     $from_temp = Carbon::parse($from_date)->endOfDay();
        // }
        // dd();
        // return "asd";
        $data = $this->read();
        return view('livewire.records-h', [
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
        ]);
    }

    public function read()
    {
        $latest_data = RecordH::orderBy('id', 'desc')->first();
        if (!$latest_data) {
            $latest = Carbon::now();
            $from_date = Carbon::now()->subHours(1);
        } else {
            $latest = Carbon::parse($latest_data->time);
            $from_date = Carbon::parse($latest_data->time)->subHours(1);
        }
        $records = RecordH::whereBetween('time', [$from_date, $latest])
            ->orderBy('id', 'desc')
            ->get();
        $temperature = [];
        $humidity = [];
        foreach ($records as $item) {
            $temperature[] = [
                'x' => $item->time,
                'y' => round($item->temperature / $item->numbers, 2),
            ];
            $humidity[] = [
                'x' => $item->time,
                'y' => round($item->humidity / $item->numbers, 2),
            ];
        }
        return [
            'temperature' => $temperature,
            'humidity' => $humidity,
        ];
    }
}
