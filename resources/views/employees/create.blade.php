@extends('master')

@section('title')
    Thêm mới nhân viên
@endsection

@section('content')
    <h1>Thêm mới nhân viên</h1>

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3 row">
                <label for="first_name" class="col-4 col-form-label">First Name</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="last_name" class="col-4 col-form-label">Last Name</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('first_name') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-4 col-form-label">Phone</label>
                <div class="col-8">
                    <input type="tel" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="date_of_birth" class="col-4 col-form-label">Date Of Birth</label>
                <div class="col-8">
                    <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="hire_date" class="col-4 col-form-label">Hire Date</label>
                <div class="col-8">
                    <input type="datetime" class="form-control" name="hire_date" id="hire_date" value="{{ old('hire_date') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="salary" class="col-4 col-form-label">Salary</label>
                <div class="col-8">
                    <input type="number" class="form-control" name="salary" id="salary" value="{{ old('salary') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">Is Active?</label>
                <div class="col-8">
                    <input type="checkbox" name="is_active" id="is_active" value="1" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="department_id" class="col-4 col-form-label">Department</label>
                <div class="col-8">
                    <select class="form-select" name="department_id" id="department_id">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="manager_id" class="col-4 col-form-label">Manager</label>
                <div class="col-8">
                    <select class="form-select" name="manager_id" id="manager_id">
                        <option value="">Select Manager</option>
                        @foreach ($managers as $manager)
                            <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                                {{ $manager->first_name }} {{ $manager->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-4 col-form-label">Address</label>
                <div class="col-8">
                    <input type="text" class="form-control" name="address" id="address" value="{{ old('address') }}" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="profile_picture" class="col-4 col-form-label">Profile Picture</label>
                <div class="col-8">
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" />
                </div>
            </div>

            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <a class="btn btn-secondary" href="{{ route('employees.index') }}">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
