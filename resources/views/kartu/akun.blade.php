@extends('layouts.app')

@section('title', 'Manajemen Akun Petugas')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
<div class="alert-banner alert-success">
  <span class="ico">✅</span>
  <div class="txt"><strong>{{ session('success') }}</strong></div>
</div>
@endif

@if(session('error'))
<div class="alert-banner">
  <span class="ico">⚠️</span>
  <div class="txt"><strong>{{ session('error') }}</strong></div>
</div>
@endif

<div class="page-hdr">
  <div>
    <div class="page-title">Manajemen Akun Petugas</div>
    <div class="page-sub">Kelola akun login untuk semua petugas.</div>
  </div>
  <button class="btn btn-primary btn-sm" onclick="openTambah()">➕ Tambah Akun</button>
</div>

{{-- Grid Akun --}}
<div class="akun-grid">
  @foreach($users as $u)
    @php
      $color  = $u->role === 'admin' ? 'amber' : ($u->role === 'cs' ? 'purple' : 'teal');
      $badge  = $u->role === 'admin' ? 'b-amber' : ($u->role === 'cs' ? 'b-purple' : 'b-teal');
      $inits  = strtoupper(substr($u->nama, 0, 2));
      $isSelf = $u->id === Auth::id();
    @endphp
    <div class="akun-card" style="{{ !$u->is_active ? 'opacity:.55' : '' }}">
      <div class="akun-avatar" style="background:var(--{{ $color }}-light);color:var(--{{ $color }})">
        {{ $inits }}
      </div>
      <div style="flex:1;min-width:0">
        <div class="akun-name" style="{{ !$u->is_active ? 'text-decoration:line-through;color:var(--text3)' : '' }}">
          {{ $u->nama }}
        </div>
        <div class="akun-user">{{ $u->username }}</div>
        <span class="badge {{ $badge }}">{{ $u->role }}</span>
        @if(!$u->is_active)
          <span class="badge b-gray" style="margin-left:3px">nonaktif</span>
        @endif
      </div>
      <div class="akun-actions">
        {{-- Tombol Edit --}}
        <button class="btn btn-icon"
                onclick="openEdit('{{ $u->id }}','{{ addslashes($u->nama) }}','{{ $u->username }}','{{ $u->role }}')"
                title="Edit akun">✏️</button>

        {{-- Tombol Aktif/Nonaktif (tidak tampil untuk akun sendiri) --}}
        @if(!$isSelf)
        <form method="POST" action="/akun/{{ $u->id }}/toggle" style="display:inline;margin:0">
          @csrf
          @method('PATCH')
          <button type="submit" class="btn btn-icon"
                  style="color:{{ $u->is_active ? 'var(--red)' : 'var(--green)' }}"
                  title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan kembali' }}">
            {{ $u->is_active ? '🚫' : '✅' }}
          </button>
        </form>
        @endif
      </div>
    </div>
  @endforeach

  <div class="akun-card akun-add" onclick="openTambah()">
    <div style="font-size:22px;margin-bottom:4px">➕</div>
    <div style="font-size:12px;color:var(--text3)">Tambah Akun Baru</div>
  </div>
</div>

{{-- ===== MODAL TAMBAH AKUN ===== --}}
<div class="modal-backdrop" id="modalTambah" onclick="closeTambah()">
  <div class="modal-box" onclick="event.stopPropagation()" style="max-width:440px">
    <div class="modal-title">➕ Tambah Akun Baru</div>
    <form method="POST" action="/akun">
      @csrf
      <input type="hidden" name="_form_type" value="tambah">

      <div class="form-group">
        <label class="form-label">NAMA LENGKAP <span style="color:var(--red)">*</span></label>
        <input class="form-input {{ $errors->tambah->has('nama') ? 'error' : '' }}"
               name="nama" value="{{ old('nama') }}" placeholder="cth: Satpam Budi" required>
        @if($errors->tambah->has('nama'))
          <div class="err-msg show">{{ $errors->tambah->first('nama') }}</div>
        @endif
      </div>

      <div class="form-group">
        <label class="form-label">USERNAME <span style="color:var(--red)">*</span></label>
        <input class="form-input {{ $errors->tambah->has('username') ? 'error' : '' }}"
               name="username" value="{{ old('username') }}" placeholder="cth: satpam_02" required>
        @if($errors->tambah->has('username'))
          <div class="err-msg show">{{ $errors->tambah->first('username') }}</div>
        @endif
      </div>

      <div class="form-group">
        <label class="form-label">ROLE <span style="color:var(--red)">*</span></label>
        <select class="form-select {{ $errors->tambah->has('role') ? 'error' : '' }}" name="role" required>
          <option value="">-- Pilih role --</option>
          <option value="satpam" {{ old('role') == 'satpam' ? 'selected' : '' }}>Satpam</option>
          <option value="cs"     {{ old('role') == 'cs'     ? 'selected' : '' }}>Customer Service</option>
          <option value="admin"  {{ old('role') == 'admin'  ? 'selected' : '' }}>Admin</option>
        </select>
        @if($errors->tambah->has('role'))
          <div class="err-msg show">{{ $errors->tambah->first('role') }}</div>
        @endif
      </div>

      <div class="form-group">
        <label class="form-label">PASSWORD <span style="color:var(--red)">*</span></label>
        <input class="form-input {{ $errors->tambah->has('password') ? 'error' : '' }}"
               type="password" name="password" placeholder="Minimal 6 karakter" required>
        @if($errors->tambah->has('password'))
          <div class="err-msg show">{{ $errors->tambah->first('password') }}</div>
        @endif
      </div>

      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">KONFIRMASI PASSWORD <span style="color:var(--red)">*</span></label>
        <input class="form-input" type="password" name="password_confirmation"
               placeholder="Ulangi password" required>
      </div>

      <div class="modal-footer" style="margin-top:20px">
        <button type="button" class="btn btn-outline" onclick="closeTambah()">Batal</button>
        <button type="submit" class="btn btn-primary">💾 Simpan Akun</button>
      </div>
    </form>
  </div>
