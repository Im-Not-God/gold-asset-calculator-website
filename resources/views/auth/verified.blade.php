@extends('layouts.layout')

@section('content')

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-center">
                <div class="card-body">
                    <span class="material-symbols-outlined" style="color: green; font-size: 40px;">
                        mark_email_read
                    </span>
                    <p class="card-title">{{ __('Your email has been verified') }}</p>
                    <p class="card-text">{{ __('You may now proceed to use our services.') }}</p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection