<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inkraft — AI Content Generator</title>
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
            --nav-w:     260px;
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

        /* ── App shell ── */
        .app { display: flex; height: 100vh; overflow: hidden; }

        /* ══════════════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════════════ */
        .sidebar {
            width: var(--nav-w);
            background: var(--bg-2);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow: hidden;
        }

        .sb-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }
        .sb-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 15px;
            font-weight: 600;
            color: var(--text);
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
            width: 100%;
            padding: 8px 11px;
            background: var(--bg-3);
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            font-size: 12.5px;
            font-family: var(--font);
            color: var(--text-2);
            cursor: pointer;
            display: flex; align-items: center; gap: 7px;
            transition: all var(--ease);
        }
        .new-btn:hover { background: var(--bg-4); color: var(--text); border-color: var(--border-2); }
        .new-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; flex-shrink: 0; }

        .sb-scroll {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: var(--bg-4) transparent;
        }
        .sb-scroll::-webkit-scrollbar { width: 4px; }
        .sb-scroll::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 4px; }

        .sb-section {
            padding: 14px 16px 5px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-3);
            font-family: var(--mono);
        }

        /* History item */
        .sb-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 12px 7px 16px;
            font-size: 12.5px;
            color: var(--text-2);
            cursor: pointer;
            border-left: 2px solid transparent;
            transition: all var(--ease);
            position: relative;
            user-select: none;
        }
        .sb-item:hover { background: var(--bg-3); color: var(--text); }
        .sb-item.active { background: var(--accent-bg); color: var(--accent); border-left-color: var(--accent); }

        .sb-item-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .sb-item-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 12px;
        }
        .sb-item-time {
            font-size: 10px;
            color: var(--text-3);
            flex-shrink: 0;
            font-family: var(--mono);
        }

        /* Three-dot menu on history item */
        .sb-item-more {
            width: 22px; height: 22px;
            border-radius: 5px;
            border: none;
            background: transparent;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-3);
            transition: all var(--ease);
            flex-shrink: 0;
            font-size: 15px;
            letter-spacing: 0;
            padding: 0;
        }
        .sb-item:hover .sb-item-more { display: flex; }
        .sb-item-more:hover { background: var(--bg-4); color: var(--text-2); }

        /* Nav links */
        .sb-nav-item {
            display: flex; align-items: center; gap: 9px;
            padding: 7px 16px;
            font-size: 12.5px;
            color: var(--text-2);
            border-left: 2px solid transparent;
            transition: all var(--ease);
        }
        .sb-nav-item:hover { background: var(--bg-3); color: var(--text); }
        .sb-nav-item.active { background: var(--accent-bg); color: var(--accent); border-left-color: var(--accent); }
        .sb-nav-item svg { width: 13px; height: 13px; stroke: currentColor; fill: none; flex-shrink: 0; opacity: 0.7; }

        /* Footer / profile */
        .sb-footer {
            margin-top: auto;
            border-top: 1px solid var(--border);
            padding: 11px 14px;
            display: flex; align-items: center; gap: 9px;
            cursor: pointer;
            transition: background var(--ease);
            position: relative;
            flex-shrink: 0;
        }
        .sb-footer:hover { background: var(--bg-3); }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-2), var(--accent));
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            letter-spacing: 0.02em;
        }
        .user-name { font-size: 13px; font-weight: 500; color: var(--text); line-height: 1.3; }
        .user-plan { font-size: 11px; color: var(--text-3); }
        .sb-footer-arrow { margin-left: auto; color: var(--text-3); font-size: 11px; }

        /* ══════════════════════════════════════════════════
           MAIN
        ══════════════════════════════════════════════════ */
        .main { flex: 1; display: flex; flex-direction: column; min-width: 0; background: var(--bg); }

        /* Topbar */
        .main-topbar {
            padding: 13px 24px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
            background: var(--bg);
        }
        .topbar-title { font-size: 14px; font-weight: 600; }
        .topbar-sub { font-size: 11px; color: var(--text-3); margin-top: 1px; font-family: var(--mono); }
        .topbar-actions { display: flex; gap: 7px; align-items: center; }

        .tbtn {
            padding: 6px 12px;
            font-size: 12px;
            font-family: var(--font);
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            background: transparent;
            color: var(--text-2);
            cursor: pointer;
            display: flex; align-items: center; gap: 5px;
            transition: all var(--ease);
            text-decoration: none;
        }
        .tbtn:hover { background: var(--bg-3); color: var(--text); }
        .tbtn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }
        .tbtn-primary { background: var(--accent); border-color: var(--accent); color: #fff; font-weight: 500; }
        .tbtn-primary:hover { background: var(--accent-2); border-color: var(--accent-2); color: #fff; }

        /* ── Body grid ── */
        .body-grid {
            display: grid;
            grid-template-columns: 1fr 420px;
            flex: 1;
            overflow: hidden;
        }

        /* ══════════════════════════════════════════════════
           FORM PANEL
        ══════════════════════════════════════════════════ */
        .form-panel {
            padding: 0;
            overflow-y: auto;
            border-right: 1px solid var(--border);
            background: var(--bg);
            scrollbar-width: thin;
            scrollbar-color: var(--bg-4) transparent;
        }
        .form-panel::-webkit-scrollbar { width: 4px; }
        .form-panel::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 4px; }

        /* ── Hero prompt ── */
        .hero-prompt {
            padding: 32px 28px 24px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, var(--bg-2) 0%, var(--bg) 100%);
        }
        .hero-greeting {
            font-size: 11px;
            font-family: var(--mono);
            color: var(--accent);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .hero-question {
            font-size: 22px;
            font-weight: 600;
            color: var(--text);
            line-height: 1.3;
            margin-bottom: 18px;
            letter-spacing: -0.03em;
        }
        .hero-question span {
            background: linear-gradient(135deg, var(--accent), #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .quick-prompts {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }
        .qchip {
            padding: 5px 12px;
            border: 1px solid var(--border-2);
            border-radius: 999px;
            font-size: 12px;
            font-family: var(--font);
            color: var(--text-2);
            background: var(--bg-3);
            cursor: pointer;
            transition: all var(--ease);
            white-space: nowrap;
        }
        .qchip:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-bg); }

        /* ── Form body ── */
        .form-body { padding: 24px 28px; }

        .field { margin-bottom: 18px; }
        .field > label {
            display: block;
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text-2);
            margin-bottom: 7px;
            font-family: var(--mono);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .optional { color: var(--text-3); font-weight: 400; text-transform: none; letter-spacing: 0; }

        .chips { display: flex; flex-wrap: wrap; gap: 6px; }
        .chip {
            padding: 5px 11px;
            border: 1px solid var(--border-2);
            border-radius: 999px;
            font-size: 12px;
            font-family: var(--font);
            color: var(--text-2);
            background: var(--bg-2);
            cursor: pointer;
            transition: all var(--ease);
            white-space: nowrap;
        }
        .chip:hover { border-color: var(--accent); color: var(--accent); }
        .chip.sel { border-color: var(--accent); color: var(--accent); background: var(--accent-bg); font-weight: 500; }

        .inp {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            background: var(--bg-2);
            color: var(--text);
            font-size: 13px;
            font-family: var(--font);
            transition: border-color var(--ease), box-shadow var(--ease);
            outline: none;
            line-height: 1.5;
        }
        .inp:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-bg); }
        .inp::placeholder { color: var(--text-3); }
        textarea.inp { resize: none; }

        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        .tone-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 6px; }
        .tone-card {
            padding: 9px 10px;
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            background: var(--bg-2);
            cursor: pointer;
            transition: all var(--ease);
        }
        .tone-card:hover { border-color: var(--accent-bd); }
        .tone-card.sel { border-color: var(--accent); background: var(--accent-bg); }
        .tone-name { font-size: 12px; font-weight: 500; color: var(--text); }
        .tone-card.sel .tone-name { color: var(--accent); }
        .tone-desc { font-size: 10.5px; color: var(--text-3); margin-top: 2px; }

        .gen-btn {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, var(--accent-2), var(--accent));
            color: #fff;
            border: none;
            border-radius: var(--r);
            font-size: 13.5px;
            font-weight: 600;
            font-family: var(--font);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: all var(--ease);
            letter-spacing: -0.01em;
        }
        .gen-btn:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 8px 24px var(--accent-bg); }
        .gen-btn:active { transform: translateY(0); }
        .gen-btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none; filter: none; box-shadow: none; }
        .gen-btn svg { width: 15px; height: 15px; stroke: #fff; fill: none; }

        .progress-wrap { height: 1.5px; background: var(--border); border-radius: 1px; overflow: hidden; margin-top: 10px; }
        .progress-fill { height: 100%; width: 0%; background: linear-gradient(90deg, var(--accent-2), var(--accent)); border-radius: 1px; transition: width 0.08s linear; }

        .error-alert {
            display: none;
            margin-bottom: 16px;
            padding: 11px 13px;
            background: var(--danger-bg);
            border: 1px solid var(--danger-bd);
            border-radius: var(--r);
            font-size: 12.5px;
            color: var(--danger);
        }
        .error-alert strong { display: block; margin-bottom: 2px; font-weight: 600; }

        /* ══════════════════════════════════════════════════
           OUTPUT PANEL
        ══════════════════════════════════════════════════ */
        .out-panel {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--bg-2);
        }
        .out-topbar {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
            gap: 8px;
        }
        .out-label-row { display: flex; align-items: center; gap: 7px; min-width: 0; }
        .out-label { font-size: 11.5px; font-weight: 500; color: var(--text-2); font-family: var(--mono); }
        .badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 500;
            font-family: var(--mono);
            white-space: nowrap;
        }
        .badge-purple { background: var(--accent-bg); color: var(--accent); border: 1px solid var(--accent-bd); }
        .badge-green  { background: var(--success-bg); color: var(--success); border: 1px solid rgba(74,222,128,0.2); }

        .icon-btn-group { display: flex; gap: 5px; flex-shrink: 0; }
        .icon-btn {
            width: 28px; height: 28px;
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            background: transparent;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all var(--ease);
            color: var(--text-2);
        }
        .icon-btn:hover { background: var(--bg-3); color: var(--text); }
        .icon-btn svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }

        /* Copy button — prominent */
        .copy-btn-large {
            padding: 7px 14px;
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            background: var(--bg-3);
            cursor: pointer;
            display: none;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-family: var(--font);
            font-weight: 500;
            color: var(--text-2);
            transition: all var(--ease);
            white-space: nowrap;
        }
        .copy-btn-large:hover { background: var(--bg-4); color: var(--text); border-color: var(--accent-bd); }
        .copy-btn-large.copied { background: var(--success-bg); color: var(--success); border-color: rgba(74,222,128,0.2); }
        .copy-btn-large svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }

        .out-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 18px;
            scrollbar-width: thin;
            scrollbar-color: var(--bg-4) transparent;
        }
        .out-body::-webkit-scrollbar { width: 4px; }
        .out-body::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 4px; }

        .empty-state {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            height: 100%; gap: 11px; text-align: center; padding: 32px;
        }
        .empty-icon {
            width: 48px; height: 48px;
            border: 1px solid var(--border-2);
            border-radius: var(--r-lg);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-3);
        }
        .empty-icon svg { width: 22px; height: 22px; stroke: currentColor; fill: none; }
        .empty-title { font-size: 14px; font-weight: 600; color: var(--text-2); letter-spacing: -0.02em; }
        .empty-desc { font-size: 12px; color: var(--text-3); max-width: 200px; line-height: 1.7; }

        .out-text {
            font-size: 13px;
            line-height: 1.85;
            color: var(--text);
            white-space: pre-wrap;
            font-family: var(--font);
        }

        .out-meta {
            display: none;
            margin-bottom: 14px;
            padding: 10px 12px;
            background: var(--bg-3);
            border-radius: var(--r);
            border: 1px solid var(--border);
            font-size: 11px;
            color: var(--text-3);
            font-family: var(--mono);
            gap: 12px;
            flex-wrap: wrap;
        }
        .out-meta span { display: flex; align-items: center; gap: 4px; }

        .out-footer {
            padding: 9px 16px;
            border-top: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
            font-size: 11px;
            color: var(--text-3);
            font-family: var(--mono);
        }

        .s-dot {
            display: inline-block; width: 6px; height: 6px;
            border-radius: 50%; background: var(--accent);
            animation: sdot 1s ease-in-out infinite; margin-left: 4px; vertical-align: middle;
        }
        @keyframes sdot { 0%,100% { opacity:.3; transform:scale(.8); } 50% { opacity:1; transform:scale(1.1); } }

        /* ══════════════════════════════════════════════════
           POPUP (shared)
        ══════════════════════════════════════════════════ */
        .popup-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
        }
        .popup-overlay.show { display: flex; }
        .popup-box {
            background: var(--bg-2);
            border: 1px solid var(--border-2);
            border-radius: var(--r-lg);
            padding: 24px;
            width: 340px;
            max-width: calc(100vw - 32px);
            box-shadow: 0 24px 64px rgba(0,0,0,0.6);
            animation: popIn 0.18s cubic-bezier(0.34,1.4,0.64,1) both;
        }
        @keyframes popIn {
            from { opacity: 0; transform: scale(0.92) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .popup-icon {
            width: 40px; height: 40px;
            border-radius: var(--r);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
        }
        .popup-icon.red { background: var(--danger-bg); color: var(--danger); border: 1px solid var(--danger-bd); }
        .popup-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; }
        .popup-title { font-size: 15px; font-weight: 600; color: var(--text); margin-bottom: 6px; letter-spacing: -0.02em; }
        .popup-desc { font-size: 13px; color: var(--text-2); line-height: 1.6; margin-bottom: 20px; }
        .popup-desc strong { color: var(--text); }
        .popup-actions { display: flex; gap: 8px; }
        .popup-btn {
            flex: 1;
            padding: 9px;
            border-radius: var(--r);
            font-size: 13px;
            font-weight: 500;
            font-family: var(--font);
            cursor: pointer;
            border: 1px solid var(--border-2);
            background: var(--bg-3);
            color: var(--text-2);
            transition: all var(--ease);
        }
        .popup-btn:hover { background: var(--bg-4); color: var(--text); }
        .popup-btn.danger { background: var(--danger); border-color: var(--danger); color: #fff; }
        .popup-btn.danger:hover { filter: brightness(1.1); }

        /* Profile popup */
        .profile-popup {
            display: none;
            position: absolute;
            bottom: calc(100% + 6px);
            left: 10px; right: 10px;
            background: var(--bg-3);
            border: 1px solid var(--border-2);
            border-radius: var(--r-lg);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
            z-index: 100;
            overflow: hidden;
            animation: slideUp 0.15s var(--ease) both;
        }
        @keyframes slideUp {
            from { opacity:0; transform: translateY(8px); }
            to   { opacity:1; transform: translateY(0); }
        }
        .profile-popup.show { display: block; }
        .pp-user {
            padding: 14px;
            border-bottom: 1px solid var(--border);
        }
        .pp-name { font-size: 13px; font-weight: 600; color: var(--text); }
        .pp-email { font-size: 11px; color: var(--text-3); font-family: var(--mono); }
        .pp-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 14px;
            font-size: 12.5px;
            color: var(--text-2);
            cursor: pointer;
            transition: all var(--ease);
        }
        .pp-item:hover { background: var(--bg-4); color: var(--text); }
        .pp-item.red { color: var(--danger); }
        .pp-item.red:hover { background: var(--danger-bg); color: var(--danger); }
        .pp-item svg { width: 13px; height: 13px; stroke: currentColor; fill: none; flex-shrink: 0; }

        /* Context menu (3-dot) */
        .ctx-menu {
            display: none;
            position: fixed;
            background: var(--bg-3);
            border: 1px solid var(--border-2);
            border-radius: var(--r);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            z-index: 500;
            min-width: 160px;
            overflow: hidden;
            animation: fadeIn 0.12s var(--ease) both;
        }
        @keyframes fadeIn { from { opacity:0; transform: scale(0.96); } to { opacity:1; transform: scale(1); } }
        .ctx-menu.show { display: block; }
        .ctx-item {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 13px;
            font-size: 12.5px;
            color: var(--text-2);
            cursor: pointer;
            transition: all var(--ease);
        }
        .ctx-item:hover { background: var(--bg-4); color: var(--text); }
        .ctx-item.red { color: var(--danger); }
        .ctx-item.red:hover { background: var(--danger-bg); }
        .ctx-item svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }

        @media (max-width: 960px) {
            .body-grid { grid-template-columns: 1fr; }
            .out-panel { display: none; }
        }
        @media (max-width: 700px) {
            .sidebar { display: none; }
        }
    </style>
