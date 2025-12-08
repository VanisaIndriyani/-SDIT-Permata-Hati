@extends('layouts.app')

@section('title', 'Kelola User - Admin')

@section('content')
<style>
    .btn-group {
        display: flex;
        gap: 8px;
    }
    .btn-group .btn {
        border-radius: 25px !important;
        margin-right: 0;
        padding: 8px 24px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }
    .btn-primary-custom {
        background-color: var(--primary-green) !important;
        border-color: var(--primary-green) !important;
        color: white !important;
    }
    .btn-light.text-primary-custom {
        background-color: #e8f5e9 !important;
        border-color: #e8f5e9 !important;
        color: var(--primary-green) !important;
    }
    .d-flex.gap-1 {
        gap: 4px !important;
    }
    .d-flex.gap-1 .btn {
        padding: 4px 8px;
    }
    .d-flex.gap-1 form {
        margin: 0 !important;
        display: inline-block;
    }
</style>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-2" style="padding-top: 10px;">
    <h2 class="fw-bold text-primary-custom mb-0">
        <i class="bi bi-people"></i> Kelola User
    </h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Tambah User Baru</span><span class="d-sm-none">Tambah</span>
    </a>
</div>

<!-- Filter Role -->
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-2">
            <span class="text-primary-custom fw-bold">Filter Role:</span>
            <div class="btn-group flex-wrap" role="group">
                <a href="{{ route('admin.users.index', ['role' => '']) }}" 
                   class="btn rounded-pill {{ request('role') == '' ? 'btn-primary-custom text-white' : 'btn-light text-primary-custom' }}">
                    Semua
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                   class="btn rounded-pill {{ request('role') == 'admin' ? 'btn-primary-custom text-white' : 'btn-light text-primary-custom' }}">
                    Admin
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'guru']) }}" 
                   class="btn rounded-pill {{ request('role') == 'guru' ? 'btn-primary-custom text-white' : 'btn-light text-primary-custom' }}">
                    Guru
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'wali_kelas']) }}" 
                   class="btn rounded-pill {{ request('role') == 'wali_kelas' ? 'btn-primary-custom text-white' : 'btn-light text-primary-custom' }}">
                    Wali Kelas
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'kepsek']) }}" 
                   class="btn rounded-pill {{ request('role') == 'kepsek' ? 'btn-primary-custom text-white' : 'btn-light text-primary-custom' }}">
                    Kepala Sekolah
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>NIP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'guru' ? 'primary' : ($user->role == 'wali_kelas' ? 'success' : 'warning')) }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td>{{ $user->nip ?? '-' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="d-inline m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Reset password user ini?')">
                                        <i class="bi bi-key"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

