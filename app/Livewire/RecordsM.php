<?php

namespace App\Livewire;

use App\Models\Record;
use Livewire\Component;
use Illuminate\Support\Carbon;

class RecordsM extends Component
{

    protected $data = [];

    public function render()
    {
        $data = $this->read();
        return view('livewire.records-m', [
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
        ]);
    }

    public function read()
    {
        $latest_data = Record::orderBy('id', 'desc')->first();
        if (!$latest_data) {
            $latest = Carbon::now();
            $from_date = Carbon::now()->subMinute(1);
        } else {
            $latest = Carbon::parse($latest_data->time);
            $from_date = Carbon::parse($latest_data->time)->subMinute(1);
        }
        $records = Record::whereBetween('time', [$from_date, $latest])
            ->orderBy('id', 'desc')
            ->get();

        $temperature = [];
        $humidity = [];
        foreach ($records as $item) {
            $temperature[] = [
                'x' => $item->time,
                'y' => $item->temperature,
            ];
            $humidity[] = [
                'x' => $item->time,
                'y' => $item->humidity,
            ];
        }

        return [
            'temperature' => $temperature,
            'humidity' => $humidity,
        ];
    }
}