</head>
<body>
<div class="app">

    {{-- ══ SIDEBAR ══ --}}
    <aside class="sidebar">
        <div class="sb-header">
            <a href="{{ route('dashboard') }}" class="sb-brand">
                <div class="sb-logo-mark">
                    <svg viewBox="0 0 16 16"><path d="M8 1l2 5h5l-4 3 1.5 5L8 11l-4.5 3L5 9 1 6h5z" stroke-width="1.4" stroke-linejoin="round"/></svg>
                </div>
                Inkraft AI
            </a>
            <button class="new-btn" onclick="resetAll()">
                <svg viewBox="0 0 16 16"><path d="M8 3v10M3 8h10" stroke-width="1.5" stroke-linecap="round"/></svg>
                New generation
            </button>
        </div>

        <div class="sb-scroll">
            <div class="sb-section">Recent</div>
            <div id="historyList">
                @forelse($recentGenerations as $gen)
                    @php
                        $colors = ['#a78bfa','#60a5fa','#34d399','#fbbf24','#f87171'];
                        $color  = $colors[$loop->index % count($colors)];
                    @endphp
                    <div class="sb-item"
                         id="sb-{{ $gen->id }}"
                         data-id="{{ $gen->id }}"
                         onclick="loadFromSidebar({{ $gen->id }})">
                        <div class="sb-item-dot" style="background:{{ $color }}"></div>
                        <span class="sb-item-text">{{ $gen->topic ?: $gen->content_type }}</span>
                        <span class="sb-item-time">{{ $gen->created_at->diffForHumans(null, true) }}</span>
                        <button class="sb-item-more"
                                onclick="openCtxMenu(event, {{ $gen->id }})"
                                title="More options">···</button>
                    </div>
                @empty
                    <div id="emptyHistory" style="padding:10px 16px;font-size:12px;color:var(--text-3);">No history yet</div>
                @endforelse
            </div>

            <div class="sb-section" style="margin-top:8px;">Navigation</div>
            <a href="{{ route('dashboard') }}" class="sb-nav-item active">
                <svg viewBox="0 0 16 16"><path d="M2 6h5V2H2v4zM9 6h5V2H9v4zM2 14h5v-4H2v4zM9 14h5v-4H9v4z" stroke-width="1.2"/></svg>
                Generator
            </a>
            <a href="{{ route('content.history') }}" class="sb-nav-item">
                <svg viewBox="0 0 16 16"><circle cx="8" cy="8" r="6" stroke-width="1.2"/><path d="M8 5v3.5L10 10" stroke-width="1.2" stroke-linecap="round"/></svg>
                All History
            </a>
        </div>

        {{-- Profile / footer --}}
        <div class="sb-footer" onclick="toggleProfilePopup(event)" id="sbFooter">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-plan">Free plan</div>
            </div>
            <span class="sb-footer-arrow">⌃</span>

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

    {{-- ══ MAIN ══ --}}
    <div class="main">
        <div class="main-topbar">
            <div>
                <div class="topbar-title">AI Content Generator</div>
                <div class="topbar-sub">powered by Google Gemini</div>
            </div>
            <div class="topbar-actions">
                <a href="{{ route('content.history') }}" class="tbtn">
                    <svg viewBox="0 0 16 16"><circle cx="8" cy="8" r="6" stroke-width="1.2"/><path d="M8 5v3.5L10 10" stroke-width="1.2" stroke-linecap="round"/></svg>
                    History
                </a>
                <button class="tbtn tbtn-primary" onclick="document.getElementById('genBtn').click()">
                    Generate
                </button>
            </div>
        </div>

        <div class="body-grid">

            {{-- ── FORM PANEL ── --}}
            <div class="form-panel">
                <div class="hero-prompt">
                    <div class="hero-greeting">✦ Inkraft AI</div>
                    <div class="hero-question">
                        Apa yang ingin kamu <span>buat hari ini?</span>
                    </div>
                    <div class="quick-prompts">
                        <button class="qchip" onclick="quickFill('Email promosi produk baru')">📧 Email Promosi</button>
                        <button class="qchip" onclick="quickFill('Blog post tentang teknologi AI')">📝 Blog Post</button>
                        <button class="qchip" onclick="quickFill('Iklan media sosial untuk brand fashion')">📱 Social Media</button>
                        <button class="qchip" onclick="quickFill('Deskripsi produk untuk toko online')">🛍 Product Desc</button>
                        <button class="qchip" onclick="quickFill('Landing page copy untuk startup SaaS')">🚀 Landing Page</button>
                    </div>
                </div>

                <div class="form-body">
                    <div class="error-alert" id="errorAlert">
                        <strong>Generasi gagal</strong>
                        <span id="errorMsg"></span>
                    </div>

                    <div class="field">
                        <label>Tipe konten</label>
                        <div class="chips" id="typeChips">
                            @php
                                $types = ['Email Newsletter','Blog Post','Ad Copy','Social Media Post','Product Description','Landing Page Copy','Press Release','Video Script'];
                            @endphp
                            @foreach($types as $i => $type)
                                <button type="button"
                                        class="chip {{ $i === 0 ? 'sel' : '' }}"
                                        onclick="selectChip(this,'typeChips')"
                                        data-value="{{ $type }}">{{ $type }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="field">
                        <label>Topik / subjek</label>
                        <input class="inp" type="text" id="topic"
                               placeholder="Contoh: Flash sale akhir tahun, peluncuran produk baru...">
                    </div>

                    <div class="two-col">
                        <div class="field" style="margin-bottom:0">
                            <label>Kata kunci</label>
                            <input class="inp" type="text" id="keywords"
                                   placeholder="diskon, limited offer">
                        </div>
                        <div class="field" style="margin-bottom:0">
                            <label>Target audiens</label>
                            <input class="inp" type="text" id="audience"
                                   placeholder="milenial, profesional muda">
                        </div>
                    </div>

                    <div class="field" style="margin-top:18px">
                        <label>Tone of voice</label>
                        <div class="tone-grid">
                            @php
                                $tones = [
                                    ['Professional','Formal, kredibel'],
                                    ['Casual','Ramah, hangat'],
                                    ['Persuasive','Meyakinkan, tegas'],
                                    ['Witty','Playful, humor'],
                                    ['Empathetic','Peduli, manusiawi'],
                                    ['Formal','Resmi, presisi'],
                                ];
                            @endphp
                            @foreach($tones as $i => [$name,$desc])
                                <div class="tone-card {{ $i === 0 ? 'sel' : '' }}"
                                     onclick="selectTone(this)"
                                     data-value="{{ $name }}">
                                    <div class="tone-name">{{ $name }}</div>
                                    <div class="tone-desc">{{ $desc }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="field">
                        <label>Instruksi tambahan <span class="optional">(opsional)</span></label>
                        <textarea class="inp" id="instructions" rows="3"
                                  placeholder="Persyaratan khusus, gaya penulisan, poin penting..."></textarea>
                    </div>

                    <button class="gen-btn" id="genBtn" onclick="generate()">
                        <svg viewBox="0 0 16 16"><path d="M8 1l2 5h5l-4 3 1.5 5L8 11l-4.5 3L5 9 1 6h5z" stroke-width="1.4" stroke-linejoin="round"/></svg>
                        <span id="genBtnText">Generate konten</span>
                    </button>
                    <div class="progress-wrap"><div class="progress-fill" id="progress"></div></div>
                </div>
            </div>

            {{-- ── OUTPUT PANEL ── --}}
            <div class="out-panel">
                <div class="out-topbar">
                    <div class="out-label-row">
                        <span class="out-label">Output</span>
                        <span class="badge badge-purple" id="typeBadge" style="display:none"></span>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <button class="copy-btn-large" id="copyBtnLarge" onclick="copyOutput()">
                            <svg viewBox="0 0 16 16"><rect x="5" y="5" width="9" height="9" rx="1.5" stroke-width="1.2"/><path d="M5 5V3.5A1.5 1.5 0 016.5 2H12a1.5 1.5 0 011.5 1.5v6A1.5 1.5 0 0112 11H10.5" stroke-width="1.2" stroke-linecap="round"/></svg>
                            Salin
                        </button>
                        <div class="icon-btn-group">
                            <button class="icon-btn" id="dlBtn" title="Download .txt" onclick="downloadOutput()" style="display:none">
                                <svg viewBox="0 0 16 16"><path d="M8 3v7M5 7l3 3 3-3M3 12h10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button class="icon-btn" id="regenBtn" title="Regenerate" onclick="generate()" style="display:none">
                                <svg viewBox="0 0 16 16"><path d="M13 8A5 5 0 113.5 5.5M3 3v2.5H5.5" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="out-body" id="outBody">
                    <div class="out-meta" id="outMeta">
                        <span id="metaType"></span>
                        <span id="metaDate"></span>
                    </div>

                    <div class="empty-state" id="emptyState">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 3L14.5 9H21L15.5 13 17.5 19.5 12 15.5 6.5 19.5 8.5 13 3 9H9.5L12 3z" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="empty-title">Siap untuk generate</div>
                        <div class="empty-desc">Isi form di sebelah kiri dan klik Generate untuk membuat konten dengan AI</div>
                    </div>

                    <div id="outText" class="out-text" style="display:none"></div>
                </div>

                <div class="out-footer" id="outFooter" style="display:none">
                    <span id="wordCount"></span>
                    <span class="badge badge-green" id="savedBadge" style="display:none">✓ Tersimpan</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ POPUP: Hapus semua riwayat ══ --}}
