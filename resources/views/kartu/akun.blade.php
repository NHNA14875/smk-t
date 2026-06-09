@extends('layouts.app')

@section('title', 'Manajemen Akun Petugas')

@section('content')
<style>
.akun-grid{display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:12px;}
.akun-card{background:var(--bg2); border:1px solid var(--border); border-radius:var(--radius); padding:14px; display:flex; align-items:center; gap:12px;}
.akun-avatar{width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:14px; font-weight:700; flex-shrink:0;}
.akun-name{font-size:13px; font-weight:600;}
.akun-user{font-size:11px; color:var(--text3); font-family:monospace; margin-bottom:4px;}
.akun-actions{display:flex; gap:5px; margin-left:auto;}
.akun-add{border-style:dashed; cursor:pointer; opacity:.5; justify-content:center; flex-direction:column; text-align:center; min-height:70px;}
.akun-add:hover{opacity:.8; background:var(--bg3);}
</style>

<div class="page-hdr" style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:18px;">
  <div>
    <div class="page-title" style="font-size:18px; font-weight:700;">Manajemen Akun Petugas</div>
    <div class="page-sub" style="font-size:13px; color:var(--text2);">Kelola akun login untuk semua petugas.</div>
  </div>
  <button class="btn btn-primary btn-sm" onclick="showModal('tambahAkun', '')">➕ Tambah Akun</button>
</div>

<div class="akun-grid">
  <div class="akun-card">
    <div class="akun-avatar" style="background:var(--teal-light); color:var(--teal);">SA</div>
    <div style="flex:1; min-width:0;">
      <div class="akun-name">Satpam Andi</div><div class="akun-user">satpam_andi</div>
      <span style="display:inline-block; padding:2px 8px; border-radius:5px; font-size:10px; background:var(--teal-light); color:var(--teal);">satpam</span>
    </div>
    <div class="akun-actions"><button class="btn btn-outline" style="padding:4px 8px;">✏️</button></div>
  </div>

  <div class="akun-card">
    <div class="akun-avatar" style="background:var(--purple-light); color:var(--purple);">CD</div>
    <div style="flex:1; min-width:0;">
      <div class="akun-name">CS Dewi</div><div class="akun-user">cs_dewi</div>
      <span style="display:inline-block; padding:2px 8px; border-radius:5px; font-size:10px; background:var(--purple-light); color:var(--purple);">cs</span>
    </div>
    <div class="akun-actions"><button class="btn btn-outline" style="padding:4px 8px;">✏️</button></div>
  </div>
  
  <div class="akun-card akun-add" onclick="showModal('tambahAkun', '')">
    <div style="font-size:22px; margin-bottom:4px;">➕</div>
    <div style="font-size:12px; color:var(--text3);">Tambah Akun Baru</div>
  </div>
</div>
@endsection