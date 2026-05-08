<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeBonusController extends Controller
{
    public function claimBonus(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Hanya customer yang dapat mengklaim bonus.');
        }

        if ($user->welcome_bonus_claimed) {
            return redirect()->back()->with('error', 'Anda sudah mengklaim bonus welcome.');
        }

        // Give 100 points
        $user->increment('points', 100);
        
        // Mark as claimed
        $user->update([
            'welcome_bonus_claimed' => true,
        ]);

        return redirect()->back()->with('success', 'Selamat! Anda mendapatkan 100 points (senilai Rp 10.000) dan akan mendapat free grip pada pembelian pertama!');
    }
}
