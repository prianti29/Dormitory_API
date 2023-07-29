<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['member_list'] = Member::get();
        return view('members.index', $data);
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        $member_list = new Member();
        $member_list->member_name = $request->member_name;
        $member_list->member_type = $request->member_type;
        $member_list->phone = $request->phone;
        $member_list->email = $request->email;
        $member_list->password = Hash::make($request->password);
        $member_list->save();
        return redirect()->route('member.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $members = DB::table('members')->where('id', $id)->first();
        return response()->json($members);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return redirect('/api/member');
        }
        $data["member"] = $member;
        return view("members.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, $id)
    {
        $member_list = Member::find($id);
        $member_list->member_name = $request->member_name;
        $member_list->member_type = $request->member_type;
        $member_list->phone = $request->phone;
        $member_list->email = $request->email;
        $member_list->save();
        $data['member_list'] = Member::get();
        return view('members.index', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('members')->where('id', $id)->first();
        DB::table('members')->where('id', $id)->delete();
        $data['member_list'] = Member::get();
        return view('members.index', $data);
    }
}
