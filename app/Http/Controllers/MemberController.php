<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function cariMember($keyword)
    {
        $member = Member::where(function($query) use ($keyword) {
                            return $query->where('UID', $keyword)
                                         ->orWhere('no_telephone', $keyword)
                                         ->orWhereRaw('lower(nama) like (?)',["%{$keyword}%"]);
                          });
    }
}
