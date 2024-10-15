@extends('master')

@section('title')
    Danh sách User
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class=>
                <tr class="">
                    <th scope="col">USER ID</th>
                    <th scope="col">PHONE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr class="">
                        <td scope="row">{{ $user->id }}</td>
                        <td>{{ $user->phone->value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
@endsection
