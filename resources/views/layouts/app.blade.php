<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>@yield('title') — SMK-T</title>
<style>
/* ===== SEMUA CSS VARIABEL & ELEMEN UTAMA DARI PROTOTYPE ===== */
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
  --gray-light:#f8f9fa;
  --shadow:0 1px 4px rgba(0,0,0,0.08);
  --shadow2:0 4px 20px rgba(0,0,0,0.12);
  --radius:10px;--radius-lg:14px;
  --font:'Segoe UI',system-ui,sans-serif;
}
body{font-family:var(--font);background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;overflow-x:hidden}

/* ===== UTILITI UTAMA ===== */
.hide{display:none!important}
.show{display:flex!important}
.text-muted{color:var(--text2)}
.text-small{font-size:12px}
.fw-bold{font-weight:600}

.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:11px 18px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;border:1.5px solid transparent;font-family:var(--font);transition:all .15s;text-decoration:none;white-space:nowrap}
.btn-primary{background:var(--teal);color:#fff;border-color:var(--teal)}
.btn-primary:hover{background:var(--teal2);border-color:var(--teal2)}
.btn-primary:active{transform:scale(.98)}
.btn-outline{background:transparent;color:var(--text);border-color:var(--border2)}
.btn-outline:hover{background:var(--bg3)}
.btn-danger{background:var(--red-light);color:var(--red);border-color:rgba(220,53,69,.2)}
.btn-danger:hover{background:rgba(220,53,69,.15)}
.btn-sm{padding:7px 12px;font-size:12px;gap:5px}

/* ===== STRUKTUR TATA LETAK SISI KIRI (SIDEBAR) ===== */
#appScreen{display:flex; flex-direction:row; min-height:100vh;}
.sidebar{width:220px;background:var(--bg2);border-right:1px solid var(--border);flex-direction:column;display:flex;flex-shrink:0;transition:transform .25s;z-index:200}
.sidebar-head{padding:16px 14px 12px;border-bottom:1px solid var(--border)}
.s-brand{display:flex;align-items:center;gap:9px}
.s-icon{width:32px;height:32px;background:var(--teal);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}
.s-title{font-size:14px;font-weight:700}
.s-sub{font-size:10px;color:var(--text3);letter-spacing:.5px}
.s-nav{flex:1;padding:10px 8px;overflow-y:auto}
.s-section{font-size:10px;font-weight:600;color:var(--text3);letter-spacing:.8px;padding:8px 8px 4px;text-transform:uppercase}
.s-item{display:flex;align-items:center;gap:9px;padding:9px 10px;border-radius:8px;cursor:pointer;color:var(--text2);font-size:13px;font-weight:500;margin-bottom:1px;border:1.5px solid transparent;transition:all .15s;text-decoration:none;position:relative}
.s-item:hover{background:var(--bg3);color:var(--text)}
.s-item.active{background:var(--teal-dim);color:var(--teal);border-color:rgba(15,158,116,.15)}
.s-item .ico{font-size:16px;width:18px;text-align:center;flex-shrink:0}
.s-foot{padding:10px 8px;border-top:1px solid var(--border)}
.s-user{display:flex;align-items:center;gap:9px;padding:8px;border-radius:8px;cursor:pointer}
.s-user:hover{background:var(--bg3)}
.s-avatar{width:32px;height:32px;border-radius:50%;font-size:12px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.s-uname{font-size:12px;font-weight:600}
.s-urole{font-size:10px;color:var(--text3)}

/* ===== BAGIAN KONTEN UTAMA ===== */
.main{flex:1;display:flex;flex-direction:column;overflow:hidden;min-width:0}
.topbar{height:52px;background:var(--bg2);border-bottom:1px solid var(--border);display:flex;align-items:center;padding:0 16px;gap:12px;flex-shrink:0}
.topbar-menu{display:none;background:none;border:none;font-size:22px;cursor:pointer;color:var(--text);padding:4px}
.topbar-title{font-size:15px;font-weight:700;flex:1}
.topbar-right{display:flex;align-items:center;gap:8px}
.topbar-date{font-size:11px;color:var(--text3)}
.content{flex:1;overflow-y:auto;padding:20px 16px}

/* ===== OVERLAY RESPONSID LAYAR HP ===== */
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:190}
.sidebar-overlay.open{display:block}

/* ===== RESPONSIVITAS MOBILE ===== */
@media(max-width:768px){
  .sidebar{position:fixed;left:0;top:0;bottom:0;transform:translateX(-100%);box-shadow:var(--shadow2)}
  .sidebar.open{transform:translateX(0)}
  .topbar-menu{display:block}
  .topbar-date{display:none}
  .content{padding:14px 12px}
}
</style>
</head>
<body>

<div id="appScreen">
  <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

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
      
      @if(Auth::user()->role === 'cs' || Auth::user()->role === 'admin')
      <a href="{{ url('/dashboard') }}" class="s-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <span class="ico">📊</span> Dashboard
      </a>
      @endif
      
      <a href="{{ url('/input') }}" class="s-item {{ Request::is('input') ? 'active' : '' }}">
        <span class="ico">➕</span> Input Kartu
      </a>

      @if(Auth::user()->role === 'cs' || Auth::user()->role === 'admin')
      <div class="s-section" style="margin-top:10px;">Data & Laporan</div>
      
      <a href="{{ url('/arsip') }}" class="s-item {{ Request::is('arsip') ? 'active' : '' }}">
        <span class="ico">📁</span> Arsip Riwayat
      </a>
      
      <a href="{{ url('/rekap') }}" class="s-item {{ Request::is('rekap') ? 'active' : '' }}">
        <span class="ico">📈</span> Rekap Mingguan
      </a>
      @endif

      @if(Auth::user()->role === 'admin')
      <div class="s-section" style="margin-top:10px;">Pengaturan</div>
      <a href="{{ url('/akun') }}" class="s-item {{ Request::is('akun') ? 'active' : '' }}">
        <span class="ico">👥</span> Manajemen Akun
      </a>
      @endif
    </nav>

    <div class="s-foot">
      <a href="{{ url('/logout') }}" style="text-decoration:none; color:inherit;">
        <div class="s-user" title="Ketuk untuk keluar">
          @php
            // Penentuan skema warna avatar secara visual sesuai peran di basis data
            $avatarBg = 'var(--teal-light)'; $avatarColor = 'var(--teal)';
            if(Auth::user()->role === 'cs') { $avatarBg = 'var(--purple-light)'; $avatarColor = 'var(--purple)'; }
            elseif(Auth::user()->role === 'admin') { $avatarBg = 'var(--amber-light)'; $avatarColor = 'var(--amber)'; }
          @endphp
          <div class="s-avatar" style="background:{{ $avatarBg }}; color:{{ $avatarColor }};">
            {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
          </div>
          <div>
            <div class="s-uname">{{ Auth::user()->nama }}</div>
            <div class="s-urole">{{ strtoupper(Auth::user()->role) }} · Keluar</div>
          </div>
        </div>
      </a>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <button class="topbar-menu" onclick="openSidebar()">☰</button>
      <div class="topbar-title" id="topTitle">@yield('title')</div>
      <div class="topbar-right">
        <span class="topbar-date" id="todayDate"></span>
      </div>
    </div>

    <div class="content">
      @yield('content')
    </div>
  </div>
</div>

<script>
  function openSidebar(){
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebarOverlay').classList.add('open');
  }
  function closeSidebar(){
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('open');
  }

  // Format Penulisan Tanggal Otomatis di Batang Atas (Topbar)
  function formatDate(d){
    const m=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    return d.getDate()+' '+m[d.getMonth()]+' '+d.getFullYear();
  }
  document.getElementById('todayDate').textContent = formatDate(new Date());
</script>

</body>
</html>