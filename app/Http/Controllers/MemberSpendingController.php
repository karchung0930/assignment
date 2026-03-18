<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class MemberSpendingController extends Controller
{
    public function index(): View
    {
        $members = User::with([
            'corporate',
            'role',
            'wallet',
            'transactions.category',
        ])
            ->whereHas('role', fn($query) => $query->where('name', 'Member'))
            ->get();

        return view('members.list-spending', compact('members'));
    }
}
