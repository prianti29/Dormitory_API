<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meal = DB::table('meals_count')->get();
        return response()->json($meal);
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
        $data['daily_count'] = $request->daily_count;
        $data['created_at'] = $current_time;
        DB::table('meals_count')->insert($data);
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
        $meal = DB::table('meals_count')->where('id', $id)->first();
        return response()->json($meal);
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
        $data['member_id'] = $request->member_id;
        $data['daily_count'] = $request->daily_count;
        $data['updated_at'] = $current_time;
        DB::table('meals_count')->where('id', $id)->update($data);
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
        DB::table('meals_count')->where('id', $id)->first();
        DB::table('meals_count')->where('id', $id)->delete();
        return response('deleted');
    }
    
    public function monthlyCount(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $meal = DB::table('meals_count')
            ->select('member_id', DB::raw('CAST(SUM(daily_count) AS SIGNED) as total_meal'))
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('member_id')
            ->get();
        $total_meal = DB::table('meals_count')->sum(DB::raw('CAST(daily_count AS SIGNED INTEGER)'));
        return response()->json([$meal, "total meal " . "= "  . $total_meal]);
    }
}
