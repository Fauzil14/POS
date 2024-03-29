<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class MemberController extends Controller
{
    
    public function index() 
    {
        $members = Member::get();

        return view('member.index', compact('members'));
    }
    
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

    public function show($member_id)
    {
        $member = Member::findOrFail($member_id);
        $member->load('penjualan');

        return view('member.detail-member', compact('member'));
    }

    public function update(Request $request)
    {
        $member = Member::findOrFail($request->id);

        $validatedData = $request->validate([
            'nama'         => ['required', 'max:50'],
            'no_telephone' => ['required', Rule::unique('members')->ignore($member->id)],
            'saldo'        => ['required', 'integer', 'min:10000'],
        ]);

        $member->update($validatedData);

        return response()->json($member->refresh());
    }

    public function delete($member_id)
    {
        $member = Member::findOrFail($member_id);

        try {
            $member->delete();
    
            Alert::success('Berhasil', 'Member berhasil di hapus');
            return redirect()->route('member');
        } catch(\Throwable $e) {
            Alert::error('Gagal', 'Member gagal di hapus');
            return back();
        }
    }
}
