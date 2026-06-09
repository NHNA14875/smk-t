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
    <input type="text" class="search-box" id="searchArsip" placeholder="🔍 Cari nama..." oninput="filterArsip()">
    <select class="sel-filter" id="filterStatusArsip" onchange="filterArsip()">
      <option value="">Semua Status</option>
      <option value="Diambil">Diambil Nasabah</option>
      <option value="Dimusnahkan">Dimusnahkan</option>
    </select>
  </div>
  
  <div style="width: 100%;">
    <table style="width:100%; border-collapse:collapse;">
      <thead>
        <tr>
          <th style="padding:12px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">No. Kartu</th>
          <th style="padding:12px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Nama Nasabah</th>
          <th style="padding:12px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Tgl. Masuk</th>
          <th style="padding:12px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Tgl. Selesai</th>
          <th style="padding:12px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Status Akhir</th>
          <th style="padding:12px 14px; font-size:11px; font-weight:600; color:var(--text3); text-transform:uppercase; background:var(--bg3); border-bottom:1px solid var(--border); text-align:left;">Log</th>
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
            <td style="padding:14px;"><span style="font-family:'Courier New',monospace; font-size:13px; color:var(--text2);">{{ $row->nomor_kartu }}</span></td>
            <td style="padding:14px;"><strong>{{ $row->nama_nasabah }}</strong></td>
            <td style="padding:14px;"><span style="font-family:'Courier New',monospace; font-size:13px; color:var(--text2);">{{ $row->tanggal_masuk }}</span></td>
            <td style="padding:14px;"><span style="font-family:'Courier New',monospace; font-size:13px; color:var(--text2);">{{ $row->tanggal_selesai }}</span></td>
            <td style="padding:14px;">
              <span style="display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:20px; font-size:11px; font-weight:600; background:{{ $badgeCls }}; color:{{ $badgeTxt }};">
                <span style="width:5px; height:5px; border-radius:50%; background:{{ $dotColor }};"></span>
                {{ $row->status_akhir }}
              </span>
            </td>
            <td style="padding:14px;">
              <button class="btn btn-outline btn-sm" onclick="showLogModal('{{ $row->nama_nasabah }}', '{{ $row->nomor_kartu }}')">📋 Log</button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal-backdrop" id="modalLog" onclick="closeLogModal()">
  <div class="modal-box" onclick="event.stopPropagation()">
    <div style="font-size:16px; font-weight:700; margin-bottom:8px;">📋 Log Audit — Kartu <span id="logNoKartu"></span></div>
    <div style="font-size:12px; color:var(--text3); margin-bottom:14px; font-family:'Courier New',monospace;">Nasabah: <span id="logNama"></span></div>
    <div style="display:flex; flex-direction:column;">
      <div style="display:flex; gap:12px; padding:10px 0;">
        <div><div style="width:10px; height:10px; border-radius:50%; background:var(--teal);"></div></div>
        <div><div style="font-size:13px; font-weight:600;">Status Akhir Tercapai</div></div>
      </div>
    </div>
    <div style="margin-top:16px; text-align:right;">
      <button class="btn btn-outline" onclick="closeLogModal()">Tutup</button>
    </div>
  </div>
</div>

<script>
function filterArsip() {
  const searchVal = document.getElementById('searchArsip').value.toLowerCase();
  const statusVal = document.getElementById('filterStatusArsip').value;
  document.querySelectorAll('.arsip-row').forEach(row => {
    const nama = row.getAttribute('data-nama');
    const status = row.getAttribute('data-status');
    row.style.display = (nama.includes(searchVal) && (statusVal === '' || status === statusVal)) ? '' : 'none';
  });
}

function showLogModal(nama, noKartu) {
  document.getElementById('logNama').textContent = nama;
  document.getElementById('logNoKartu').textContent = noKartu;
  document.getElementById('modalLog').classList.add('open');
}

function closeLogModal() {
  document.getElementById('modalLog').classList.remove('open');
}
</script>
@endsection