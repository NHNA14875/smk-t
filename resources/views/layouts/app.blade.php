<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>@yield('title') — SMK-T</title>
<style>
/* CSS VARIABEL & ELEMEN UTAMA */
*{margin:0;padding:0;box-sizing:border-box;-webkit-tap-highlight-color:transparent}
:root{
  --bg:#f5f6fa;--bg2:#ffffff;--bg3:#f0f1f5;
  --text:#1a1d2e;--text2:#6b7280;--text3:#9ca3af;
  --border:#e5e7eb;--border2:#d1d5db;
  --teal:#0f9e74;--teal2:#0d8a64;--teal-light:#e6f7f2;--teal-dim:rgba(15,158,116,0.1);
  --blue:#1a6fbf;--blue-light:#e8f1fb;
  --amber:#c47b00;--amber-light:#fff3d0;
  --red:#dc3545;--red-light:#fde8ea;
  --green:#1a7a45;--green-light:#e6f4ec;
  --purple:#5b3fa6;--purple-light:#ede9fc;
  --shadow:0 1px 4px rgba(0,0,0,0.08);
  --shadow2:0 4px 20px rgba(0,0,0,0.12);
  --radius:10px;
  --font:'Segoe UI',system-ui,sans-serif;
}

body{font-family:var(--font);background:var(--bg);color:var(--text);font-size:14px;overflow-x:hidden}

#appScreen{display:flex; flex-direction:row; min-height:100vh;}

/* SIDEBAR */
.sidebar{width:220px;background:var(--bg2);border-right:1px solid var(--border);display:flex;flex-direction:column;flex-shrink:0;z-index:200}
.sidebar-head{padding:16px 14px 12px;border-bottom:1px solid var(--border)}
.s-brand{display:flex;align-items:center;gap:9px}
.s-icon{width:32px;height:32px;background:var(--teal);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;color:white}
.s-title{font-size:14px;font-weight:700}
.s-sub{font-size:10px;color:var(--text3);letter-spacing:.5px}
.s-nav{flex:1;padding:10px 8px;overflow-y:auto}
.s-section{font-size:10px;font-weight:600;color:var(--text3);padding:8px 8px 4px;text-transform:uppercase}
.s-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:8px;color:var(--text2);font-size:13px;font-weight:500;text-decoration:none;margin-bottom:2px}
.s-item:hover{background:var(--bg3);color:var(--text)}
.s-item.active{background:var(--teal-dim);color:var(--teal)}
.s-foot{padding:10px 8px;border-top:1px solid var(--border)}
.s-user{display:flex;align-items:center;gap:9px;padding:8px;border-radius:8px;cursor:pointer}
.s-avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px}

/* MAIN CONTENT */
.main{flex:1;display:flex;flex-direction:column;min-width:0;overflow:hidden}
.topbar{height:52px;background:var(--bg2);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 16px;flex-shrink:0}
.topbar-title{font-size:15px;font-weight:700;flex:1}
.content{flex:1;overflow-y:auto;padding:20px 16px} /* Scroll bar muncul di sini saja */

@media(max-width:768px){
  .sidebar{position:fixed;left:0;top:0;bottom:0;transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
}
</style>
</head>
<body>

<div id="appScreen">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-head">
      <div class="s-brand">
        <div class="s-icon">💳</div>
        <div>
          <div class="s-title">SMK-T</div>
          <div class="s-sub">MONITORING KARTU ATM</div>
        </div>
      </div>
    </div>
    
    <nav class="s-nav">
      <div class="s-section">Menu Utama</div>
      <a href="{{ url('/dashboard') }}" class="s-item {{ Request::is('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
      <a href="{{ url('/input') }}" class="s-item {{ Request::is('input') ? 'active' : '' }}">➕ Input Kartu</a>
      
      <div class="s-section">Data & Laporan</div>
      <a href="{{ url('/arsip') }}" class="s-item {{ Request::is('arsip') ? 'active' : '' }}">📁 Arsip Riwayat</a>
      <a href="{{ url('/rekap') }}" class="s-item {{ Request::is('rekap') ? 'active' : '' }}">📈 Rekap Mingguan</a>
    </nav>

    <div class="s-foot">
      <a href="{{ url('/logout') }}" style="text-decoration:none; color:inherit;">
        <div class="s-user">
          <div class="s-avatar" style="background:var(--teal-light); color:var(--teal);">{{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}</div>
          <div>
            <div style="font-size:12px;font-weight:600">{{ Auth::user()->nama }}</div>
            <div style="font-size:10px;color:var(--text3)">{{ strtoupper(Auth::user()->role) }} · Keluar</div>
          </div>
        </div>
      </a>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">@yield('title')</div>
      <div id="todayDate" style="font-size:11px; color:var(--text3)"></div>
    </div>

    <div class="content">
      @yield('content')
    </div>
  </div>
</div>

<script>
  function formatDate(d){
    const m=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    return d.getDate()+' '+m[d.getMonth()]+' '+d.getFullYear();
  }
  document.getElementById('todayDate').textContent = formatDate(new Date());
</script>

</body>
</html>