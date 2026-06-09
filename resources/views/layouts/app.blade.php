<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title') — SMK-T</title>
<style>
/* CSS Reset & Variabel */
*{margin:0;padding:0;box-sizing:border-box}
:root{
  --bg:#f5f6fa;--bg2:#ffffff;--text:#1a1d2e;--text2:#6b7280;
  --teal:#0f9e74;--teal-dim:rgba(15,158,116,0.1);
  --shadow:0 1px 4px rgba(0,0,0,0.08);
}
body, html { height: 100%; font-family: 'Segoe UI', sans-serif; }

/* Layout Utama */
#appScreen { display: flex; height: 100vh; overflow: hidden; }

/* Sidebar */
.sidebar { width: 220px; background: var(--bg2); border-right: 1px solid #e5e7eb; display: flex; flex-direction: column; flex-shrink: 0; }
.sidebar-head { padding: 20px 16px; border-bottom: 1px solid #e5e7eb; }
.s-nav { flex: 1; padding: 10px 8px; overflow-y: auto; }
.s-item { display: flex; align-items: center; gap: 10px; padding: 10px; color: var(--text2); text-decoration: none; font-size: 13px; font-weight: 500; border-radius: 8px; margin-bottom: 4px; }
.s-item:hover, .s-item.active { background: var(--teal-dim); color: var(--teal); }
.s-foot { padding: 16px; border-top: 1px solid #e5e7eb; }

/* Main Content */
.main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
.topbar { height: 60px; display: flex; align-items: center; padding: 0 20px; background: white; border-bottom: 1px solid #e5e7eb; }
.content { flex: 1; overflow-y: auto; padding: 20px; background: var(--bg); }

/* Utility */
.s-avatar { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; margin-right: 10px; }
</style>
</head>
<body>

<div id="appScreen">
  <aside class="sidebar">
    <div class="sidebar-head">
      <div style="font-weight:700;">SMK-T</div>
      <div style="font-size:10px; color:var(--text2);">MONITORING KARTU ATM</div>
    </div>
    
    <nav class="s-nav">
      <div style="font-size:10px; color:var(--text2); padding:10px;">MENU UTAMA</div>
      <a href="{{ url('/dashboard') }}" class="s-item {{ Request::is('dashboard') ? 'active' : '' }}">📊 Dashboard</a>
      <a href="{{ url('/input') }}" class="s-item {{ Request::is('input') ? 'active' : '' }}">➕ Input Kartu</a>
      
      <div style="font-size:10px; color:var(--text2); padding:10px; margin-top:10px;">DATA & LAPORAN</div>
      <a href="{{ url('/arsip') }}" class="s-item {{ Request::is('arsip') ? 'active' : '' }}">📁 Arsip Riwayat</a>
      <a href="{{ url('/rekap') }}" class="s-item {{ Request::is('rekap') ? 'active' : '' }}">📈 Rekap Mingguan</a>

      {{-- Perbaikan: Gunakan strtolower agar tidak case-sensitive --}}
      @if(strtolower(Auth::user()->role) === 'admin')
      <div style="font-size:10px; color:var(--text2); padding:10px; margin-top:10px;">PENGATURAN</div>
      <a href="{{ url('/akun') }}" class="s-item {{ Request::is('akun') ? 'active' : '' }}">👥 Manajemen Akun</a>
      @endif
    </nav>

    <div class="s-foot">
      <a href="{{ url('/logout') }}" style="text-decoration:none; color:inherit;">
        <div style="display:flex; align-items:center;">
          <div class="s-avatar" style="background:var(--teal-dim); color:var(--teal);">{{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}</div>
          <div style="font-size:12px;">
            <div style="font-weight:600">{{ Auth::user()->nama }}</div>
            <div style="font-size:10px; color:var(--text2)">{{ strtoupper(Auth::user()->role) }} · Keluar</div>
          </div>
        </div>
      </a>
    </div>
  </aside>

  <main class="main">
    <header class="topbar">
      <div style="font-weight:700;">@yield('title')</div>
    </header>
    <div class="content">
      @yield('content')
    </div>
  </main>
</div>

</body>
</html>