<div class="popup-overlay" id="deleteAllOverlay" onclick="closeDeleteAllModal(event)">
    <div class="popup-box">
        <div class="popup-icon red">
            <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="popup-title">Hapus semua riwayat?</div>
        <div class="popup-desc">
            Tindakan ini akan <strong>menghapus semua riwayat</strong> generasi konten kamu secara permanen dan tidak dapat dibatalkan.
        </div>
        <div class="popup-actions">
            <button class="popup-btn" onclick="closeDeleteAllModal()">Batal</button>
            <button class="popup-btn danger" id="confirmDeleteAll" onclick="deleteAllHistory()">Ya, hapus semua</button>
        </div>
    </div>
</div>

{{-- ══ POPUP: Hapus 1 obrolan ══ --}}
<div class="popup-overlay" id="deleteOneOverlay" onclick="closeDeleteOneModal(event)">
    <div class="popup-box">
        <div class="popup-icon red">
            <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <div class="popup-title">Hapus obrolan ini?</div>
        <div class="popup-desc">Obrolan ini akan dihapus permanen. Riwayat lainnya tidak akan terpengaruh.</div>
        <div class="popup-actions">
            <button class="popup-btn" onclick="closeDeleteOneModal()">Batal</button>
            <button class="popup-btn danger" onclick="confirmDeleteOne()">Ya, hapus</button>
        </div>
    </div>
