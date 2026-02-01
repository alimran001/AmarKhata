<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Account;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;

class ReportController extends Controller
{
    public function __construct()
    {
        // Remove the middleware from the constructor
    }
    
    public function index()
    {
        return view('reports.index');
    }
    
    public function monthly()
    {
        $monthYear = request('month', Carbon::now()->format('Y-m'));
        
        // Check if we received just a month number
        if (is_numeric($monthYear) && (int)$monthYear > 0 && (int)$monthYear <= 12) {
            // Create a valid date with the current year and the selected month
            $year = Carbon::now()->year;
            $startDate = Carbon::createFromDate($year, (int)$monthYear, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($year, (int)$monthYear, 1)->endOfMonth();
            $month = (int)$monthYear;
        } else {
            // If we have the YYYY-MM format, parse it normally
            try {
                $startDate = Carbon::parse($monthYear)->startOfMonth();
                $endDate = Carbon::parse($monthYear)->endOfMonth();
                $month = (int)$startDate->format('m');
                $year = (int)$startDate->format('Y');
            } catch (\Exception $e) {
                // Fallback if parsing fails
                $now = Carbon::now();
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $month = (int)$now->format('m');
                $year = (int)$now->format('Y');
            }
        }

        $transactions = Transaction::with(['category', 'account'])
            ->where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $income = $transactions->where('type', 'income')->sum('amount');
        $expense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expense;

        // ক্যাটেগরি অনুযায়ী ব্যয়
        $expenseByCategory = $transactions->where('type', 'expense')
            ->groupBy('category_id')
            ->map(function ($items) {
                $category = $items->first()->category;
                return [
                    'category' => $category ? $category->name : 'অন্যান্য',
                    'amount' => $items->sum('amount')
                ];
            })
            ->sortByDesc('amount');

        // ক্যাটেগরি অনুযায়ী আয়-ব্যয়
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        $categoryIncome = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        // দৈনিক আয়-ব্যয়
        $days = collect();
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $dayTransactions = $transactions->filter(function ($transaction) use ($currentDate) {
                return $transaction->date->format('Y-m-d') === $currentDate->format('Y-m-d');
            });
            
            $days->push([
                'date' => $currentDate->format('Y-m-d'),
                'day' => $currentDate->format('d'),
                'income' => $dayTransactions->where('type', 'income')->sum('amount'),
                'expense' => $dayTransactions->where('type', 'expense')->sum('amount')
            ]);
            
            $currentDate->addDay();
        }

        // অ্যাকাউন্ট অনুযায়ী ব্যালেন্স
        $accounts = Account::where('user_id', Auth::id())->get();
        $accountBalances = $accounts->map(function ($account) use ($startDate, $endDate) {
            $transactions = Transaction::where('account_id', $account->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();
            
            $income = $transactions->where('type', 'income')->sum('amount');
            $expense = $transactions->where('type', 'expense')->sum('amount');
            
            return (object)[
                'name' => $account->name,
                'type' => $account->type,
                'month_end_balance' => $income - $expense
            ];
        });

        // Calculate balance by account type
        $balanceByType = $accountBalances->groupBy('type')
            ->map(function ($accounts) {
                return $accounts->sum('month_end_balance');
            });

        // লোন স্ট্যাটাস - পুরো ঋণের হিসাব
        // সবগুলো ঋণ নিবো, শুধু সিলেক্টেড তারিখের মধ্যে নয়
        $allLoans = Loan::where('user_id', Auth::id())->get();
        
        // লোন পেমেন্ট এই তারিখের মধ্যে হিসাব করবো
        $loanPaymentsInRange = \DB::table('loan_payments')
            ->join('loans', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.user_id', Auth::id())
            ->whereBetween('loan_payments.date', [$startDate, $endDate])
            ->select('loans.id', 'loans.type', \DB::raw('SUM(loan_payments.amount) as paid_in_range'))
            ->groupBy('loans.id', 'loans.type')
            ->get()
            ->groupBy('type');

        $givenLoans = $allLoans->where('type', 'Given');
        $takenLoans = $allLoans->where('type', 'Taken');
        
        // Given Loans হিসাব
        $givenTotal = $givenLoans->sum('amount');
        $givenPaid = $givenLoans->sum('paid_amount');
        $givenPaidInRange = isset($loanPaymentsInRange['Given']) ? $loanPaymentsInRange['Given']->sum('paid_in_range') : 0;
        
        // Taken Loans হিসাব
        $takenTotal = $takenLoans->sum('amount');
        $takenPaid = $takenLoans->sum('paid_amount');
        $takenPaidInRange = isset($loanPaymentsInRange['Taken']) ? $loanPaymentsInRange['Taken']->sum('paid_in_range') : 0;

        $givenLoanData = [
            'total' => $givenTotal ?: 0,
            'paid' => $givenPaid ?: 0,
            'paid_in_range' => $givenPaidInRange ?: 0,
            'remaining' => ($givenTotal - $givenPaid) ?: 0
        ];

        $takenLoanData = [
            'total' => $takenTotal ?: 0,
            'paid' => $takenPaid ?: 0,
            'paid_in_range' => $takenPaidInRange ?: 0,
            'remaining' => ($takenTotal - $takenPaid) ?: 0
        ];

        $data = [
            'monthName' => $startDate->format('F Y'),
            'year' => $year,
            'month' => $month,
            'totalIncome' => $income,
            'totalExpense' => $expense,
            'balance' => $balance,
            'expenseByCategory' => $expenseByCategory,
            'accountBalances' => $accountBalances,
            'balanceByType' => $balanceByType,
            'categoryExpense' => $categoryExpense,
            'categoryIncome' => $categoryIncome,
            'days' => $days->values()->toArray(),
            'givenLoans' => $givenLoanData,
            'takenLoans' => $takenLoanData
        ];

        if (request('download')) {
            $options = new Options();
            $options->set('defaultFont', 'Nikosh');
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('isRemoteEnabled', true);
            $options->set('defaultMediaType', 'screen');
            $options->set('isFontSubsettingEnabled', true);
            $options->set('defaultEncoding', 'UTF-8');
            $options->set('debugKeepTemp', true);
            $options->set('debugCss', true);
            $options->set('debugLayout', true);
            $options->set('chroot', public_path());
            $options->set('fontDir', storage_path('fonts'));
            $options->set('fontCache', storage_path('fonts'));
            $options->set('tempDir', storage_path('app/temp'));
            $options->set('logOutputFile', storage_path('logs/pdf.log'));
            
            $dompdf = new Dompdf($options);
            
            // Register custom font
            $fontPath = storage_path('fonts/Nikosh.ttf');
            if (file_exists($fontPath)) {
                $dompdf->getFontMetrics()->registerFont(
                    ['family' => 'Nikosh', 'style' => 'normal', 'weight' => 'normal'],
                    $fontPath
                );
            } else {
                \Log::error('Nikosh font not found at: ' . $fontPath);
            }
            
            $html = view('reports.monthly-pdf', $data)->render();
            
            // Add font-face declaration to HTML
            $html = '<style>
                @font-face {
                    font-family: "Nikosh";
                    src: url("' . $fontPath . '") format("truetype");
                    font-weight: normal;
                    font-style: normal;
                }
                @font-face {
                    font-family: "nikosh";
                    src: url("' . $fontPath . '") format("truetype");
                    font-weight: normal;
                    font-style: normal;
                }
                body, table, td, th, div, p, h1, h2, h3, h4, h5, h6 {
                    font-family: "Nikosh" !important;
                }
                * {
                    font-family: "Nikosh" !important;
                }
            </style>' . $html;
            
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            return $dompdf->stream('monthly-report-' . $startDate->format('Y-m') . '.pdf', ['Attachment' => false]);
        }

        return view('reports.monthly', $data);
    }
    
    public function yearly()
    {
        $year = request('year', Carbon::now()->format('Y'));
        $startDate = Carbon::parse($year)->startOfYear();
        $endDate = Carbon::parse($year)->endOfYear();

        $transactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        // মাস অনুযায়ী আয়-ব্যয়
        $monthlyData = collect();
        for ($i = 1; $i <= 12; $i++) {
            $monthStart = Carbon::parse($year . '-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01');
            $monthEnd = $monthStart->copy()->endOfMonth();
            
            $monthTransactions = $transactions->filter(function ($transaction) use ($monthStart, $monthEnd) {
                return $transaction->date->between($monthStart, $monthEnd);
            });

            $monthlyData->push([
                'month' => $i,
                'name' => $monthStart->format('F'),
                'income' => $monthTransactions->where('type', 'income')->sum('amount'),
                'expense' => $monthTransactions->where('type', 'expense')->sum('amount')
            ]);
        }

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // ক্যাটেগরি অনুযায়ী আয়-ব্যয়
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        $categoryIncome = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        // অ্যাকাউন্ট অনুযায়ী ব্যালেন্স
        $accounts = Account::where('user_id', Auth::id())->get();
        $accountBalances = $accounts->map(function ($account) {
            return (object)[
                'name' => $account->name,
                'type' => $account->type,
                'current_balance' => $account->current_balance
            ];
        });

        // Calculate balance by account type
        $balanceByType = $accountBalances->groupBy('type')
            ->map(function ($accounts) {
                return $accounts->sum('current_balance');
            });

        // লোন স্ট্যাটাস
        $loans = Loan::where('user_id', Auth::id())
            ->get();

        $givenLoans = $loans->where('type', 'Given');
        $takenLoans = $loans->where('type', 'Taken');

        // লোন পেমেন্ট এই তারিখের মধ্যে হিসাব করবো
        $loanPaymentsInRange = \DB::table('loan_payments')
            ->join('loans', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.user_id', Auth::id())
            ->whereBetween('loan_payments.date', [$startDate, $endDate])
            ->select('loans.id', 'loans.type', \DB::raw('SUM(loan_payments.amount) as paid_in_range'))
            ->groupBy('loans.id', 'loans.type')
            ->get()
            ->groupBy('type');

        // ঋণের ডাটা যেন খালি থাকলেও অবজেক্ট তৈরি হয়
        $givenLoanData = [
            'total' => $givenLoans->sum('amount') ?: 0,
            'paid' => $givenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Given']) ? $loanPaymentsInRange['Given']->sum('paid_in_range') : 0,
            'remaining' => ($givenLoans->sum('amount') - $givenLoans->sum('paid_amount')) ?: 0
        ];

        $takenLoanData = [
            'total' => $takenLoans->sum('amount') ?: 0,
            'paid' => $takenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Taken']) ? $loanPaymentsInRange['Taken']->sum('paid_in_range') : 0,
            'remaining' => ($takenLoans->sum('amount') - $takenLoans->sum('paid_amount')) ?: 0
        ];

        $data = [
            'year' => $year,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'months' => $monthlyData->toArray(),
            'yearlyTotals' => [
                'income' => $totalIncome,
                'expense' => $totalExpense,
                'balance' => $balance
            ],
            'categoryExpense' => $categoryExpense,
            'categoryIncome' => $categoryIncome,
            'accountBalances' => $accountBalances,
            'balanceByType' => $balanceByType,
            'givenLoans' => $givenLoanData,
            'takenLoans' => $takenLoanData
        ];

        if (request('download')) {
            $pdf = PDF::loadView('reports.yearly-pdf', $data);
            $pdf->setPaper('a4');
            $pdf->setOption('font-family', 'SolaimanLipi');
            $pdf->setOption('font-size', 12);
            return $pdf->download('yearly-report-' . $year . '.pdf');
        }

        return view('reports.yearly', $data);
    }
    
    public function custom()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth());
        $endDate = request('end_date', Carbon::now()->endOfMonth());

        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $transactions = Transaction::with(['category', 'account'])
            ->where('user_id', Auth::id())
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get();

        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // ক্যাটেগরি অনুযায়ী আয়-ব্যয়
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        $categoryIncome = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', Auth::id())
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.date', [$startDate, $endDate])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();

        // অ্যাকাউন্ট অনুযায়ী ব্যালেন্স
        $accounts = Account::where('user_id', Auth::id())->get();
        $accountBalances = $accounts->map(function ($account) {
            return (object)[
                'name' => $account->name,
                'type' => $account->type,
                'current_balance' => $account->current_balance
            ];
        });

        // Calculate balance by account type
        $balanceByType = $accountBalances->groupBy('type')
            ->map(function ($accounts) {
                return $accounts->sum('current_balance');
            });

        // লোন স্ট্যাটাস
        $loans = Loan::where('user_id', Auth::id())
            ->get();

        $givenLoans = $loans->where('type', 'Given');
        $takenLoans = $loans->where('type', 'Taken');

        // লোন পেমেন্ট এই তারিখের মধ্যে হিসাব করবো
        $loanPaymentsInRange = \DB::table('loan_payments')
            ->join('loans', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.user_id', Auth::id())
            ->whereBetween('loan_payments.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select('loans.id', 'loans.type', \DB::raw('SUM(loan_payments.amount) as paid_in_range'))
            ->groupBy('loans.id', 'loans.type')
            ->get()
            ->groupBy('type');

        // ঋণের ডাটা যেন খালি থাকলেও অবজেক্ট তৈরি হয়
        $givenLoanData = [
            'total' => $givenLoans->sum('amount') ?: 0,
            'paid' => $givenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Given']) ? $loanPaymentsInRange['Given']->sum('paid_in_range') : 0,
            'remaining' => ($givenLoans->sum('amount') - $givenLoans->sum('paid_amount')) ?: 0
        ];

        $takenLoanData = [
            'total' => $takenLoans->sum('amount') ?: 0,
            'paid' => $takenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Taken']) ? $loanPaymentsInRange['Taken']->sum('paid_in_range') : 0,
            'remaining' => ($takenLoans->sum('amount') - $takenLoans->sum('paid_amount')) ?: 0
        ];

        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'transactions' => $transactions,
            'categoryExpense' => $categoryExpense,
            'categoryIncome' => $categoryIncome,
            'accountBalances' => $accountBalances,
            'balanceByType' => $balanceByType,
            'givenLoans' => $givenLoanData,
            'takenLoans' => $takenLoanData
        ];

        if (request('download')) {
            $pdf = PDF::loadView('reports.custom-pdf', $data);
            $pdf->setPaper('a4');
            $pdf->setOption('font-family', 'SolaimanLipi');
            $pdf->setOption('font-size', 12);
            return $pdf->download('custom-report.pdf');
        }

        return view('reports.custom', $data);
    }
    
    public function downloadPdf(Request $request)
    {
        $type = $request->input('type', 'monthly');
        
        switch ($type) {
            case 'monthly':
                return $this->downloadMonthlyPdf($request);
            case 'yearly':
                return $this->downloadYearlyPdf($request);
            case 'custom':
                return $this->downloadCustomPdf($request);
            default:
                abort(404);
        }
    }
    
    private function getPdfOptions()
    {
        $options = new Options();
        $options->set('defaultFont', 'Nikosh');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultMediaType', 'screen');
        $options->set('isFontSubsettingEnabled', true);
        $options->set('defaultEncoding', 'UTF-8');
        $options->set('chroot', public_path());
        $options->set('fontDir', storage_path('fonts'));
        $options->set('fontCache', storage_path('fonts'));
        
        return $options;
    }
    
    private function registerNikoshFont(Dompdf $dompdf)
    {
        $fontPath = storage_path('fonts/Nikosh.ttf');
        if (file_exists($fontPath)) {
            $dompdf->getFontMetrics()->registerFont(
                ['family' => 'Nikosh', 'style' => 'normal', 'weight' => 'normal'],
                $fontPath
            );
            
            return true;
        } else {
            \Log::error('Nikosh font not found at: ' . $fontPath);
            return false;
        }
    }
    
    private function addFontFaceStyle($html)
    {
        $fontPath = storage_path('fonts/Nikosh.ttf');
        
        return '<style>
            @font-face {
                font-family: "Nikosh";
                src: url("' . $fontPath . '") format("truetype");
                font-weight: normal;
                font-style: normal;
            }
            @font-face {
                font-family: "nikosh";
                src: url("' . $fontPath . '") format("truetype");
                font-weight: normal;
                font-style: normal;
            }
            body, table, td, th, div, p, h1, h2, h3, h4, h5, h6 {
                font-family: "Nikosh" !important;
            }
            * {
                font-family: "Nikosh" !important;
            }
        </style>' . $html;
    }
    
    private function downloadMonthlyPdf(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);
        
        // Make sure month is an integer between 1-12
        $month = (int)$month;
        if ($month < 1 || $month > 12) {
            $month = Carbon::now()->month;
        }
        
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        $user = Auth::user();
        
        // Get total income and expense for the month
        $summary = Transaction::where('user_id', $user->id)
            ->whereIn('type', ['income', 'expense'])
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select('type', DB::raw('SUM(amount) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type')
            ->toArray();
            
        $totalIncome = $summary['income'] ?? 0;
        $totalExpense = $summary['expense'] ?? 0;
        $balance = $totalIncome - $totalExpense;
        
        // Get accounts
        $accounts = DB::table('accounts')
            ->where('user_id', $user->id)
            ->get();
            
        // Calculate account balances up to the end of the selected month
        $accountBalances = collect();
        
        foreach ($accounts as $account) {
            // Get the account's opening balance
            $openingBalance = $account->opening_balance ?? 0;
            
            // Get all transactions for this account up to the end of the selected month
            $transactions = Transaction::where('user_id', $user->id)
                ->where('account_id', $account->id)
                ->whereDate('date', '<=', $endDate->format('Y-m-d'))
                ->get();
                
            // Calculate the balance based on transactions
            $balance = $openingBalance;
            
            foreach ($transactions as $transaction) {
                if ($transaction->type == 'income') {
                    $balance += $transaction->amount;
                } elseif ($transaction->type == 'expense') {
                    $balance -= $transaction->amount;
                } elseif ($transaction->type == 'transfer') {
                    // For transfers, check if this account is source or destination
                    if ($transaction->account_id == $account->id) {
                        $balance -= $transaction->amount; // Outgoing transfer
                    }
                    if ($transaction->to_account_id == $account->id) {
                        $balance += $transaction->amount; // Incoming transfer
                    }
                }
            }
            
            // Add the calculated balance to the account object
            $accountWithBalance = clone $account;
            $accountWithBalance->month_end_balance = $balance;
            $accountBalances->push($accountWithBalance);
        }
        
        // Calculate total balance by account type for the month end
        $balanceByType = $accountBalances->groupBy('type')
            ->map(function ($accounts) {
                return $accounts->sum('month_end_balance');
            });
        
        // Get category-wise income and expense
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();
            
        $categoryIncome = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();
        
        // লোন স্ট্যাটাস - পুরো ঋণের হিসাব
        $loans = Loan::where('user_id', $user->id)
            ->get();

        $givenLoans = $loans->where('type', 'Given');
        $takenLoans = $loans->where('type', 'Taken');
        
        // লোন পেমেন্ট এই মাসের মধ্যে হিসাব করবো
        $loanPaymentsInRange = \DB::table('loan_payments')
            ->join('loans', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.user_id', $user->id)
            ->whereBetween('loan_payments.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select('loans.id', 'loans.type', \DB::raw('SUM(loan_payments.amount) as paid_in_range'))
            ->groupBy('loans.id', 'loans.type')
            ->get()
            ->groupBy('type');
        
        // Given Loans হিসাব
        $givenTotal = $givenLoans->sum('amount');
        $givenPaid = $givenLoans->sum('paid_amount');
        $givenPaidInRange = isset($loanPaymentsInRange['Given']) ? $loanPaymentsInRange['Given']->sum('paid_in_range') : 0;
        
        // Taken Loans হিসাব
        $takenTotal = $takenLoans->sum('amount');
        $takenPaid = $takenLoans->sum('paid_amount');
        $takenPaidInRange = isset($loanPaymentsInRange['Taken']) ? $loanPaymentsInRange['Taken']->sum('paid_in_range') : 0;

        $givenLoanData = [
            'total' => $givenTotal ?: 0,
            'paid' => $givenPaid ?: 0,
            'paid_in_range' => $givenPaidInRange ?: 0,
            'remaining' => ($givenTotal - $givenPaid) ?: 0
        ];

        $takenLoanData = [
            'total' => $takenTotal ?: 0,
            'paid' => $takenPaid ?: 0,
            'paid_in_range' => $takenPaidInRange ?: 0,
            'remaining' => ($takenTotal - $takenPaid) ?: 0
        ];
        
        // Create PDF using direct Dompdf instance
        $options = $this->getPdfOptions();
        $dompdf = new Dompdf($options);
        
        // Register custom font
        $this->registerNikoshFont($dompdf);
        
        $html = view('reports.pdf.monthly', [
            'year' => $year,
            'month' => $month,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'categoryExpense' => $categoryExpense,
            'categoryIncome' => $categoryIncome,
            'accountBalances' => $accountBalances,
            'balanceByType' => $balanceByType,
            'givenLoans' => $givenLoanData,
            'takenLoans' => $takenLoanData
        ])->render();
        
        // Add font-face declaration to HTML
        $html = $this->addFontFaceStyle($html);
        
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream('monthly-report-' . $startDate->format('Y-m') . '.pdf', ['Attachment' => false]);
    }
    
    private function downloadYearlyPdf(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        
        $startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();
        
        $user = Auth::user();
        
        // Get monthly data with SQLite compatible query
        $monthlyData = Transaction::where('user_id', $user->id)
            ->whereIn('type', ['income', 'expense'])
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                DB::raw("strftime('%m', date) as month"),
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month', 'type')
            ->get();
            
        $months = [];
        
        for ($i = 1; $i <= 12; $i++) {
            // Make sure month is two digits (01, 02, etc.) to match strftime format
            $monthKey = str_pad($i, 2, '0', STR_PAD_LEFT);
            $months[$monthKey] = [
                'month' => $i,
                'name' => Carbon::createFromDate($year, $i, 1)->format('F'),
                'income' => 0,
                'expense' => 0
            ];
        }
        
        foreach ($monthlyData as $data) {
            $months[$data->month][$data->type] = $data->total;
        }
        
        // Calculate yearly totals
        $yearlyTotals = [
            'income' => array_sum(array_column($months, 'income')),
            'expense' => array_sum(array_column($months, 'expense')),
        ];
        
        $yearlyTotals['balance'] = $yearlyTotals['income'] - $yearlyTotals['expense'];
        
        // Category breakdown for the year
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();
            
        $categoryIncome = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();
        
        // লোন স্ট্যাটাস
        $loans = Loan::where('user_id', $user->id)
            ->get();

        $givenLoans = $loans->where('type', 'Given');
        $takenLoans = $loans->where('type', 'Taken');

        // লোন পেমেন্ট এই তারিখের মধ্যে হিসাব করবো
        $loanPaymentsInRange = \DB::table('loan_payments')
            ->join('loans', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.user_id', $user->id)
            ->whereBetween('loan_payments.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select('loans.id', 'loans.type', \DB::raw('SUM(loan_payments.amount) as paid_in_range'))
            ->groupBy('loans.id', 'loans.type')
            ->get()
            ->groupBy('type');

        // ঋণের ডাটা যেন খালি থাকলেও অবজেক্ট তৈরি হয়
        $givenLoanData = [
            'total' => $givenLoans->sum('amount') ?: 0,
            'paid' => $givenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Given']) ? $loanPaymentsInRange['Given']->sum('paid_in_range') : 0,
            'remaining' => ($givenLoans->sum('amount') - $givenLoans->sum('paid_amount')) ?: 0
        ];

        $takenLoanData = [
            'total' => $takenLoans->sum('amount') ?: 0,
            'paid' => $takenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Taken']) ? $loanPaymentsInRange['Taken']->sum('paid_in_range') : 0,
            'remaining' => ($takenLoans->sum('amount') - $takenLoans->sum('paid_amount')) ?: 0
        ];
        
        // Create PDF using direct Dompdf instance
        $options = $this->getPdfOptions();
        $dompdf = new Dompdf($options);
        
        // Register custom font
        $this->registerNikoshFont($dompdf);
        
        $html = view('reports.pdf.yearly', [
            'year' => $year,
            'months' => $months,
            'yearlyTotals' => $yearlyTotals,
            'categoryExpense' => $categoryExpense,
            'categoryIncome' => $categoryIncome,
            'givenLoans' => $givenLoanData,
            'takenLoans' => $takenLoanData
        ])->render();
        
        // Add font-face declaration to HTML
        $html = $this->addFontFaceStyle($html);
        
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream('yearly-report-' . $year . '.pdf');
    }
    
    private function downloadCustomPdf(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        
        $user = Auth::user();
        
        // Get total income and expense for period
        $summary = Transaction::where('user_id', $user->id)
            ->whereIn('type', ['income', 'expense'])
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select('type', DB::raw('SUM(amount) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type')
            ->toArray();
            
        $totalIncome = $summary['income'] ?? 0;
        $totalExpense = $summary['expense'] ?? 0;
        $balance = $totalIncome - $totalExpense;
        
        // Get account balances
        $accountBalances = DB::table('accounts')
            ->where('user_id', $user->id)
            ->select('id', 'name', 'type', 'current_balance')
            ->orderBy('type')
            ->orderBy('name')
            ->get();
        
        // Calculate total balance by account type
        $balanceByType = $accountBalances->groupBy('type')
            ->map(function ($accounts) {
                return $accounts->sum('current_balance');
            });
        
        // Get all transactions for the period
        $transactions = Transaction::with(['category', 'account'])
            ->where('user_id', $user->id)
            ->whereIn('type', ['income', 'expense'])
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->orderBy('date', 'desc')
            ->get();
            
        // Category breakdown
        $categoryExpense = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereBetween('transactions.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();
            
        $categoryIncome = Transaction::join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->whereBetween('transactions.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'categories.name',
                'categories.color',
                DB::raw('SUM(transactions.amount) as total')
            )
            ->groupBy('categories.name', 'categories.color')
            ->orderBy('total', 'desc')
            ->get();
        
        // লোন স্ট্যাটাস
        $loans = Loan::where('user_id', $user->id)
            ->get();

        $givenLoans = $loans->where('type', 'Given');
        $takenLoans = $loans->where('type', 'Taken');

        // লোন পেমেন্ট এই তারিখের মধ্যে হিসাব করবো
        $loanPaymentsInRange = \DB::table('loan_payments')
            ->join('loans', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.user_id', $user->id)
            ->whereBetween('loan_payments.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select('loans.id', 'loans.type', \DB::raw('SUM(loan_payments.amount) as paid_in_range'))
            ->groupBy('loans.id', 'loans.type')
            ->get()
            ->groupBy('type');

        // ঋণের ডাটা যেন খালি থাকলেও অবজেক্ট তৈরি হয়
        $givenLoanData = [
            'total' => $givenLoans->sum('amount') ?: 0,
            'paid' => $givenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Given']) ? $loanPaymentsInRange['Given']->sum('paid_in_range') : 0,
            'remaining' => ($givenLoans->sum('amount') - $givenLoans->sum('paid_amount')) ?: 0
        ];

        $takenLoanData = [
            'total' => $takenLoans->sum('amount') ?: 0,
            'paid' => $takenLoans->sum('paid_amount') ?: 0,
            'paid_in_range' => isset($loanPaymentsInRange['Taken']) ? $loanPaymentsInRange['Taken']->sum('paid_in_range') : 0,
            'remaining' => ($takenLoans->sum('amount') - $takenLoans->sum('paid_amount')) ?: 0
        ];
        
        // Create PDF using direct Dompdf instance
        $options = $this->getPdfOptions();
        $dompdf = new Dompdf($options);
        
        // Register custom font
        $this->registerNikoshFont($dompdf);
        
        $html = view('reports.pdf.custom', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $balance,
            'transactions' => $transactions,
            'categoryExpense' => $categoryExpense,
            'categoryIncome' => $categoryIncome,
            'accountBalances' => $accountBalances,
            'balanceByType' => $balanceByType,
            'givenLoans' => $givenLoanData,
            'takenLoans' => $takenLoanData
        ])->render();
        
        // Add font-face declaration to HTML
        $html = $this->addFontFaceStyle($html);
        
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream('custom-report-' . $startDate->format('Y-m-d') . '-to-' . $endDate->format('Y-m-d') . '.pdf');
    }
}
