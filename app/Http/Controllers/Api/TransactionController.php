<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function startTransaction(Request $request)
    {
        $transactionData = [
            'amount' => $request->input('amount'),
            'destination_account' => $request->input('destination_account'),
            'status' => 'đã khởi tạo'
        ];

        session(['transaction' => $transactionData]);

        return response()->json([
            'message' => 'Đã khởi tạo phiên giao dịch!',
            'transaction' => session('transaction')
        ]);
    }

    public function updateTransactionStep(Request $request)
    {
        session()->put('transaction.status', 'Hoàn thành bước tiếp theo');
        session()->put('transaction.additional_data', $request->input('additional_data'));

        return response()->json([
            'message' => 'Đã cập nhật giao dịch!',
            'transaction' => session('transaction')
        ]);
    }

    public function resumeTransaction()
    {
        if (session()->has('transaction')) {
            return response()->json([
                'message' => 'Đang tiếp tục phiên giao dịch...',
                'transaction' => session('transaction')
            ]);
        } else {
            return response()->json(['message' => 'Không tìm thấy giao dịch!'], 404);
        }
    }

    public function completeTransaction()
    {
        $transaction = session('transaction');

        Transaction::create([
            'amount' => $transaction['amount'],
            'destination_account' => $transaction['destination_account'],
            'status' => 'thành công',
        ]);

        session()->forget('transaction');

        return response()->json(['message' => 'Giao dịch thành công!']);
    }

    public function cancelTransaction()
    {
        session()->forget('transaction');
        return response()->json(['message' => 'Giao dịch bị hủy!']);
    }
}
