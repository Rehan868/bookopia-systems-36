
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Room;
use App\Models\Property;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('property');

        // Apply filters if provided
        if ($request->has('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->has('date_filter')) {
            switch ($request->date_filter) {
                case 'this_month':
                    $query->whereMonth('date', Carbon::now()->month)
                          ->whereYear('date', Carbon::now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('date', Carbon::now()->subMonth()->month)
                          ->whereYear('date', Carbon::now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('date', Carbon::now()->year);
                    break;
            }
        }

        // Fetch expenses with pagination
        $expenses = $query->orderBy('date', 'desc')->paginate(10);
        
        // Get expense categories for filter
        $categories = Expense::select('category')->distinct()->pluck('category');
        
        // Calculate total expenses based on filters
        $totalExpenses = $query->sum('amount');
        
        return view('pages.staff.expenses.index', compact('expenses', 'categories', 'totalExpenses'));
    }

    public function create()
    {
        $properties = Property::all();
        $categories = [
            'Maintenance',
            'Utilities',
            'Cleaning',
            'Supplies',
            'Taxes',
            'Insurance',
            'Salaries',
            'Marketing',
            'Other'
        ];
        
        $paymentMethods = [
            'Cash',
            'Credit Card',
            'Bank Transfer',
            'Check',
            'Digital Wallet'
        ];
        
        return view('pages.staff.expenses.create', compact('properties', 'categories', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'property_id' => 'required|exists:properties,id',
            'category' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'vendor' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'receipt' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_path'] = $path;
        }
        
        $expense = Expense::create($validated);
        
        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        return view('pages.staff.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $properties = Property::all();
        $categories = [
            'Maintenance',
            'Utilities',
            'Cleaning',
            'Supplies',
            'Taxes',
            'Insurance',
            'Salaries',
            'Marketing',
            'Other'
        ];
        
        $paymentMethods = [
            'Cash',
            'Credit Card',
            'Bank Transfer',
            'Check',
            'Digital Wallet'
        ];
        
        return view('pages.staff.expenses.edit', compact('expense', 'properties', 'categories', 'paymentMethods'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'property_id' => 'required|exists:properties,id',
            'category' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'vendor' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'receipt' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('receipts', 'public');
            $validated['receipt_path'] = $path;
        }
        
        $expense->update($validated);
        
        return redirect()->route('expenses.show', $expense)
            ->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        
        return redirect()->route('expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
