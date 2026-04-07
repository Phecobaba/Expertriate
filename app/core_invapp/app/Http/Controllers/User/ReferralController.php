<?php


namespace App\Http\Controllers\User;

use App\Models\Transaction;
use App\Models\Referral;

use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
use Illuminate\Support\Collection;

use App\Http\Controllers\Controller;
class ReferralController extends Controller
{
    public function index()
    {
    	if(!referral_system()) {
            $transactions = new Collection();
            $stats = [
                'refer' => 0,
                'recieved' => 0,
                'pending' => 0,
            ];
            return view('user.referrals.index', compact('stats', 'transactions'));
    	}

        $refers = Referral::where('refer_by', auth()->user()->id);
        $transactions = Transaction::where('type', TransactionType::REFERRAL)->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();

        $bonusRecieved = $transactions->where('status', TransactionStatus::COMPLETED)->sum('amount');
        $bonusPending = $transactions->where('status', TransactionStatus::PENDING)->sum('amount');

        $stats = [
            'refer' => $refers->count(),
            'recieved' => $bonusRecieved,
            'pending' => $bonusPending,
        ];

        return view('user.referrals.index', compact('stats', 'transactions'));
    }
}
