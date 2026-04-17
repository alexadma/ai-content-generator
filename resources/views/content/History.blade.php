<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>History — Inkraft AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #0f0f10;
            --bg-2:      #161618;
            --bg-3:      #1e1e20;
            --bg-4:      #252528;
            --border:    rgba(255,255,255,0.07);
            --border-2:  rgba(255,255,255,0.12);
            --text:      #f2f2f2;
            --text-2:    #8a8a8a;
            --text-3:    #555;
            --accent:    #a78bfa;
            --accent-2:  #7c3aed;
            --accent-bg: rgba(167,139,250,0.08);
            --accent-bd: rgba(167,139,250,0.2);
            --danger:    #f87171;
            --danger-bg: rgba(248,113,113,0.08);
            --danger-bd: rgba(248,113,113,0.2);
            --success:   #4ade80;
            --success-bg:rgba(74,222,128,0.08);
            --nav-w:     240px;
            --font:      'Geist', system-ui, sans-serif;
            --mono:      'Geist Mono', monospace;
            --r:         8px;
            --r-lg:      12px;
            --ease:      0.18s cubic-bezier(0.25,0.46,0.45,0.94);
        }

        html, body { height: 100%; }
        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        a { text-decoration: none; color: inherit; }

        .app { display: flex; height: 100vh; overflow: hidden; }

        /* Sidebar */
        .sidebar {
            width: var(--nav-w);
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sb-header { padding: 16px; border-bottom: 1px solid var(--border); }
        .sb-brand {
            display: flex; align-items: center; gap: 9px;
            font-size: 15px; font-weight: 600; color: var(--text);
            margin-bottom: 12px;
        }
        .sb-logo-mark {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, var(--accent-2), var(--accent));
            border-radius: var(--r);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-logo-mark svg { width: 13px; height: 13px; stroke: #fff; fill: none; }
        .new-btn {
            width: 100%; padding: 8px 11px;
            background: var(--bg-3); border: 1px solid var(--border-2);
            border-radius: var(--r); font-size: 12.5px; font-family: var(--font);
            color: var(--text-2); cursor: pointer;
            display: flex; align-items: center; gap: 7px;
            transition: all var(--ease); text-decoration: none;
        }
        .new-btn:hover { background: var(--bg-4); color: var(--text); }
        .new-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }

        .sb-section {
            padding: 14px 16px 5px;
            font-size: 10.5px; font-weight: 600; letter-spacing: 0.08em;
            text-transform: uppercase; color: var(--text-3);
            font-family: var(--mono);
        }
        .sb-nav-item {
            display: flex; align-items: center; gap: 9px;
            padding: 7px 16px; font-size: 12.5px; color: var(--text-2);
            border-left: 2px solid transparent; transition: all var(--ease);
        }
        .sb-nav-item:hover { background: var(--bg-3); color: var(--text); }
        .sb-nav-item.active { background: var(--accent-bg); color: var(--accent); border-left-color: var(--accent); }
        .sb-nav-item svg { width: 13px; height: 13px; stroke: currentColor; fill: none; flex-shrink: 0; opacity: 0.7; }

        .sb-footer {
            margin-top: auto; border-top: 1px solid var(--border);
            padding: 11px 14px; display: flex; align-items: center; gap: 9px;
            cursor: pointer; transition: background var(--ease); position: relative;
        }
        .sb-footer:hover { background: var(--bg-3); }
        .user-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-2), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .user-name { font-size: 13px; font-weight: 500; color: var(--text); }
        .user-plan { font-size: 11px; color: var(--text-3); }

        /* Profile popup */
        .profile-popup {
            display: none; position: absolute;
            bottom: calc(100% + 6px); left: 10px; right: 10px;
            background: var(--bg-3); border: 1px solid var(--border-2);
            border-radius: var(--r-lg); box-shadow: 0 12px 40px rgba(0,0,0,0.4);
            z-index: 100; overflow: hidden;
            animation: slideUp 0.15s var(--ease) both;
        }
        @keyframes slideUp { from { opacity:0; transform: translateY(8px); } to { opacity:1; transform: translateY(0); } }
        .profile-popup.show { display: block; }
        .pp-user { padding: 14px; border-bottom: 1px solid var(--border); }
        .pp-name { font-size: 13px; font-weight: 600; color: var(--text); }
        .pp-email { font-size: 11px; color: var(--text-3); font-family: var(--mono); }
        .pp-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 14px; font-size: 12.5px; color: var(--text-2);
            cursor: pointer; transition: all var(--ease);
        }
        .pp-item:hover { background: var(--bg-4); color: var(--text); }
        .pp-item.red { color: var(--danger); }
        .pp-item.red:hover { background: var(--danger-bg); }
        .pp-item svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }

        /* Main */
        .main { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; }
        .main-topbar {
            padding: 13px 28px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0; background: var(--bg);
        }
        .topbar-title { font-size: 14px; font-weight: 600; }
        .topbar-sub { font-size: 11px; color: var(--text-3); margin-top: 1px; font-family: var(--mono); }

        .tbtn {
            padding: 6px 12px; font-size: 12px; font-family: var(--font);
            border: 1px solid var(--border-2); border-radius: var(--r);
            background: transparent; color: var(--text-2); cursor: pointer;
            display: flex; align-items: center; gap: 5px; transition: all var(--ease);
            text-decoration: none;
        }
        .tbtn:hover { background: var(--bg-3); color: var(--text); }
        .tbtn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }
        .tbtn-primary { background: var(--accent); border-color: var(--accent); color: #fff; font-weight: 500; }
        .tbtn-primary:hover { background: var(--accent-2); border-color: var(--accent-2); color: #fff; }
        .tbtn-danger { border-color: var(--danger-bd); color: var(--danger); background: var(--danger-bg); }
        .tbtn-danger:hover { background: var(--danger); color: #fff; border-color: var(--danger); }

        /* Content area */
        .content-area {
            flex: 1; overflow-y: auto; padding: 28px;
            scrollbar-width: thin; scrollbar-color: var(--bg-4) transparent;
        }
        .content-area::-webkit-scrollbar { width: 4px; }
        .content-area::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 4px; }

        /* Stats row */
        .stats-row {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 12px; margin-bottom: 24px;
        }
        .stat-card {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: var(--r-lg); padding: 16px 18px;
        }
        .stat-num { font-size: 24px; font-weight: 700; color: var(--accent); letter-spacing: -0.04em; }
        .stat-label { font-size: 11.5px; color: var(--text-3); margin-top: 2px; font-family: var(--mono); }

        /* Filter / search */
        .filter-row {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 20px; flex-wrap: wrap;
        }
        .search-inp {
            flex: 1; min-width: 180px;
            padding: 8px 12px; border: 1px solid var(--border-2);
            border-radius: var(--r); background: var(--bg-2); color: var(--text);
            font-size: 13px; font-family: var(--font); outline: none;
            transition: border-color var(--ease);
        }
        .search-inp:focus { border-color: var(--accent); }
        .search-inp::placeholder { color: var(--text-3); }

        .filter-select {
            padding: 8px 12px; border: 1px solid var(--border-2);
            border-radius: var(--r); background: var(--bg-2); color: var(--text-2);
            font-size: 12.5px; font-family: var(--font); outline: none;
            cursor: pointer; transition: border-color var(--ease);
            -webkit-appearance: none; appearance: none;
        }
        .filter-select:focus { border-color: var(--accent); color: var(--text); }

        /* Table */
        .hist-table-wrap {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: var(--r-lg); overflow: hidden;
        }
        .hist-table { width: 100%; border-collapse: collapse; }
        .hist-table thead tr { border-bottom: 1px solid var(--border); }
        .hist-table th {
            padding: 10px 16px; text-align: left;
            font-size: 10.5px; font-weight: 600; color: var(--text-3);
            text-transform: uppercase; letter-spacing: 0.07em;
            font-family: var(--mono); background: var(--bg-3);
        }
        .hist-table td {
            padding: 12px 16px; border-bottom: 1px solid var(--border);
            font-size: 13px; vertical-align: middle;
        }
        .hist-table tbody tr:last-child td { border-bottom: none; }
        .hist-table tbody tr { transition: background var(--ease); }
        .hist-table tbody tr:hover { background: var(--bg-3); }

        .type-badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px; border-radius: 999px;
            font-size: 10.5px; font-weight: 500;
            font-family: var(--mono);
            background: var(--accent-bg); color: var(--accent);
            border: 1px solid var(--accent-bd);
            white-space: nowrap;
        }
        .topic-text { color: var(--text); font-size: 13px; }
        .topic-sub { color: var(--text-3); font-size: 11px; font-family: var(--mono); margin-top: 2px; }
        .word-count { font-family: var(--mono); font-size: 12px; color: var(--text-2); }
        .date-text { font-family: var(--mono); font-size: 11px; color: var(--text-3); }

        /* Row actions */
        .row-actions { display: flex; gap: 6px; align-items: center; }
        .row-btn {
            padding: 5px 10px; border: 1px solid var(--border-2);
            border-radius: var(--r); background: transparent;
            font-size: 11.5px; font-family: var(--font); font-weight: 500;
            color: var(--text-2); cursor: pointer; transition: all var(--ease);
            display: flex; align-items: center; gap: 5px;
            white-space: nowrap;
        }
        .row-btn:hover { background: var(--bg-3); color: var(--text); }
        .row-btn.del { color: var(--danger); border-color: var(--danger-bd); }
        .row-btn.del:hover { background: var(--danger-bg); }
        .row-btn svg { width: 11px; height: 11px; stroke: currentColor; fill: none; }

        /* Preview modal */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.65); z-index: 999;
            align-items: center; justify-content: center;
            backdrop-filter: blur(4px);
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: var(--bg-2); border: 1px solid var(--border-2);
            border-radius: var(--r-lg); width: 620px; max-width: calc(100vw - 32px);
            max-height: 80vh; display: flex; flex-direction: column;
            box-shadow: 0 32px 80px rgba(0,0,0,0.7);
            animation: modalIn 0.2s cubic-bezier(0.34,1.4,0.64,1) both;
        }
        @keyframes modalIn { from { opacity:0; transform: scale(0.92) translateY(16px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-header {
            padding: 16px 20px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .modal-title { font-size: 14px; font-weight: 600; letter-spacing: -0.02em; }
        .modal-sub { font-size: 11px; color: var(--text-3); font-family: var(--mono); margin-top: 2px; }
        .modal-close {
            width: 28px; height: 28px; border-radius: var(--r);
            border: 1px solid var(--border-2); background: transparent;
            cursor: pointer; color: var(--text-2);
            display: flex; align-items: center; justify-content: center;
            transition: all var(--ease);
        }
        .modal-close:hover { background: var(--bg-3); color: var(--text); }
        .modal-close svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }
        .modal-body { flex: 1; overflow-y: auto; padding: 20px; scrollbar-width: thin; scrollbar-color: var(--bg-4) transparent; }
        .modal-text { font-size: 13px; line-height: 1.85; color: var(--text); white-space: pre-wrap; }
        .modal-footer {
            padding: 12px 20px; border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .modal-word-count { font-size: 11px; color: var(--text-3); font-family: var(--mono); }

        .copy-modal-btn {
            padding: 7px 14px; border: 1px solid var(--border-2);
            border-radius: var(--r); background: var(--bg-3);
            color: var(--text-2); font-size: 12px; font-family: var(--font);
            font-weight: 500; cursor: pointer; transition: all var(--ease);
            display: flex; align-items: center; gap: 6px;
        }
        .copy-modal-btn:hover { background: var(--bg-4); color: var(--text); }
        .copy-modal-btn.copied { background: var(--success-bg); color: var(--success); border-color: rgba(74,222,128,0.2); }
        .copy-modal-btn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }

        /* Delete confirm popup */
        .popup-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.55); z-index: 1000;
            align-items: center; justify-content: center;
            backdrop-filter: blur(3px);
        }
        .popup-overlay.show { display: flex; }
        .popup-box {
            background: var(--bg-2); border: 1px solid var(--border-2);
            border-radius: var(--r-lg); padding: 24px; width: 340px;
            max-width: calc(100vw - 32px);
            box-shadow: 0 24px 64px rgba(0,0,0,0.6);
            animation: popIn 0.18s cubic-bezier(0.34,1.4,0.64,1) both;
        }
        @keyframes popIn { from { opacity:0; transform: scale(0.92) translateY(8px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .popup-icon { width: 40px; height: 40px; border-radius: var(--r); display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .popup-icon.red { background: var(--danger-bg); color: var(--danger); border: 1px solid var(--danger-bd); }
        .popup-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; }
        .popup-title { font-size: 15px; font-weight: 600; color: var(--text); margin-bottom: 6px; letter-spacing: -0.02em; }
        .popup-desc { font-size: 13px; color: var(--text-2); line-height: 1.6; margin-bottom: 20px; }
        .popup-desc strong { color: var(--text); }
        .popup-actions { display: flex; gap: 8px; }
        .popup-btn {
            flex: 1; padding: 9px; border-radius: var(--r); font-size: 13px;
            font-weight: 500; font-family: var(--font); cursor: pointer;
            border: 1px solid var(--border-2); background: var(--bg-3);
            color: var(--text-2); transition: all var(--ease);
        }
        .popup-btn:hover { background: var(--bg-4); color: var(--text); }
        .popup-btn.danger { background: var(--danger); border-color: var(--danger); color: #fff; }
        .popup-btn.danger:hover { filter: brightness(1.1); }

        /* Pagination */
        .pagination-wrap {
            display: flex; justify-content: center; align-items: center;
            gap: 6px; margin-top: 24px; padding-bottom: 8px; flex-wrap: wrap;
        }
        .pagination-wrap a, .pagination-wrap span {
            padding: 6px 10px; border-radius: var(--r);
            font-size: 12px; font-family: var(--mono);
            border: 1px solid var(--border-2); background: var(--bg-2);
            color: var(--text-2); transition: all var(--ease);
        }
        .pagination-wrap a:hover { background: var(--bg-3); color: var(--text); }
        .pagination-wrap .active-page { background: var(--accent-bg); color: var(--accent); border-color: var(--accent-bd); }
        .pagination-wrap .disabled-page { opacity: 0.4; cursor: default; pointer-events: none; }

        /* Empty */
        .empty-hist {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; padding: 64px 32px; gap: 12px; text-align: center;
        }
        .empty-hist-icon { font-size: 32px; margin-bottom: 4px; opacity: 0.5; }
        .empty-hist h3 { font-size: 16px; font-weight: 600; color: var(--text-2); letter-spacing: -0.02em; }
        .empty-hist p { font-size: 13px; color: var(--text-3); max-width: 240px; line-height: 1.7; }

        @media (max-width: 700px) { .sidebar { display: none; } }
        @media (max-width: 900px) { .stats-row { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 600px) {
            .stats-row { grid-template-columns: 1fr; }
            .content-area { padding: 16px; }
            .hist-table th:nth-child(3), .hist-table td:nth-child(3) { display: none; }
        }
    </style>
</head>
<body>
<div class="app">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sb-header">
            <a href="{{ route('dashboard') }}" class="sb-brand">
                <div class="sb-logo-mark">
                    <svg viewBox="0 0 16 16"><path d="M8 1l2 5h5l-4 3 1.5 5L8 11l-4.5 3L5 9 1 6h5z" stroke-width="1.4" stroke-linejoin="round"/></svg>
                </div>
                Inkraft AI
            </a>
            <a href="{{ route('dashboard') }}" class="new-btn">
                <svg viewBox="0 0 16 16"><path d="M8 3v10M3 8h10" stroke-width="1.5" stroke-linecap="round"/></svg>
                New generation
            </a>
        </div>
        <div class="sb-section">Navigation</div>
        <a href="{{ route('dashboard') }}" class="sb-nav-item">
            <svg viewBox="0 0 16 16"><path d="M2 6h5V2H2v4zM9 6h5V2H9v4zM2 14h5v-4H2v4zM9 14h5v-4H9v4z" stroke-width="1.2"/></svg>
            Generator
        </a>
        <a href="{{ route('content.history') }}" class="sb-nav-item active">
            <svg viewBox="0 0 16 16"><circle cx="8" cy="8" r="6" stroke-width="1.2"/><path d="M8 5v3.5L10 10" stroke-width="1.2" stroke-linecap="round"/></svg>
            All History
        </a>

        <div class="sb-footer" onclick="toggleProfilePopup(event)" id="sbFooter">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-plan">Free plan</div>
            </div>
            <div class="profile-popup" id="profilePopup">
                <div class="pp-user">
                    <div class="pp-name">{{ Auth::user()->name }}</div>
                    <div class="pp-email">{{ Auth::user()->email }}</div>
                </div>
                <div class="pp-item" onclick="openDeleteAllModal(event)">
                    <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Hapus semua riwayat
                </div>
                <div class="pp-item red" onclick="event.stopPropagation(); doLogout()">
                    <svg viewBox="0 0 16 16"><path d="M6 2H3a1 1 0 00-1 1v10a1 1 0 001 1h3M11 11l3-3-3-3M14 8H6" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Logout
                </div>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="main">
        <div class="main-topbar">
            <div>
                <div class="topbar-title">Riwayat Generasi</div>
                <div class="topbar-sub">{{ $generations->total() }} total generasi</div>
            </div>
            <div style="display:flex;gap:8px;">
                <button class="tbtn tbtn-danger" onclick="openDeleteAllModal(event)">
                    <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Hapus semua
                </button>
                <a href="{{ route('dashboard') }}" class="tbtn tbtn-primary">
                    <svg viewBox="0 0 16 16"><path d="M8 3v10M3 8h10" stroke-width="1.5" stroke-linecap="round"/></svg>
                    New
                </a>
            </div>
        </div>

        <div class="content-area">
            @if($generations->total() > 0)
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-num">{{ $generations->total() }}</div>
                    <div class="stat-label">Total Generasi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">{{ number_format($generations->sum('word_count')) }}</div>
                    <div class="stat-label">Total Kata</div>
                </div>
                <div class="stat-card">
                    <div class="stat-num">{{ $generations->first()?->created_at->diffForHumans() ?? '—' }}</div>
                    <div class="stat-label">Terakhir Generate</div>
                </div>
            </div>
            @endif

            <div class="filter-row">
                <input type="text" class="search-inp" id="searchInput"
                       placeholder="🔍  Cari topik atau tipe konten..."
                       oninput="filterRows()">
                <select class="filter-select" id="typeFilter" onchange="filterRows()">
                    <option value="">Semua tipe</option>
                    @foreach($generations->unique('content_type') as $gen)
                        <option value="{{ $gen->content_type }}">{{ $gen->content_type }}</option>
                    @endforeach
                </select>
            </div>

            @if($generations->count() > 0)
            <div class="hist-table-wrap">
                <table class="hist-table" id="histTable">
                    <thead>
                        <tr>
                            <th>Topik</th>
                            <th>Tipe</th>
                            <th>Kata</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($generations as $gen)
                        <tr id="row-{{ $gen->id }}"
                            data-topic="{{ strtolower($gen->topic ?? '') }}"
                            data-type="{{ strtolower($gen->content_type) }}">
                            <td>
                                <div class="topic-text">{{ $gen->topic ?: '—' }}</div>
                                @if($gen->tone)
                                    <div class="topic-sub">{{ $gen->tone }} · {{ $gen->audience ?? 'General' }}</div>
                                @endif
                            </td>
                            <td><span class="type-badge">{{ $gen->content_type }}</span></td>
                            <td><span class="word-count">{{ number_format($gen->word_count) }}</span></td>
                            <td>
                                <div class="date-text">{{ $gen->created_at->format('d M Y') }}</div>
                                <div class="date-text">{{ $gen->created_at->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="row-actions">
                                    <button class="row-btn" onclick="previewItem({{ $gen->id }})">
                                        <svg viewBox="0 0 16 16"><path d="M8 3C4 3 1 8 1 8s3 5 7 5 7-5 7-5-3-5-7-5z" stroke-width="1.2"/><circle cx="8" cy="8" r="2" stroke-width="1.2"/></svg>
                                        Lihat
                                    </button>
                                    <button class="row-btn del" onclick="openDeleteOne({{ $gen->id }})">
                                        <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($generations->hasPages())
            <div class="pagination-wrap">
                @if($generations->onFirstPage())
                    <span class="disabled-page">← Prev</span>
                @else
                    <a href="{{ $generations->previousPageUrl() }}">← Prev</a>
                @endif

                @foreach($generations->getUrlRange(1, $generations->lastPage()) as $page => $url)
                    @if($page == $generations->currentPage())
                        <span class="active-page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($generations->hasMorePages())
                    <a href="{{ $generations->nextPageUrl() }}">Next →</a>
                @else
                    <span class="disabled-page">Next →</span>
                @endif
            </div>
            @endif

            @else
            <div class="hist-table-wrap">
                <div class="empty-hist">
                    <div class="empty-hist-icon">📭</div>
                    <h3>Belum ada riwayat</h3>
                    <p>Mulai generate konten pertamamu di halaman Generator.</p>
                    <a href="{{ route('dashboard') }}" style="margin-top:8px;padding:9px 18px;background:var(--accent);color:#fff;border-radius:var(--r);font-size:13px;font-weight:500;">
                        Mulai Generate →
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Preview Modal --}}
<div class="modal-overlay" id="previewOverlay" onclick="closePreviewModal(event)">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <div class="modal-title" id="previewTitle">Preview Konten</div>
                <div class="modal-sub" id="previewSub"></div>
            </div>
            <button class="modal-close" onclick="closePreviewModal()">
                <svg viewBox="0 0 16 16"><path d="M4 4l8 8M12 4l-8 8" stroke-width="1.4" stroke-linecap="round"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-text" id="previewContent">Memuat...</div>
        </div>
        <div class="modal-footer">
            <span class="modal-word-count" id="previewWords"></span>
            <button class="copy-modal-btn" id="copyModalBtn" onclick="copyPreviewContent()">
                <svg viewBox="0 0 16 16"><rect x="5" y="5" width="9" height="9" rx="1.5" stroke-width="1.2"/><path d="M5 5V3.5A1.5 1.5 0 016.5 2H12a1.5 1.5 0 011.5 1.5v6A1.5 1.5 0 0112 11H10.5" stroke-width="1.2" stroke-linecap="round"/></svg>
                Salin konten
            </button>
        </div>
    </div>
</div>

{{-- Delete ALL popup --}}
<div class="popup-overlay" id="deleteAllOverlay" onclick="closeDeleteAllModal(event)">
    <div class="popup-box">
        <div class="popup-icon red">
            <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="popup-title">Hapus semua riwayat?</div>
        <div class="popup-desc">Tindakan ini akan <strong>menghapus semua</strong> riwayat generasi konten kamu secara permanen.</div>
        <div class="popup-actions">
            <button class="popup-btn" onclick="document.getElementById('deleteAllOverlay').classList.remove('show')">Batal</button>
            <button class="popup-btn danger" id="confirmDeleteAll" onclick="deleteAllHistory()">Ya, hapus semua</button>
        </div>
    </div>
</div>

{{-- Delete ONE popup --}}
<div class="popup-overlay" id="deleteOneOverlay" onclick="closeDeleteOneModal(event)">
    <div class="popup-box">
        <div class="popup-icon red">
            <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="popup-title">Hapus generasi ini?</div>
        <div class="popup-desc">Konten ini akan dihapus permanen. Riwayat lainnya tidak terpengaruh.</div>
        <div class="popup-actions">
            <button class="popup-btn" onclick="document.getElementById('deleteOneOverlay').classList.remove('show')">Batal</button>
            <button class="popup-btn danger" onclick="confirmDeleteOne()">Ya, hapus</button>
        </div>
    </div>
</div>

<form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>

<script>
const HISTORY_BASE    = @json(url('/history'));
const DESTROY_ALL_URL = @json(route('content.destroy-all'));
const CSRF            = document.querySelector('meta[name="csrf-token"]')?.content || '';

let previewCurrentContent = '';
let deleteTargetId        = null;

// ── Filter ─────────────────────────────────────────────────────────────────
function filterRows() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const type   = document.getElementById('typeFilter').value.toLowerCase();
    document.querySelectorAll('#histTable tbody tr').forEach(row => {
        const topic = row.dataset.topic || '';
        const rType = row.dataset.type  || '';
        const matchSearch = !search || topic.includes(search) || rType.includes(search);
        const matchType   = !type   || rType === type;
        row.style.display = (matchSearch && matchType) ? '' : 'none';
    });
}

// ── Preview ────────────────────────────────────────────────────────────────
async function previewItem(id) {
    document.getElementById('previewOverlay').classList.add('show');
    document.getElementById('previewContent').textContent = 'Memuat...';
    document.getElementById('previewTitle').textContent   = 'Preview Konten';
    document.getElementById('previewSub').textContent     = '';
    document.getElementById('previewWords').textContent   = '';

    try {
        const res  = await fetch(`${HISTORY_BASE}/${id}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        if (!data.success) throw new Error();
        previewCurrentContent = data.content;
        document.getElementById('previewContent').textContent = data.content;
        document.getElementById('previewTitle').textContent   = data.meta.content_type;
        document.getElementById('previewSub').textContent     = (data.meta.topic ? `${data.meta.topic} · ` : '') + data.meta.created_at;
        document.getElementById('previewWords').textContent   = data.meta.word_count + ' kata';
    } catch {
        document.getElementById('previewContent').textContent = 'Gagal memuat konten.';
    }
}
function closePreviewModal(e) {
    if (e && e.target !== document.getElementById('previewOverlay')) return;
    document.getElementById('previewOverlay').classList.remove('show');
}

// ── Copy preview ───────────────────────────────────────────────────────────
function copyPreviewContent() {
    if (!previewCurrentContent) return;
    navigator.clipboard.writeText(previewCurrentContent).then(() => {
        const btn = document.getElementById('copyModalBtn');
        btn.classList.add('copied');
        btn.innerHTML = `<svg viewBox="0 0 16 16" width="12" height="12" style="stroke:currentColor;fill:none"><path d="M2 8l4 4 8-8" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg> Tersalin!`;
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = `<svg viewBox="0 0 16 16" width="12" height="12" style="stroke:currentColor;fill:none"><rect x="5" y="5" width="9" height="9" rx="1.5" stroke-width="1.2"/><path d="M5 5V3.5A1.5 1.5 0 016.5 2H12a1.5 1.5 0 011.5 1.5v6A1.5 1.5 0 0112 11H10.5" stroke-width="1.2" stroke-linecap="round"/></svg> Salin konten`;
        }, 2500);
    });
}

// ── Delete ONE ─────────────────────────────────────────────────────────────
function openDeleteOne(id) {
    deleteTargetId = id;
    document.getElementById('deleteOneOverlay').classList.add('show');
}
function closeDeleteOneModal(e) {
    if (e && e.target !== document.getElementById('deleteOneOverlay')) return;
    document.getElementById('deleteOneOverlay').classList.remove('show');
}
async function confirmDeleteOne() {
    if (!deleteTargetId) return;
    try {
        const res = await fetch(`${HISTORY_BASE}/${deleteTargetId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (!data.success) throw new Error();
        const row = document.getElementById(`row-${deleteTargetId}`);
        if (row) row.remove();
        document.getElementById('deleteOneOverlay').classList.remove('show');
        deleteTargetId = null;
    } catch { alert('Gagal menghapus.'); }
}

// ── Delete ALL ─────────────────────────────────────────────────────────────
function openDeleteAllModal(e) {
    if (e) e.stopPropagation();
    document.getElementById('profilePopup')?.classList.remove('show');
    document.getElementById('deleteAllOverlay').classList.add('show');
}
function closeDeleteAllModal(e) {
    if (e && e.target !== document.getElementById('deleteAllOverlay')) return;
    document.getElementById('deleteAllOverlay').classList.remove('show');
}
async function deleteAllHistory() {
    const btn = document.getElementById('confirmDeleteAll');
    btn.disabled = true; btn.textContent = 'Menghapus...';
    try {
        const res = await fetch(DESTROY_ALL_URL, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (!data.success) throw new Error();
        window.location.reload();
    } catch {
        alert('Gagal menghapus. Coba lagi.');
        btn.disabled = false; btn.textContent = 'Ya, hapus semua';
    }
}

// ── Profile popup ──────────────────────────────────────────────────────────
function toggleProfilePopup(e) {
    e.stopPropagation();
    document.getElementById('profilePopup').classList.toggle('show');
}
document.addEventListener('click', () => {
    document.getElementById('profilePopup')?.classList.remove('show');
});

function doLogout() { document.getElementById('logoutForm').submit(); }
</script>
</body>
</html>