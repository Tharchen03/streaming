@extends('layout.main')
@section('title')
    {{$title}}
@endsection
@section('content')
    <div class="auth-page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        @livewire($component, key(rand()))
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
