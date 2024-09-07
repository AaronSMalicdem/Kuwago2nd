<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Query the expenses based on the date range
    $query = Expense::where('archived', false);

    if ($startDate) {
        $query->whereDate('date', '>=', Carbon::parse($startDate));
    }

    if ($endDate) {
        $query->whereDate('date', '<=', Carbon::parse($endDate));
    }

    // Execute the query and paginate the results
    $expenses = $query->orderBy('date', 'desc')->paginate(10);
    $totalExpenses = $query->sum('total_expenses');

    return view('admin.expenses.index', compact('expenses', 'totalExpenses'));
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'item_name' => 'required|string|max:255',
            'total_expenses' => 'required|numeric',
            'date' => 'required|date',
        ]);
    
        Expense::create([
            'expense_type' => $request->input('expense_type'),
            'item_name' => $request->input('item_name'),
            'total_expenses' => $request->input('total_expenses'),
            'date' => Carbon::parse($request->input('date')),
        ]);
    
        return redirect()->route('admin.expenses.index')->with('success', 'Expense Report Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
{
    $request->validate([
        'expense_type' => 'required|string',
        'item_name' => 'required|string',
        'total_expenses' => 'required|numeric',
        'date' => 'required|date_format:Y-m-d\TH:i',
    ]);

    $expense->update([
        'expense_type' => $request->expense_type,
        'item_name' => $request->item_name,
        'total_expenses' => $request->total_expenses,
        'date' => $request->date,
    ]);

    return redirect()->route('admin.expenses.index')->with('success', 'Expense report updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function archive(Expense $expense)
    {
        $expense->archived = true;
    $expense->save();

    return redirect()->route('admin.expenses.index')->with('success', 'Expense report archived successfully.');
    }

    // Show archived expenses
    public function archived()
{
    // Fetch archived expenses
    $archivedExpenses = Expense::where('archived', true)->orderBy('date', 'desc')->get();

    // Pass the archived expenses to the view
    return view('admin.expenses.archived', compact('archivedExpenses'));
}
public function unarchive($id)
{
    $expense = Expense::find($id);

    if ($expense) {
        // Update the archived status
        $expense->archived = false;
        $expense->save();

        // Redirect with success message
        return redirect()->route('admin.expenses.archived')
            ->with('status', 'Expense report has been unarchived.');
    }

    // Redirect with error if expense not found
    return redirect()->route('admin.expenses.archived')
        ->with('error', 'Expense report not found.');
}


}
