<?php

namespace App\Http\Livewire\BranchAdmin\Dashboard;

use App\Models\Room;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Exports\{CheckInToday,CheckOutToday};
use Maatwebsite\Excel\Facades\Excel;

class StatisticOverview extends Component
{

    public function loadData()
    {
        $check_in_count_overall =  DB::table('check_in_details')
            ->where('check_in_at', '!=', null)
            ->select([
            DB::raw('"total_check_in_overall_count" as label'),
            DB::raw('count(*) as value'),
        ]);

        $check_in_count_today = DB::table('check_in_details')
            ->where('check_in_at', '!=', null)
            ->where('created_at', '>=', Carbon::today())
            ->select([
            DB::raw('"total_check_in_today_count" as label'),
            DB::raw('count(*) as value'),
        ]);

        $check_out_count_today = DB::table('check_in_details')
            ->where('check_out_at', '!=', null)
            ->where('created_at', '>=', Carbon::today())
            ->select([
            DB::raw('"total_check_out_today_count" as label'),
            DB::raw('count(*) as value'),
        ]);

        $expected_check_out_today = DB::table('check_in_details')
            ->where('expected_check_out_at','>=', Carbon::today())
            ->select([
                DB::raw('"total_expected_check_out_today_count" as label'),
                DB::raw('count(*) as value'),
            ]);

        return  $check_in_count_overall
            ->unionAll($check_in_count_today)
            ->unionAll($check_out_count_today)
            ->unionAll($expected_check_out_today)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->label => $item->value];
            })->toArray();
    }
    
    public function printCheckInToday()
    {
        $time = Carbon::now()->format('Y-m-d_H-i-s');
        $file_name = "check_in_today_{$time}.xlsx";
        return Excel::download(new CheckInToday, $file_name);
    }

    public function printCheckOutToday()
    {
        $time = Carbon::now()->format('Y-m-d_H-i-s');
        $file_name = "check_out_today_{$time}.xlsx";
        return Excel::download(new CheckOutToday, $file_name);
    }

    public function render()
    {
        return view('livewire.branch-admin.dashboard.statistic-overview',[
            'data' => $this->loadData(),
            'available_rooms' => Room::where('room_status_id', 1)
                                ->whereHas('floor', function($query){
                                    $query->where('branch_id', auth()->user()->branch_id);
                                })
                                ->count(),
        ]);
    }
}
