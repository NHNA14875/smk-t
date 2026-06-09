@extends('layouts.guest')

@section('title', 'Login - SMK-T')

@section('content')
<div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
  <div class="brand-icon">💳</div>
  <div>
    <div style="font-size:20px; font-weight:700;">SMK-T</div>
    <div style="font-size:11px; color:var(--text2);">Sistem Monitoring Kartu Tertelan</div>
  </div>
</div>

<p style="font-size:14px; color:var(--text2); margin-bottom:20px; line-height:1.5;">Masuk sesuai peran Anda untuk mengakses sistem.</p>

<div style="margin-bottom:16px;">
  <div class="form-label">DEMO — PILIH PERAN</div>
  <div style="display:flex; gap:6px; background:var(--bg3); border-radius:8px; padding:3px;">
    <button class="role-tab" onclick="setRole('satpam',this)" style="flex:1; padding:7px 4px; border-radius:6px; border:none; background:var(--bg2); color:var(--teal); box-shadow:var(--shadow); font-weight:600; cursor:pointer;">Satpam</button>
    <button class="role-tab" onclick="setRole('cs',this)" style="flex:1; padding:7px 4px; border-radius:6px; border:none; background:transparent; color:var(--text2); cursor:pointer;">Customer Service</button>
    <button class="role-tab" onclick="setRole('admin',this)" style="flex:1; padding:7px 4px; border-radius:6px; border:none; background:transparent; color:var(--text2); cursor:pointer;">Admin</button>
  </div>
</div>

<form action="{{ url('/login') }}" method="POST">
  @csrf
  <div class="form-group" style="margin-bottom:14px;">
    <label class="form-label">USERNAME</label>
    <input class="form-input" id="loginUser" name="username" value="satpam_budi" readonly>
  </div>
  <div class="form-group" style="margin-bottom:14px;">
    <label class="form-label">PASSWORD</label>
    <input class="form-input" type="password" name="password" value="password">
  </div>
  
  @error('username')
    <div style="color:var(--red); font-size:12px; margin-bottom:10px;">{{ $message }}</div>
  @enderror

  <button type="submit" class="btn btn-primary" style="width:100%">Masuk ke Sistem →</button>
</form>

<p style="text-align:center; margin-top:14px; font-size:11px; color:var(--text3);">Sistem internal · Hanya untuk petugas bank</p>
@endsection

@section('scripts')
<script>
// Username disesuaikan dengan isi tabel "users" di database MySQL
const roles = {
  satpam: { username: 'satpam_budi' },
  cs: { username: 'cs_siti' },
  admin: { username: 'admin_rian' }
};

function setRole(roleName, element) {
  // Hapus efek aktif dari semua tombol
  document.querySelectorAll('.role-tab').forEach(tab => {
    tab.style.background = 'transparent';
    tab.style.color = 'var(--text2)';
    tab.style.boxShadow = 'none';
    tab.style.fontWeight = '500';
  });
  
  // Tambahkan efek aktif pada tombol yang diklik
  element.style.background = 'var(--bg2)';
  element.style.color = 'var(--teal)';
  element.style.boxShadow = 'var(--shadow)';
  element.style.fontWeight = '600';
  
  // Ubah isi kotak input username secara dinamis
  document.getElementById('loginUser').value = roles[roleName].username;
}
</script>
@endsection