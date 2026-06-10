<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
    <title>Login - SI Kemasan UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
            gap: 60px;
            padding: 48px 24px;
            position: relative;
            z-index: 1;
        }

        .login-hero {
            flex: 0 0 420px;
            text-align: center;
            animation: heroEnter .9s cubic-bezier(.22,1,.36,1) both;
        }

        @keyframes heroEnter {
            from { opacity: 0; transform: translateY(30px) scale(.97); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .login-card {
            width: 400px;
            max-width: 90vw;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            animation: heroEnter .9s cubic-bezier(.22,1,.36,1) both;
            animation-delay: .15s;
        }

        .login-card .card-body {
            padding: 40px;
        }

        .password-toggle {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0 14px;
            color: #6c757d;
            z-index: 10;
        }
        .password-toggle:hover { color: #0d6efd; }
        .password-toggle:focus { outline: none; }
        .form-control, .input-group-text {
            border-radius: 10px;
        }
        .input-group .form-control:not(:first-child) {
            border-radius: 0 10px 10px 0;
        }
        .input-group .input-group-text:first-child {
            border-radius: 10px 0 0 10px;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        @media (max-width: 1024px) {
            .login-hero { flex: 0 0 320px; }
        }

        @media (max-width: 860px) {
            .login-container { flex-direction: column; gap: 32px; }
            .login-hero { flex: none; width: 100%; max-width: 400px; }
        }

        /* ─── Background Machines ─── */
        .machine-bg {
            position: absolute;
            pointer-events: none;
            z-index: 0;
        }
        .machine-bg svg {
            width: 100%;
            height: 100%;
        }
        .machine-parallax {
            transition: transform .15s ease-out;
            width: 100%;
            height: 100%;
            animation: fadeIn 1.5s ease forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .bg-gear {
            top: 3%;
            left: 2%;
            width: 180px;
            height: 150px;
            opacity: .55;
        }
        .bg-nodes {
            bottom: 5%;
            right: 2%;
            width: 260px;
            height: 170px;
            opacity: .5;
        }
        .bg-pipeline {
            bottom: 15%;
            left: 0;
            width: 100%;
            height: 56px;
            opacity: .45;
        }
        .bg-pulse {
            top: 2%;
            right: 0;
            width: 100%;
            height: 90px;
            opacity: .3;
        }

        .bg-glow-1 {
            position: absolute; z-index: 0; pointer-events: none;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 70%);
            top: -20%; right: -10%;
            animation: glowDrift 8s ease-in-out infinite alternate;
        }
        .bg-glow-2 {
            position: absolute; z-index: 0; pointer-events: none;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,.06) 0%, transparent 70%);
            bottom: -10%; left: -10%;
            animation: glowDrift 10s ease-in-out infinite alternate-reverse;
        }
        @keyframes glowDrift {
            from { transform: translate(-20px, -20px) scale(1); }
            to { transform: translate(20px, 20px) scale(1.15); }
        }

        /* ─── Box ─── */
        .box-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 28px;
            perspective: 900px;
        }
        .box-logo {
            animation: boxFloat 4s ease-in-out infinite;
        }
        @keyframes boxFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-16px); }
        }
        .box-logo svg {
            width: 170px;
            height: 170px;
            display: block;
            filter: drop-shadow(0 8px 30px rgba(255,255,255,.12));
        }
        .box-glow {
            position: absolute;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,255,255,.1) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation: pulseGlow 3s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: .4; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: .8; transform: translate(-50%, -50%) scale(1.3); }
        }
        .box-shadow {
            position: absolute;
            bottom: -18px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 16px;
            background: radial-gradient(ellipse, rgba(0,0,0,.25) 0%, transparent 70%);
            border-radius: 50%;
            animation: shadowScale 4s ease-in-out infinite;
            pointer-events: none;
        }
        @keyframes shadowScale {
            0%, 100% { transform: translateX(-50%) scale(1); opacity: .5; }
            50% { transform: translateX(-50%) scale(1.45); opacity: .25; }
        }
        .flap-front { transform-origin: 90px 70px; transform-style: preserve-3d; }
        .flap-back  { transform-origin: 118px 42px; transform-style: preserve-3d; }
        .tape-stretch { transform-origin: 90px 62px; }

        .home-title {
            font-size: 44px; font-weight: 800;
            color: #fff;
            margin-bottom: 10px; letter-spacing: -1px; line-height: 1.15;
            text-shadow: 0 2px 20px rgba(0,0,0,.15);
        }
        .home-subtitle {
            font-size: 16px; color: rgba(255,255,255,.8);
            line-height: 1.7; margin: 0 auto 12px;
        }
        .home-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.12); color: #fff;
            padding: 6px 18px; border-radius: 20px;
            font-size: 13px; font-weight: 500;
            border: 1px solid rgba(255,255,255,.15);
        }

        /* ─── SVG Animations ─── */
        .gear-a { animation: spinCW 5s linear infinite; transform-origin: 68px 62px; }
        .gear-b { animation: spinCCW 4s linear infinite; transform-origin: 154px 50px; }
        .gear-c { animation: spinCW 3.5s linear infinite; transform-origin: 100px 105px; }
        @keyframes spinCW { to { transform: rotate(360deg); } }
        @keyframes spinCCW { to { transform: rotate(-360deg); } }

        .belt-dot {
            animation: beltMove 2s linear infinite;
        }
        .belt-dot:nth-child(2) { animation-delay: .5s; }
        .belt-dot:nth-child(3) { animation-delay: 1s; }
        .belt-dot:nth-child(4) { animation-delay: 1.5s; }
        @keyframes beltMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(0, 80px); }
        }

        .flow-dot {
            animation: flowMove 2.8s ease-in-out infinite;
        }
        .flow-dot:nth-child(2) { animation-delay: .7s; }
        .flow-dot:nth-child(3) { animation-delay: 1.4s; }
        .flow-dot:nth-child(4) { animation-delay: 2.1s; }
        .flow-dot-fast {
            animation: flowMove 1.8s ease-in-out infinite;
        }
        .flow-dot-fast:nth-child(2) { animation-delay: .45s; }
        .flow-dot-fast:nth-child(3) { animation-delay: .9s; }
        .flow-dot-fast:nth-child(4) { animation-delay: 1.35s; }
        @keyframes flowMove {
            0% { transform: translate(-50px, 0); opacity: 0; }
            15% { opacity: .9; }
            85% { opacity: .9; }
            100% { transform: translate(1150px, 0); opacity: 0; }
        }

        .pulse-wave {
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
            animation: drawWave 3.5s ease-in-out infinite;
        }
        @keyframes drawWave {
            0% { stroke-dashoffset: 500; }
            50% { stroke-dashoffset: 0; }
            100% { stroke-dashoffset: -500; }
        }
        .pulse-wave-2 {
            stroke-dasharray: 400;
            stroke-dashoffset: 400;
            animation: drawWave2 3.5s ease-in-out infinite;
        }
        @keyframes drawWave2 {
            0% { stroke-dashoffset: 400; }
            50% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: -300; }
        }
        .pulse-blip {
            animation: blipMove 3.5s ease-in-out infinite;
        }
        @keyframes blipMove {
            0% { transform: translate(0, 0); }
            50% { transform: translate(1140px, 0); }
            100% { transform: translate(0, 0); }
        }

        .freq-bar {
            animation: freqBounce 1.2s ease-in-out infinite alternate;
        }
        .freq-bar:nth-child(2) { animation-delay: .15s; }
        .freq-bar:nth-child(3) { animation-delay: .3s; }
        .freq-bar:nth-child(4) { animation-delay: .45s; }
        .freq-bar:nth-child(5) { animation-delay: .6s; }
        .freq-bar:nth-child(6) { animation-delay: .75s; }
        .freq-bar:nth-child(7) { animation-delay: .9s; }
        @keyframes freqBounce {
            from { transform: scaleY(.3); }
            to { transform: scaleY(1); }
        }

        .node-ring {
            animation: ringExpand 2s ease-out infinite;
            transform-origin: center;
        }
        .node-ring:nth-child(2) { animation-delay: .5s; }
        .node-ring:nth-child(3) { animation-delay: 1s; }
        @keyframes ringExpand {
            0% { r: 4; opacity: .8; }
            100% { r: 18; opacity: 0; }
        }

        .data-packet-h {
            animation: packetH 2.6s ease-in-out infinite;
        }
        .data-packet-h:nth-child(2) { animation-delay: .65s; }
        .data-packet-h:nth-child(3) { animation-delay: 1.3s; }
        .data-packet-h:nth-child(4) { animation-delay: 1.95s; }
        @keyframes packetH {
            0% { transform: translate(0, 0); opacity: 0; }
            15% { opacity: .9; }
            50% { transform: translate(80px, 0); opacity: .9; }
            85% { opacity: .9; }
            100% { transform: translate(160px, 0); opacity: 0; }
        }

        .data-packet-v {
            animation: packetV 2.6s ease-in-out infinite;
        }
        .data-packet-v:nth-child(2) { animation-delay: .65s; }
        .data-packet-v:nth-child(3) { animation-delay: 1.3s; }
        @keyframes packetV {
            0% { transform: translate(0, 0); opacity: 0; }
            15% { opacity: .9; }
            50% { transform: translate(0, 70px); opacity: .9; }
            85% { opacity: .9; }
            100% { transform: translate(0, 140px); opacity: 0; }
        }

        @media (max-width: 860px) {
            .home-title { font-size: 30px; }
            .box-logo svg { width: 140px; height: 140px; }
            .home-subtitle { font-size: 14px; }
            .bg-gear { width: 110px; height: 100px; opacity: .4; }
            .bg-nodes { width: 160px; height: 120px; opacity: .35; }
            .bg-pipeline { height: 36px; opacity: .3; }
            .bg-pulse { height: 55px; opacity: .28; }
        }
        @media (max-width: 480px) {
            .home-title { font-size: 24px; }
            .box-logo svg { width: 120px; height: 120px; }
            .bg-gear { width: 80px; height: 70px; }
            .bg-nodes { width: 120px; height: 90px; }
            .bg-pipeline { height: 28px; }
            .bg-pulse { height: 40px; }
            .box-shadow { width: 80px; height: 12px; }
        }
    </style>
