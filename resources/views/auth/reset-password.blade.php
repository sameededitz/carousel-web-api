@extends('layout.admin-guest')
@section('admin-guest')
    <section class="auth bg-base d-flex flex-wrap justify-content-center align-items-center">
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                {{ $slot }}
            </div>
        </div>
    </section>
@endsection