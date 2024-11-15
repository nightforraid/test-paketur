<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve employees with their associated users (belonging to the same company as the authenticated user)
        $query = Employee::with('user')->whereHas('user', function ($query) {
            $query->where('company_id', auth()->user()->company_id);
        });

        // Search functionality by employee name
        if ($request->has('search')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Paginate the results (10 items per page)
        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        // Validate input for creating an employee
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        // Create the employee associated with the authenticated user
        $employee = Employee::create([
            'user_id' => auth()->user()->id, // Use the authenticated user ID
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return response()->json($employee, 201);
    }

    public function show($id)
    {
        // Retrieve a specific employee by ID with the associated user data
        $employee = Employee::with('user')->findOrFail($id);
        return response()->json($employee);
    }
}