</head>
<body>
    <div class="login-page" id="loginPage">
        <div class="bg-glow-1"></div>
        <div class="bg-glow-2"></div>

        <!-- Machine: Gear System -->
        <div class="machine-bg bg-gear" aria-hidden="true" data-speed="1.4">
            <div class="machine-parallax">
                <svg viewBox="0 0 240 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <circle cx="68" cy="62" r="38" stroke="#d97706" stroke-width="6" class="gear-a"/>
                        <circle cx="68" cy="62" r="10" fill="#d97706" opacity=".6"/>
                        <g stroke="#d97706" stroke-width="5" class="gear-a">
                            <line x1="68" y1="14" x2="68" y2="4"/>
                            <line x1="68" y1="110" x2="68" y2="120"/>
                            <line x1="16" y1="62" x2="6" y2="62"/>
                            <line x1="120" y1="62" x2="130" y2="62"/>
                            <line x1="31" y1="25" x2="24" y2="18"/>
                            <line x1="105" y1="99" x2="112" y2="106"/>
                            <line x1="31" y1="99" x2="24" y2="106"/>
                            <line x1="105" y1="25" x2="112" y2="18"/>
                        </g>
                        <circle cx="154" cy="50" r="28" stroke="#f59e0b" stroke-width="5" class="gear-b"/>
                        <circle cx="154" cy="50" r="7" fill="#f59e0b" opacity=".5"/>
                        <g stroke="#f59e0b" stroke-width="4" class="gear-b">
                            <line x1="154" y1="14" x2="154" y2="6"/>
                            <line x1="154" y1="86" x2="154" y2="94"/>
                            <line x1="118" y1="50" x2="110" y2="50"/>
                            <line x1="190" y1="50" x2="198" y2="50"/>
                            <line x1="132" y1="28" x2="126" y2="22"/>
                            <line x1="176" y1="72" x2="182" y2="78"/>
                            <line x1="132" y1="72" x2="126" y2="78"/>
                            <line x1="176" y1="28" x2="182" y2="22"/>
                        </g>
                        <circle cx="100" cy="130" r="20" stroke="#fbbf24" stroke-width="4" class="gear-c"/>
                        <circle cx="100" cy="130" r="5" fill="#fbbf24" opacity=".5"/>
                        <g stroke="#fbbf24" stroke-width="3" class="gear-c">
                            <line x1="100" y1="104" x2="100" y2="98"/>
                            <line x1="100" y1="156" x2="100" y2="162"/>
                            <line x1="74" y1="130" x2="68" y2="130"/>
                            <line x1="126" y1="130" x2="132" y2="130"/>
                            <line x1="82" y1="112" x2="78" y2="108"/>
                            <line x1="118" y1="148" x2="122" y2="152"/>
                            <line x1="82" y1="148" x2="78" y2="152"/>
                            <line x1="118" y1="112" x2="122" y2="108"/>
                        </g>
                    </g>
                </svg>
            </div>
        </div>

        <!-- Machine: Data Nodes -->
        <div class="machine-bg bg-nodes" aria-hidden="true" data-speed="1.1">
            <div class="machine-parallax">
                <svg viewBox="0 0 300 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g>
                        <line x1="40" y1="100" x2="130" y2="40" stroke="#0284c7" stroke-width="2" stroke-dasharray="4,4" opacity=".5"/>
                        <line x1="130" y1="40" x2="260" y2="70" stroke="#0284c7" stroke-width="2" stroke-dasharray="4,4" opacity=".5"/>
                        <line x1="40" y1="100" x2="130" y2="160" stroke="#0284c7" stroke-width="2" stroke-dasharray="4,4" opacity=".5"/>
                        <line x1="130" y1="160" x2="260" y2="130" stroke="#0284c7" stroke-width="2" stroke-dasharray="4,4" opacity=".5"/>
                        <line x1="130" y1="40" x2="130" y2="160" stroke="#0284c7" stroke-width="2" stroke-dasharray="4,4" opacity=".3"/>
                        <line x1="40" y1="100" x2="260" y2="100" stroke="#0284c7" stroke-width="1.5" stroke-dasharray="3,5" opacity=".25"/>
                        <line x1="130" y1="40" x2="40" y2="100" stroke="#0ea5e9" stroke-width="1.5" stroke-dasharray="2,6" opacity=".3"/>
                        <line x1="130" y1="160" x2="260" y2="130" stroke="#0ea5e9" stroke-width="1.5" stroke-dasharray="2,6" opacity=".3"/>
                        <circle cx="40" cy="100" r="10" fill="#E0F2FE" stroke="#0284c7" stroke-width="2"/>
                        <circle cx="40" cy="100" r="4" fill="#0284c7"/>
                        <circle cx="130" cy="40" r="12" fill="#E0F2FE" stroke="#0284c7" stroke-width="2.5"/>
                        <circle cx="130" cy="40" r="5" fill="#0284c7"/>
                        <circle cx="130" cy="40" r="5" fill="none" stroke="#38bdf8" stroke-width="2" class="node-ring"/>
                        <circle cx="130" cy="40" r="5" fill="none" stroke="#38bdf8" stroke-width="1.5" class="node-ring" style="animation-delay:.5s"/>
                        <circle cx="130" cy="40" r="5" fill="none" stroke="#38bdf8" stroke-width="1" class="node-ring" style="animation-delay:1s"/>
                        <circle cx="130" cy="160" r="12" fill="#E0F2FE" stroke="#0284c7" stroke-width="2.5"/>
                        <circle cx="130" cy="160" r="5" fill="#0284c7"/>
                        <circle cx="130" cy="160" r="5" fill="none" stroke="#38bdf8" stroke-width="2" class="node-ring" style="animation-delay:.3s"/>
                        <circle cx="130" cy="160" r="5" fill="none" stroke="#38bdf8" stroke-width="1.5" class="node-ring" style="animation-delay:.8s"/>
                        <circle cx="260" cy="70" r="10" fill="#E0F2FE" stroke="#0284c7" stroke-width="2"/>
                        <circle cx="260" cy="70" r="4" fill="#0284c7"/>
                        <circle cx="260" cy="130" r="10" fill="#E0F2FE" stroke="#0284c7" stroke-width="2"/>
                        <circle cx="260" cy="130" r="4" fill="#0284c7"/>
                        <g class="data-packet-h"><circle cx="0" cy="100" r="3.5" fill="#0284c7"/></g>
                        <g class="data-packet-h"><circle cx="0" cy="100" r="2.5" fill="#38bdf8"/></g>
                        <g class="data-packet-h"><circle cx="0" cy="100" r="3" fill="#0ea5e9"/></g>
                        <g class="data-packet-h"><circle cx="0" cy="100" r="2" fill="#7dd3fc"/></g>
                        <g class="data-packet-v"><circle cx="130" cy="20" r="3" fill="#0284c7"/></g>
                        <g class="data-packet-v"><circle cx="130" cy="20" r="2.5" fill="#38bdf8"/></g>
                        <g class="data-packet-v"><circle cx="130" cy="20" r="2" fill="#7dd3fc"/></g>
                    </g>
                </svg>
            </div>
        </div>

        <!-- Machine: Flow Pipeline -->
        <div class="machine-bg bg-pipeline" aria-hidden="true" data-speed="0.6">
            <div class="machine-parallax">
                <svg viewBox="0 0 1200 60" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <g>
                        <rect x="0" y="18" width="1200" height="24" rx="12" fill="#E5E7EB"/>
                        <rect x="0" y="18" width="1200" height="24" rx="12" fill="url(#pipeGrad)" opacity=".35"/>
                        <rect x="150" y="28" width="30" height="32" rx="3" fill="#9CA3AF" opacity=".5"/>
                        <rect x="150" y="28" width="6" height="32" rx="1" fill="#6B7280" opacity=".6"/>
                        <circle cx="165" cy="38" r="4" fill="#EF4444" opacity=".6"/>
                        <circle cx="165" cy="50" r="3" fill="#10B981" opacity=".5"/>
                        <rect x="950" y="24" width="20" height="28" rx="4" fill="#6B7280" opacity=".4"/>
                        <rect x="948" y="22" width="24" height="4" rx="1" fill="#4B5563" opacity=".5"/>
                        <rect x="948" y="50" width="24" height="4" rx="1" fill="#4B5563" opacity=".5"/>
                        <defs>
                            <linearGradient id="pipeGrad" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#2563eb" stop-opacity="0"/>
                                <stop offset="15%" stop-color="#2563eb"/>
                                <stop offset="85%" stop-color="#3b82f6"/>
                                <stop offset="100%" stop-color="#2563eb" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <g class="flow-dot"><circle cx="0" cy="30" r="5" fill="#2563eb" opacity=".9"/></g>
                        <g class="flow-dot"><circle cx="0" cy="30" r="3.5" fill="#60a5fa" opacity=".7"/></g>
                        <g class="flow-dot"><circle cx="0" cy="30" r="4.5" fill="#3b82f6" opacity=".8"/></g>
                        <g class="flow-dot"><circle cx="0" cy="30" r="3" fill="#93c5fd" opacity=".6"/></g>
                        <g class="flow-dot-fast"><circle cx="0" cy="30" r="3.5" fill="#2563eb" opacity=".7"/></g>
                        <g class="flow-dot-fast"><circle cx="0" cy="30" r="2.5" fill="#60a5fa" opacity=".5"/></g>
                        <g class="flow-dot-fast"><circle cx="0" cy="30" r="3" fill="#3b82f6" opacity=".6"/></g>
                        <g class="flow-dot-fast"><circle cx="0" cy="30" r="2" fill="#93c5fd" opacity=".4"/></g>
                    </g>
                </svg>
            </div>
        </div>

        <!-- Machine: Pulse Signal -->
        <div class="machine-bg bg-pulse" aria-hidden="true" data-speed="0.8">
            <div class="machine-parallax">
                <svg viewBox="0 0 1200 90" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <g>
                        <rect x="0" y="0" width="1200" height="90" rx="6" fill="#F3F4F6" opacity=".2"/>
                        <rect x="0" y="0" width="1200" height="90" rx="6" stroke="#E5E7EB" stroke-width="1" opacity=".3"/>
                        <line x1="0" y1="60" x2="1200" y2="60" stroke="#E5E7EB" stroke-width="1" stroke-dasharray="6,4" opacity=".3"/>
                        <line x1="0" y1="30" x2="1200" y2="30" stroke="#E5E7EB" stroke-width="1" stroke-dasharray="6,4" opacity=".2"/>
                        <polyline points="0,60 40,60 60,20 80,80 100,30 120,70 140,35 160,55 180,38 200,52 220,42 240,48 260,45 280,45 300,20 320,80 340,30 360,70 380,35 400,55 420,38 440,52 460,42 480,48 500,45 520,45 540,20 560,80 580,30 600,70 620,35 640,55 660,38 680,52 700,42 720,48 740,45 760,45 780,20 800,80 820,30 840,70 860,35 880,55 900,38 920,52 940,42 960,48 980,45 1000,45 1020,20 1040,80 1060,30 1080,70 1100,35 1120,55 1140,38 1160,52 1180,45 1200,45"
                            stroke="#059669" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round" class="pulse-wave"/>
                        <polyline points="0,60 40,60 60,40 80,50 100,45 120,55 140,42 160,48 180,52 200,46 220,54 240,50 260,45 280,45 300,40 320,50 340,45 360,55 380,42 400,48 420,52 440,46 460,54 480,50 500,45 520,45 540,40 560,50 580,45 600,55 620,42 640,48 660,52 680,46 700,54 720,50 740,45 760,45 780,40 800,50 820,45 840,55 860,42 880,48 900,52 920,46 940,54 960,50 980,45 1000,45 1020,40 1040,50 1060,45 1080,55 1100,42 1120,48 1140,52 1160,46 1180,54 1200,50"
                            stroke="#10B981" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round" class="pulse-wave-2" opacity=".5"/>
                        <circle cx="0" cy="60" r="4" fill="#059669" class="pulse-blip"/>
                        <rect x="1080" y="64" width="6" height="20" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1083px 74px"/>
                        <rect x="1092" y="58" width="6" height="26" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1095px 71px"/>
                        <rect x="1104" y="52" width="6" height="32" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1107px 68px"/>
                        <rect x="1116" y="56" width="6" height="28" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1119px 70px"/>
                        <rect x="1128" y="60" width="6" height="24" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1131px 72px"/>
                        <rect x="1140" y="50" width="6" height="34" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1143px 67px"/>
                        <rect x="1152" y="54" width="6" height="30" rx="2" fill="#059669" opacity=".6" class="freq-bar" style="transform-origin:1155px 69px"/>
                    </g>
                </svg>
            </div>
        </div>

        <div class="login-container">
            <!-- Hero Section -->
            <div class="login-hero">
                <div class="box-wrapper">
                    <div class="box-glow"></div>
                    <div class="box-logo">
                        <svg viewBox="0 0 200 190" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="boxFront" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#EDCFA0"/>
                                    <stop offset="100%" stop-color="#D4A76A"/>
                                </linearGradient>
                                <linearGradient id="boxTopF" x1="0" y1="1" x2="0" y2="0">
                                    <stop offset="0%" stop-color="#E8C492"/>
                                    <stop offset="100%" stop-color="#F5DEB3"/>
                                </linearGradient>
                                <linearGradient id="boxTopB" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#F5DEB3"/>
                                    <stop offset="100%" stop-color="#E0BF85"/>
                                </linearGradient>
                                <linearGradient id="boxSide" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#C49A5C"/>
                                    <stop offset="100%" stop-color="#9C7340"/>
                                </linearGradient>
                                <linearGradient id="boxInner" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#8B6914"/>
                                    <stop offset="100%" stop-color="#6B4F10"/>
                                </linearGradient>
                                <linearGradient id="tapeGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#FCFCF8"/>
                                    <stop offset="100%" stop-color="#EEE8D8"/>
                                </linearGradient>
                            </defs>
                            <ellipse cx="100" cy="180" rx="75" ry="8" fill="rgba(0,0,0,0.06)"/>
                            <g class="flap-back">
                                <polygon points="44,56 58,42 178,42 164,56" fill="url(#boxTopB)" stroke="#B8864E" stroke-width="1.2">
                                    <animate attributeName="points" values="44,56 58,42 178,42 164,56; 48,68 58,42 178,42 168,66; 44,56 58,42 178,42 164,56" dur="4s" repeatCount="indefinite"/>
                                </polygon>
                                <polygon points="44,56 58,42 178,42 164,56" fill="url(#boxTopB)" stroke="none" opacity=".3">
                                    <animate attributeName="points" values="44,56 58,42 178,42 164,56; 48,68 58,42 178,42 168,66; 44,56 58,42 178,42 164,56" dur="4s" repeatCount="indefinite"/>
                                </polygon>
                            </g>
                            <polygon points="58,42 58,128 30,156 30,70" fill="url(#boxSide)" stroke="#B8864E" stroke-width="1.2"/>
                            <line x1="58" y1="42" x2="58" y2="128" stroke="#8B6914" stroke-width="1" stroke-dasharray="3,4" opacity=".4"/>
                            <rect x="30" y="70" width="120" height="86" rx="2" fill="url(#boxFront)" stroke="#B8864E" stroke-width="1.2"/>
                            <rect x="30" y="70" width="120" height="86" rx="2" fill="url(#boxFront)" stroke="none" opacity="0">
                                <animate attributeName="opacity" values="0;0;0;0" dur="4s" repeatCount="indefinite"/>
                            </rect>
                            <g class="flap-front">
                                <polygon points="30,70 44,56 164,56 150,70" fill="url(#boxTopF)" stroke="#B8864E" stroke-width="1.2">
                                    <animate attributeName="points" values="30,70 44,56 164,56 150,70; 30,70 38,38 158,38 150,70; 30,70 44,56 164,56 150,70" dur="4s" repeatCount="indefinite"/>
                                </polygon>
                            </g>
                            <line x1="150" y1="70" x2="178" y2="42" stroke="#B8864E" stroke-width="1.2"/>
                            <line x1="58" y1="42" x2="178" y2="42" stroke="#A0764A" stroke-width="1.5" opacity=".5"/>
                            <g class="tape-stretch">
                                <rect x="76" y="62" width="28" height="22" rx="2" fill="url(#tapeGrad)" stroke="#E0D8C8" stroke-width=".8">
                                    <animate attributeName="height" values="22; 36; 22" dur="4s" repeatCount="indefinite"/>
                                    <animate attributeName="y" values="62; 48; 62" dur="4s" repeatCount="indefinite"/>
                                </rect>
                                <polygon points="76,62 104,62 108,42 80,42" fill="url(#tapeGrad)" stroke="#E0D8C8" stroke-width=".8">
                                    <animate attributeName="points" values="76,62 104,62 108,42 80,42; 76,48 104,48 108,28 80,28; 76,62 104,62 108,42 80,42" dur="4s" repeatCount="indefinite"/>
                                </polygon>
                            </g>
                            <g transform="translate(106,62) rotate(-28)">
                                <rect x="-14" y="-2" width="28" height="38" rx="2" fill="url(#tapeGrad)" stroke="#E0D8C8" stroke-width=".8" opacity=".85">
                                    <animate attributeName="height" values="38; 52; 38" dur="4s" repeatCount="indefinite"/>
                                </rect>
                            </g>
                            <line x1="82" y1="63" x2="82" y2="83" stroke="#DDD5C5" stroke-width=".5" opacity=".5"/>
                            <line x1="98" y1="63" x2="98" y2="83" stroke="#DDD5C5" stroke-width=".5" opacity=".5"/>
                            <rect x="60" y="100" width="60" height="24" rx="4" fill="#2563eb" opacity=".92"/>
                            <rect x="60" y="100" width="60" height="24" rx="4" fill="none" stroke="#1d4ed8" stroke-width="1" opacity=".3"/>
                            <text x="90" y="117" text-anchor="middle" fill="#fff" font-size="11" font-weight="800" font-family="sans-serif" letter-spacing="1">KEMASIN</text>
                            <rect x="0" y="0" width="200" height="190" fill="none"/>
                        </svg>
                    </div>
                    <div class="box-shadow"></div>
                </div>
                <h1 class="home-title">KemasIn</h1>
                <p class="home-subtitle">
                    Sistem informasi manajemen pengemasan UMKM — kelola target, pantau progres, dan optimalkan produksi kemasan Anda.
                </p>
                <div class="home-badge">
                    <i class="fas fa-cog fa-spin" style="font-size:11px"></i>
                    Sistem Berjalan
                </div>
            </div>

            <!-- Login Form -->
            <div class="login-card card shadow">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" height="60" class="mb-3">
                        <h4 class="fw-bold">SI Kemasan UMKM</h4>
                        <p class="text-muted small">Sistem Informasi Manajemen Produksi & Pengemasan</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first('username') ?: 'Login gagal' }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="username" class="form-label fw-medium small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" class="form-control bg-light" id="username" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light" id="password" name="password" required placeholder="Masukkan password">
                                <button type="button" class="password-toggle input-group-text bg-light" onclick="togglePassword()" tabindex="-1">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-login shadow-sm">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        var input = document.getElementById('password');
        var icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Parallax mouse tracking
    (function() {
        var page = document.getElementById('loginPage');
        var parallax = document.querySelectorAll('.machine-parallax');

        page.addEventListener('mousemove', function(e) {
            var rect = page.getBoundingClientRect();
            var x = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
            var y = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
            x = Math.max(-1, Math.min(1, x));
            y = Math.max(-1, Math.min(1, y));

            parallax.forEach(function(el) {
                var speed = parseFloat(el.closest('.machine-bg').dataset.speed || 1);
                var tx = x * 22 * speed;
                var ty = y * 16 * speed;
                el.style.transform = 'translate(' + tx + 'px, ' + ty + 'px)';
            });
        });

        page.addEventListener('mouseleave', function() {
            parallax.forEach(function(el) {
                el.style.transform = 'translate(0, 0)';
            });
        });
    })();
    </script>
</body>
</html>