</div>

{{-- ══ CONTEXT MENU (3-dot) ══ --}}
<div class="ctx-menu" id="ctxMenu">
    <div class="ctx-item" onclick="ctxLoadItem()">
        <svg viewBox="0 0 16 16"><path d="M2 8h12M8 3l5 5-5 5" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Lihat konten
    </div>
    <div class="ctx-item red" onclick="ctxDeleteItem()">
        <svg viewBox="0 0 16 16"><path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 10h8l1-10" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Hapus obrolan ini
    </div>
</div>

<form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none">
    @csrf
</form>

<script>
const GENERATE_URL    = @json(route('content.generate'));
const HISTORY_BASE    = @json(url('/history'));
const DESTROY_ALL_URL = @json(route('content.destroy-all'));
const CSRF            = document.querySelector('meta[name="csrf-token"]')?.content || '';

let currentOutput  = '';
let isGenerating   = false;
let ctxTargetId    = null;

// ── Chip / tone selectors ──────────────────────────────────────────────────
function selectChip(el, groupId) {
    document.querySelectorAll(`#${groupId} .chip`).forEach(c => c.classList.remove('sel'));
    el.classList.add('sel');
}
function selectTone(el) {
    document.querySelectorAll('.tone-card').forEach(c => c.classList.remove('sel'));
    el.classList.add('sel');
}
function selectedChipValue(groupId) {
    return document.querySelector(`#${groupId} .chip.sel`)?.dataset.value ?? '';
}
function selectedToneValue() {
    return document.querySelector('.tone-card.sel')?.dataset.value ?? 'Professional';
}

