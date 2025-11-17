@extends('layouts.app')

@section('title', 'خانه')

@push('styles')
    @vite('resources/css/page/home.css')
@endpush

@section('content')
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-xl p-6 text-center">
                <h2 class="text-xl font-semibold mb-4">صفحه اصلی</h2>
                <p>خوش آمدید</p>
            </div>
        </div>
    </div>
@endsection
