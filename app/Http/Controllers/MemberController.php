<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function cariMember($keyword = null)
    {
        $member = Member::where(function($query) use ($keyword) {
                            return $query->where('UID', $keyword)
                                         ->orWhere('no_telephone', $keyword)
                                         ->orWhereRaw('lower(nama) like (?)',["%{$keyword}%"]);
                          });
    }

    public function createMember(Request $request)
    {
        $validatedData = $request->validate([
            'nama'         => 'required',
            'no_telephone' => 'required|unique:members',
            'saldo'        => 'required|number',
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
            'nominal'   => 'required|number'
        ]);

        $member = Member::find($validatedData['id']);
        $member->saldo += $validatedData['nominal'];
        $member->save();

        if ($request->wantsJson()) {
            return $this->sendResponse('success', 'Member successfully created', $member, 200);
        }
    }
}
