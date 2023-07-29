<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account=DB::table('accounts')->get();
    
        return view('accounts.index', ['account'=>$account]);
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
        $data=array();
        $data['member_id']= $request->member_id;
        $data['deposit_cost']= $request->deposit_cost;
        $data['created_at'] = $current_time;

        DB::table('accounts')->insert($data);
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
        $account=DB::table('accounts')->where('id', $id)->first();
        return response()->json($account);
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
        $data=array();
        $data['deposit_cost']= $request->deposit_cost;
        $data['updated_at'] = $current_time;
        DB::table('accounts')->where('id', $id)->update($data);
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
        DB::table('accounts')->where('id', $id)->first();
        DB::table('accounts')->where('id', $id)->delete();
        return response('deleted');
    }

    public function perHeadDeposit(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $deposit = DB::table('accounts')->select('member_id', DB::raw('CAST(SUM(deposit_cost) AS SIGNED) as total_deposit'))->whereBetween('created_at', [$start_date, $end_date])->groupBy('member_id')
        ->get();
        $total_deposit = 0;
        foreach($deposit as $data){
            $total_deposit += $data->total_deposit;
        }
        $response['individual_deposit']=$deposit;
        $response['total_deposit']=(int)$total_deposit;
        return response()->json($response);
    }
}
