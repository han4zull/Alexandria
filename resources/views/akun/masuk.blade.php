<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk - Alexandria</title>

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      margin: 0;
      min-height: 100vh;
      background-color: #f6e9c8;
      background-image:
        linear-gradient(0deg, rgba(200,180,100,0.1) 1px, transparent 1px),
        linear-gradient(90deg, rgba(200,180,100,0.1) 1px, transparent 1px);
      background-size: 40px 40px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      background: #fbf6ec;
      width: 380px;
      border-radius: 18px;
      padding: 24px 26px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    h1 {
      font-family: 'Playfair Display', serif;
      text-align: center;
      font-size: 24px;
      margin: 0;
      color: #4a3a18;
      letter-spacing: 1px;
    }

    .subtitle {
      text-align: center;
      color: #7a6a45;
      margin: 6px 0 18px;
      font-size: 13px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #4a3a18;
      font-size: 13px;
    }

    .input-group {
      position: relative;
      margin-bottom: 12px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 42px 12px 42px;
      border-radius: 12px;
      border: 1px solid #e4d6ad;
      background: #fffaf0;
      font-size: 13px;
      outline: none;
    }

    .input-group input::placeholder {
      color: #b6a97f;
    }

    .icon {
      position: absolute;
      top: 50%;
      left: 14px;
      transform: translateY(-50%);
    }

    .eye {
      position: absolute;
      top: 50%;
      right: 14px;
      transform: translateY(-50%);
      cursor: pointer;
    }

    button {
      width: 100%;
      border: none;
      border-radius: 14px;
      padding: 12px;
      background: linear-gradient(180deg, #d8b45b, #caa14a);
      color: #3e2f12;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 6px;
    }

    button:hover {
      opacity: 0.95;
    }

    .footer {
      text-align: center;
      margin-top: 12px;
      font-size: 13px;
      color: #7a6a45;
    }

    .footer a {
      color: #caa14a;
      font-weight: 600;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="card">
    

    <!-- LOGO -->
    <div style="display:flex; justify-content:center; margin-bottom:12px;">
      <svg width="140" height="140" viewBox="0 0 200 200">
        <circle cx="100" cy="100" r="88" stroke="#c9a44c" stroke-width="1.2" fill="none"/>
        <circle cx="100" cy="100" r="70" stroke="#e0c98a" stroke-width="0.8" fill="none"/>
        <path d="M70 58 Q100 46 130 58 V142 Q100 154 70 142 Z" fill="none" stroke="#c9a44c" stroke-width="1.4"/>
        <path d="M70 70 Q66 82 70 94 M70 104 Q66 116 70 128" stroke="#c9a44c" stroke-width="0.7" fill="none"/>
        <path d="M130 70 Q134 82 130 94 M130 104 Q134 116 130 128" stroke="#c9a44c" stroke-width="0.7" fill="none"/>
        <line x1="82" y1="78" x2="118" y2="78" stroke="#c9a44c" stroke-width="0.9"/>
        <line x1="84" y1="92" x2="116" y2="92" stroke="#c9a44c" stroke-width="0.8"/>
        <line x1="86" y1="106" x2="114" y2="106" stroke="#c9a44c" stroke-width="0.8"/>
        <line x1="88" y1="120" x2="112" y2="120" stroke="#c9a44c" stroke-width="0.7"/>
        <path d="M94 66 Q100 62 106 66" stroke="#c9a44c" stroke-width="0.7" fill="none"/>
      </svg>
    </div>

    <h1>Memasuki perpustakaan<br>Alexandria</h1>
    <p class="subtitle">Mulai perjalanan ilmu pengetahuan Anda</p>

    <form method="POST" action="{{ route('akun.login') }}">
      @csrf

      <!-- EMAIL -->
      <label>Email</label>
      <div class="input-group">
        <span class="icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#c5a85c" stroke-width="2">
            <path d="M4 4h16v16H4z"/>
            <polyline points="22,6 12,13 2,6"/>
          </svg>
        </span>
        <input type="email" name="email" placeholder="Masukkan email Anda" required>
      </div>

      <!-- PASSWORD -->
      <label>Password</label>
      <div class="input-group">
        <span class="icon">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#c5a85c" stroke-width="2">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </span>

        <input type="password" id="password" name="password" placeholder="••••••••" required>

        <span class="eye" onclick="togglePassword()">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
            stroke="#c5a85c" stroke-width="2">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
        </span>
      </div>

      <button type="submit">Memasuki Arsip</button>
    </form>

    <div class="footer">
      Belum punya akun?
      <a href="{{ route('akun.daftar') }}">Daftar sekarang</a>
    </div>

  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>

  <script>
  window.addEventListener('load', () => {
  setTimeout(() => {
    document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]').forEach(input => {
      input.value = '';
    });
  }, 50);
});
</script>

</body>
</html>
