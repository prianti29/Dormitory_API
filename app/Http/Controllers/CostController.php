<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CostRequest;
use App\Models\Cost;
use App\Models\Costs;
use App\Models\MealCount;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cost_list = DB::table('costs')->get();
        return view('costs.index', ['cost_list' => $cost_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member_list = DB::table('members')->get();
        return view('costs.create', ['member_list' => $member_list]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CostRequest $request)
    {
        $cost_list = new Cost();
        $cost_list->member_id = $request->member_id;
        $cost_list->types_of_cost = $request->types_of_cost;
        $cost_list->cost_amount = $request->cost_amount;
        $cost_list->save();
        return redirect()->route('cost.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $cost = DB::table('costs')->where('id', $id)->first();
        return response()->json($cost);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cost = Cost::find($id);
        if (!$cost) {
            return redirect('/api/cost');
        }
        $data["cost"] = $cost;
        return view("costs.edit", $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $current_time = Carbon::now();
        $cost_list = Cost::find($id);
        $cost_list->types_of_cost = $request->type_of_cost;
        $cost_list->cost_amount = $request->cost_amount;
        $cost_list->save();
        $data['cost_list'] = Cost::get();
        return view('costs.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('costs')->where('id', $id)->first();
        DB::table('costs')->where('id', $id)->delete();
        $data['cost_list'] = Cost::get();
        return view('costs.index', $data);
    }

    public function monthlyCostView()
    {
        return view('costs.details');
    }
    public function monthlyCost(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        //cost count
        $meal_cost = DB::table('costs')
            ->select('member_id', DB::raw('CAST(SUM(cost_amount) AS SIGNED) as total_cost'))
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('member_id')
            ->get();
        $total_cost = 0;
        foreach ($meal_cost as $data) {
            $total_cost += $data->total_cost;
        }
        $total_meal = MealCount::sum('daily_count');

        //meal rate
        $per_meal_rate = 0;
        if ($total_meal != 0) {
            $per_meal_rate = ceil($total_cost / $total_meal);
        }

        //Individual Meal cost
        $meal = DB::table('meal_counts')
            ->select('member_id', DB::raw('CAST(SUM(daily_count) AS SIGNED) as individual_meal'))
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('member_id')
            ->get();
        $individual_meal_cost = [];
        foreach ($meal as $data) {
            $memberId = $data->member_id;
            $individual_meal = $data->individual_meal;
            $individual_meal_cost[$memberId] = ceil($individual_meal * $per_meal_rate);
        }

        //debit/credit
        $deposit = DB::table('accounts')->select('member_id', DB::raw('CAST(SUM(deposit_cost) AS SIGNED) as total_deposit'))->whereBetween('created_at', [$start_date, $end_date])->groupBy('member_id')
            ->get();
        $total_deposit = 0;
        foreach ($deposit as $data) {
            $total_deposit += $data->total_deposit;
        }
        $debitCredit = [];
        foreach ($deposit as $data) {
            $memberId = $data->member_id;
            $individual_deposit = $data->total_deposit;
            $debitCredit[$memberId] = ceil($individual_deposit - $individual_meal_cost[$memberId]);
        }
        //views
        return view('costs.cost_count', [
            'individual_cost' =>  $meal_cost,
            'total_cost' => $total_cost,
            'per_meal_rate' => $per_meal_rate,
            'individual_meal_cost' =>  $individual_meal_cost,
            'debitCredit' =>  $debitCredit,
        ]);
    }

    // public function expenseCount(Request $request)
    // {
    //     $start_date = $request->start_date;
    //     $end_date = $request->end_date;
    //     $meal = DB::table('meal_counts')
    //         ->select('member_id', DB::raw('CAST(SUM(daily_count) AS SIGNED) as individual_meal'))
    //         ->whereBetween('created_at', [$start_date, $end_date])
    //         ->groupBy('member_id')
    //         ->get();
    //     $individual_meal = 0;
    //     foreach ($meal as $data) {
    //         $individual_meal += $data->individual_meal;
    //     }

    //     //meal_cost
    //     $meal_cost = DB::table('costs')
    //         ->select('member_id', DB::raw('CAST(SUM(cost_amount) AS SIGNED) as total_cost'))
    //         ->whereBetween('created_at', [$start_date, $end_date])
    //         ->groupBy('member_id')
    //         ->get();
    //     // dd($meal_cost);
    //     $total_cost = 0;
    //     foreach ($meal_cost as $data) {
    //         $total_cost += $data->total_cost;
    //     }
    //     $deposit = DB::table('accounts')->select('member_id', DB::raw('CAST(SUM(deposit_cost) AS SIGNED) as total_deposit'))->whereBetween('created_at', [$start_date, $end_date])->groupBy('member_id')
    //         ->get();
    //     $total_deposit = 0;
    //     foreach ($deposit as $data) {
    //         $total_deposit += $data->total_deposit;
    //     }

    //     //per head meal rate
    //     $per_meal_rate = ceil($total_cost / $individual_meal);

    //     //monthly individual cost
    //     $individual_meal_cost = [];
    //     foreach ($meal as $data) {
    //         $memberId = $data->member_id;
    //         $individual_meal = $data->individual_meal;
    //         $individual_meal_cost[$memberId] = ceil($individual_meal * $per_meal_rate);
    //     }

    //     $debitCredit = [];
    //     foreach ($deposit as $data) {
    //         $memberId = $data->member_id;
    //         $total_deposit = $data->total_deposit;
    //         $debitCredit[$memberId] = ceil($total_deposit - $per_meal_rate);
    //     }
    //     $response['per_meal_rate'] = $per_meal_rate;
    //     $response['individual_meal_cost'] = $individual_meal_cost;
    //     $response['debit_credit'] = $debitCredit;

    //     return response()->json($response);
    // }
}
