<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'string'
        ]);
        $employees = Employee::with('user')->filter(request(['search']))->paginate(10);
        return view('employee.index', [
            'employees' => $employees
        ]);
    }

    public function create() {
        return view('employee.create');
    }

    public function edit() {
        return view('employee.update');
    }

    public function store(CreateEmployeeRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'staff')->first()->id
        ]);
        Employee::create([
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'birth_date' => $request->birth,
            'user_id' => $user->id
        ]);
        return redirect()->route('employees')->with('success', 'Berhasil tambah karyawan');
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee) {
        $employee->user()->update([
            'name' => $request->name,
        ]);
        $employee->update([
            'phone_number' => $request->phone_number,
            'address' => $request->address
        ]);
        return redirect()->route('employees')->with('success', 'Berhasil update karyawan');
    }

    public function delete(Employee $employee) {
        $data = $employee->user;
        $employee->delete();
        return redirect()->back()->with('success', 'Berhasil hapus karyawan ' . $data->name);
    }
}
