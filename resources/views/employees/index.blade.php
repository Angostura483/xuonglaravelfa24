@extends('master')

@section('title')
    Danh sách nhân viên
@endsection

@section('content')
    <h1>Danh sách nhân viên</h1>

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-info">
            Thao tác thành công
        </div>
    @endif

    <div class="text-end mb-2">
        <a class="btn btn-success" href="{{ route('employees.create') }}">CREATE</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class=>
                <tr class="">
                    <th scope="col">ID</th>
                    <th scope="col">FIRST NAME</th>
                    <th scope="col">LAST NAME</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">DATE OF BIRTH</th>
                    <th scope="col">HIRE DATE</th>
                    <th scope="col">SALARY</th>
                    <th scope="col">IS ACTIVE</th>
                    <th scope="col">DEPARTMENT</th>
                    <th scope="col">MANAGER</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">PROFILE PICTURE</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $employee)
                    <tr class="">
                        <td scope="row">{{ $employee->id }}</td>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->date_of_birth }}</td>
                        <td>{{ $employee->hire_date }}</td>
                        <td>{{ $employee->salary }}</td>
                        <td>
                            @if ($employee->is_active)
                                <span class="badge bg-success">YES</span>
                            @else
                                <span class="badge bg-danger">NO</span>
                            @endif
                        </td>
                        <td>
                            {{ $employee->department_id ? $employee->department->name : 'N/A' }}
                        </td>
                        <td>
                            {{ $employee->manager_id ? $employee->manager->first_name . ' ' . $employee->manager->last_name : 'N/A' }}
                        </td>
                        <td>{{ $employee->address }}</td>
                        <td>
                            @if ($employee->profile_picture)
                                <img src="{{ Storage::url($employee->profile_picture) }}" alt="" width="100px">
                            @endif
                        </td>
                        <td>{{ $employee->created_at }}</td>
                        <td>{{ $employee->updated_at }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('employees.show', $employee) }}">SHOW</a>
                            <a class="btn btn-warning" href="{{ route('employees.edit', $employee) }}">EDIT</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">XM</button>
                            </form>

                            <form action="{{ route('employees.forceDestroy', $employee) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-dark"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">XC</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
