<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adeknya Nana — Profil</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <style>
    :root {
      --blue-deep: #1a3a6b;
      --blue-mid: #2563eb;
      --blue-light: #60a5fa;
      --blue-pale: #dbeafe;
      --gold: #f59e0b;
      --gold-light: #fde68a;
      --white: #ffffff;
      --gray-light: #f0f4ff;
      --gray-text: #64748b;
      --dark: #0f172a;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-light);
      color: var(--dark);
      overflow-x: hidden;
    }

    /* ===== NAVBAR ===== */
    nav {
      position: fixed; top: 0; width: 100%; z-index: 100;
      background: rgba(26, 58, 107, 0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255,255,255,0.1);
      padding: 0 2rem;
      display: flex; align-items: center; justify-content: space-between;
      height: 64px;
      box-shadow: 0 4px 30px rgba(0,0,0,0.2);
    }

    .nav-logo {
      font-family: 'Playfair Display', serif;
      color: var(--white);
      font-size: 1.2rem;
      letter-spacing: 0.5px;
    }

    .nav-logo span { color: var(--gold); }

    .nav-links { display: flex; gap: 0.25rem; }

    .nav-links a {
      color: rgba(255,255,255,0.75);
      text-decoration: none;
      padding: 0.5rem 1.1rem;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: all 0.2s;
      cursor: pointer;
    }

    .nav-links a:hover, .nav-links a.active {
      background: rgba(255,255,255,0.15);
      color: #fff;
    }

    .nav-links a.active {
      background: var(--blue-mid);
      color: #fff;
    }

    /* ===== PAGES ===== */
    .page { display: none; padding-top: 64px; min-height: 100vh; }
    .page.active { display: block; }

    /* ===== HERO / BERANDA ===== */
    .hero {
      background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue-mid) 60%, #3b82f6 100%);
      min-height: calc(100vh - 64px);
      display: flex; align-items: center; justify-content: center;
      position: relative; overflow: hidden;
      padding: 3rem 2rem;
    }

    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .floating-blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(60px);
      opacity: 0.15;
      animation: float 8s ease-in-out infinite;
    }

    .blob1 { width: 400px; height: 400px; background: #60a5fa; top: -100px; right: -100px; animation-delay: 0s; }
    .blob2 { width: 300px; height: 300px; background: var(--gold); bottom: -50px; left: -50px; animation-delay: 3s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-20px) scale(1.05); }
    }

    .hero-card {
      background: rgba(255,255,255,0.12);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 24px;
      padding: 3rem 3.5rem;
      max-width: 540px; width: 100%;
      text-align: center;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      animation: slideUp 0.8s ease;
      position: relative; z-index: 1;
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .avatar-ring {
      width: 130px; height: 130px;
      border-radius: 50%;
      margin: 0 auto 1.5rem;
      padding: 4px;
      background: linear-gradient(135deg, var(--gold), var(--blue-light));
      box-shadow: 0 8px 30px rgba(245,158,11,0.4);
    }

    .avatar-inner {
      width: 100%; height: 100%;
      border-radius: 50%;
      background: linear-gradient(135deg, #dbeafe, #bfdbfe);
      display: flex; align-items: center; justify-content: center;
      font-size: 3rem; overflow: hidden;
      border: 3px solid rgba(255,255,255,0.8);
    }

    .hero-tag {
      display: inline-block;
      background: rgba(245,158,11,0.2);
      border: 1px solid rgba(245,158,11,0.4);
      color: var(--gold-light);
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      padding: 0.3rem 1rem;
      border-radius: 50px;
      margin-bottom: 1rem;
    }

    .hero-name {
      font-family: 'Playfair Display', serif;
      font-size: 2.2rem;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 0.8rem;
    }

    .hero-desc {
      color: rgba(255,255,255,0.75);
      font-size: 0.95rem;
      line-height: 1.7;
      margin-bottom: 2rem;
    }

    .hero-desc strong { color: var(--gold-light); font-weight: 600; }

    .btn-group { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

    .btn-primary {
      background: var(--gold);
      color: var(--dark);
      border: none;
      padding: 0.8rem 1.8rem;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: 0 4px 15px rgba(245,158,11,0.4);
    }

    .btn-primary:hover {
      background: #fbbf24;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245,158,11,0.5);
    }

    .btn-ghost {
      background: transparent;
      color: #fff;
      border: 2px solid rgba(255,255,255,0.4);
      padding: 0.8rem 1.8rem;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-ghost:hover {
      background: rgba(255,255,255,0.1);
      border-color: rgba(255,255,255,0.7);
      transform: translateY(-2px);
    }

    .stats-strip {
      background: rgba(255,255,255,0.08);
      border-top: 1px solid rgba(255,255,255,0.1);
      margin-top: 2rem; padding-top: 1.5rem;
      display: flex; justify-content: center; gap: 2.5rem;
      flex-wrap: wrap;
    }

    .stat-item { text-align: center; }
    .stat-num { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--gold-light); font-weight: 700; }
    .stat-label { font-size: 0.72rem; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }

    /* ===== BIODATA PAGE ===== */
    .page-hero {
      background: linear-gradient(135deg, var(--blue-deep), var(--blue-mid));
      padding: 3rem 2rem;
      text-align: center;
      position: relative; overflow: hidden;
    }

    .page-hero::after {
      content: '';
      position: absolute; bottom: 0; left: 0; right: 0;
      height: 40px;
      background: var(--gray-light);
      clip-path: ellipse(60% 100% at 50% 100%);
    }

    .page-hero h1 {
      font-family: 'Playfair Display', serif;
      color: #fff; font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .page-hero p { color: rgba(255,255,255,0.75); font-size: 1rem; }

    .page-content { max-width: 720px; margin: 0 auto; padding: 3rem 1.5rem; }

    .bio-card {
      background: #fff;
      border-radius: 20px;
      padding: 2.5rem;
      box-shadow: 0 4px 30px rgba(37,99,235,0.08);
      border: 1px solid rgba(37,99,235,0.06);
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .section-title {
      display: flex; align-items: center; gap: 0.75rem;
      font-family: 'Playfair Display', serif;
      font-size: 1.4rem;
      color: var(--blue-deep);
      margin-bottom: 1.75rem;
    }

    .section-title::before {
      content: '';
      width: 4px; height: 28px;
      background: linear-gradient(to bottom, var(--blue-mid), var(--gold));
      border-radius: 4px;
      flex-shrink: 0;
    }

    .bio-table { width: 100%; border-collapse: collapse; }

    .bio-table tr { border-bottom: 1px solid #f1f5f9; }
    .bio-table tr:last-child { border-bottom: none; }

    .bio-table td {
      padding: 0.85rem 0;
      font-size: 0.93rem;
      vertical-align: top;
    }

    .bio-table td:first-child {
      color: var(--blue-mid);
      font-weight: 600;
      width: 180px;
    }

    .bio-table td:nth-child(2) { color: var(--gray-text); width: 16px; }
    .bio-table td:last-child { color: var(--dark); }

    .badge {
      display: inline-block;
      background: var(--blue-pale);
      color: var(--blue-deep);
      padding: 0.25rem 0.8rem;
      border-radius: 20px;
      font-size: 0.82rem;
      font-weight: 600;
    }

    .nav-bottom {
      display: flex; justify-content: center; gap: 1rem;
      margin-top: 2.5rem; flex-wrap: wrap;
    }

    .btn-blue {
      background: var(--blue-mid);
      color: #fff;
      border: none;
      padding: 0.75rem 1.75rem;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s;
      box-shadow: 0 4px 15px rgba(37,99,235,0.3);
    }

    .btn-blue:hover { background: var(--blue-deep); transform: translateY(-2px); }

    .btn-outline {
      background: transparent;
      color: var(--blue-mid);
      border: 2px solid var(--blue-mid);
      padding: 0.75rem 1.75rem;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s;
    }

    .btn-outline:hover { background: var(--blue-pale); transform: translateY(-2px); }

    /* ===== HOBI PAGE ===== */
    .hobi-grid { display: grid; gap: 1.5rem; }

    .hobi-card {
      background: #fff;
      border-radius: 20px;
      padding: 2rem 2.5rem;
      box-shadow: 0 4px 30px rgba(37,99,235,0.08);
      border: 1px solid rgba(37,99,235,0.06);
      animation: fadeIn 0.5s ease;
      animation-fill-mode: both;
      position: relative; overflow: hidden;
    }

    .hobi-card:nth-child(1) { animation-delay: 0.1s; }
    .hobi-card:nth-child(2) { animation-delay: 0.2s; }
    .hobi-card:nth-child(3) { animation-delay: 0.3s; }

    .hobi-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--blue-mid), var(--blue-light), var(--gold));
    }

    .hobi-icon-wrap {
      width: 56px; height: 56px;
      background: var(--blue-pale);
      border-radius: 16px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.6rem;
      margin-bottom: 1.25rem;
    }

    .hobi-card p {
      color: var(--gray-text);
      font-size: 0.93rem;
      line-height: 1.75;
      margin-bottom: 1rem;
    }

    .hobi-card .italic-quote {
      color: var(--blue-mid);
      font-style: italic;
      font-weight: 500;
      border-left: 3px solid var(--gold);
      padding-left: 1rem;
      margin: 1rem 0;
      font-size: 0.93rem;
      line-height: 1.65;
    }

    .persiapan-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem;
      color: var(--blue-deep);
      margin: 1.2rem 0 0.75rem;
    }

    .persiapan-list {
      list-style: none; padding: 0;
    }

    .persiapan-list li {
      display: flex; align-items: flex-start; gap: 0.75rem;
      padding: 0.55rem 0;
      border-bottom: 1px solid #f1f5f9;
      font-size: 0.9rem; color: var(--dark);
    }

    .persiapan-list li:last-child { border-bottom: none; }

    .list-num {
      display: flex; align-items: center; justify-content: center;
      min-width: 26px; height: 26px;
      background: var(--blue-mid);
      color: #fff;
      border-radius: 8px;
      font-size: 0.75rem;
      font-weight: 700;
      margin-top: 1px;
    }

    .list-key { color: var(--blue-mid); font-weight: 600; }

    /* ===== FOOTER ===== */
    footer {
      background: var(--blue-deep);
      color: rgba(255,255,255,0.6);
      text-align: center;
      padding: 1.5rem;
      font-size: 0.85rem;
      margin-top: 1rem;
    }

    footer span { color: var(--gold-light); font-weight: 600; }

    /* ===== SCROLL REVEAL ===== */
    .reveal { opacity: 0; transform: translateY(20px); transition: all 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 600px) {
      .hero-card { padding: 2rem 1.5rem; }
      .hero-name { font-size: 1.75rem; }
      .bio-table td:first-child { width: 130px; }
      .hobi-card { padding: 1.5rem; }
      .page-hero h1 { font-size: 1.8rem; }
      .btn-group { flex-direction: column; align-items: center; }
    }
  </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<nav>
  <div class="nav-logo">✦ <span>adeknya nana</span></div>
  <div class="nav-links">
    <a class="active" onclick="showPage('beranda', this)">Beranda</a>
    <a onclick="showPage('biodata', this)">Biodata</a>
    <a onclick="showPage('hobi', this)">Hobi Saya</a>
  </div>
</nav>

<!-- ===== BERANDA ===== -->
<div id="beranda" class="page active">
  <section class="hero">
    <div class="floating-blob blob1"></div>
    <div class="floating-blob blob2"></div>

    <div class="hero-card">
      <div class="avatar-ring">
        <div class="avatar-inner">🎓</div>
      </div>

      <div class="hero-tag">✦ Mahasiswa Aktif 2025</div>

      <h1 class="hero-name">Halo, Saya<br/>Adeknya nana</h1>

      <p class="hero-desc">
        Mahasiswi semester 2 jurusan <strong>Promosi Kesehatan</strong><br/>
        di <strong>Politeknik Negeri Jember</strong> — NIM G43252442
      </p>

      <div class="btn-group">
        <button class="btn-primary" onclick="showPage('biodata', document.querySelectorAll('.nav-links a')[1])">
          📋 Lihat Biodata
        </button>
        <button class="btn-ghost" onclick="showPage('hobi', document.querySelectorAll('.nav-links a')[2])">
          🌟 Hobi Saya
        </button>
      </div>

      <div class="stats-strip">
        <div class="stat-item">
          <div class="stat-num">2</div>
          <div class="stat-label">Semester</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">2007</div>
          <div class="stat-label">Tahun Lahir</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">2+</div>
          <div class="stat-label">Hobi Favorit</div>
        </div>
      </div>
    </div>
  </section>

  <footer>© 2026 <span>Adeknya Nana</span> — Politeknik Negeri Jember</footer>
</div>

<!-- ===== BIODATA ===== -->
<div id="biodata" class="page">
  <div class="page-hero">
    <h1>Biodata Saya</h1>
    <p>Informasi lengkap tentang diri saya</p>
  </div>

  <div class="page-content">
    <div class="bio-card reveal">
      <div class="section-title">Data Diri</div>
      <table class="bio-table">
        <tr>
          <td>Nama Lengkap</td><td>:</td>
          <td><strong>Adeknya Nana</strong></td>
        </tr>
        <tr>
          <td>NIM</td><td>:</td>
          <td><span class="badge">G43252442</span></td>
        </tr>
        <tr>
          <td>Universitas</td><td>:</td>
          <td>Politeknik Negeri Jember</td>
        </tr>
        <tr>
          <td>Fakultas</td><td>:</td>
          <td>Fakultas Kesehatan</td>
        </tr>
        <tr>
          <td>Prodi</td><td>:</td>
          <td>Promosi Kesehatan</td>
        </tr>
        <tr>
          <td>Tempat, Tgl Lahir</td><td>:</td>
          <td>Jember, 15 Maret 2007</td>
        </tr>
        <tr>
          <td>Jenis Kelamin</td><td>:</td>
          <td>Perempuan</td>
        </tr>
        <tr>
          <td>Agama</td><td>:</td>
          <td>Islam</td>
        </tr>
        <tr>
          <td>Alamat</td><td>:</td>
          <td>Prum. Bernady Land, Selawu, Jember</td>
        </tr>
        <tr>
          <td>Email</td><td>:</td>
          <td>annisa15@gmail.com</td>
        </tr>
      </table>
    </div>

    <div class="nav-bottom">
      <button class="btn-outline" onclick="showPage('beranda', document.querySelectorAll('.nav-links a')[0])">← Beranda</button>
      <button class="btn-blue" onclick="showPage('hobi', document.querySelectorAll('.nav-links a')[2])">Selanjutnya: Hobi Saya →</button>
    </div>
  </div>

  <footer>© 2026 <span>Adeknya Nana</span> — Politeknik Negeri Jember</footer>
</div>

<!-- ===== HOBI SAYA ===== -->
<div id="hobi" class="page">
  <div class="page-hero">
    <h1>Hobi Saya</h1>
    <p>Berenang & Mendengarkan Musik — dua hal yang saya cintai 💙</p>
  </div>

  <div class="page-content">
    <div class="hobi-grid">

      <!-- Card 1 -->
      <div class="hobi-card reveal">
        <div class="hobi-icon-wrap">🏊</div>
        <div class="section-title">Berenang & Mendengarkan Musik</div>
        <p>
          Saya memiliki dua hobi yang sangat saya sukai, yaitu berenang dan mendengarkan musik.
          Awalnya, saya mulai menyukai berenang sejak kecil ketika pertama kali diajak pergi ke
          kolam renang bersama keluarga. Saat itu saya merasa senang karena bisa bermain air
          sekaligus belajar sesuatu yang baru.
        </p>
        <p>
          Sementara itu, ketertarikan saya pada musik muncul ketika saya sering mendengarkan
          lagu saat belajar maupun saat bersantai.
        </p>
        <div class="italic-quote">
          "Air adalah sahabat yang selalu menyambutku dengan pelukan tenang, dan Musik membuat
          saya berfikir bahwa dia akan menjadi teman dalam berbagai suasana."
        </div>
      </div>

      <!-- Card 2 -->
      <div class="hobi-card reveal">
        <div class="hobi-icon-wrap">❤️</div>
        <div class="section-title">Mengapa Saya Menyukainya?</div>
        <p>
          Saya menyukai berenang karena membuat tubuh terasa segar, sehat, dan pikiran menjadi
          lebih rileks. Selain itu, berenang juga membantu saya mengurangi rasa lelah setelah
          beraktivitas.
        </p>
        <p>
          Mendengarkan musik juga memberikan ketenangan dan bisa memperbaiki suasana hati,
          terutama ketika saya merasa bosan atau stres.
        </p>
      </div>

      <!-- Card 3 -->
      <div class="hobi-card reveal">
        <div class="hobi-icon-wrap">🎒</div>
        <div class="section-title">Persiapan yang Dibutuhkan</div>

        <div class="persiapan-title">🏊 Untuk Berenang:</div>
        <ul class="persiapan-list">
          <li><span class="list-num">1</span><span><span class="list-key">Pakaian</span> — digunakan agar nyaman dan aman saat berenang</span></li>
          <li><span class="list-num">2</span><span><span class="list-key">Handuk</span> — untuk mengeringkan tubuh setelah berenang</span></li>
          <li><span class="list-num">3</span><span><span class="list-key">Kacamata Renang</span> — melindungi mata dari air dan membantu melihat di dalam air</span></li>
          <li><span class="list-num">4</span><span><span class="list-key">Sabun & Sampo</span> — membersihkan tubuh setelah berenang</span></li>
          <li><span class="list-num">5</span><span><span class="list-key">Tas Perlengkapan</span> — membawa dan menyimpan semua kebutuhan berenang</span></li>
          <li><span class="list-num">6</span><span><span class="list-key">Kondisi tubuh yang sehat</span> — agar dapat berenang dengan aman dan tidak mudah lelah</span></li>
        </ul>

        <div class="persiapan-title" style="margin-top:1.5rem;">🎵 Untuk Mendengarkan Musik:</div>
        <ul class="persiapan-list">
          <li><span class="list-num">1</span><span><span class="list-key">Ponsel atau pemutar musik</span> — alat untuk memutar lagu</span></li>
          <li><span class="list-num">2</span><span><span class="list-key">Aplikasi musik / file lagu</span> — sumber musik yang akan didengarkan</span></li>
          <li><span class="list-num">3</span><span><span class="list-key">Earphone atau headphone</span> — membantu mendengar musik dengan jelas dan nyaman</span></li>
          <li><span class="list-num">4</span><span><span class="list-key">Baterai penuh / power bank</span> — memastikan perangkat tetap menyala</span></li>
          <li><span class="list-num">5</span><span><span class="list-key">Playlist lagu</span> — memudahkan memilih musik sesuai suasana hati</span></li>
        </ul>
      </div>

    </div>

    <div class="nav-bottom">
      <button class="btn-blue" onclick="showPage('beranda', document.querySelectorAll('.nav-links a')[0])">← Kembali ke Beranda</button>
    </div>
  </div>

  <footer>© 2026 <span>Adeknya Nana</span> — Politeknik Negeri Jember</footer>
</div>

<script>
  function showPage(id, navEl) {
    // hide all pages
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.nav-links a').forEach(a => a.classList.remove('active'));

    document.getElementById(id).classList.add('active');
    if (navEl) navEl.classList.add('active');

    window.scrollTo({ top: 0, behavior: 'smooth' });
    triggerReveal();
  }

  function triggerReveal() {
    setTimeout(() => {
      document.querySelectorAll('.page.active .reveal').forEach((el, i) => {
        setTimeout(() => el.classList.add('visible'), i * 120);
      });
    }, 100);
  }

  // Run on load
  triggerReveal();
</script>
</body>
</html>