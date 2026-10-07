@extends('layouts.app')

@section('title', 'Kelola Pegawai & Hak Akses (RBAC)')

@section('content')
<!-- HEADER -->
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="fs-4 fw-bold text-dark m-0" style="font-family: var(--font-heading);">Manajemen Pegawai & Hak Akses (RBAC)</h2>
        <p class="text-muted small m-0">Pengelolaan data akun pegawai, otorisasi peran, verifikasi OTP, dan integrasi SSO</p>
    </div>
    <span class="badge bg-primary bg-opacity-10 text-primary border px-3 py-2">
        <i class="bi bi-shield-lock-fill me-1"></i> Mode Administrator Sistem
    </span>
</div>

@if(session('success'))
    <div class="alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3">
        <i class="bi bi-exclamation-circle-fill fs-5"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

<!-- RBAC CAPABILITIES MATRIX (Card Ringkasan Hak Akses) -->
<div class="kemenhub-card mb-4">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-grid-3x3-gap-fill text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Matriks Wewenang & Hak Akses Sistem (RBAC)</h5>
        </div>
        <span class="badge bg-info bg-opacity-10 text-info border">Standar Birokrasi BKT 2026</span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center mb-0" style="font-size: 0.82rem;">
            <thead class="table-light">
                <tr>
                    <th class="text-start" style="width: 25%;">Peran Pengguna (Role)</th>
                    <th>Konsep Naskah</th>
                    <th>Paraf Koordinasi</th>
                    <th>TTE Digital BSrE</th>
                    <th>Disposisi Pimpinan</th>
                    <th>Kelola Pengguna & Logs</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-start">
                        <span class="badge bg-danger">Administrator</span>
                        <div class="small text-muted mt-1">Pengelola Sistem Persuratan</div>
                    </td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <span class="badge bg-warning text-dark">Kepala Pusat (Kapus)</span>
                        <div class="small text-muted mt-1">Pimpinan Tertinggi Unit Kerja</div>
                    </td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i> (Otoritas Final)</td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <span class="badge bg-primary">Kepala Bidang (Kabid)</span>
                        <div class="small text-muted mt-1">Pimpinan Koordinasi Substansi</div>
                    </td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i> (Paraf Tahap 1)</td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i> (Lanjutan)</td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                </tr>
                <tr>
                    <td class="text-start">
                        <span class="badge bg-info text-dark">Staf / Pegawai PKST</span>
                        <div class="small text-muted mt-1">Analis Kebijakan & Pengonsep</div>
                    </td>
                    <td><i class="bi bi-check-circle-fill text-success fs-6"></i></td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                    <td><i class="bi bi-dash text-muted"></i> (Penerima)</td>
                    <td><i class="bi bi-dash text-muted"></i></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- USERS TABLE CARD -->
