<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'search' => 'nullable|string'
        ]);
        $employees = Employee::with('user')->filter(request(['search']))->paginate(10);
        return view('employee.index', [
            'employees' => $employees
        ]);
    }

    public function create() {
        return view('employee.create');
    }

    public function detail(Employee $employee) {
        $employeeData = [
            'name' => $employee->user->name,
            'email' => $employee->user->email,
            'birth_date' => Carbon::createFromDate($employee->birth_date)->format('d/m/Y'),
            'phone_number' => $employee->phone_number,
            'address' => $employee->address,
        ];
        return view('employee.detail', [
            'employee' => $employeeData
        ]);
    }

    public function edit(Employee $employee) {
        return view('employee.update', [
            'employee' => $employee
        ]);
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
        $is_exist = User::where('email', $request->email)->first();
        if($is_exist->id !== $employee->user_id) {
            return redirect()->route('employees')->withErrors([
                'email' => 'Email yang dimasukan sudah terdapaftar'
            ]);
        }
        $employee->user()->update([
            'name' => $request->name,
            'email' => $request->email,
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
