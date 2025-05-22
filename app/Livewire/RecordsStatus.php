<?php

namespace App\Livewire;

use App\Models\RecordMM;
use App\Models\Record;
use Livewire\Component;
use Illuminate\Support\Carbon;

class RecordsStatus extends Component
{
    public function render()
    {
        $data = $this->read();
        return view('livewire.records-status', [
            'numbers' => $data['numbers'],
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
        $numbers = [];
        foreach ($records as $item) {
            $numbers[] = [
                'x' => $item->time,
                'y' => $item->numbers,
            ];
        }
        return [
            'numbers' => $numbers,
        ];
    }
}
