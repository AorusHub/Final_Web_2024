@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                                <img src="{{ asset('images/logo.png') }}" alt="">
                                <span class="d-none d-lg-block">D.Library</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                    <p class="text-center small">Enter your personal details to create account</p>
                                </div>

                                <form method="POST" action="{{ route('register') }}" class="row g-3 needs-validation" novalidate>
                                    @csrf

                                    <!-- Name -->
                                    <div class="col-12">
                                        <label for="yourName" class="form-label">Your Name</label>
                                        <input 
                                            type="text" 
                                            name="name" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            id="yourName" 
                                            value="" 
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="col-12">
                                        <label for="yourAddress" class="form-label">Address</label>
                                        <input 
                                            type="text" 
                                            name="address" 
                                            class="form-control @error('address') is-invalid @enderror" 
                                            id="yourAddress" 
                                            value="">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-12">
                                        <label for="yourPhone" class="form-label">Phone Number</label>
                                        <input 
                                            type="text" 
                                            name="phone_number" 
                                            class="form-control @error('phone_number') is-invalid @enderror" 
                                            id="yourPhone" 
                                            value="">
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-12">
                                        <label for="yourGender" class="form-label">Gender</label>
                                        <select 
                                            name="gender" 
                                            class="form-select @error('gender') is-invalid @enderror" 
                                            id="yourGender">
                                            <option value="" selected>Choose...</option>
                                            <option value="Laki-Laki" {{ old('gender') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Birth Date -->
                                    <div class="col-12">
                                        <label for="yourBirthDate" class="form-label">Birth Date</label>
                                        <input 
                                            type="date" 
                                            name="birth_date" 
                                            class="form-control @error('birth_date') is-invalid @enderror" 
                                            id="yourBirthDate" 
                                            value="{{ old('birth_date') }}">
                                        @error('birth_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12">
                                        <label for="yourEmail" class="form-label">Email</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input 
                                                type="email" 
                                                name="email" 
                                                class="form-control @error('email') is-invalid @enderror" 
                                                id="yourEmail" 
                                                value="{{ old('email') }}" 
                                                required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input 
                                            type="password" 
                                            name="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            id="yourPassword" 
                                            required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-12">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <input 
                                            type="password" 
                                            name="password_confirmation" 
                                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                                            id="confirmPassword" 
                                            required>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input 
                                                class="form-check-input @error('terms') is-invalid @enderror" 
                                                name="terms" 
                                                type="checkbox" 
                                                value="1" 
                                                id="acceptTerms" 
                                                {{ old('terms') ? 'checked' : '' }} 
                                                required>
                                            <label class="form-check-label" for="acceptTerms">
                                                I agree and accept the <a href="#">terms and conditions</a>
                                            </label>
                                            @error('terms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                    </div>

                                    <!-- Login Link -->
                                    <div class="col-12">
                                        <p class="small mb-0">
                                            Already have an account? <a href="{{ route('login') }}">Log in</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main><!-- End #main -->
@endsection
