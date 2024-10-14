@extends('master')

@section('title')
    Xem chi tiết khách hàng {{ $customer->name }}
@endsection

@section('content')
    <h1>Xem chi tiết khách hàng {{ $customer->name }}</h1>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Tên trường</th>
                    <th scope="col">Giá trị</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer->toArray() as $key => $value)
                    <tr class="">
                        <td scope="row">{{ strtoupper($key) }}</td>
                        <td>
                            @php
                                switch ($key) {
                                    case 'avatar':
                                        if ($value) {
                                            $url = Storage::url($value);

                                            echo "<img src='$url' width='100px'>";
                                        }
                                        break;
                                    case 'is_active':
                                        echo $value
                                            ? '<span class="badge bg-success">YES</span>'
                                            : '<span class="badge bg-danger">NO</span>';
                                        break;
                                    default:
                                        echo $value;
                                        break;
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-3 row">
            <div class="text-center">
                <a class="btn btn-secondary" href="{{ route('customers.index') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