function quickFill(text) {
    document.getElementById('topic').value = text;
    document.getElementById('topic').focus();
}

// ── Generate ───────────────────────────────────────────────────────────────
async function generate() {
    if (isGenerating) return;
    isGenerating = true;

    const btn     = document.getElementById('genBtn');
    const btnText = document.getElementById('genBtnText');
    btn.disabled  = true;
    btnText.innerHTML = 'Generating<span class="s-dot"></span>';

    document.getElementById('errorAlert').style.display = 'none';
    setOutputVisible(false);

    const fd = new FormData();
    fd.append('content_type', selectedChipValue('typeChips'));
    fd.append('topic',        document.getElementById('topic').value);
    fd.append('keywords',     document.getElementById('keywords').value);
    fd.append('audience',     document.getElementById('audience').value);
    fd.append('tone',         selectedToneValue());
    fd.append('instructions', document.getElementById('instructions').value);

    const prog = document.getElementById('progress');
    prog.style.width = '0%';
    let fake = 0;
    const fakeTimer = setInterval(() => {
        fake = Math.min(fake + Math.random() * 7, 88);
        prog.style.width = fake + '%';
    }, 300);

    try {
        const res  = await fetch(GENERATE_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
            body: fd,
        });
        const data = await res.json();
        clearInterval(fakeTimer);

        if (!res.ok || !data.success) throw new Error(data.message || 'Terjadi kesalahan.');

        prog.style.width = '100%';
        setTimeout(() => { prog.style.width = '0%'; }, 700);

        currentOutput = data.content;
        setOutputVisible(true, data.content_type ?? selectedChipValue('typeChips'), data.word_count, true);

        if (data.id) addToSidebar(data.id, document.getElementById('topic').value || data.content_type);

    } catch (err) {
        clearInterval(fakeTimer);
        prog.style.width = '0%';
        const alert = document.getElementById('errorAlert');
        alert.style.display = 'block';
        document.getElementById('errorMsg').textContent = ' ' + err.message;
        alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } finally {
        isGenerating = false;
        btn.disabled = false;
        btnText.innerHTML = 'Generate konten';
    }
}