<div class="kemenhub-card">
    <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people-fill text-primary fs-5"></i>
            <h5 class="fs-6 fw-bold text-dark m-0">Daftar Pegawai, Peran, & Status Keanggotaan</h5>
        </div>
        <span class="badge bg-light text-muted border">Total: {{ $users->count() }} Pengguna</span>
    </div>

    <div class="table-responsive">
        <table class="table-kemenhub">
            <thead>
                <tr>
                    <th>Nama Pegawai & NIP</th>
                    <th>Jabatan & Unit Kerja</th>
                    <th>Email & Autentikasi</th>
                    <th>Hak Akses (Role)</th>
                    <th>Status Akun</th>
                    <th class="text-center">Beban Kerja</th>
                    <th class="text-center" style="width: 140px;">Aksi RBAC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>
                        <div class="fw-bold text-dark">{{ $u->name }}</div>
                        <div class="small text-muted font-monospace">NIP. {{ $u->nip ?? '-' }}</div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $u->jabatan }}</div>
                        <div class="small text-muted">{{ $u->unit_kerja }}</div>
                    </td>
                    <td>
                        <div class="small fw-semibold text-primary">
                            <i class="bi bi-envelope me-1"></i>{{ $u->email }}
                        </div>
                        <div class="mt-1">
                            @if($u->sso_provider)
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size: 0.68rem;">
                                    <i class="bi bi-shield-check me-1"></i> SSO {{ ucfirst($u->sso_provider) }}
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25" style="font-size: 0.68rem;">
                                    <i class="bi bi-key me-1"></i> Email & Sandi
                                </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $u->role === 'kepala_pusat' ? 'bg-warning text-dark' : ($u->role === 'kepala_bidang' ? 'bg-primary' : ($u->role === 'admin' ? 'bg-danger' : 'bg-info text-dark')) }}">
                            {{ $u->role_label }}
                        </span>
                    </td>
                    <td>
                        @if($u->status === 'active')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                <i class="bi bi-check-circle-fill me-1"></i> Aktif
                            </span>
                        @elseif($u->status === 'suspended')
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                <i class="bi bi-slash-circle-fill me-1"></i> Dinonaktifkan
                            </span>
                        @else
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25">
                                <i class="bi bi-clock-history me-1"></i> Pending OTP
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-light text-dark border" title="Disposisi Diterima">
                                <i class="bi bi-inbox me-1"></i>{{ $u->disposisi_diterima_count }}
                            </span>
                            <span class="badge bg-light text-primary border" title="Konsep Surat Keluar">
                                <i class="bi bi-file-earmark-text me-1"></i>{{ $u->surat_keluar_dikonsep_count }}
                            </span>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <!-- Tombol Ubah Role -->
                            <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2" title="Ubah Hak Akses (RBAC)" onclick="openRoleModal({{ $u->id }}, '{{ $u->name }}', '{{ $u->role }}')">
                                <i class="bi bi-person-gear"></i> Peran
                            </button>

                            <!-- Tombol Toggle Status Akun -->
                            @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.status', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status aktif akun {{ $u->name }}?');">
                                    @csrf
                                    @if($u->status === 'active')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Nonaktifkan Akun">
                                            <i class="bi bi-pause-circle"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2" title="Aktifkan Akun">
                                            <i class="bi bi-play-circle"></i>
                                        </button>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL EDIT ROLE RBAC -->
<div class="modal fade" id="modalEditRole" tabindex="-1" aria-labelledby="modalEditRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content kemenhub-card border-0">
            <div class="modal-header border-bottom p-3">
                <h5 class="modal-title fs-6 fw-bold text-dark m-0" id="modalEditRoleLabel">
                    <i class="bi bi-shield-lock-fill text-primary me-2"></i> Perbarui Hak Akses Pegawai (RBAC)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditRole" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1">Nama Pegawai</label>
                        <input type="text" id="modalUserName" class="form-control bg-light" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary mb-1" for="modalRoleSelect">
                            Pilih Hak Akses / Peran Baru <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="modalRoleSelect" class="form-select" required>
                            <option value="pegawai">Staf / Pegawai PKST (Konseptor Naskah)</option>
                            <option value="kepala_bidang">Kepala Bidang (Kabid - Paraf Koordinasi & Disposisi)</option>
                            <option value="kepala_pusat">Kepala Pusat (Kapus - Otoritas TTE Digital BSrE)</option>
                            <option value="admin">Administrator Sistem Persuratan</option>
                        </select>
                    </div>

                    <div class="alert alert-info py-2 px-3 small mb-0" style="font-size: 0.76rem;">
                        <i class="bi bi-info-circle-fill me-1"></i> Perubahan peran akan segera berlaku pada sesi login pengguna dan tercatat dalam Audit Log Keamanan.
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan Peran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRoleModal(userId, userName, currentRole) {
        document.getElementById('modalUserName').value = userName;
        document.getElementById('modalRoleSelect').value = currentRole;
        document.getElementById('formEditRole').action = `/admin/users/${userId}/role`;
        const modal = new bootstrap.Modal(document.getElementById('modalEditRole'));
        modal.show();
    }
</script>
@endsection
