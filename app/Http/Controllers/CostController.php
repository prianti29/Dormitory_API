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
        ->select('member_id', DB::raw('SUM(cost_amount) as total_cost'))
        ->whereBetween('created_at', [$start_date, $end_date])
        ->groupBy('member_id')
        ->get();
        $total_cost = DB::table('cost')->sum(DB::raw('CAST(cost_amount AS SIGNED INTEGER)'));
        return response()->json([$meal_cost, "total cost " . "= "  . $total_cost]);
    }
}
