<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empdata;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmpdataExport;
use App\Imports\EmpdataImport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmpdataController extends Controller
{
    /**
     * Dashboard & Orders Table with Search and Filtering
     */
    public function index(Request $request)
    {
        $query = Empdata::query();

        // Search across customer name, mobile, email, product, city
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('customer_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('mobile_number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%')
                  ->orWhere('product_name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('city', 'like', '%' . $searchTerm . '%');
            });
        }

        // Date range filtering
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('order_date', [
                $request->from_date,
                $request->to_date
            ]);
        } elseif ($request->filled('from_date')) {
            $query->where('order_date', '>=', $request->from_date);
        } elseif ($request->filled('to_date')) {
            $query->where('order_date', '<=', $request->to_date);
        }

        $orders = $query->latest()
                        ->paginate(10)
                        ->withQueryString();

        $totalRecords = Empdata::count();
        $todayOrders  = Empdata::whereDate('created_at', today())->count();
        $monthOrders  = Empdata::whereMonth('created_at', now()->month)->count();
        $totalRevenue = Empdata::sum('order_amount');

        return view('phrases.index', compact(
            'orders',
            'totalRecords',
            'todayOrders',
            'monthOrders',
            'totalRevenue'
        ));
    }

    /**
     * View Single Order Details
     */
    public function show(int $id)
    {
        $order = Empdata::findOrFail($id);
        return view('action.show', compact('order'));
    }

    /**
     * Edit Order Form
     */
    public function edit(int $id)
    {
        $order = Empdata::findOrFail($id);
        return view('action.edit', compact('order'));
    }

    /**
     * Update Existing Order
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
            'email'         => 'required|email|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'pincode'       => 'required|string|max:15',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'order_amount'  => 'required|numeric|min:0',
            'order_date'    => 'required|date',
        ]);

        $validated['order_date'] = Carbon::parse($request->order_date)->format('Y-m-d');

        $order = Empdata::findOrFail($id);
        $order->update($validated);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order #' . $id . ' updated successfully!');
    }

    /**
     * Delete Order
     */
    public function destroy(int $id)
    {
        $order = Empdata::findOrFail($id);
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order #' . $id . ' deleted successfully!');
    }

    /**
     * Phrase 1: Single Record Entry Form
     */
    public function create()
    {
        return view('phrases.phrase1');
    }

    /**
     * Phrase 1: Store Single Record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
            'email'         => 'required|email|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'pincode'       => 'required|string|max:15',
            'product_name'  => 'required|string|max:255',
            'quantity'      => 'required|integer|min:1',
            'order_amount'  => 'required|numeric|min:0',
            'order_date'    => 'required|date',
        ]);

        $validated['order_date'] = Carbon::parse($request->order_date)->format('Y-m-d');

        Empdata::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    /**
     * Phrase 2: Multiple Dynamic Record Entry Form
     */
    public function multipleCreate()
    {
        return view('phrases.phrase2');
    }

    /**
     * Phrase 2: Store Multiple Records Atomically with Transaction
     */
    public function multiplestore(Request $request)
    {
        $request->validate([
            'customer_name'   => 'required|array|min:1',
            'customer_name.*' => 'required|string|max:255',
            'mobile_number.*' => 'required|digits:10',
            'email.*'         => 'required|email|max:255',
            'city.*'          => 'required|string|max:100',
            'state.*'         => 'required|string|max:100',
            'pincode.*'       => 'required|string|max:15',
            'product_name.*'  => 'required|string|max:255',
            'quantity.*'      => 'required|integer|min:1',
            'order_amount.*'  => 'required|numeric|min:0',
            'order_date.*'    => 'required|date',
        ]);

        $count = count($request->customer_name);

        DB::transaction(function () use ($request, $count) {
            for ($i = 0; $i < $count; $i++) {
                Empdata::create([
                    'customer_name' => $request->customer_name[$i],
                    'mobile_number' => $request->mobile_number[$i],
                    'email'         => $request->email[$i],
                    'city'          => $request->city[$i],
                    'state'         => $request->state[$i],
                    'pincode'       => $request->pincode[$i],
                    'product_name'  => $request->product_name[$i],
                    'quantity'      => $request->quantity[$i],
                    'order_amount'  => $request->order_amount[$i],
                    'order_date'    => Carbon::parse($request->order_date[$i])->format('Y-m-d'),
                ]);
            }
        });

        return redirect()->route('orders.index')->with(
            'success',
            $count . ' Orders Saved Successfully!'
        );
    }

    /**
     * Phrase 3: Bulk CSV Import Form
     */
    public function csvCreate()
    {
        return view('phrases.phrase3');
    }

    /**
     * Phrase 3: Process CSV Import
     */
    public function csvStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120'
        ]);

        try {
            $import = new EmpdataImport;
            Excel::import($import, $request->file('file'));

            return redirect()->route('orders.index')
                ->with('success', 'CSV File imported and processed successfully!');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            return back()->with('error', 'Validation Error: ' . implode(' | ', array_slice($messages, 0, 3)));
        } catch (\Exception $e) {
            return back()->with('error', 'Import Error: ' . $e->getMessage());
        }
    }

    /**
     * Download Sample CSV template
     */
    public function downloadSample()
    {
        $dir = public_path('sample');
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $path = public_path('sample/sample_orders.csv');

        if (!file_exists($path)) {
            $sampleContent = "customer_name,mobile_number,email,city,state,pincode,product_name,quantity,order_amount,order_date\n" .
                             "Rahul Sharma,9876543210,rahul@example.com,Mumbai,Maharashtra,400001,Wireless Mouse,1,1500,2026-06-09\n" .
                             "Amit Verma,9123456789,amit@example.com,Delhi,Delhi,110001,Laptop Stand,2,2400,2026-06-09\n";
            file_put_contents($path, $sampleContent);
        }

        return response()->download($path, 'sample_orders.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Export all orders to CSV
     */
    public function exportCsv()
    {
        $fileName = 'orders_export_' . date('Y_m_d_His') . '.csv';
        return Excel::download(new EmpdataExport, $fileName);
    }
}