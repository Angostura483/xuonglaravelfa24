@extends('master')

@section('title')
    Danh sách khách hàng
@endsection

@section('content')
    <h1>Danh sách khách hàng</h1>

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
        <a class="btn btn-success" href="{{ route('customers.create') }}">CREATE</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class=>
                <tr class="">
                    <th scope="col">ID</th>
                    <th scope="col">NAME</th>
                    <th scope="col">AVATAR</th>
                    <th scope="col">ADDRESS</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">IS ACTIVE</th>
                    <th scope="col">CREATED AT</th>
                    <th scope="col">UPDATED AT</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $customer)
                    <tr class="">
                        <td scope="row">{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>
                            @if ($customer->avatar)
                                <img src="{{ Storage::url($customer->avatar) }}" alt="" width="100px">
                            @endif
                        </td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            @if ($customer->is_active)
                                <span class="badge bg-success">YES</span>
                            @else
                                <span class="badge bg-danger">NO</span>
                            @endif
                        </td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('customers.show', $customer) }}">SHOW</a>
                            <a class="btn btn-warning" href="{{ route('customers.edit', $customer) }}">EDIT</a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">XM</button>
                            </form>

                            <form action="{{ route('customers.forceDestroy', $customer) }}" method="POST">
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
