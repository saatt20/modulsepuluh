<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, input, redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\http\Controllers\datatable;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use PDF;
class EmployeeController extends Controller



{
    /**
     * Display a listing of the resource.
     */
        //return view('employee.index', ['pageTitle' => $pageTitle]);

        // RAW SQL QUERY
        // $employees = DB::select('
        //     select *, employees.id as employee_id, positions.name as position_name
        //     from employees
        //     left join positions on employees.position_id = positions.id
        // ');
        // return view('employee.index', [
        //     'pageTitle' => $pageTitle,
        //     'employees' => $employees
        // ]);
    // public function index()
    // {
    //     $pageTitle = 'Employee List';
    //     $employees = DB::table('employees')
    //     ->select('employees.*', 'employees.id as employee_id', 'positions.name as position_name')
    //     ->join('positions', 'positions.id', '=', 'employees.position_id')->get();
    //     return view('employee.index', [
    //         'pageTitle' => $pageTitle,
    //         'employees' => $employees
    //     ]);
    // }
        public function index()
    {
        // ELOQUENT
        // $employees = Employee::all();
        $pageTitle = 'Employee List';
        confirmDelete();
        return view('employee.index', compact('pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $pageTitle = 'Create Employee';
        //  // RAW SQL Query
        // $positions = DB::select('select * from positions');

        // return view('employee.create', compact('pageTitle', 'positions'));
        // $pageTitle = 'Create Employee';
        // $positions = DB::table('positions')->get();
        // return view('employee.create', compact('pageTitle','positions'));
        $pageTitle = 'Create Employee';
        // ELOQUENT
        $positions = Position::all();
        return view('employee.create', compact('pageTitle', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // $messages = [
    //     'required' => ':Attribute harus diisi.',
    //     'email' => 'Isi :attribute dengan format yang benar',
    //     'numeric' => 'Isi :attribute dengan angka'
    // ];

    // $validator = Validator::make($request->all(), [
    //     'firstName' => 'required',
    //     'lastName' => 'required',
    //     'email' => 'required|email',
    //     'age' => 'required|numeric',
    // ], $messages);

    // if ($validator->fails()) {
    //     return redirect()->back()->withErrors($validator)->withInput();
    // }

    // // INSERT QUERY
    // DB::table('employees')->insert([
    //     'firstname' => $request->firstName,
    //     'lastname' => $request->lastName,
    //     'email' => $request->email,
    //     'age' => $request->age,
    //     'position_id' => $request->position,
    // ]);

    // return redirect()->route('employees.index');
    $messages = [
        'required' => ':Attribute harus diisi.',
        'email' => 'Isi :attribute dengan format yang benar',
        'numeric' => 'Isi :attribute dengan angka'
    ];

    $validator = Validator::make($request->all(), [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        'age' => 'required|numeric',
    ], $messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Get File
    $file = $request->file('cv');

    if ($file != null) {
        $originalFilename = $file->getClientOriginalName();
        $encryptedFilename = $file->hashName();

        // Store File
        $file->store('public/files');
    }



    // ELOQUENT
    $employee = New Employee;
    $employee->firstname = $request->firstName;
    $employee->lastname = $request->lastName;
    $employee->email = $request->email;
    $employee->age = $request->age;
    $employee->position_id = $request->position;

    if ($file != null) {
        $employee->original_filename = $originalFilename;
        $employee->encrypted_filename = $encryptedFilename;
    }
    $employee->save();

    Alert::success('Added Successfully', 'Employee Data Added Successfully.');
    return redirect()->route('employees.index');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // RAW SQL QUERY
            // $employee = collect(DB::select('
            //     select *, employees.id as employee_id, positions.name as position_name
            //     from employees
            //     left join positions on employees.position_id = positions.id
            //     where employees.id = ?
            // ', [$id]))->first();

            // return view('employee.show', compact('pageTitle', 'employee'));
        // $pageTitle = 'Employee Detail';
        // $employee = DB::table('employees')
        // ->select('employees.*', 'positions.name as position_name', 'positions.id as position_id')
        // ->leftJoin('positions', 'positions.id', '=', 'employees.position_id')
        // ->where('employees.id', $id)
        // ->first();
        // return view('employee.show', compact('pageTitle', 'employee'));

        $pageTitle = 'Employee Detail';
        // ELOQUENT
        $employee = Employee::find($id);
        return view('employee.show', compact('pageTitle', 'employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $pageTitle = 'Edit Employee';
        // $positions = DB::table('positions')->get();
        // $employee = DB::table('employees')
        //     ->select('*', 'employees.id as employee_id', 'positions.name as position_name')
        //     ->leftJoin('positions', 'employees.position_id', 'positions.id')
        //     ->where('employees.id', $id)
        //     ->first();
        // return view('employee.edit', compact('pageTitle', 'positions', 'employee'));

        $pageTitle = 'Edit Employee';
        // ELOQUENT
        $positions = Position::all();
        $employee = Employee::find($id);
        return view('employee.edit', compact('pageTitle', 'positions', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // {
        //     DB::table('employees')
        //     ->where('id', $id)
        //     ->update([
        //     'firstname' => $request->input('firstname'),
        //     'lastname' => $request->input('lastname'),
        //     'email' => $request->input('email'),
        //     'age' => $request->input('age'),
        //     'position_id' => $request->input('position')
        //     ]);
        //     return redirect()->route('employees.index');
        //     return view('employee.index', compact('pageTitle', 'employee'));
        //     }
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'age' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('cv');

        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            $file->store('public/files');

            $employee = Employee::find($id);
            if ($employee->encrypted_filename) {
                Storage::delete('public/file/' . $employee->encrypted_filename);
            }
        }
        // ELOQUENT
        $employee = Employee::find($id);
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        $employee->save();

        if ($file != null) {
            $employee->original_filename = $originalFilename;
            $employee->encrypted_filename = $encryptedFilename;
        }

        $employee->save();

        Alert::success('Changed Successfully', 'Employee Data Changed Successfully.');
        return redirect()->route('employees.index')->with('succes', 'Employee updated succesfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // QUERY BUILDER
        // DB::table('employees')
        //     ->where('id', $id)
        //     ->delete();

        // return redirect()->route('employees.index');
        // ELOQUENT

        // $employee = Employee::find($id);
        // if ($employee->encrypted_filename) {
        //     Storage::delete('public/files/' . $employee->encrypted_filename);
        //     }

        //     $employee->delete();

        //     return redirect()->route('employees.index');
        $employee = Employee::find($id);
            if ($employee) {
                $file = 'public/files/'.$employee->encrypted_filename;
            if (!empty($file)) {
                Storage::delete('/'.$file);
            }
            $employee->delete();
            }
            Alert::success('Deleted Successfully', 'Employee Data Deleted Successfully.');
            return redirect()->route('employees.index');
    }

        public function downloadFile($employeeId)
    {
        $employee = Employee::find($employeeId);
        $encryptedFilename = 'public/files/'.$employee->encrypted_filename;
        $downloadFilename = Str::lower($employee->firstname.'_'.$employee->lastname.'_cv.pdf');

        if(Storage::exists($encryptedFilename)) {
        return Storage::download($encryptedFilename, $downloadFilename);
        }
    }

        public function getData(Request $request)
    {
        $employees = Employee::with('position');

        if ($request->ajax()) {
        return datatables()->of($employees)->addIndexColumn()->addColumn('actions', function($employee) {
        return view('employee.actions', compact('employee'));
        })->toJson();
        }
    }

        public function exportExcel()
    {
        return Excel::download(new EmployeesExport, 'employees.xlsx');
    }

        public function exportPdf()
    {
        $employees = Employee::all();

        $pdf = PDF::loadView('employee.export_pdf', compact('employees'));

        return $pdf->download('employees.pdf');
    }


}