// ── Add to sidebar dynamically ─────────────────────────────────────────────
function addToSidebar(id, label) {
    const colors = ['#a78bfa','#60a5fa','#34d399','#fbbf24','#f87171'];
    const color  = colors[Math.floor(Math.random() * colors.length)];

    const empty = document.getElementById('emptyHistory');
    if (empty) empty.remove();

    const list = document.getElementById('historyList');
    const div  = document.createElement('div');
    div.className = 'sb-item active';
    div.id = `sb-${id}`;
    div.dataset.id = id;
    div.innerHTML = `
        <div class="sb-item-dot" style="background:${color}"></div>
        <span class="sb-item-text">${label}</span>
        <span class="sb-item-time">baru saja</span>
        <button class="sb-item-more" onclick="openCtxMenu(event, ${id})" title="More options">···</button>
    `;
    div.addEventListener('click', function(e) {
        if (e.target.closest('.sb-item-more')) return;
        loadFromSidebar(id);
    });

    list.querySelectorAll('.sb-item').forEach(i => i.classList.remove('active'));

    const section = list.querySelector('.sb-section');
    if (section) section.after(div);
    else list.prepend(div);
}

// ── Set output visible ─────────────────────────────────────────────────────
function setOutputVisible(show, contentType, wordCount, saved, meta) {
    document.getElementById('emptyState').style.display    = show ? 'none' : 'flex';
    document.getElementById('outText').style.display       = show ? 'block' : 'none';
    document.getElementById('outFooter').style.display     = show ? 'flex' : 'none';
    document.getElementById('dlBtn').style.display         = show ? 'flex' : 'none';
    document.getElementById('regenBtn').style.display      = show ? 'flex' : 'none';
    document.getElementById('typeBadge').style.display     = show ? 'inline-flex' : 'none';
    document.getElementById('copyBtnLarge').style.display  = show ? 'flex' : 'none';

    const outMeta = document.getElementById('outMeta');
    outMeta.style.display = (show && meta) ? 'flex' : 'none';

    if (show) {
        document.getElementById('outText').textContent        = currentOutput;
        document.getElementById('typeBadge').textContent      = contentType || selectedChipValue('typeChips');
        document.getElementById('wordCount').textContent      = (wordCount ?? currentOutput.split(/\s+/).filter(Boolean).length) + ' words';
        document.getElementById('savedBadge').style.display   = saved ? 'inline-flex' : 'none';

        if (meta) {
            document.getElementById('metaType').textContent = '📄 ' + (meta.content_type || '');
            document.getElementById('metaDate').textContent = '🕐 ' + (meta.created_at || '');
        }
    }

    const cb = document.getElementById('copyBtnLarge');
    cb.classList.remove('copied');
    cb.innerHTML = `<svg viewBox="0 0 16 16" width="13" height="13" style="stroke:currentColor;fill:none"><rect x="5" y="5" width="9" height="9" rx="1.5" stroke-width="1.2"/><path d="M5 5V3.5A1.5 1.5 0 016.5 2H12a1.5 1.5 0 011.5 1.5v6A1.5 1.5 0 0112 11H10.5" stroke-width="1.2" stroke-linecap="round"/></svg> Salin`;
}

