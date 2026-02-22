<aside class="w-20 bg-[#faf6ee] rounded-3xl shadow-md flex flex-col items-center py-6 gap-6 lg:fixed lg:top-6 lg:left-6 lg:bottom-6 lg:z-20 overflow-auto">

    <!-- LOGO ALEXANDRIA -->
    <a href="{{ route('br_user') }}" class="mb-4">
        <svg viewBox="0 0 200 200" class="w-14 h-14">
            <circle cx="100" cy="100" r="88" stroke="#c9a44c" stroke-width="1.4" fill="none"/>
            <circle cx="100" cy="100" r="70" stroke="#e0c98a" stroke-width="0.9" fill="none"/>
            <path d="M70 58 Q100 46 130 58 V142 Q100 154 70 142 Z" fill="none" stroke="#c9a44c" stroke-width="1.6"/>
            <path d="M70 70 Q66 82 70 94 M70 104 Q66 116 70 128" stroke="#c9a44c" stroke-width="0.8" fill="none"/>
            <path d="M130 70 Q134 82 130 94 M130 104 Q134 116 130 128" stroke="#c9a44c" stroke-width="0.8" fill="none"/>
            <line x1="82" y1="78" x2="118" y2="78" stroke="#c9a44c" stroke-width="1"/>
            <line x1="84" y1="92" x2="116" y2="92" stroke="#c9a44c" stroke-width="0.9"/>
            <line x1="86" y1="106" x2="114" y2="106" stroke="#c9a44c" stroke-width="0.9"/>
            <line x1="88" y1="120" x2="112" y2="120" stroke="#c9a44c" stroke-width="0.8"/>
            <path d="M94 66 Q100 62 106 66" stroke="#c9a44c" stroke-width="0.8" fill="none"/>
        </svg>
    </a>

    @php
        $active = 'bg-[#c9a44c] text-white shadow-lg';
        $inactive = 'bg-[#e7dcc8] text-[#6b5a4a] hover:bg-[#d8c9aa]';
    @endphp

    <nav class="flex flex-col gap-5">

        <!-- BR / DASHBOARD -->
        <a href="{{ route('br_user') }}"
           class="w-10 h-10 rounded-xl flex items-center justify-center transition
           {{ request()->routeIs('br_user') ? $active : $inactive }}"
           title="Beranda">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 10.5L12 3l9 7.5M5 10v9a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9"/>
            </svg>
        </a>

        <!-- RAK BUKU -->
        <a href="{{ route('buku_user') }}"
           class="w-10 h-10 rounded-xl flex items-center justify-center transition
           {{ request()->routeIs('buku_user') ? $active : $inactive }}"
           title="Rak Buku">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </a>

        <!-- SIMPAN / WISHLIST -->
        <a href="{{ route('simpan_user') }}"
           class="w-10 h-10 rounded-xl flex items-center justify-center transition
           {{ request()->routeIs('simpan_user') ? $active : $inactive }}"
           title="Simpan">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
            </svg>
        </a>

        <!-- RIWAYAT PEMINJAMAN -->
        <a href="{{ route('riwayat_user') }}"
           class="w-10 h-10 rounded-xl flex items-center justify-center transition
           {{ request()->routeIs('riwayat_user') ? $active : $inactive }}"
           title="Riwayat">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </a>

        <!-- ULASAN SAYA -->
        <a href="{{ route('ulasan.index') }}"
           class="w-10 h-10 rounded-xl flex items-center justify-center transition
           {{ request()->routeIs('ulasan.index') ? $active : $inactive }}"
           title="Ulasan Saya">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
        </a>

        <!-- PROFILE USER -->
        <a href="{{ route('profile_user') }}"
           class="w-10 h-10 rounded-xl flex items-center justify-center transition
           {{ request()->routeIs('profile_user') ? $active : $inactive }}"
           title="Profil">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19a4 4 0 00-6 0M12 12a4 4 0 100-8 4 4 0 000 8z"/>
            </svg>
        </a>

        <!-- LOGOUT (with confirmation modal) -->
        <div class="w-full flex justify-center">
            <button id="logout-btn" type="button"
                    class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-200
                    bg-[#e7dcc8] text-[#6b5a4a] hover:bg-gradient-to-br hover:from-red-400 hover:to-red-500
                    hover:text-white hover:shadow-lg transform hover:scale-110 active:scale-95"
                    title="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="sr-only">
                @csrf
            </form>
        </div>

    </nav>
</aside>

<!-- spacer to keep layout when sidebar is fixed on large screens -->
<div class="hidden lg:block w-20"></div>

<!-- Logout confirmation modal -->
<div id="logout-modal" class="fixed inset-0 hidden items-center justify-center z-50">
    <!-- Background with blur -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Card -->
    <div class="bg-white rounded-3xl p-8 z-10 w-11/12 max-w-md shadow-2xl border border-[#e7dcc8] transform transition-all duration-300 scale-95 opacity-0" id="modal-content">
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#c9a44c] to-[#b08b33] flex items-center justify-center shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-center text-[#3e2a1f] mb-3 font-['Poppins']">Konfirmasi Logout</h3>

        <!-- Message -->
        <p class="text-center text-[#6b5a4a] mb-8 leading-relaxed">
            Apakah Anda yakin ingin keluar dari akun user Alexandria?
        </p>

        <!-- Buttons -->
        <div class="flex gap-4">
            <button id="logout-cancel"
                    class="flex-1 py-3 px-6 rounded-xl border-2 border-[#e7dcc8] text-[#6b5a4a]
                           font-semibold hover:bg-[#faf6ee] hover:border-[#c9a44c] transition-all duration-200
                           transform hover:scale-[1.02] active:scale-[0.98]">
                Batal
            </button>

            <button id="logout-confirm"
                    class="flex-1 py-3 px-6 rounded-xl bg-gradient-to-r from-[#c9a44c] to-[#b08b33]
                           text-white font-semibold shadow-lg hover:shadow-xl transition-all duration-200
                           transform hover:scale-[1.02] active:scale-[0.98] hover:from-[#b08b33] hover:to-[#8a6a3f]">
                <span class="flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </span>
            </button>
        </div>

        <!-- Decorative element -->
        <div class="mt-6 flex justify-center">
            <div class="w-12 h-1 bg-gradient-to-r from-[#c9a44c] to-[#b08b33] rounded-full"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const btn = document.getElementById('logout-btn');
    const modal = document.getElementById('logout-modal');
    const modalContent = document.getElementById('modal-content');
    const cancel = document.getElementById('logout-cancel');
    const confirm = document.getElementById('logout-confirm');
    const form = document.getElementById('logout-form');

    function showModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Trigger animation
        setTimeout(() => {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }, 10);
        // Focus on cancel button for accessibility
        setTimeout(() => cancel.focus(), 100);
    }

    function hideModal() {
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        // Wait for animation to complete before hiding
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    btn && btn.addEventListener('click', showModal);
    cancel && cancel.addEventListener('click', hideModal);
    modal && modal.addEventListener('click', function(e){
        if (e.target === modal) hideModal();
    });
    confirm && confirm.addEventListener('click', function(){
        // Add loading state to confirm button
        confirm.innerHTML = `
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Keluar...
            </span>
        `;
        confirm.disabled = true;
        form && form.submit();
    });

    // Keyboard support
    document.addEventListener('keydown', function(e) {
        if (modal.classList.contains('flex')) {
            if (e.key === 'Escape') {
                hideModal();
            }
        }
    });
});
</script>