</div>

{{-- ===== MODAL EDIT AKUN ===== --}}
<div class="modal-backdrop" id="modalEdit" onclick="closeEdit()">
  <div class="modal-box" onclick="event.stopPropagation()" style="max-width:440px">
    <div class="modal-title">✏️ Edit Akun</div>

    @if($errors->edit->any())
    <div class="alert-banner" style="margin-bottom:14px;padding:10px 12px">
      <span class="ico" style="font-size:14px">⚠️</span>
      <div class="txt" style="font-size:12px">
        @foreach($errors->edit->all() as $err)
          {{ $err }}<br>
        @endforeach
      </div>
    </div>
    @endif

    <form method="POST" id="formEdit" action="">
      @csrf
      @method('PUT')
      <input type="hidden" name="_form_type" value="edit">
      <input type="hidden" name="_edit_id"   id="editIdField">

      <div class="form-group">
        <label class="form-label">NAMA LENGKAP <span style="color:var(--red)">*</span></label>
        <input class="form-input {{ $errors->edit->has('nama') ? 'error' : '' }}"
               type="text" name="nama" id="editNama" placeholder="Nama lengkap" required>
      </div>

      <div class="form-group">
        <label class="form-label">USERNAME <span style="color:var(--red)">*</span></label>
        <input class="form-input {{ $errors->edit->has('username') ? 'error' : '' }}"
               type="text" name="username" id="editUsername" placeholder="Username" required>
      </div>

      <div class="form-group">
        <label class="form-label">ROLE <span style="color:var(--red)">*</span></label>
        <select class="form-select" name="role" id="editRole" required>
          <option value="satpam">Satpam</option>
          <option value="cs">Customer Service</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <div class="form-group">
        <label class="form-label">
          PASSWORD BARU
          <span style="color:var(--text3);font-weight:400;font-size:11px">(kosongkan jika tidak diubah)</span>
        </label>
        <input class="form-input {{ $errors->edit->has('password') ? 'error' : '' }}"
               type="password" name="password" id="editPassword"
               placeholder="Minimal 6 karakter">
        @if($errors->edit->has('password'))
          <div class="err-msg show">{{ $errors->edit->first('password') }}</div>
        @endif
      </div>

      <div class="form-group" style="margin-bottom:0">
        <label class="form-label">KONFIRMASI PASSWORD BARU</label>
        <input class="form-input" type="password" name="password_confirmation"
               id="editPasswordConfirm" placeholder="Ulangi password baru">
      </div>

      <div class="modal-footer" style="margin-top:20px">
        <button type="button" class="btn btn-outline" onclick="closeEdit()">Batal</button>
        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
// ===== MODAL TAMBAH =====
function openTambah() {
  document.getElementById('modalTambah').classList.add('open');
}
function closeTambah() {
  document.getElementById('modalTambah').classList.remove('open');
}

// ===== MODAL EDIT =====
function openEdit(id, nama, username, role) {
  document.getElementById('editIdField').value   = id;
  document.getElementById('editNama').value      = nama;
  document.getElementById('editUsername').value  = username;
  document.getElementById('editRole').value      = role;
  document.getElementById('formEdit').action     = `/akun/${id}`;
  // Reset field password (tidak pernah di-prefill)
  document.getElementById('editPassword').value        = '';
  document.getElementById('editPasswordConfirm').value = '';
  document.getElementById('modalEdit').classList.add('open');
}
function closeEdit() {
  document.getElementById('modalEdit').classList.remove('open');
}

// ===== Auto-buka modal yang tepat jika ada error validasi =====
@if($errors->tambah->any())
  document.addEventListener('DOMContentLoaded', () => openTambah());

@elseif($errors->edit->any())
  @php
    $editId = old('_edit_id');
    $eu = $editId ? $users->firstWhere('id', $editId) : null;
  @endphp
  @if($eu)
  document.addEventListener('DOMContentLoaded', () => {
    openEdit(
      '{{ $eu->id }}',
      '{{ addslashes(old("nama", $eu->nama)) }}',
      '{{ old("username", $eu->username) }}',
      '{{ old("role", $eu->role) }}'
    );
  });
  @endif
@endif
</script>
@endsection