// ── Load from sidebar ──────────────────────────────────────────────────────
async function loadFromSidebar(id) {
    document.querySelectorAll('.sb-item').forEach(i => i.classList.remove('active'));
    const el = document.getElementById(`sb-${id}`);
    if (el) el.classList.add('active');

    try {
        const res  = await fetch(`${HISTORY_BASE}/${id}`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
        });
        const data = await res.json();
        if (!data.success) throw new Error();

        currentOutput = data.content;
        setOutputVisible(true, data.meta.content_type, data.meta.word_count, false, data.meta);
    } catch {
        alert('Tidak dapat memuat konten.');
    }
}

// ── Copy ───────────────────────────────────────────────────────────────────
function copyOutput() {
    if (!currentOutput) return;
    navigator.clipboard.writeText(currentOutput).then(() => {
        const btn = document.getElementById('copyBtnLarge');
        btn.classList.add('copied');
        btn.innerHTML = `<svg viewBox="0 0 16 16" width="13" height="13" style="stroke:currentColor;fill:none"><path d="M2 8l4 4 8-8" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg> Tersalin!`;
        setTimeout(() => {
            btn.classList.remove('copied');
            btn.innerHTML = `<svg viewBox="0 0 16 16" width="13" height="13" style="stroke:currentColor;fill:none"><rect x="5" y="5" width="9" height="9" rx="1.5" stroke-width="1.2"/><path d="M5 5V3.5A1.5 1.5 0 016.5 2H12a1.5 1.5 0 011.5 1.5v6A1.5 1.5 0 0112 11H10.5" stroke-width="1.2" stroke-linecap="round"/></svg> Salin`;
        }, 2500);
    });
}

