@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')
<style>
/* CSS Dashboard */
.alert-banner{background:var(--red-light);border:1px solid rgba(220,53,69,.2);border-radius:var(--radius);padding:12px 14px;display:flex;align-items:center;gap:10px;margin-bottom:16px;font-size:13px}
.alert-banner .ico{font-size:18px;flex-shrink:0}
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:12px;margin-bottom:18px}
.stat-card{background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);padding:14px;position:relative;overflow:hidden}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
.stat-card.teal::before{background:var(--teal)}
.stat-card.amber::before{background:var(--amber)}
.stat-card.red::before{background:var(--red)}
.stat-card.green::before{background:var(--green)}
.stat-ico{font-size:20px;margin-bottom:8px}
.stat-val{font-size:26px;font-weight:700;line-height:1;color:var(--text)}
.stat-lbl{font-size:11px;color:var(--text2);margin-top:3px}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap}
.bdot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
.b-teal{background:var(--teal-light);color:#085041}
.b-amber{background:var(--amber-light);color:#7a4800}
.b-green{background:var(--green-light);color:#0f4a27}
.cdown{font-size:12px;font-weight:600;font-family:'Courier New',monospace}
.cdown.safe{color:var(--green)}
.cdown.warn{color:var(--amber)}
.cdown.dang{color:var(--red)}
.dropdown{position:relative;display:inline-block}
.dropdown-menu{position:absolute;right:0;top:calc(100% + 4px);background:var(--bg2);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow2);min-width:170px;z-index:50;display:none}
.dropdown-menu.open{display:block}
.dd-item{display:flex;align-items:center;gap:8px;padding:10px 14px;font-size:13px;cursor:pointer;color:var(--text);transition:background .1s}
.dd-item:hover{background:var(--bg3)}
.dd-item.danger{color:var(--red)}
.dd-item.danger:hover{background:var(--red-light)}
.dd-divider{height:1px;background:var(--border);margin:3px 0}
.tag-chip{display:inline-block;padding:2px 8px;border-radius:5px;background:var(--bg3);border:1px solid var(--border);font-size:11px;color:var(--text2);font-family:'Courier New',monospace}
.search-box{background:var(--bg3);border:1.5px solid var(--border);border-radius:8px;padding:7px 12px;font-size:13px;font-family:var(--font);color:var(--text);outline:none;width:180px;}
.sel-filter{background:var(--bg3);border:1.5px solid var(--border);border-radius:8px;padding:7px 10px;font-size:12px;color:var(--text2);font-family:var(--font);cursor:pointer;outline:none;}
.card {background: var(--bg2); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden;}
.card-header {padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px;}
.card-title {font-weight: 700; flex: 1; font-size: 15px;}
.tbl-wrap {overflow-x: auto;}
table {width: 100%; border-collapse: collapse; min-width: 800px;}
th {text-align: left; padding: 12px 16px; font-size: 11px; color: var(--text3); font-weight: 600; background: var(--bg3); text-transform: uppercase; letter-spacing: 0.5px;}
td {padding: 14px 16px; border-bottom: 1px solid var(--border); vertical-align: middle;}
.dash-row.row-d {background: var(--red-light);}
.dash-row.row-w {background: var(--amber-light);}

/* Modal CSS */
.modal-backdrop{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .2s}
.modal-backdrop.open{opacity:1;pointer-events:auto}
.modal-box{background:var(--bg2);width:90%;max-width:400px;border-radius:var(--radius-lg);box-shadow:var(--shadow2);transform:translateY(20px);transition:transform .2s;overflow:hidden}
.modal-backdrop.open .modal-box{transform:translateY(0)}
.modal-title{padding:16px 20px;font-weight:700;font-size:16px;border-bottom:1px solid var(--border)}
.modal-body{padding:20px;font-size:14px;color:var(--text2);line-height:1.5}
.modal-footer{padding:16px 20px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:10px;background:var(--gray-light)}
</style>

@if(isset($kritisCount) && $kritisCount > 0)
<div class="alert-banner">
  <span class="ico">🚨</span>
  <div class="txt"><strong>{{ $kritisCount }} kartu memerlukan tindakan segera</strong> — batas waktu sudah terlewati atau hampir habis.</div>
</div>
@endif

<div class="stats-grid">
  <div class="stat-card teal"><div class="stat-ico">💳</div><div class="stat-val">{{ count($kartu) }}</div><div class="stat-lbl">Kartu aktif</div></div>
  <div class="stat-card amber"><div class="stat-ico">⏳</div><div class="stat-val">{{ $kartu->where('status', 'Disimpan')->count() }}</div><div class="stat-lbl">Belum dihubungi</div></div>
  <div class="stat-card red"><div class="stat-ico">🔴</div><div class="stat-val">{{ $kritisCount ?? 0 }}</div><div class="stat-lbl">Mendekati batas</div></div>
</div>

<div class="card">
  <div class="card-header">
    <span class="card-title">Daftar Kartu Aktif</span>
    <input class="search-box" placeholder="🔍 Cari nama..." id="searchDash" oninput="filterDashboard()">
    <select class="sel-filter" id="filterDash" onchange="filterDashboard()">
      <option value="">Semua Status</option>
      <option value="Disimpan">Disimpan</option>
      <option value="Dihubungi">Dihubungi</option>
    </select>
  </div>
  
  <div class="tbl-wrap">
    <table>
      <thead>
        <tr>
          <th>No. Kartu</th><th>Nama Nasabah</th><th>Lokasi ATM</th>
          <th>Simpan Di</th><th>Sisa Waktu</th><th>Status</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($kartu as $item)
          @php
            $rowCls = ''; $sisaCls = 'safe'; $sisaLabel = '✓ ' . $item->sisa_hari . ' hari';
            if($item->sisa_hari <= 0) { $rowCls = 'row-d'; $sisaCls = 'dang'; $sisaLabel = '⚠ Lewat batas'; }
            elseif($item->sisa_hari <= 2) { $rowCls = 'row-w'; $sisaCls = 'warn'; $sisaLabel = '⏳ ' . $item->sisa_hari . ' hari'; }
            $badgeCls = $item->status === 'Disimpan' ? 'b-teal' : 'b-amber';
            $dotClr = $item->status === 'Disimpan' ? 'var(--teal)' : 'var(--amber)';
          @endphp

          <tr class="dash-row {{ $rowCls }}" data-nama="{{ strtolower($item->nama_nasabah) }}" data-status="{{ $item->status }}">
            <td><span style="font-family:monospace; color:var(--text2);">{{ $item->nomor_kartu }}</span></td>
            <td><strong>{{ $item->nama_nasabah }}</strong></td>
            <td><span class="tag-chip">{{ $item->lokasi_atm }}</span></td>
            <td style="font-size:12px">{{ $item->lokasi_simpan }}</td>
            <td><span class="cdown {{ $sisaCls }}">{{ $sisaLabel }}</span></td>
            <td><span class="badge {{ $badgeCls }}"><span class="bdot" style="background:{{ $dotClr }}"></span>{{ $item->status }}</span></td>
            <td>
              <div class="dropdown">
                <button class="btn btn-outline btn-sm" onclick="toggleDD(this)">Aksi ▾</button>
                <div class="dropdown-menu">
                  <div class="dd-item" onclick="showModal('hubungi', '{{ $item->nama_nasabah }}', '{{ $item->id }}')">📞 Tandai Dihubungi</div>
                  <div class="dd-item" onclick="showModal('diambil', '{{ $item->nama_nasabah }}', '{{ $item->id }}')">✅ Kartu Diambil</div>
                  <div class="dd-divider"></div>
                  <div class="dd-item danger" onclick="showModal('musnahkan', '{{ $item->nama_nasabah }}', '{{ $item->id }}')">🗑 Musnahkan</div>
                </div>
              </div>
            </td>
          </tr>
        @endforeach
        
        @if(count($kartu) == 0)
        <tr>
          <td colspan="7" style="text-align:center; padding:30px; color:var(--text3);">Semua kartu telah diselesaikan.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

<form id="formAksi" method="POST" style="display: none;">
  @csrf
  <input type="hidden" name="status" id="inputStatus">
</form>

<div class="modal-backdrop" id="modalMain" onclick="closeModal()">
  <div class="modal-box" onclick="event.stopPropagation()">
    <div class="modal-title" id="mTitle">Konfirmasi</div>
    <div class="modal-body" id="mBody">Apakah Anda yakin?</div>
    <div class="modal-footer">
      <button class="btn btn-outline" onclick="closeModal()">Batal</button>
      <button class="btn btn-primary" id="mConfirm" onclick="confirmModal()">Konfirmasi</button>
    </div>
  </div>
</div>

<script>
function toggleDD(btn){
  const menu = btn.nextElementSibling;
  document.querySelectorAll('.dropdown-menu.open').forEach(m => { if(m !== menu) m.classList.remove('open'); });
  menu.classList.toggle('open');
  event.stopPropagation();
}

document.addEventListener('click', () => {
  document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
});

let selectedId = '';
let selectedStatus = '';

function showModal(type, name, id) {
  document.querySelectorAll('.dropdown-menu.open').forEach(m => m.classList.remove('open'));
  selectedId = id;

  const cfg = {
    hubungi: {
      status: 'Dihubungi', 
      title: '📞 Tandai Sudah Dihubungi', 
      body: `Tandai kartu milik <strong>${name}</strong> sudah dihubungi?`, 
      btn: 'Konfirmasi', btnCls: 'btn btn-primary'
    },
    diambil: {
      status: 'Diambil',
      title: '✅ Kartu Diambil Nasabah', 
      body: `Konfirmasi kartu milik <strong>${name}</strong> sudah diambil setelah verifikasi identitas?`, 
      btn: 'Konfirmasi Diambil', btnCls: 'btn btn-primary'
    },
    musnahkan: {
      status: 'Dimusnahkan',
      title: '⚠️ Konfirmasi Pemusnahan', 
      body: `<span style="color:var(--red)">Apakah Anda yakin memusnahkan kartu <strong>${name}</strong>? Tindakan ini <strong>tidak dapat dibatalkan</strong>.</span>`, 
      btn: 'Musnahkan Kartu', btnCls: 'btn btn-danger'
    }
  };
  
  const c = cfg[type];
  selectedStatus = c.status;

  document.getElementById('mTitle').textContent = c.title;
  document.getElementById('mBody').innerHTML = c.body;
  const btn = document.getElementById('mConfirm');
  btn.textContent = c.btn;
  btn.className = c.btnCls;
  
  document.getElementById('modalMain').classList.add('open');
}

function closeModal() {
  document.getElementById('modalMain').classList.remove('open');
}

function confirmModal() {
  document.getElementById('inputStatus').value = selectedStatus;
  const form = document.getElementById('formAksi');
  form.action = `/kartu/${selectedId}/status`;
  form.submit();
}

function filterDashboard() {
  const search = document.getElementById('searchDash').value.toLowerCase();
  const status = document.getElementById('filterDash').value;
  document.querySelectorAll('.dash-row').forEach(row => {
    const rNama = row.getAttribute('data-nama');
    const rStatus = row.getAttribute('data-status');
    const matchSearch = rNama.includes(search);
    const matchStatus = status === '' || rStatus === status;
    row.style.display = (matchSearch && matchStatus) ? '' : 'none';
  });
}
</script>
@endsection