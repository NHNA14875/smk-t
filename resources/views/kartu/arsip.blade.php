@extends('layouts.app')

@section('title', 'Arsip Riwayat Kartu')

@section('content')
<div class="page-hdr">
  <div>
    <div class="page-title">Arsip Riwayat Kartu</div>
    <div class="page-sub">Rekam jejak kartu yang sudah selesai diproses.</div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <span class="card-title">Riwayat Selesai</span>
    <input type="text" class="search-box" id="searchArsip" placeholder="🔍 Cari nama..." style="background:var(--bg3); border:1.5px solid var(--border); border-radius:8px; padding:7px 12px; font-size:13px; width:180px; outline:none;" oninput="filterArsip()">
    <select class="sel-filter" id="filterStatusArsip" style="background:var(--bg3); border:1.5px solid var(--border); border-radius:8px; padding:7px 10px; font-size:12px; color:var(--text2); outline:none; cursor:pointer;" onchange="filterArsip()">
      <option value="">Semua Status</option>
      <option value="Diambil">Diambil Nasabah</option>
      <option value="Dimusnahkan">Dimusnahkan</option>
    </select>
  </div>
  
  <div class="tbl-wrap" style="overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; min-width:560px;">
      <thead>
        <tr>
          <th style="padding:10px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">No. Kartu</th>
          <th style="padding:10px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Nama Nasabah</th>
          <th style="padding:10px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Tgl. Masuk</th>
          <th style="padding:10px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Tgl. Selesai</th>
          <th style="padding:10px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Status Akhir</th>
          <th style="padding:10px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Log</th>
        </tr>
      </thead>
      <tbody>
        @foreach($arsip as $row)
          @php
            $badgeCls = $row->status_akhir === 'Diambil' ? 'var(--green-light)' : 'var(--red-light)';
            $badgeTxt = $row->status_akhir === 'Diambil' ? '#0f4a27' : '#8b1a1a';
            $dotColor = $row->status_akhir === 'Diambil' ? 'var(--green)' : 'var(--red)';
          @endphp
          <tr class="arsip-row" data-nama="{{ strtolower($row->nama_nasabah) }}" data-status="{{ $row->status_akhir }}" style="border-bottom:1px solid var(--border);">
            <td style="padding:13px 14px;"><span style="font-family:'Courier New',monospace; font-size:12px; color:var(--text2);">{{ $row->nomor_kartu }}</span></td>
            <td style="padding:13px 14px;"><strong>{{ $row->nama_nasabah }}</strong></td>
            <td style="padding:13px 14px;"><span style="font-family:'Courier New',monospace; font-size:12px; color:var(--text2);">{{ $row->tanggal_masuk }}</span></td>
            <td style="padding:13px 14px;"><span style="font-family:'Courier New',monospace; font-size:12px; color:var(--text2);">{{ $row->tanggal_selesai }}</span></td>
            <td style="padding:13px 14px;">
              <span style="display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; background:{{ $badgeCls }}; color:{{ $badgeTxt }};">
                <span style="width:5px; height:5px; border-radius:50%; background:{{ $dotColor }}; flex-shrink:0;"></span>
                {{ $row->status_akhir }}
              </span>
            </td>
            <td style="padding:13px 14px;">
              <button class="btn btn-outline" style="padding:7px 12px; font-size:12px; gap:5px;" onclick="showLogModal('{{ $row->nama_nasabah }}', '{{ $row->nomor_kartu }}')">📋 Log</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal-backdrop" id="modalLog" onclick="closeLogModal()" style="position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:300; display:none; align-items:center; justify-content:center; padding:16px; backdrop-filter:blur(3px);">
  <div class="modal-box" onclick="event.stopPropagation()" style="background:var(--bg2); border-radius:var(--radius-lg); padding:24px; width:100%; max-width:440px; box-shadow:var(--shadow2); animation:fadeUp 0.2s ease;">
    <div style="font-size:16px; font-weight:700; margin-bottom:8px;">📋 Log Audit — Kartu <span id="logNoKartu"></span></div>
    <div style="font-size:12px; color:var(--text3); margin-bottom:14px; font-family:'Courier New',monospace;">Nasabah: <span id="logNama"></span> · Data Backend</div>
    
    <div style="display:flex; flex-direction:column;">
      <div style="display:flex; gap:12px; padding:10px 0; border-bottom:1px solid var(--border);">
        <div style="display:flex; flex-direction:column; align-items:center; padding-top:3px;">
          <div style="width:10px; height:10px; border-radius:50%; flex-shrink:0; background:var(--teal);"></div>
          <div style="flex:1; width:1px; background:var(--border); margin-top:3px;"></div>
        </div>
        <div>
          <div style="font-size:13px; font-weight:600;">Input — Status: Disimpan</div>
          <div style="font-size:11px; color:var(--text3); margin-top:2px; font-family:'Courier New',monospace;">[TGL MASUK] · satpam_01</div>
        </div>
      </div>
      <div style="display:flex; gap:12px; padding:10px 0; border-bottom:1px solid var(--border);">
        <div style="display:flex; flex-direction:column; align-items:center; padding-top:3px;">
          <div style="width:10px; height:10px; border-radius:50%; flex-shrink:0; background:var(--amber);"></div>
          <div style="flex:1; width:1px; background:var(--border); margin-top:3px;"></div>
        </div>
        <div>
          <div style="font-size:13px; font-weight:600;">Ubah Status → Dihubungi</div>
          <div style="font-size:11px; color:var(--text3); margin-top:2px; font-family:'Courier New',monospace;">[TGL UBAH] · cs_dewi</div>
        </div>
      </div>
      <div style="display:flex; gap:12px; padding:10px 0;">
        <div style="display:flex; flex-direction:column; align-items:center; padding-top:3px;">
          <div style="width:10px; height:10px; border-radius:50%; flex-shrink:0; background:var(--green);"></div>
        </div>
        <div>
          <div style="font-size:13px; font-weight:600;">Ubah Status Selesai Proses</div>
          <div style="font-size:11px; color:var(--text3); margin-top:2px; font-family:'Courier New',monospace;">[TGL SELESAI] · cs_dewi</div>
        </div>
      </div>
    </div>
    
    <div style="margin-top:16px; text-align:right;">
      <button class="btn btn-outline" onclick="closeLogModal()">Tutup</button>
    </div>
  </div>
</div>

<script>
// Filter Arsip (Sesuai Bab 4.3.4 & Laporan Pengujian)
function filterArsip() {
  const searchVal = document.getElementById('searchArsip').value.toLowerCase();
  const statusVal = document.getElementById('filterStatusArsip').value;
  
  document.querySelectorAll('.arsip-row').forEach(row => {
    const nama = row.getAttribute('data-nama');
    const status = row.getAttribute('data-status');
    const matchSearch = nama.includes(searchVal);
    const matchStatus = statusVal === '' || status === statusVal;
    
    row.style.display = (matchSearch && matchStatus) ? '' : 'none';
  });
}

function showLogModal(nama, noKartu) {
  document.getElementById('logNama').textContent = nama;
  document.getElementById('logNoKartu').textContent = noKartu;
  document.getElementById('modalLog').style.display = 'flex';
}

function closeLogModal() {
  document.getElementById('modalLog').style.display = 'none';
}
</script>
@endsection