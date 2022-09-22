<?php

namespace App\Http\Livewire\BranchAdmin\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
    public function render()
    {
        return view('livewire.branch-admin.dashboard.statistic-overview',[
            'data' => $this->loadData()
        ]);
    }
}
