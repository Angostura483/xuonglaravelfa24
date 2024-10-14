<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'employees.';
    public function index()
    {
        $data = Employee::latest('id')->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $managers = Manager::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('departments', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'        => 'required|max:100',
            'last_name'         => 'required|max:100',
            'email'             => ['required', 'email', 'max:150', Rule::unique('employees')],
            'phone'             => 'required|string|max:15',
            'date_of_birth'     => 'required|date|before:today',
            'hire_date'         => 'required|date|after_or_equal:date_of_birth',
            'salary'            => 'required|numeric|min:5000000|max:60000000',
            'is_active'         => ['nullable', Rule::in([0, 1])],
            'department_id'     => 'required|exists:departments,id',
            'manager_id'        => 'required|exists:managers,id',
            'address'           => 'required|string',
            'profile_picture'   => 'nullable|file|max:2048',
        ]);

        try {
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $data['profile_picture'] = Storage::put('employees', file_get_contents($file));
            }

            Employee::query()->create($data);

            return redirect()
                ->route('employees.index')
                ->with('success', true);
        } catch (\Throwable $th) {
            if (!empty($data['profile_picture']) && Storage::exists($data['profile_picture'])) {
                Storage::delete($data['profile_picture']);
            }

            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $departments = Department::all();
        $managers = Manager::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('employee', 'departments', 'managers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $managers = Manager::all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('employee', 'departments', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name'        => 'required|max:100',
            'last_name'         => 'required|max:100',
            'email'             => ['required', 'email', 'max:150', Rule::unique('employees')->ignore($employee->id)],
            'phone'             => 'required|string|max:15',
            'date_of_birth'     => 'required|date|before:today',
            'hire_date'         => 'required|date|after_or_equal:date_of_birth',
            'salary'            => 'required|numeric|min:5000000|max:60000000',
            'is_active'         => ['nullable', Rule::in([0, 1])],
            'department_id'     => 'required|exists:departments,id',
            'manager_id'        => 'required|exists:managers,id',
            'address'           => 'required|string',
            'profile_picture'   => 'nullable|file|max:2048',
        ]);

        try {

            $data['is_active'] ??= 0;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $data['profile_picture'] = Storage::put('employees', file_get_contents($file));
            }

            $currentProfilePicture = $employee->profile_picture;

            $employee->update($data);

            if ($request->hasFile('profile_picture') && !empty($currentProfilePicture) && Storage::exists($currentProfilePicture)) {
                Storage::delete($currentProfilePicture);
            }

            return back()
                ->with('success', true);
        } catch (\Throwable $th) {
            if (!empty($data['profile_picture']) && Storage::exists($data['profile_picture'])) {
                Storage::delete($data['profile_picture']);
            }

            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return back()
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function forceDestroy(Employee $employee)
    {
        try {
            $employee->forceDelete();

            if (!empty($employee->profile_picture) && Storage::exists($employee->profile_picture)) {
                Storage::delete($employee->profile_picture);
            }

            return back()
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }
}
