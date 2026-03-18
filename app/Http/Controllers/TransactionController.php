<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCreatedMail;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function create(): View
    {
        $categories = Category::all();

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category' => 'required|exists:categories,id',
            'cost'     => 'required|numeric|min:0.01',
        ], [
            'category.required' => 'Please select a category.',
            'cost.required'     => 'Please enter a cost.',
        ]);

        $user     = auth()->user()->load(['wallet', 'corporate']);
        $category = Category::findOrFail($request->category);

        $cost   = (float)$request->cost;
        $fee    = $category->calculateFee($cost);
        $total  = $cost + $fee;
        $wallet = $user->wallet;

        if ($wallet->amount < $total) {
            $shortfall = $total - $wallet->amount;

            return back()
                ->withInput()
                ->withErrors([
                    'cost' => "Insufficient balance. You need additional {$wallet->currency} " . number_format($shortfall, 2)
                ]);
        }

        $wallet->decrement('amount', $total);

        $status = TransactionStatus::where('name', 'Completed')->first();

        $transaction = Transaction::create([
            'corporate_id'          => $user->corporate_id,
            'user_id'               => $user->id,
            'category_id'           => $category->id,
            'transaction_status_id' => $status->id,
            'cost'                  => $cost,
            'transaction_fee'       => $fee,
            'currency'              => $wallet->currency,
        ]);

        $this->notifyUser($user, $transaction, $category);

        return redirect('/transaction')
            ->with('success', 'Transaction created successfully.');
    }

    private function notifyUser($user, $transaction, $category): void
    {
        try {
            Mail::to("karchung0930@pm.me")->send(new TransactionCreatedMail($user, $transaction, $category));
        } catch (\Exception $e) {
            Log::info('Transaction created', [
                'error'           => $e->getMessage(),
                'user'            => $user->name,
                'email'           => $user->email,
                'category'        => $category->name,
                'cost'            => $transaction->cost,
                'transaction_fee' => $transaction->transaction_fee,
                'currency'        => $transaction->currency,
                'total'           => $transaction->cost + $transaction->transaction_fee,
            ]);
        }
    }
}
