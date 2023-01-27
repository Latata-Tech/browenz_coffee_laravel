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
        $employees = User::filter(request(['search']))->paginate(10);
        return view('employee.index', [
            'employees' => $employees
        ]);
    }

    public function create() {
        return view('employee.create');
    }

    public function createAccount(User $employee) {
        $roles = Role::select(['id', 'name']);
        if (auth()->user()->role_id === 1) {
            $roles = $roles->where('name', 'staff');
        }
        return view('employee.create_account', [
            'roles' => $roles->get(),
            'employee' => $employee
        ]);
    }

    public function updateAccount(User $employee) {
        return view('employee.update_account', [
            'roles' => Role::select(['id','name'])->get(),
            'employee' => $employee
        ]);
    }

    public function storeAccount(Request $request, User $employee) {
        $request->validate([
            'email' => 'required|email:rfc|unique:users,email',
            'password' => 'required|string|min:6|max:24',
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable',
        ]);
        $password = Hash::make($request->password);
        $employee->update([
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
            'status' => $request->status === "on"
        ]);
        return redirect()->route('employees')->with('success', 'Berhasil buat akun karyawan ' . $employee->name);
    }

    public function storeUpdateAccount(Request $request, User $employee) {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable'
        ]);

        $employee->update([
            'role_id' => $request->role_id,
            'status' => $request->status === "on"
        ]);
        return redirect()->route('employees')->with('success', 'Berhasil update akun karyawan ' . $employee->name);
    }

    public function detail(User $employee) {
        $employeeData = [
            'name' => $employee->name,
            'birth_date' => Carbon::createFromDate($employee->birth_date)->format('d/m/Y'),
            'phone_number' => $employee->phone_number,
            'address' => $employee->address,
        ];
        return view('employee.detail', [
            'employee' => $employeeData
        ]);
    }

    public function edit(User $employee) {
        return view('employee.update', [
            'employee' => $employee
        ]);
    }

    public function store(CreateEmployeeRequest $request) {
        User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);
        return redirect()->route('employees')->with('success', 'Berhasil tambah karyawan');
    }

    public function update(UpdateEmployeeRequest $request, User $employee) {
        if($request->role_id === 1 && auth()->user()->role_id === 1 && !is_null($employee->email)) {
            return redirect()->back()->with('errors', 'Admin tidak dapat update user admin');
        }
        $employee->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
        ]);
        return redirect()->route('employees')->with('success', 'Berhasil update karyawan');
    }

    public function delete(User $employee) {
        if($employee->role_id === 1 && auth()->user()->role_id === 1 && !is_null($employee->email)) {
            return redirect()->back()->with('failed', 'Admin tidak dapat menghapus user admin');
        }
        $data = $employee;
        $employee->delete();
        return redirect()->back()->with('success', 'Berhasil hapus karyawan ' . $data->name);
    }
}
