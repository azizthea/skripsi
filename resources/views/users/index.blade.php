@extends('layouts.app')

@section('content')
<div class="container-fluid py-3">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="color: var(--af-positive)">
                <i class="bi bi-people-fill me-2"></i>Manajemen Pengguna
            </h3>
            <p class="text-muted mb-0">Kelola akun Admin dan Guru yang dapat masuk ke sistem</p>
        </div>
        <div class="d-flex w-100" style="max-width: max-content;">
            <button class="neo-btn neo-btn-primary flex-grow-1 text-center" data-bs-toggle="modal" data-bs-target="#modalTambah" style="min-height: 45px; padding: 0.5rem 1rem;">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- Statistik Akun -->
    <div class="row g-3 mb-4">
        @php
            $totalAdmin = $users->whereIn('role', ['admin', 'pengurus'])->count();
            $totalBK    = $users->where('role', 'bk')->count();
            $totalGuru  = $users->where('role', 'guru')->count();
        @endphp
        <div class="col-6 col-md-3">
            <div class="neo-card p-3 p-md-4 text-center h-100">
                <i class="bi bi-people-fill mb-2 d-block" style="font-size: 1.8rem; color: var(--af-positive);"></i>
                <div class="text-muted small fw-bold">Total Pengguna</div>
                <div class="fw-bold" style="font-size: 1.8rem; color: var(--af-dark);">{{ $users->count() }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="neo-card p-3 p-md-4 text-center h-100">
                <i class="bi bi-shield-fill-check mb-2 d-block" style="font-size: 1.8rem; color: #2F855A;"></i>
                <div class="text-muted small fw-bold">Pengurus</div>
                <div class="fw-bold" style="font-size: 1.8rem; color: #2F855A;">{{ $totalAdmin }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="neo-card p-3 p-md-4 text-center h-100">
                <i class="bi bi-clipboard2-pulse-fill mb-2 d-block" style="font-size: 1.8rem; color: #D69E2E;"></i>
                <div class="text-muted small fw-bold">Guru BK</div>
                <div class="fw-bold" style="font-size: 1.8rem; color: #D69E2E;">{{ $totalBK }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="neo-card p-3 p-md-4 text-center h-100">
                <i class="bi bi-person-fill-check mb-2 d-block" style="font-size: 1.8rem; color: #3182CE;"></i>
                <div class="text-muted small fw-bold">Guru Formal</div>
                <div class="fw-bold" style="font-size: 1.8rem; color: #3182CE;">{{ $totalGuru }}</div>
            </div>
        </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="neo-card" style="padding: 0; overflow: hidden;">

        <!-- Tab Filter Role -->
        <div style="padding: 1rem 1.5rem; border-bottom: 1px solid rgba(163,177,198,0.2); display: flex; gap: 1rem; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            <div class="d-flex flex-wrap gap-2 flex-grow-1">
                <a href="?role=" class="neo-btn px-3 py-1 flex-grow-1 text-center {{ !request('role') ? 'neo-btn-primary' : '' }}" style="font-size: 0.82rem;">
                    Semua ({{ $users->count() }})
                </a>
                <a href="?role=pengurus" class="neo-btn px-3 py-1 flex-grow-1 text-center {{ request('role') == 'pengurus' ? 'neo-btn-primary' : '' }}" style="font-size: 0.82rem;">
                    <i class="bi bi-shield-fill-check me-1"></i>Pengurus ({{ $users->whereIn('role', ['admin', 'pengurus'])->count() }})
                </a>
                <a href="?role=bk" class="neo-btn px-3 py-1 flex-grow-1 text-center {{ request('role') == 'bk' ? 'neo-btn-primary' : '' }}" style="font-size: 0.82rem; background: {{ request('role') == 'bk' ? '#D69E2E' : '' }}; color: {{ request('role') == 'bk' ? 'white' : '' }};">
                    <i class="bi bi-clipboard2-pulse-fill me-1"></i>Guru BK ({{ $users->where('role', 'bk')->count() }})
                </a>
                <a href="?role=guru" class="neo-btn px-3 py-1 flex-grow-1 text-center {{ request('role') == 'guru' ? 'neo-btn-primary' : '' }}" style="font-size: 0.82rem; background: {{ request('role') == 'guru' ? '#3182CE' : '' }}; color: {{ request('role') == 'guru' ? 'white' : '' }};">
                    <i class="bi bi-person-fill-check me-1"></i>Guru ({{ $users->where('role','guru')->count() }})
                </a>
            </div>
            <small class="text-muted">Klik baris untuk edit</small>
        </div>

        <div style="overflow-x: auto;">
            <table class="table table-borderless align-middle" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="padding: 1rem 1.25rem; width: 40px;">#</th>
                        <th style="padding: 1rem 1.25rem;">Nama Pengguna</th>
                        <th style="padding: 1rem 1.25rem;">Email</th>
                        <th class="text-center" style="padding: 1rem 1.25rem;">Role</th>
                        <th class="text-center" style="padding: 1rem 1.25rem;">Bergabung</th>
                        <th class="text-end" style="padding: 1rem 1.25rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $filtered = request('role') ? $users->where('role', request('role')) : $users;
                    @endphp
                    @forelse($filtered as $index => $user)
                    <tr>
                        <td style="padding: 0.9rem 1.25rem;" class="text-muted fw-bold">{{ $index + 1 }}</td>
                        <td style="padding: 0.9rem 1.25rem;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; color: white; flex-shrink: 0; background: {{ $user->role === 'admin' ? 'linear-gradient(135deg, #2F855A, #38A169)' : 'linear-gradient(135deg, #2B6CB0, #3182CE)' }};">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-size: 0.95rem;">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <small style="color: var(--af-positive); font-size: 0.72rem;"><i class="bi bi-check-circle-fill me-1"></i>Anda</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding: 0.9rem 1.25rem;">
                            <code style="font-size: 0.85rem; color: var(--af-dark);">{{ $user->email }}</code>
                        </td>
                        <td class="text-center" style="padding: 0.9rem 1.25rem;">
                            @if($user->role === 'admin' || $user->role === 'pengurus')
                                <span style="background: rgba(47,133,90,0.15); color: #2F855A; font-weight: 700; padding: 5px 14px; border-radius: 50px; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; border: 1px solid rgba(47,133,90,0.3);">
                                    <i class="bi bi-shield-fill-check me-1"></i>{{ ucfirst($user->role) }}
                                </span>
                            @elseif($user->role === 'bk')
                                <span style="background: rgba(214,158,46,0.15); color: #D69E2E; font-weight: 700; padding: 5px 14px; border-radius: 50px; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; border: 1px solid rgba(214,158,46,0.3);">
                                    <i class="bi bi-clipboard2-pulse-fill me-1"></i>Guru BK
                                </span>
                            @else
                                <span style="background: rgba(49,130,206,0.15); color: #3182CE; font-weight: 700; padding: 5px 14px; border-radius: 50px; font-size: 0.8rem; display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; border: 1px solid rgba(49,130,206,0.3);">
                                    <i class="bi bi-person-fill-check me-1"></i>Guru
                                </span>
                            @endif
                        </td>
                        <td class="text-center" style="padding: 0.9rem 1.25rem;">
                            <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                        </td>
                        <td class="text-end" style="padding: 0.9rem 1.25rem;">
                            <div class="d-flex gap-2 justify-content-end">
                                <!-- Edit -->
                                <button class="neo-btn px-2 py-1" style="font-size: 0.8rem;"
                                        onclick="openEdit({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')"
                                        title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <!-- Reset Password -->
                                <form action="{{ route('users.reset-password', $user) }}" method="POST"
                                      onsubmit="return confirm('Reset password {{ addslashes($user->name) }} ke \'password\'?')">
                                    @csrf
                                    <button type="submit" class="neo-btn px-2 py-1" style="font-size: 0.8rem; color: #D69E2E;" title="Reset Password">
                                        <i class="bi bi-key-fill"></i>
                                    </button>
                                </form>
                                <!-- Hapus -->
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Hapus akun \'{{ addslashes($user->name) }}\'? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="neo-btn px-2 py-1" style="font-size: 0.8rem; color: var(--af-negative);" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                            <div class="text-muted">Tidak ada pengguna ditemukan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ===== MODAL: Tambah Pengguna ===== --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 1.25rem; background: white; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-2" style="color: var(--af-positive)"></i>Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 h-100" style="box-shadow: var(--neo-shadow-inner); cursor: pointer;">
                                    <input type="radio" name="role" value="pengurus" class="form-check-input" style="margin: 0;">
                                    <span style="background: rgba(47,133,90,0.15); color: #2F855A; font-weight: 700; padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; display: inline-flex; align-items: center; white-space: nowrap;"><i class="bi bi-shield-fill-check me-1"></i>Pengurus</span>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 h-100" style="box-shadow: var(--neo-shadow-inner); cursor: pointer;">
                                    <input type="radio" name="role" value="bk" class="form-check-input" style="margin: 0;">
                                    <span style="background: rgba(214,158,46,0.15); color: #D69E2E; font-weight: 700; padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; display: inline-flex; align-items: center; white-space: nowrap;"><i class="bi bi-clipboard2-pulse-fill me-1"></i>Guru BK</span>
                                </label>
                            </div>
                            <div class="col-12">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-3 h-100" style="box-shadow: var(--neo-shadow-inner); cursor: pointer;">
                                    <input type="radio" name="role" value="guru" class="form-check-input" style="margin: 0;" checked>
                                    <span style="background: rgba(49,130,206,0.15); color: #3182CE; font-weight: 700; padding: 4px 10px; border-radius: 50px; font-size: 0.75rem; display: inline-flex; align-items: center; white-space: nowrap;"><i class="bi bi-person-fill-check me-1"></i>Guru Formal</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control neo-input" placeholder="cth: Ustadz Ahmad Fauzi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control neo-input" placeholder="email@pesantren.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control neo-input" placeholder="Min. 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control neo-input" placeholder="Ulangi password" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="neo-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="neo-btn neo-btn-primary">
                        <i class="bi bi-person-plus-fill me-1"></i>Buat Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== MODAL: Edit Pengguna ===== --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 1.25rem; background: white; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2" style="color: var(--af-positive)"></i>Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="editForm">
                @csrf @method('PUT')
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select neo-input" id="editRole">
                            <option value="pengurus">Pengurus Kesantrian</option>
                            <option value="bk">Guru BK</option>
                            <option value="guru">Guru (Sekolah Formal)</option>
                            <option value="admin">Admin Sistem</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" id="editName" class="form-control neo-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control neo-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password Baru <small class="text-muted fw-normal">(kosongkan jika tidak diubah)</small></label>
                        <input type="password" name="password" class="form-control neo-input" placeholder="Password baru (opsional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control neo-input" placeholder="Ulangi password baru">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="neo-btn" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="neo-btn neo-btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEdit(id, name, email, role) {
    document.getElementById('editName').value  = name;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value  = role;
    document.getElementById('editForm').action = '/users/' + id;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>
@endsection
