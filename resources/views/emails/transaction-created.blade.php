<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h1>Transaction Created</h1>

    <p>Hi {{ $user->name }},</p>
    <p>Your transaction has been created successfully.</p>

    <table
        style="border-collapse: collapse;"
    >
        <tr>
            <td style="padding: 12px 24px; border: 2px solid #000;">Category</td>
            <td style="padding: 12px 24px; border: 2px solid #000;">{{ $category->name }}</td>
        </tr>
        <tr>
            <td style="padding: 12px 24px; border: 2px solid #000;">Cost</td>
            <td style="padding: 12px 24px; border: 2px solid #000;">{{ $transaction->currency }} {{ number_format($transaction->cost, 2) }}</td>
        </tr>
        <tr>
            <td style="padding: 12px 24px; border: 2px solid #000;">Transaction Fee</td>
            <td style="padding: 12px 24px; border: 2px solid #000;">{{ $transaction->currency }} {{ number_format($transaction->transaction_fee, 2) }}</td>
        </tr>
        <tr>
            <td style="padding: 12px 24px; border: 2px solid #000;">Total Deducted</td>
            <td style="padding: 12px 24px; border: 2px solid #000;">
                {{ $transaction->currency }} {{ number_format($transaction->cost + $transaction->transaction_fee, 2) }}
            </td>
        </tr>
    </table>

    <p>Thank you.</p>
</body>
</html>