@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endpush
    
@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header text-center"><h2>Search Asteroids<h2></div>

                <div class="card-body">
                    <form class="row" method="POST" action="{{ route('asteroid') }}">
                        @csrf
                        <label for="start_date" class="col-sm-3 col-form-label">&nbsp;Start Date</label>
                        <div class="col-sm-9">
                            <div class="input-group date datepicker">
                                <input type="text" class="form-control" id="start_date" name="start_date"/>
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block cal-icon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <label for="end_date" class="col-sm-3 col-form-label">&nbsp;End Date</label>
                        <div class="col-sm-9">
                            <div class="input-group date datepicker">
                                <input type="text" class="form-control" id="end_date" name="end_date"/>
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block cal-icon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-12 text-center mt-3">
                            <input type="submit" class="btn btn-success"/>
                        </div>
                    </form>
                </div>

                @if($errors->any())
                    <div class="card-footer text-center">
                        <div class="col-sm-12 alert alert-danger">
                            {{ $errors->all()[0] }}
                        </div>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                todayHighlight:'TRUE',
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
        });
    </script>
@endpush