<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cost = DB::table('cost')->get();
        return response()->json($cost);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_time = Carbon::now();
        $data = array();
        $data['member_id'] = $request->member_id;
        $data['types_of_cost'] = $request->types_of_cost;
        $data['cost_amount'] = $request->cost_amount;
        $data['created_at'] = $current_time;

        DB::table('cost')->insert($data);
        return response('Inserted');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cost = DB::table('cost')->where('id', $id)->first();
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
        //
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
        $data = array();
        $data['types_of_cost'] = $request->types_of_cost;
        $data['cost_amount'] = $request->cost_amount;
        $data['updated_at'] = $current_time;
        DB::table('cost')->where('id', $id)->update($data);
        return response('updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('cost')->where('id', $id)->first();
        DB::table('cost')->where('id', $id)->delete();
        return response('deleted');
    }
    public function monthlyCost(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $meal_cost = DB::table('cost')
        ->select('member_id', DB::raw('CAST(SUM(cost_amount) AS SIGNED) as total_cost'))
        ->whereBetween('created_at', [$start_date, $end_date])
        ->groupBy('member_id')
        ->get();
        $total_cost = 0;
        foreach($meal_cost as $data){
            $total_cost += $data->total_cost;
        }
        // $total_cost = DB::table('cost')->sum(DB::raw('CAST(cost_amount AS SIGNED INTEGER)'));
        $response['individual_cost']=$meal_cost;
        $response['total_cost']=(int)$total_cost;
        return response()->json($response);
    }
    public function mealRate(Request $request){
        $total_cost = $request->total_cost;
        $total_meal = $request->total_meal;
        $per_meal_rate = $total_cost / $total_meal;
        $response['meal_rate'] = $per_meal_rate;
        return response()->json($response);
    }
    // intput -> startdate, enddate
    // total cost with individual
    // total meal with individual
    // meal rate
    // monthly individual cost (meal rate * individual meal)
    // per head total deposit
    // credit / debit (deposit -  monthly individual cost)
    public function expenseCount(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
         //meal_count
        // DB::enableQueryLog(); 
        $meal = DB::table('meals_count')
            ->select('member_id', DB::raw('CAST(SUM(daily_count) AS SIGNED) as individual_meal'))
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('member_id')
            ->get();
        //dd($meal);
        $individual_meal = 0;
        foreach($meal as $data){
            $individual_meal += $data->individual_meal;
        }
        // dd(DB::getQueryLog());


        //meal_cost
        $meal_cost = DB::table('cost')
        ->select('member_id', DB::raw('CAST(SUM(cost_amount) AS SIGNED) as total_cost'))
        ->whereBetween('created_at', [$start_date, $end_date])
        ->groupBy('member_id')
        ->get();
       // dd($meal_cost);
        $total_cost = 0;
        foreach($meal_cost as $data){
            $total_cost += $data->total_cost;
        }
        
       
        //total_deposit
        $deposit = DB::table('accounts')->select('member_id', DB::raw('CAST(SUM(deposit_cost) AS SIGNED) as total_deposit'))->whereBetween('created_at', [$start_date, $end_date])->groupBy('member_id')
        ->get();
        $total_deposit = 0;
        foreach($deposit as $data){
            $total_deposit += $data->total_deposit;
        }

        //per head meal rate
        $per_meal_rate = ceil($total_cost / $individual_meal);

        //monthly individual cost
        $individual_meal_cost= [];
        foreach ($meal as $data) {
            $memberId = $data->member_id;
            $individual_meal = $data->individual_meal;
            $individual_meal_cost[$memberId] = ceil($individual_meal * $per_meal_rate );
            
         }

         $debitCredit = [];
         foreach($deposit as $data){
            $memberId = $data->member_id;
            $total_deposit = $data->total_deposit;
            $debitCredit[$memberId] = ceil( $total_deposit - $per_meal_rate  );
         }
         $response['per_meal_rate'] = $per_meal_rate;
         $response['individual_meal_cost'] = $individual_meal_cost;
         $response['debit_credit'] = $debitCredit;

        return response()->json($response);
    }
}