// ── Download ───────────────────────────────────────────────────────────────
function downloadOutput() {
    if (!currentOutput) return;
    const blob = new Blob([currentOutput], { type: 'text/plain' });
    const url  = URL.createObjectURL(blob);
    const a    = Object.assign(document.createElement('a'), { href: url, download: `inkraft-${Date.now()}.txt` });
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// ── Reset ──────────────────────────────────────────────────────────────────
function resetAll() {
    ['topic','keywords','audience','instructions'].forEach(id => document.getElementById(id).value = '');
    document.querySelectorAll('#typeChips .chip').forEach((c,i) => c.classList.toggle('sel', i === 0));
    document.querySelectorAll('.tone-card').forEach((c,i) => c.classList.toggle('sel', i === 0));
    currentOutput = '';
    setOutputVisible(false);
    document.getElementById('errorAlert').style.display = 'none';
    document.querySelectorAll('.sb-item').forEach(i => i.classList.remove('active'));
}

// ══ PROFILE POPUP ═════════════════════════════════════════════════════════
function toggleProfilePopup(e) {
    e.stopPropagation();
    document.getElementById('profilePopup').classList.toggle('show');
}
document.addEventListener('click', () => {
    document.getElementById('profilePopup').classList.remove('show');
    closeCtxMenu();
});

// ══ DELETE ALL HISTORY ═════════════════════════════════════════════════════
function openDeleteAllModal(e) {
    e.stopPropagation();
    document.getElementById('profilePopup').classList.remove('show');
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

        const list = document.getElementById('historyList');
        list.querySelectorAll('.sb-item').forEach(i => i.remove());
        const emptyDiv = document.createElement('div');
        emptyDiv.id = 'emptyHistory';
        emptyDiv.style.cssText = 'padding:10px 16px;font-size:12px;color:var(--text-3)';
        emptyDiv.textContent = 'No history yet';
        list.appendChild(emptyDiv);
        document.getElementById('deleteAllOverlay').classList.remove('show');
        resetAll();
    } catch {
        alert('Gagal menghapus. Coba lagi.');
    } finally {
        btn.disabled = false; btn.textContent = 'Ya, hapus semua';
    }
}

// ══ DELETE ONE (3-dot context menu) ════════════════════════════════════════
function openCtxMenu(e, id) {
    e.stopPropagation();
    ctxTargetId = id;
    const menu = document.getElementById('ctxMenu');
    menu.classList.add('show');
    const x = Math.min(e.clientX, window.innerWidth - 180);
    const y = Math.min(e.clientY + 4, window.innerHeight - 100);
    menu.style.left = x + 'px';
    menu.style.top  = y + 'px';
}
function closeCtxMenu() {
    document.getElementById('ctxMenu').classList.remove('show');
}
function ctxLoadItem() {
    closeCtxMenu();
    if (ctxTargetId) loadFromSidebar(ctxTargetId);
}
function ctxDeleteItem() {
    closeCtxMenu();
    document.getElementById('deleteOneOverlay').classList.add('show');
}
function closeDeleteOneModal(e) {
    if (e && e.target !== document.getElementById('deleteOneOverlay')) return;
    document.getElementById('deleteOneOverlay').classList.remove('show');
}
async function confirmDeleteOne() {
    if (!ctxTargetId) return;
    try {
        const res = await fetch(`${HISTORY_BASE}/${ctxTargetId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (!data.success) throw new Error();

        const el = document.getElementById(`sb-${ctxTargetId}`);
        if (el) el.remove();

        if (!document.querySelector('.sb-item.active')) resetAll();

        if (!document.querySelector('#historyList .sb-item')) {
            const emptyDiv = document.createElement('div');
            emptyDiv.id = 'emptyHistory';
            emptyDiv.style.cssText = 'padding:10px 16px;font-size:12px;color:var(--text-3)';
            emptyDiv.textContent = 'No history yet';
            document.getElementById('historyList').appendChild(emptyDiv);
        }

        document.getElementById('deleteOneOverlay').classList.remove('show');
        ctxTargetId = null;
    } catch {
        alert('Gagal menghapus. Coba lagi.');
    }
}

function doLogout() {
    document.getElementById('logoutForm').submit();
}
</script>
</body>
</html>