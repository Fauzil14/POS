<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function cariMember($keyword = null)
    {
        $member = Member::where(function($query) use ($keyword) {
                            return $query->where('kode_member', $keyword)
                                         ->orWhere('no_telephone', $keyword)
                                         ->orWhereRaw('lower(nama) like (?)',["%{$keyword}%"]);
                          })->get();
        
        if (request()->wantsJson()) {
            return response()->json($member);
        }
    }

    public function createMember(Request $request)
    {
        $validatedData = $request->validate([
            'nama'         => 'required',
            'no_telephone' => 'required|unique:members',
            'saldo'        => 'required|integer|min:10000',
        ]);

        $member = Member::create($validatedData);
    
        if ($request->wantsJson()) {
            return $this->sendResponse('success', 'Member successfully created', $member, 200);
        }
    }

    public function topUpSaldoMember(Request $request)
    {
        $validatedData = $request->validate([
            'member_id' => 'required|exists:members,id',
            'nominal'   => 'required|integer'
        ]);

        $member = Member::find($validatedData['member_id']);
        $member->saldo += $validatedData['nominal'];
        $member->update();

        if ($request->wantsJson()) {
            return $this->sendResponse('success', 'Member successfully created', $member, 200);
        }
    }
}
