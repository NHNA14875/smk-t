@extends('layouts.app')

@section('title', 'Manajemen Akun Petugas')

@section('content')
<div class="page-hdr">
  <div>
    <div class="page-title">Manajemen Akun Petugas</div>
    <div class="page-sub">Kelola akun login untuk semua petugas.</div>
  </div>
  <button class="btn btn-primary btn-sm" onclick="document.getElementById('modalTambah').classList.add('open')">➕ Tambah Akun</button>
</div>

<div class="akun-grid">
  <div class="akun-card">
    <div class="akun-avatar" style="background:var(--teal-light);color:var(--teal)">SA</div>
    <div style="flex:1;min-width:0">
      <div class="akun-name">Satpam Andi</div>
      <div class="akun-user">satpam_andi</div>
      <span class="badge b-teal">satpam</span>
    </div>
    <div class="akun-actions">
      <button class="btn btn-icon">✏️</button>
    </div>
  </div>

  <div class="akun-card">
    <div class="akun-avatar" style="background:var(--purple-light);color:var(--purple)">CD</div>
    <div style="flex:1;min-width:0">
      <div class="akun-name">CS Dewi</div>
      <div class="akun-user">cs_dewi</div>
      <span class="badge b-purple">cs</span>
    </div>
    <div class="akun-actions">
      <button class="btn btn-icon">✏️</button>
    </div>
  </div>

  <div class="akun-card">
    <div class="akun-avatar" style="background:var(--amber-light);color:var(--amber)">AD</div>
    <div style="flex:1;min-width:0">
      <div class="akun-name">Admin Dino</div>
      <div class="akun-user">admin_dino</div>
      <span class="badge b-amber">admin</span>
    </div>
    <div class="akun-actions">
      <button class="btn btn-icon">✏️</button>
    </div>
  </div>

  <div class="akun-card akun-add"
       onclick="document.getElementById('modalTambah').classList.add('open')">
    <div style="font-size:22px;margin-bottom:4px">➕</div>
    <div style="font-size:12px;color:var(--text3)">Tambah Akun Baru</div>
  </div>
</div>

<div class="modal-backdrop" id="modalTambah"
     onclick="document.getElementById('modalTambah').classList.remove('open')">
  <div class="modal-box" onclick="event.stopPropagation()">
    <div class="modal-title">➕ Tambah Akun Baru</div>
    <div class="form-group" style="margin-bottom:12px">
      <label class="form-label">NAMA LENGKAP</label>
      <input class="form-input" placeholder="Nama petugas">
    </div>
    <div class="form-group" style="margin-bottom:12px">
      <label class="form-label">USERNAME</label>
      <input class="form-input" placeholder="cth: satpam_02">
    </div>
    <div class="form-group" style="margin-bottom:16px">
      <label class="form-label">ROLE</label>
      <select class="form-select">
        <option>satpam</option>
        <option>cs</option>
        <option>admin</option>
      </select>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline"
              onclick="document.getElementById('modalTambah').classList.remove('open')">Batal</button>
      <button class="btn btn-primary">Simpan Akun</button>
    </div>
  </div>
</div>
@endsection