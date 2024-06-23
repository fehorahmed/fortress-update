@extends('layouts.master')


@section('title')
    Bank Account
@endsection

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <a class="btn btn-primary" href="{{ route('bank_account.add') }}">Add Bank Account</a>
                    <hr>
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Account No.</th>
                                <th>Bank</th>
                                <th>Branch</th>
                                <th>Opening Balance</th>
                                <th> Balance</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->account_name }}</td>
                                    <td>{{ $account->account_no }}</td>
{{--                                    <td>{{ $account->project->name??'' }}</td>--}}
                                    <td>{{ $account->bank->name }}</td>
                                    <td>{{ $account->branch->name }}</td>
                                    <td>৳{{ number_format($account->opening_balance, 2) }}</td>
                                    <td>৳{{ number_format($account->balance, 2) }}</td>
                                    <td>
                                        @if ($account->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('bank_account.edit', ['account' => $account->id]) }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script>
        $(function () {
            $('#table').DataTable();
        })
    </script>
@endsection
