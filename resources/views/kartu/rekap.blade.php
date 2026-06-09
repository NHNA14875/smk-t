@extends('layouts.app')

@section('title', 'Rekap Mingguan')

@section('content')
<div class="page-hdr">
  <div>
    <div class="page-title">Rekap Mingguan</div>
    <div class="page-sub">Ringkasan operasional kartu ATM tertelan.</div>
  </div>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(130px,1fr)); gap:12px; margin-bottom:18px;">
  <div style="background:var(--bg2); border:1px solid var(--border); border-radius:var(--radius); padding:14px; position:relative; overflow:hidden;">
    <div style="position:absolute; top:0; left:0; right:0; height:3px; background:var(--teal);"></div>
    <div style="font-size:20px; margin-bottom:8px;">📥</div>
    <div style="font-size:26px; font-weight:700; line-height:1; color:var(--text);">{{ $stats->masuk }}</div>
    <div style="font-size:11px; color:var(--text2); margin-top:3px;">Masuk minggu ini</div>
  </div>
  
  <div style="background:var(--bg2); border:1px solid var(--border); border-radius:var(--radius); padding:14px; position:relative; overflow:hidden;">
    <div style="position:absolute; top:0; left:0; right:0; height:3px; background:var(--green);"></div>
    <div style="font-size:20px; margin-bottom:8px;">🤝</div>
    <div style="font-size:26px; font-weight:700; line-height:1; color:var(--text);">{{ $stats->diambil }}</div>
    <div style="font-size:11px; color:var(--text2); margin-top:3px;">Diambil nasabah</div>
  </div>

  <div style="background:var(--bg2); border:1px solid var(--border); border-radius:var(--radius); padding:14px; position:relative; overflow:hidden;">
    <div style="position:absolute; top:0; left:0; right:0; height:3px; background:var(--red);"></div>
    <div style="font-size:20px; margin-bottom:8px;">✂️</div>
    <div style="font-size:26px; font-weight:700; line-height:1; color:var(--text);">{{ $stats->dimusnahkan }}</div>
    <div style="font-size:11px; color:var(--text2); margin-top:3px;">Dimusnahkan</div>
  </div>
</div>

<div style="display:grid; grid-template-columns:minmax(0,2fr) minmax(0,1fr); gap:16px;">
  
  <div class="card" style="padding:16px; margin-bottom:0;">
    <div class="card-title" style="margin-bottom:14px; font-weight:700;">Frekuensi per Mesin ATM</div>
    
    <div style="display:flex; flex-direction:column; gap:10px;">
      @foreach($grafikAtm as $atm)
        <div style="display:flex; align-items:center; gap:10px;">
          <div style="font-size:12px; color:var(--text2); width:110px; flex-shrink:0;">{{ $atm->nama }}</div>
          
          <div style="flex:1; height:8px; background:var(--bg3); border-radius:4px; overflow:hidden;">
            <div style="height:100%; border-radius:4px; transition:width 0.6s ease; width:{{ $atm->persentase }}%; background:{{ $atm->warna }};"></div>
          </div>
          
          <div style="font-size:12px; font-family:'Courier New',monospace; color:var(--text2); width:20px; text-align:right;">{{ $atm->jumlah }}</div>
        </div>
      @endforeach
    </div>
    
    <div style="margin-top:12px; padding-top:12px; border-top:1px solid var(--border); font-size:12px; color:var(--text2);">
      💡 <strong>{{ $grafikAtm[0]->nama }}</strong> paling sering bermasalah — pertimbangkan perawatan rutin.
    </div>
  </div>

  <div class="card" style="padding:16px; margin-bottom:0;">
    <div class="card-title" style="margin-bottom:14px; font-weight:700;">Rata-rata Penanganan</div>
    
    <div style="text-align:center; padding:16px 0;">
      <div style="font-size:44px; font-weight:700; color:var(--teal); font-family:'Courier New',monospace;">{{ $waktu->rata_rata }}</div>
      <div style="font-size:13px; color:var(--text2); margin-top:4px;">hari rata-rata</div>
    </div>
    
    <div style="border-top:1px solid var(--border); padding-top:12px; display:flex; flex-direction:column; gap:8px;">
      <div style="display:flex; justify-content:space-between; font-size:12px;">
        <span style="color:var(--text2);">Tercepat</span>
        <span style="color:var(--green); font-family:'Courier New',monospace; font-weight:600;">{{ $waktu->tercepat }} hari</span>
      </div>
      <div style="display:flex; justify-content:space-between; font-size:12px;">
        <span style="color:var(--text2);">Terlama</span>
        <span style="color:var(--red); font-family:'Courier New',monospace; font-weight:600;">{{ $waktu->terlama }} hari</span>
      </div>
      <div style="display:flex; justify-content:space-between; font-size:12px;">
        <span style="color:var(--text2);">Target SOP</span>
        <span style="color:var(--amber); font-family:'Courier New',monospace; font-weight:600;">&lt; 7 hari</span>
      </div>
    </div>
  </div>
  
</div>

<style>
@media(max-width:768px){
  div[style*="grid-template-columns:minmax(0,2fr)"] {
    grid-template-columns: 1fr !important;
  }
}
</style>
@endsection