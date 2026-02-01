<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from the constructor
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get total balance from all accounts
        $totalBalance = Account::where('user_id', $user->id)
            ->sum('current_balance');
            
        // Get Cash In Hand balance
        $cashInHandBalance = Account::where('user_id', $user->id)
            ->where('type', 'Cash')
            ->sum('current_balance');
        
        // Get total expense for current month
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        
        $totalExpense = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        
        // Get total income for current month
        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        
        // Get total loan
        $totalLoanGiven = Loan::where('user_id', $user->id)
            ->where('type', 'Given')
            ->where('is_settled', false)
            ->sum('remaining');
            
        $totalLoanTaken = Loan::where('user_id', $user->id)
            ->where('type', 'Taken')
            ->where('is_settled', false)
            ->sum('remaining');
        
        // Get weekly expense and income data for chart
        $weeklyData = $this->getWeeklyData();
        
        // Get category-wise expense for current month
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$currentMonthStart, $currentMonthEnd])
            ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.name')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
            
        // Format category data for chart.js
        $expenseByCategory = [
            'labels' => [],
            'data' => [],
            'colors' => ['#FE5B56', '#E4C306', '#4CAF50', '#2196F3', '#9C27B0']
        ];
        
        foreach ($categoryExpense as $index => $category) {
            $expenseByCategory['labels'][] = $category->name;
            $expenseByCategory['data'][] = $category->total;
        }
        
        // Get account balances - including the id field for form select
        $accounts = Account::where('user_id', $user->id)
            ->select('id', 'name', 'current_balance', 'type')
            ->get();
        
        return view('dashboard.index', compact(
            'totalBalance',
            'cashInHandBalance',
            'totalExpense',
            'totalIncome',
            'totalLoanGiven',
            'totalLoanTaken',
            'weeklyData',
            'categoryExpense',
            'expenseByCategory',
            'accounts'
        ));
    }
    
    private function getWeeklyData()
    {
        $user = Auth::user();
        $today = Carbon::now();
        $startOfWeek = Carbon::now()->subDays(6);
        $dates = [];
        
        // Create array of last 7 days including today
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dates[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'income' => 0,
                'expense' => 0
            ];
        }
        
        // Get expense and income for the last 7 days
        $transactions = Transaction::where('user_id', $user->id)
            ->whereIn('type', ['expense', 'income'])
            ->whereBetween('date', [$startOfWeek->format('Y-m-d'), $today->format('Y-m-d')])
            ->select('date', 'type', DB::raw('SUM(amount) as total'))
            ->groupBy('date', 'type')
            ->get();
        
        // Fill in the data
        foreach ($transactions as $transaction) {
            $transactionDate = $transaction->date->format('Y-m-d');
            
            foreach ($dates as &$dateItem) {
                if ($dateItem['date'] === $transactionDate) {
                    if ($transaction->type === 'income') {
                        $dateItem['income'] = $transaction->total;
                    } else {
                        $dateItem['expense'] = $transaction->total;
                    }
                    break;
                }
            }
        }
        
        // Format data for chart.js
        $result = [
            'labels' => [],
            'income' => [],
            'expense' => []
        ];
        
        foreach ($dates as $date) {
            $result['labels'][] = $date['day'];
            $result['income'][] = $date['income'];
            $result['expense'][] = $date['expense'];
        }
        
        return $result;
    }
}
