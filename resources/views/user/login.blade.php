@extends('layouts.app')

@section('title', 'ورود')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-center">ورود به حساب کاربری</h4>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">ایمیل</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">رمز عبور</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    value="1">
                                <label class="form-check-label" for="remember">
                                    من را به خاطر بسپار
                                </label>
                            </div>
                            <a href="" class="text-decoration-none">فراموشی رمز؟</a>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            ورود
                        </button>

                        <div class="text-center mt-3">
                            <small>حسابی ندارید؟ <a href="{{ route('register.show') }}">ثبت‌نام کنید</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
