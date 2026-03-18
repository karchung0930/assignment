@extends('layouts.app')

@section('content')
    <table class="border-collapse w-full">
        <thead>
            <tr class="*:py-3 *:px-6 *:border-2 text-left">
                <th>Corporate</th>
                <th>User</th>
                <th>Role</th>
                <th>Wallet Amount</th>
                <th>Category</th>
                <th>Total Spending</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                @php
                    $spendingByCategory = $member->transactions
                        ->groupBy('category.name')
                        ->map(fn($transactions) => $transactions->sum('cost'));

                    $rowspan = max($spendingByCategory->count(), 1);
                @endphp

                @if ($spendingByCategory->isEmpty())
                    <tr class="*:py-3 *:px-6 *:border-2">
                        <td>{{ $member->corporate->name }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->role->name }}</td>
                        <td>{{ $member->wallet->currency }} {{ number_format($member->wallet->amount ?? 0, 2) }}</td>
                        <td colspan="2">No transactions</td>
                    </tr>
                @else
                    @foreach ($spendingByCategory as $category => $total)
                        <tr class="*:py-3 *:px-6 *:border-2">
                            @if ($loop->first)
                                <td rowspan="{{ $rowspan }}">{{ $member->corporate->name }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $member->name }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $member->role->name }}</td>
                                <td rowspan="{{ $rowspan }}">{{ $member->wallet->currency }} {{ number_format($member->wallet->amount ?? 0, 2) }}</td>
                            @endif
                            <td>{{ $category }}</td>
                            <td>{{ $member->wallet->currency }} {{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
@endsection