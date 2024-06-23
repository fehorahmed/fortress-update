@extends('layouts.master')

@section('title')
    Edit Loan
@endsection
@section('style')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"> Loan Information </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
{{--                <form class="form-horizontal" method="POST" action="{{ route('loan.edit',['loan'=> $loan->id])}}">--}}
                <form class="form-horizontal" method="POST" action="{{ route('loan.edit',['loan'=> $loan->id])}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row {{ $errors->has('loan_from') ? 'has-error' :'' }}" >
                            <label class="col-sm-2 control-label">Loan From <span class="text-danger">*</span></label>

                            <div class="col-sm-10">
                                <select name="loan_from" class="form-control select2" id="myselection">
{{--                                    <option value="">Select loan from</option>--}}
{{--                                    <option value="1" {{ old('loan_from') == '1' ? 'selected' : '' }}>Client</option>--}}
{{--                                    <option value="2" {{ old('loan_from') == '2' ? 'selected' : '' }}>Project</option>--}}
                                    <option value="3" {{ old('loan_from') == '3' ? 'selected' : '' }}>Loan Holder</option>

{{--                                    <option value="1" {{ 1 == $loanHolder->loan_from? 'selected' :''}}>Client</option>--}}
{{--                                    <option value="2" {{ 2 == $loanHolder->loan_from? 'selected' :''}}>Project</option>--}}
{{--                                    <option value="3" {{ 3 == $loanHolder->loan_from? 'selected' :''}}>Loan Holder</option>--}}

                                </select>

                                @error('loan_from')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="myDiv form-group row{{ $errors->has('client') ? 'has-error' :'' }}" id="showOne">
                            <label class="col-sm-2 control-label">Client *</label>

                            <div class="col-sm-10">
                                <select name="client" class="form-control select2">
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{$client->id}}" {{old("client")==$client->id?"selected":''}}>{{$client->name}}</option>
                                    @endforeach
                                </select>

                                @error('client')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="myDiv form-group row{{ $errors->has('project') ? 'has-error' :'' }}" id="showTwo">
                            <label class="col-sm-2 control-label">Project *</label>

                            <div class="col-sm-10">
                                <select name="project" class="form-control select2">
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}" {{old("project")==$project->id?"selected":''}}>{{$project->name}}</option>
                                    @endforeach
                                </select>

                                @error('project')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('loan_holder') ? 'has-error' :'' }}"  id="showThree">
                            <label class="col-sm-2 control-label"> Loan Holder <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <select name="loan_holder" class="form-control select2">
                                    <option value="">Select loan holder </option>
{{--                                    @foreach($loans as $loan)--}}
{{--                                        <option value="{{$loan->loan_holder_id}}" {{$loan->loan_holder_id ==$loan->loan_holder_id?'selected':''}}>{{$loanHolder->name}}</option>--}}
{{--                                    @endforeach--}}
                                    @foreach($holders as $holder)
                                        <option value="{{$holder->id}}" {{old('loan_holder')==$holder->id?'selected':''}}>{{$holder->name}}</option>
                                    @endforeach
                                </select>

                                @error('loan_holder')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('loan_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Loan Type <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <select class="form-control select2" name="loan_type" id="loan_type">
                                    <option value=""> Select loan type </option>

                                    @foreach($loans as $loan)
                                        <option value="1" {{ 1 ==$loan->loan_type ? 'selected' :''}}>Take</option>
                                        <option value="2" {{ 2 ==$loan->loan_type ? 'selected' :''}}>Give</option>
                                    @endforeach

                                </select>

                                @error('loan_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('payment_type') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Payment type <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <select class="form-control select2" name="payment_type" id="payment_type">
                                    <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}> Cash </option>
                                    <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}> Bank </option>
                                </select>

                                @error('payment_type')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div id="bank-info">
                            <div class="form-group row{{ $errors->has('bank') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Bank <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <select class="form-control " name="bank" id="bank">
                                        <option value=""> Select Bank </option>

                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('bank')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('branch') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label">Branch <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <select class="form-control select2" name="branch" id="branch">
                                        <option value=""> Select Bank Branch</option>
                                    </select>

                                    @error('branch')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('account') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Account <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <select class="form-control select2" name="account" id="account">
                                        <option value=""> Select Account </option>
                                    </select>

                                    @error('account')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('cheque_no') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Cheque Number </label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="cheque_no" placeholder="Cheque Number">

                                    @error('cheque_no')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('cheque_image') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Cheque image </label>

                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="cheque_image">

                                    @error('cheque_image')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row{{ $errors->has('cheque_date') ? 'has-error' :'' }}">
                                <label class="col-sm-2 control-label"> Cheque date <span style="color: red">*</span></label>

                                <div class="col-sm-10">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="cheque_date" name="cheque_date" value="{{ empty(old('date')) ? ($errors->has('cheque_date') ? '' : date('Y-m-d')) : old('cheque_date') }}" autocomplete="off">
                                    </div>
                                    <!-- /.input group -->

                                    @error('cheque_date')
                                    <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group row{{ $errors->has('amount') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Amount <span style="color: red">*</span></label>

{{--                            @foreach($loans as $loan)--}}
                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder=""
                                       name="amount" value="{{ $loan->total }}">

                                @error('amount')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
{{--                            @endforeach--}}
                        </div>

                        <div class="form-group row{{ $errors->has('interest') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Interest </label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder=""
                                       name="interest" value="{{ $loan->interest }}">

                                @error('interest')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('duration') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Duration </label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control" placeholder=""
                                       name="duration" value="{{ $loan->duration }}">

                                {{--                                <select name="duration" class="form-control select2" id="myselection">--}}
                                {{--                                <option value="">Select Duration</option>--}}
                                {{--                                <option value="1" {{ old('duration') == '1' ? 'selected' : '' }}>Daily</option>--}}
                                {{--                                <option value="2" {{ old('duration') == '2' ? 'selected' : '' }}>Weekly</option>--}}
                                {{--                                <option value="3" {{ old('duration') == '3' ? 'selected' : '' }}>Monthly</option>--}}
                                {{--                                <option value="4" {{ old('duration') == '4' ? 'selected' : '' }}>Quarterly</option>--}}
                                {{--                                <option value="5" {{ old('duration') == '5' ? 'selected' : '' }}>Yearly</option>--}}
                                {{--                                </select>--}}

                                @error('duration')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('date') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Date <span style="color: red">*</span></label>

                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <input type="text" id="date" class="form-control"
                                           name="date" value="{{$loan->date}}" autocomplete="off">
                                </div>

                                @error('date')
                                <span class="help-block">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group row{{ $errors->has('note') ? 'has-error' :'' }}">
                            <label class="col-sm-2 control-label"> Note </label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder=""
                                       name="note" value="{{$loan->note}}">

                                @error('note')
                                <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- bootstrap datepicker -->
    <script src="{{ asset('themes/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $(function () {
            //Date picker
            $('#date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });

    </script>
    <script>
        $(function () {
            var branchSelected = '{{ old('branch') }}';
            var accountSelected = '{{ old('account') }}';

            //Date picker
            $('#date,#cheque_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#myselection').change(function () {
                var demovalue = $(this).val();
                if (demovalue == 1){
                    $("#showOne").show();
                    $("#showTwo").hide();
                    $("#showThree").hide();
                }else if(demovalue == 2){
                    $("#showOne").hide();
                    $("#showTwo").show();
                    $("#showThree").hide();
                }else if(demovalue == 3) {
                    $("#showOne").hide();
                    $("#showTwo").hide();
                    $("#showThree").show();
                }else{
                    $("#showOne").hide();
                    $("#showTwo").hide();
                    $("#showThree").hide();
                }
            });

            $('#myselection').trigger('change');

            // $(document).ready(function(){
            //     $('#myselection').on('change', function(){
            //         var demovalue = $(this).val();
            //         if (demovalue == ''){
            //             $("#showOne").hide();
            //             $("#showTwo").hide();
            //             $("#showThree").hide();
            //         }
            //         if (demovalue == 1){
            //             $("#showOne").show();
            //             $("#showTwo").hide();
            //             $("#showThree").hide();
            //         }else if(demovalue == 2){
            //             $("#showOne").hide();
            //             $("#showTwo").show();
            //             $("#showThree").hide();
            //         }else {
            //             $("#showOne").hide();
            //             $("#showTwo").hide();
            //             $("#showThree").show();
            //         }
            //     });
            // });
            // $('#myselection').trigger('change');

            $('#payment_type').change(function () {
                if ($(this).val() == '1' || $(this).val() == '3') {
                    $('#bank-info').hide();
                } else {
                    $('#bank-info').show();
                }
            });

            $('#payment_type').trigger('change');

            $('#bank').change(function () {
                var bankId = $(this).val();
                $('#branch').html('<option value="">Select Branch </option>');
                $('#account').html('<option value=""> Select Account </option>');

                if (bankId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_branch') }}",
                        data: { bankId: bankId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (branchSelected == item.id)
                                $('#branch').append('<option value="'+item.id+'" selected>'+item.name+'</option>');
                            else
                                $('#branch').append('<option value="'+item.id+'">'+item.name+'</option>');
                        });

                        $('#branch').trigger('change');
                    });
                }

                $('#branch').trigger('change');
            });

            $('#bank').trigger('change');

            $('#branch').change(function () {
                var branchId = $(this).val();
                $('#account').html('<option value=""> Select Account </option>');

                if (branchId != '') {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('get_bank_account') }}",
                        data: { branchId: branchId }
                    }).done(function( response ) {
                        $.each(response, function( index, item ) {
                            if (accountSelected == item.id)
                                $('#account').append('<option value="'+item.id+'" selected>'+item.account_no+'</option>');
                            else
                                $('#account').append('<option value="'+item.id+'">'+item.account_no+'</option>');
                        });
                    });
                }
            });
        });
    </script>
@endsection
