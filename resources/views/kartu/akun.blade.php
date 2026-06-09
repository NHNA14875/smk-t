@extends('layouts.app')

@section('title', 'Manajemen Akun')

@section('content')
<div class="page-hdr" style="margin-bottom: 20px;">
  <div>
    <div class="page-title" style="font-size: 20px; font-weight: 700; color: var(--text);">Manajemen Akun</div>
    <div class="page-sub" style="font-size: 13px; color: var(--text2); margin-top: 4px;">Kelola akses dan kata sandi petugas.</div>
  </div>
</div>

<div class="card" style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: var(--shadow); margin-bottom: 20px;">
  <div class="card-header" style="padding: 16px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
    <span class="card-title" style="font-weight: 700; color: var(--text);">Daftar Akun Terdaftar</span>
    <button class="btn btn-primary" style="background: var(--teal); color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;" onclick="showAddUserModal()">
      ➕ Tambah Akun Baru
    </button>
  </div>
  
  <div style="width: 100%; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; min-width: 560px;">
      <thead>
        <tr>
          <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: var(--text3); text-transform: uppercase; background: var(--bg3); border-bottom: 1px solid #e5e7eb; text-align: left;">Nama Petugas</th>
          <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: var(--text3); text-transform: uppercase; background: var(--bg3); border-bottom: 1px solid #e5e7eb; text-align: left;">Username</th>
          <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: var(--text3); text-transform: uppercase; background: var(--bg3); border-bottom: 1px solid #e5e7eb; text-align: left;">Peran / Role</th>
          <th style="padding: 12px 16px; font-size: 11px; font-weight: 600; color: var(--text3); text-transform: uppercase; background: var(--bg3); border-bottom: 1px solid #e5e7eb; text-align: left;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
          <tr style="border-bottom: 1px solid #e5e7eb;">
            <td style="padding: 14px 16px;"><strong>{{ $u->nama }}</strong></td>
            <td style="padding: 14px 16px;"><span style="font-family: 'Courier New', monospace; font-size: 13px; color: var(--text2);">{{ $u->username }}</span></td>
            <td style="padding: 14px 16px;">
              @php
                $roleBg = 'var(--bg3)'; $roleColor = 'var(--text2)';
                if(strtolower($u->role) === 'admin') { $roleBg = 'var(--amber-light)'; $roleColor = '#b37000'; }
                elseif(strtolower($u->role) === 'cs') { $roleBg = 'var(--purple-light)'; $roleColor = 'var(--purple)'; }
                elseif(strtolower($u->role) === 'satpam') { $roleBg = 'var(--teal-light)'; $roleColor = 'var(--teal)'; }
              @endphp
              <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: {{ $roleBg }}; color: {{ $roleColor }};">
                {{ strtoupper($u->role) }}
              </span>
            </td>
            <td style="padding: 14px 16px;">
              <form action="{{ url('/akun/reset/'.$u->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin mereset kata sandi akun ini kembali menjadi \'password\'?')">
                @csrf
                <button type="submit" style="background: white; border: 1px solid #d1d5db; color: var(--text); padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 500;">
                  🔄 Reset Pass
                </button>
              </form>

              @if($u->id !== Auth::id())
              <form action="{{ url('/akun/'.$u->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus akun ini dari sistem?')">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: var(--red-light); border: 1px solid rgba(220,53,69,.2); color: var(--red); padding: 6px 12px; border-radius: 6px; font-size: 12px; cursor: pointer; font-weight: 500; margin-left: 4px;">
                  🗑 Hapus
                </button>
              </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal-backdrop" id="modalAddUser" onclick="closeAddUserModal()" style="position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 300; display: none; align-items: center; justify-content: center; padding: 16px; backdrop-filter: blur(3px);">
  <div class="modal-box" onclick="event.stopPropagation()" style="background: white; border-radius: 14px; padding: 24px; width: 100%; max-width: 400px; box-shadow: var(--shadow2);">
    <div style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--text);">➕ Tambah Akun Baru</div>
    
    <form action="{{ url('/akun') }}" method="POST">
      @csrf
      <div style="margin-bottom: 14px;">
        <label style="display: block; font-size: 11px; font-weight: 600; color: var(--text2); margin-bottom: 6px;">NAMA LENGKAP</label>
        <input type="text" name="nama" required placeholder="Nama petugas" style="width: 100%; padding: 10px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; outline: none;">
      </div>
      <div style="margin-bottom: 14px;">
        <label style="display: block; font-size: 11px; font-weight: 600; color: var(--text2); margin-bottom: 6px;">USERNAME</label>
        <input type="text" name="username" required placeholder="cth: satpam_02" style="width: 100%; padding: 10px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; outline: none;">
      </div>
      <div style="margin-bottom: 24px;">
        <label style="display: block; font-size: 11px; font-weight: 600; color: var(--text2); margin-bottom: 6px;">ROLE (PERAN)</label>
        <select name="role" required style="width: 100%; padding: 10px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 13px; outline: none; background: white; cursor: pointer;">
          <option value="satpam">Satpam (Input Data)</option>
          <option value="cs">Customer Service (Kelola Kartu)</option>
          <option value="admin">Administrator (Akses Penuh)</option>
        </select>
      </div>
      <div style="text-align: right; display: flex; justify-content: flex-end; gap: 8px;">
        <button type="button" style="padding: 8px 16px; font-size: 13px; border: 1px solid #d1d5db; border-radius: 6px; background: white; cursor: pointer; font-weight: 600; color: var(--text);" onclick="closeAddUserModal()">Batal</button>
        <button type="submit" style="background: var(--teal); color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer;">Simpan Akun</button>
      </div>
    </form>
  </div>
</div>

<script>
function showAddUserModal() {
  document.getElementById('modalAddUser').style.display = 'flex';
}
function closeAddUserModal() {
  document.getElementById('modalAddUser').style.display = 'none';
}
</script>
@endsection