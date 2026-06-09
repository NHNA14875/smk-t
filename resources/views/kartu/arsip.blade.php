@extends('layouts.app')

@section('title', 'Arsip Riwayat')

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
    <input class="search-box" id="searchArsip" placeholder="🔍 Cari nama..." oninput="filterArsip()">
    <select class="sel-filter" id="filterStatusArsip" onchange="filterArsip()">
      <option value="">Semua Status</option>
      <option value="Diambil">Diambil Nasabah</option>
      <option value="Dimusnahkan">Dimusnahkan</option>
    </select>
  </div>

  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>No. Kartu</th>
          <th>Nama Nasabah</th>
          <th>Tgl. Masuk</th>
          <th>Tgl. Selesai</th>
          <th>Status Akhir</th>
          <th>Log</th>
        </tr>
      </thead>
      <tbody>
        @foreach($arsip as $row)
          @php
            $badgeCls = $row->status_akhir === 'Diambil' ? 'b-green' : 'b-red';
            $dotColor = $row->status_akhir === 'Diambil' ? 'var(--green)' : 'var(--red)';
          @endphp
          <tr class="arsip-row"
              data-nama="{{ strtolower($row->nama_nasabah) }}"
              data-status="{{ $row->status_akhir }}">
            <td><span class="mono">{{ $row->nomor_kartu }}</span></td>
            <td><strong>{{ $row->nama_nasabah }}</strong></td>
            <td><span class="mono">{{ $row->tanggal_masuk }}</span></td>
            <td><span class="mono">{{ $row->tanggal_selesai }}</span></td>
            <td>
              <span class="badge {{ $badgeCls }}">
                <span class="bdot" style="background:{{ $dotColor }}"></span>
                {{ $row->status_akhir }}
              </span>
            </td>
            <td>
              <button class="btn btn-outline btn-sm"
                      onclick="showLogModal('{{ $row->nama_nasabah }}','{{ $row->nomor_kartu }}')">
                📋 Log
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="modal-backdrop" id="modalLog" onclick="closeLogModal()">
  <div class="modal-box" onclick="event.stopPropagation()" style="max-width:440px">
    <div class="modal-title">📋 Log Audit — Kartu <span id="logNoKartu"></span></div>
    <div style="font-size:12px;color:var(--text3);margin-bottom:14px;font-family:'Courier New',monospace">
      Nasabah: <span id="logNama"></span>
    </div>
    <div class="log-list">
      <div class="log-item">
        <div class="log-dot-col">
          <div class="log-dot" style="background:var(--teal)"></div>
          <div class="log-line"></div>
        </div>
        <div>
          <div class="log-action">Input — Status: Disimpan</div>
          <div class="log-meta">Data tercatat di sistem</div>
        </div>
      </div>
      <div class="log-item">
        <div class="log-dot-col">
          <div class="log-dot" style="background:var(--green)"></div>
        </div>
        <div>
          <div class="log-action">Status Akhir Tercapai</div>
          <div class="log-meta">Proses selesai</div>
        </div>
      </div>
    </div>
    <div class="modal-footer" style="margin-top:16px">
      <button class="btn btn-outline" onclick="closeLogModal()">Tutup</button>
    </div>
  </div>
</div>

<script>
function filterArsip() {
  const searchVal = document.getElementById('searchArsip').value.toLowerCase();
  const statusVal = document.getElementById('filterStatusArsip').value;
  document.querySelectorAll('.arsip-row').forEach(row => {
    const match = row.getAttribute('data-nama').includes(searchVal)
      && (statusVal === '' || row.getAttribute('data-status') === statusVal);
    row.style.display = match ? '' : 'none';
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