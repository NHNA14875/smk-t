@extends('layouts.app')

@section('title', 'Input Kartu Tertelan')

@section('content')
<div class="page-hdr">
  <div>
    <div class="page-title">Input Kartu Tertelan</div>
    <div class="page-sub">Isi formulir setelah menemukan kartu ATM yang tertelan.</div>
  </div>
</div>

@if(session('success'))
<div class="alert-banner" style="background:var(--green-light); border-color:rgba(26,122,69,.2);">
  <span class="ico">✅</span>
  <div class="txt"><strong>Data berhasil disimpan!</strong> {{ session('success') }}</div>
</div>
@endif

<div class="form-card" style="background:var(--bg2); border:1px solid var(--border); border-radius:var(--radius-lg); padding:20px; max-width:600px;">
  <form action="{{ url('/input') }}" method="POST">
    @csrf
    
    <div style="font-size:11px; font-weight:600; color:var(--text3); letter-spacing:.8px; text-transform:uppercase; margin-bottom:12px;">Data Nasabah</div>
    
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
      <div style="margin-bottom:14px;">
        <label style="font-size:12px; font-weight:600; color:var(--text2); display:block; margin-bottom:6px;">No. Kartu (4 digit terakhir) <span style="color:var(--red)">*</span></label>
        <input type="text" class="form-input" name="nomor_kartu" value="{{ old('nomor_kartu') }}" placeholder="cth: 1234" maxlength="4" inputmode="numeric" required style="@error('nomor_kartu') border-color:var(--red); @enderror">
        @error('nomor_kartu')
          <div style="font-size:11px; color:var(--red); margin-top:4px;">{{ $message }}</div>
        @enderror
        <div style="font-size:11px; color:var(--text3); margin-top:4px;">Lihat 4 angka terakhir di fisik kartu</div>
      </div>

      <div style="margin-bottom:14px;">
        <label style="font-size:12px; font-weight:600; color:var(--text2); display:block; margin-bottom:6px;">Nama Nasabah <span style="color:var(--red)">*</span></label>
        <input type="text" class="form-input" name="nama_nasabah" value="{{ old('nama_nasabah') }}" placeholder="Nama lengkap pemilik kartu" required style="@error('nama_nasabah') border-color:var(--red); @enderror">
        @error('nama_nasabah')
          <div style="font-size:11px; color:var(--red); margin-top:4px;">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div style="height:1px; background:var(--border); margin:18px 0;"></div>
    
    <div style="font-size:11px; font-weight:600; color:var(--text3); letter-spacing:.8px; text-transform:uppercase; margin-bottom:12px;">Lokasi Kejadian</div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
      <div style="margin-bottom:14px;">
        <label style="font-size:12px; font-weight:600; color:var(--text2); display:block; margin-bottom:6px;">Kode / Nama Mesin ATM <span style="color:var(--red)">*</span></label>
        <input type="text" class="form-input" name="lokasi_atm" value="{{ old('lokasi_atm') }}" placeholder="cth: ATM-PLZ-01" required style="@error('lokasi_atm') border-color:var(--red); @enderror">
        @error('lokasi_atm')
          <div style="font-size:11px; color:var(--red); margin-top:4px;">{{ $message }}</div>
        @enderror
      </div>

      <div style="margin-bottom:14px;">
        <label style="font-size:12px; font-weight:600; color:var(--text2); display:block; margin-bottom:6px;">Lokasi Penyimpanan <span style="color:var(--red)">*</span></label>
        <select class="form-select" name="lokasi_simpan" required style="@error('lokasi_simpan') border-color:var(--red); @enderror">
          <option value="">-- Pilih lokasi simpan --</option>
          <option value="Kantor Pusat" {{ old('lokasi_simpan') == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
          <option value="Cabang" {{ old('lokasi_simpan') == 'Cabang' ? 'selected' : '' }}>Cabang</option>
          <option value="Capem" {{ old('lokasi_simpan') == 'Capem' ? 'selected' : '' }}>Capem</option>
        </select>
        @error('lokasi_simpan')
          <div style="font-size:11px; color:var(--red); margin-top:4px;">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div style="background:var(--bg3); border:1px solid var(--border); border-radius:8px; padding:10px 14px; margin-bottom:16px;">
      <div style="font-size:10px; color:var(--text3); letter-spacing:.5px; margin-bottom:6px;">DIISI OTOMATIS OLEH SISTEM</div>
      <div style="display:flex; gap:16px; flex-wrap:wrap;">
        <div style="font-size:12px; color:var(--text2);">📅 Tgl masuk: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</strong></div>
        <div style="font-size:12px; color:var(--text2);">⏰ Batas: <strong>{{ \Carbon\Carbon::now()->addDays(7)->translatedFormat('d M Y') }}</strong></div>
        <div style="font-size:12px; color:var(--text2);">🔵 Status: <strong style="color:var(--teal);">Disimpan</strong></div>
      </div>
    </div>

    <div style="display:flex; gap:10px;">
      <button type="submit" class="btn btn-primary" style="flex:1;">💾 Simpan Data Kartu</button>
      <button type="reset" class="btn btn-outline">Reset</button>
    </div>
  </form>
</div>
@endsection