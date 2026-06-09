@extends('layouts.app')

@section('title', 'Rekap Mingguan')

@section('content')
<div class="page-hdr">
  <div>
    <div class="page-title">Rekap Mingguan</div>
    <div class="page-sub">Ringkasan operasional kartu ATM tertelan.</div>
  </div>
</div>

<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card teal">
    <div class="stat-ico">📥</div>
    <div class="stat-val">{{ $stats->masuk }}</div>
    <div class="stat-lbl">Masuk minggu ini</div>
  </div>
  <div class="stat-card green">
    <div class="stat-ico">🤝</div>
    <div class="stat-val">{{ $stats->diambil }}</div>
    <div class="stat-lbl">Diambil nasabah</div>
  </div>
  <div class="stat-card red">
    <div class="stat-ico">✂️</div>
    <div class="stat-val">{{ $stats->dimusnahkan }}</div>
    <div class="stat-lbl">Dimusnahkan</div>
  </div>
</div>

<div class="rekap-grid">
  <div class="card" style="padding:16px;margin-bottom:0">
    <div class="card-title" style="margin-bottom:14px">Frekuensi per Mesin ATM</div>
    <div class="bar-chart">
      @foreach($grafikAtm as $atm)
      <div class="bar-item">
        <div class="bar-label">{{ $atm->nama }}</div>
        <div class="bar-track">
          <div class="bar-fill" style="width:{{ $atm->persentase }}%;background:{{ $atm->warna }}"></div>
        </div>
        <div class="bar-val">{{ $atm->jumlah }}</div>
      </div>
      @endforeach
    </div>
    @if(count($grafikAtm) > 0)
    <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--border);font-size:12px;color:var(--text2)">
      💡 <strong>{{ $grafikAtm[0]->nama }}</strong> paling sering bermasalah — pertimbangkan perawatan rutin.
    </div>
    @endif
  </div>

  <div class="card" style="padding:16px;margin-bottom:0">
    <div class="card-title" style="margin-bottom:14px">Rata-rata Penanganan</div>
    <div style="text-align:center;padding:16px 0">
      <div style="font-size:44px;font-weight:700;color:var(--teal);font-family:'Courier New',monospace">{{ $waktu->rata_rata }}</div>
      <div style="font-size:13px;color:var(--text2);margin-top:4px">hari rata-rata</div>
    </div>
    <div style="border-top:1px solid var(--border);padding-top:12px;display:flex;flex-direction:column;gap:8px">
      <div style="display:flex;justify-content:space-between;font-size:12px">
        <span style="color:var(--text2)">Tercepat</span>
        <span style="color:var(--green);font-family:'Courier New',monospace;font-weight:600">{{ $waktu->tercepat }} hari</span>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:12px">
        <span style="color:var(--text2)">Terlama</span>
        <span style="color:var(--red);font-family:'Courier New',monospace;font-weight:600">{{ $waktu->terlama }} hari</span>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:12px">
        <span style="color:var(--text2)">Target SOP</span>
        <span style="color:var(--amber);font-family:'Courier New',monospace;font-weight:600">&lt; 7 hari</span>
      </div>
    </div>
  </div>
</div>
@endsection