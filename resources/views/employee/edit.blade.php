<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    @vite('resources/sass/app.scss')
</head>
<body>
    @extends('layouts.app')

@section('content')
    <div class="container-sm mt-5">
        {{-- <form action="{{ route('employees.update', ['employee'=>$employee->employee_id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                <div class="p-5 bg-light rounded-3 border col-xl-6"> --}}

                    {{-- @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show">
                               {{ $error }}
                               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endforeach
                    @endif --}}

                    {{-- <div class="mb-3 text-center">
                        <i class="bi-person-circle fs-1"></i>
                        <h4>Edit Employee</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" id="firstname" value="{{$employee->firstname}}" placeholder="Enter First Name">
                            @error('firstname')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" id="lastname" value="{{$employee->lastname}}" placeholder="Enter Last Name">
                            @error('lastname')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{$employee->email}}" placeholder="Enter Email">
                            @error('email')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input class="form-control @error('age') is-invalid @enderror" type="text" name="age" id="age" value="{{$employee->age}}" placeholder="Enter Age">
                            @error('age')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" id="position" class="form-select">
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>{{ $position->code.' - '.$position->name }}</option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 d-grid">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i class="bi-arrow-left-circle me-2"></i> Cancel</a>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i> Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> --}}
        <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST">
            @csrf
            @method('put')
            <div class="row justify-content-center">
                <div class="p-5 bg-light rounded-3 col-xl-6">
                    <div class="mb-3 text-center">
                        <i class="bi-person-circle fs-1"></i>
                        <h4>Edit Employee</h4>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input class="form-control @error('firstName') is-invalid @enderror" type="text" name="firstName" id="firstName" value="{{ $errors->any() ? old('firstName') : $employee->firstname }}" placeholder="Enter First Name">
                            @error('firstName')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control @error('lastName') is-invalid @enderror" type="text" name="lastName" id="lastName" value="{{ $errors->any() ? old('lastName') : $employee->lastname }}" placeholder="Enter Last Name">
                            @error('lastName')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ $errors->any() ? old('email') : $employee->email }}" placeholder="Enter Email">
                            @error('email')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input class="form-control @error('age') is-invalid @enderror" type="text" name="age" id="age" value="{{ $errors->any() ? old('age') : $employee->age }}" placeholder="Enter Age">
                            @error('age')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <select name="position" id="position" class="form-select">
                                @php
                                    $selected = "";
                                    if ($errors->any())
                                        $selected = old('position');
                                    else
                                        $selected = $employee->position_id;
                                @endphp
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" {{ $selected == $position->id ? 'selected' : '' }}>{{ $position->code.' - '.$position->name }}</option>
                                @endforeach
                            </select>
                            @error('position')
                                <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                    </div>
                    <div class="cool-md-12 mb-3">
                        <label for="cv" class="form-label">Curriculum Vitae (CV)</label>
                        @if ($employee->original_filename)
                            <h5>{{ $employee->original_filename}}</h5>
                            <a href ="{{route('employees.downloadFile', ['employeeId => $employee->id']) }}"
                                class="btn btn-primary btn-sm mt-2">
                                <i class="bi bi-download me-1"></i>Download CV
                            </a>
                        @else
                            <h5>Tidak ada</h5>
                        @endif
                    </div>

                    <div class="cool-md-12 mb-3">
                        <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv" id="cv"
                        @error('cv')>
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @if ($employee->cv)
                            <small class="text-muted">CV alredy uploaded:
                                <a href="{{ asset('storage/' . $employee->cv )}}" target="_blank"
                                    rel="noopener noreferrer">{{ $employee->cv }}</a></small>
                        @endif
                    </div>
                    <div>
                        <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                        </form>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 d-grid">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-dark btn-lg mt-3"><i class="bi-arrow-left-circle me-2"></i> Cancel</a>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn btn-dark btn-lg mt-3"><i class="bi-check-circle me-2"></i> Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
    @vite('resources/js/app.js')
</body>
</html>
