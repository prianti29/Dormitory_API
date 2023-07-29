<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealRequest;
use App\Models\Meal;
use App\Models\MealCount;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Type\Integer;

class MealController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meal_list = DB::table('meal_counts')->get();

        return view('meals.index', ['meal_list' => $meal_list]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member_list = DB::table('members')->get();
        return view('meals.create', ['member_list' => $member_list]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MealRequest $request)
    {
        $meal_list = DB::table('meal_counts')->insert([
            'member_id' =>  $request->member_id,
            'daily_count' =>  $request->daily_count,
        ]);
        return redirect()->route('meal.index');
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meal = DB::table('meal_counts')->where('id', $id)->first();
        return response()->json($meal);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meal = MealCount::find($id);
        if (!$meal) {
            return redirect('/api/meal');
        }
        $data["meal"] = $meal;
        return view("meals.edit", $data);
    }
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meal_list = MealCount::find($id);
        $meal_list->daily_count = $request->daily_count;
        $meal_list->save();
        $data['meal_list'] = MealCount::get();
        return view('meals.index', $data);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('meal_counts')->where('id', $id)->first();
        DB::table('meal_counts')->where('id', $id)->delete();
        $data['meal_list'] = MealCount::get();
        return view('meals.index', $data);
    }
    public function monthlyCountView()
    {
        return view('meals.details');
    }
    public function monthlyCount(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $meal = DB::table('meal_counts')
            ->select('member_id', DB::raw('CAST(SUM(daily_count) AS SIGNED) as total_meal'))
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('member_id')
            ->get();
        $total_meal = 0;
        foreach ($meal as $data) {
            $total_meal += $data->total_meal;
        }
        return view('meals.meal_count', [
            'individual_meals' => $meal,
            'total_meal' => $total_meal,
        ]);
    }
}
