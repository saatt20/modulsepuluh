<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <style>
        html {
            font-size: 12px;
        }

        .table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 0.5rem;
            border: 1px solid black !important;
        }
    </style>
    @vite('resources/sass/app.scss')
</head>
<body>
    @extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row mb-0">
            <div class="col-lg-9 col-xl-10">
                <h4 class="mb-3">{{ $pageTitle }}</h4>
                <div class="col-lg-3 col-xl-6">
                    <ul class="list-inline mb-0 float-end">
                        <li class="list-inline-item">
                            <a href="{{ route('employees.exportExcel') }}" class="btn btn-outline-success">
                                <i class="bi bi-download me-1"></i> to Excel
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('employees.exportPdf') }}" class="btn btn-outline-danger">
                                <i class="bi bi-download me-1"></i> to PDF
                            </a>
                        </li>
                        <li class="list-inline-item">|</li>
                            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Create Employee
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <div class="table-responsive border p-3 rounded-3">
            <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable" id="employeeTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No.</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Position</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
                {{-- <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->firstname }}</td>
                            <td>{{ $employee->lastname }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->age }}</td>
                            <td>{{ $employee->position_name }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('employees.show', ['employee' => $employee->employee_id]) }}" class="btn btn-outline-dark btn-sm me-2"><i class="bi-person-lines-fill"></i></a>
                                    <a href="{{ route('employees.edit', ['employee' => $employee->employee_id]) }}" class="btn btn-outline-dark btn-sm me-2"><i class="bi-pencil-square"></i></a>

                                    <div>
                                        <form action="{{ route('employees.destroy', ['employee' => $employee->employee_id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-outline-dark btn-sm me-2"><i class="bi-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody> --}}
                {{-- <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->firstname }}</td>
                            <td>{{ $employee->lastname }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->age }}</td>
                            <td>{{ $employee->position->name }}</td>
                            <td>@include('employee.actions')</td> --}}
                        {{-- </tr>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $("#employeeTable").DataTable({
                serverSide: true,
                processing: true,
                ajax: "/getEmployees",
                columns: [
                    { data: "id", name: "id", visible: false },
                    { data: "DT_RowIndex", name: "DT_RowIndex", orderable: false, searchable: false },
                    { data: "firstname", name: "firstname" },
                    { data: "lastname", name: "lastname" },
                    { data: "email", name: "email" },
                    { data: "age", name: "age" },
                    { data: "position.name", name: "position.name" },
                    { data: "actions", name: "actions", orderable: false, searchable: false },
                ],
                order: [[0, "desc"]],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
            });
            $(".datatable").on("click", ".btn-delete", function (e) {
                e.preventDefault();

                var form = $(this).closest("form");
                var name = $(this).data("name");

                Swal.fire({
                    title: "Are you sure want to delete\n" + name + "?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
    @vite('resources/js/app.js')
</body>
</html>
