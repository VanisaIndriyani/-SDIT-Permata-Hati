@extends('layouts.app')

@section('title', 'Profile - ' . Auth::user()->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4" style="padding-top: 10px;">
    <h2 class="fw-bold text-primary-custom">
        <i class="bi bi-person-circle"></i> Profile
    </h2>
</div>

<div class="row">
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0"><i class="bi bi-person-gear"></i> Informasi Profile</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                               id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($user->role == 'guru' || $user->role == 'kepsek')
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                               id="nip" name="nip" value="{{ old('nip', $user->nip) }}">
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" disabled>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3"><i class="bi bi-key"></i> Ubah Password</h5>
                    <p class="text-muted small">Kosongkan jika tidak ingin mengubah password</p>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword" onclick="togglePasswordVisibility('current_password', 'toggleCurrentPassword')">
                                <i class="bi bi-eye" id="eyeIconCurrent"></i>
                            </button>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
                                <i class="bi bi-eye" id="eyeIconPassword"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Minimal 8 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation" onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordConfirmation')">
                                <i class="bi bi-eye" id="eyeIconConfirmation"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 mt-3 mt-md-0">
        <div class="card">
            <div class="card-header bg-primary-custom text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Akun</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: 80px; color: var(--primary-green);"></i>
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'guru' ? 'primary' : ($user->role == 'wali_kelas' ? 'success' : 'warning')) }} mb-3">
                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </span>
                <hr>
                <div class="text-start">
                    <p class="mb-2"><strong>Username:</strong> {{ $user->username }}</p>
                    @if($user->nip)
                        <p class="mb-2"><strong>NIP:</strong> {{ $user->nip }}</p>
                    @endif
                    <p class="mb-0"><strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group .btn {
        border-left: 0;
    }
    
    .input-group .form-control:focus + .btn {
        border-color: #86b7fe;
        box-shadow: none;
    }
</style>

<script>
    function togglePasswordVisibility(inputId, buttonId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection
