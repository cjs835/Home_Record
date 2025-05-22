<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RecordD;
use Illuminate\Support\Carbon;

class Records extends Component
{
    protected $data = [];

    public function render()
    {
        $data = $this->read();
        return view('livewire.records-h', [
            'temperature' => $data['temperature'],
            'humidity' => $data['humidity'],
        ]);
    }

    public function read()
    {
        $latest_data = RecordD::orderBy('id', 'desc')->first();
        if (!$latest_data) {
            $latest = Carbon::now();
            $from_date = Carbon::now()->subDays(1);
        } else {
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
