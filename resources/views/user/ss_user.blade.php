<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Alexandria – Ancient Manuscripts</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- SERIOUS FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Cormorant+Garamond:wght@400;500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Cormorant Garamond', serif;

      /* BACKGROUND KOTAK-KOTAK */
      background-color: #f4efe4;
      background-image: 
        linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
      background-size: 20px 20px;
    }

    .fade-in {
      animation: fadeIn 2.5s ease forwards;
    }

    .logo-spin {
      animation: spinSlow 26s linear infinite;
    }

    .logo-reveal {
      animation: scaleFade 3s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes scaleFade {
      from {
        opacity: 0;
        transform: scale(0.88);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes spinSlow {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
  </style>
</head>

<body class="text-[#3e2a1f] h-screen flex items-center justify-center overflow-hidden">

  <div class="text-center fade-in">

    <!-- ANCIENT MANUSCRIPT LOGO -->
    <div class="flex justify-center mb-16 logo-reveal">
      <svg width="190" height="190" viewBox="0 0 200 200"
           class="logo-spin">

        <!-- Eternal Ring -->
        <circle cx="100" cy="100" r="88"
                stroke="#c9a44c"
                stroke-width="1.4"
                fill="none"/>

        <!-- Inner Ring -->
        <circle cx="100" cy="100" r="70"
                stroke="#e0c98a"
                stroke-width="0.9"
                fill="none"/>

        <!-- Papyrus Sheet -->
        <path d="M70 58
                 Q100 46 130 58
                 V142
                 Q100 154 70 142 Z"
              fill="none"
              stroke="#c9a44c"
              stroke-width="1.6"/>

        <!-- Papyrus Side Tears -->
        <path d="M70 70 Q66 82 70 94
                 M70 104 Q66 116 70 128"
              stroke="#c9a44c"
              stroke-width="0.8"
              fill="none"/>

        <path d="M130 70 Q134 82 130 94
                 M130 104 Q134 116 130 128"
              stroke="#c9a44c"
              stroke-width="0.8"
              fill="none"/>

        <!-- Ancient Script Lines -->
        <line x1="82" y1="78" x2="118" y2="78"
              stroke="#c9a44c" stroke-width="1"/>
        <line x1="84" y1="92" x2="116" y2="92"
              stroke="#c9a44c" stroke-width="0.9"/>
        <line x1="86" y1="106" x2="114" y2="106"
              stroke="#c9a44c" stroke-width="0.9"/>
        <line x1="88" y1="120" x2="112" y2="120"
              stroke="#c9a44c" stroke-width="0.8"/>

        <!-- Margin Glyph -->
        <path d="M94 66 Q100 62 106 66"
              stroke="#c9a44c"
              stroke-width="0.8"
              fill="none"/>

      </svg>
    </div>

    <!-- TYPOGRAPHY -->
    <div class="space-y-8">

      <h1 class="font-['Cinzel']
                 text-3xl
                 tracking-[0.35em]">
        ALEXANDRIA
      </h1>

      <p class="text-xl italic text-[#5f5044]">
        The Great Library Reimagined
      </p>

      <p class="text-sm tracking-[0.25em] uppercase text-[#7a6a5a]">
        House of Knowledge · Since Antiquity
      </p>

    </div>

  </div>

  <script>
    setTimeout(function() {
        window.location.href = "{{ route('user.lp_user') }}";
    }, 4000);
  </script>

</body>
</html>