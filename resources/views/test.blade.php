<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BNB Nepali - Travel & Stay</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    :root {
        --brand-red: #EF4444;
        --brand-red-hover: #DC2626;
        --brand-blue: #2563EB;
        --brand-blue-hover: #1D4ED8;
        --dark-bg: #0f172a;
    }
    body {
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        background-color: #ffffff;
    }
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .dropdown-menu {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px) scale(0.98);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }
    .dropdown-menu.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .swiper-button-next, .swiper-button-prev {
        color: #1f2937 !important;
        background: white;
        width: 44px !important;
        height: 44px !important;
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        z-index: 20;
    }
    .swiper-button-next:after, .swiper-button-prev:after {
        font-size: 16px !important;
        font-weight: 900;
    }
    .swiper-button-next:hover, .swiper-button-prev:hover {
        background: var(--brand-red);
        color: white !important;
        transform: scale(1.1);
    }
    .carousel-container .swiper-button-next,
    .carousel-container .swiper-button-prev {
        opacity: 0;
        visibility: hidden;
        transform: translateX(0) scale(0.8);
    }
    .carousel-container:hover .swiper-button-next {
        opacity: 1;
        visibility: visible;
        transform: translateX(10px) scale(1);
    }
    .carousel-container:hover .swiper-button-prev {
        opacity: 1;
        visibility: visible;
        transform: translateX(-10px) scale(1);
    }

    .img-zoom-container { overflow: hidden; }
    .img-zoom-container img { transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
    .group:hover .img-zoom-container img { transform: scale(1.05); }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--brand-blue);
        line-height: 1.75rem;
    }
    @media (min-width: 768px) {
        .section-title {
            font-size: 1.5rem;
            line-height: 2rem;
        }
    }
    .section-subtitle {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    @media (min-width: 768px) {
        .section-subtitle {
            font-size: 0.875rem;
        }
    }

    .see-all-link {
        color: var(--brand-red);
        font-weight: 600;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s;
        white-space: nowrap;
    }
    @media (min-width: 768px) {
        .see-all-link {
            font-size: 0.875rem;
        }
    }
    .see-all-link:hover { color: var(--brand-red-hover); }
    .see-all-link i { transition: transform 0.2s; }
    .see-all-link:hover i { transform: translateX(3px); }

    .cat-item {
        color: #717171;
        border-bottom: 2px solid transparent;
        opacity: 0.8;
        transition: all 0.2s ease;
    }
    .cat-item:hover {
        color: var(--brand-blue);
        border-bottom: 2px solid #e5e5e5;
        opacity: 1;
    }
    .cat-active {
        color: var(--brand-blue) !important;
        border-bottom: 2px solid var(--brand-blue) !important;
        opacity: 1 !important;
    }

    .search-pill {
        transition: box-shadow 0.2s ease;
    }
    .search-pill:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    .search-section {
        transition: all 0.2s ease;
        border-radius: 9999px;
    }

    .calendar-day {
        transition: all 0.15s;
        aspect-ratio: 1/1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
    }
    .calendar-day:hover:not(.disabled) {
        background-color: #f3f4f6;
        transform: scale(1.05);
    }
    .calendar-day.selected {
        background-color: var(--brand-red);
        color: white;
        font-weight: 700;
    }
    .calendar-day.disabled {
        color: #d1d5db;
        cursor: not-allowed;
        pointer-events: none;
    }

    .counter-btn {
        width: 32px; height: 32px;
        border: 1px solid #d1d5db;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .counter-btn:hover { border-color: #000; }
    .counter-btn:active { transform: scale(0.95); }

    .fade-edges {
        mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
    }

/* Mobile Search Overlay Animation */
#mobile-search-overlay {
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease;
    transform: translateY(100%);
    opacity: 0;
    pointer-events: none;
}
#mobile-search-overlay.active {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
}
</style>
</head>
<body class="text-gray-800 flex flex-col min-h-screen overflow-x-hidden">

<!-- ================= NAVIGATION ================= -->
<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-3 transition-all duration-300">
    <div class="max-w-[1536px] mx-auto flex items-center justify-between gap-4">
<!-- Logo & Currency -->
<div class="flex items-center gap-4 md:gap-8">
    <a href="#" class="logo-link flex items-center gap-2.5 group select-none">
        <div class="logo-icon-wrap relative">
            <div class="w-11 h-11 bg-gradient-to-br from-[#EF4444] via-[#DC2626] to-[#b91c1c] rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/25 group-hover:shadow-red-500/40 transition-all duration-300">
                <i class="fa-solid fa-house-chimney-window text-white text-lg"></i>
            </div>
        </div>
        <div class="flex flex-col leading-none hidden md:block">
            <span class="text-[1.35rem] font-extrabold tracking-tight">
                <span class="logo-text-main">Ez</span><span class="logo-text-accent">Property</span>
            </span>

        </div>
    </a>
    <div class="relative hidden md:block" onclick="toggleDropdown(event, 'currency-dropdown')">
        <button class="flex items-center gap-2 px-3 py-1.5 rounded-full hover:bg-gray-50 transition text-sm font-medium border border-transparent hover:border-gray-200">
            NPR
            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400"></i>
        </button>
        <div id="currency-dropdown" class="dropdown-menu absolute top-full left-0 mt-2 w-40 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 overflow-hidden z-50">
            <div class="py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-[#EF4444] flex justify-between items-center bg-red-50/50">
                    <span>NPR (Rs)</span> <i class="fa-solid fa-check text-[#EF4444] text-xs"></i>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex justify-between items-center">
                    <span>INR (₹)</span>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex justify-between items-center">
                    <span>USD ($)</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="hidden lg:flex items-center gap-1 bg-gray-50 p-1 rounded-full border border-gray-100">
    <a href="#" class="flex items-center gap-2 px-5 py-2 rounded-full bg-white shadow-sm text-[#2563EB] text-sm font-semibold transition">
        <i class="fa-solid fa-bed"></i> Stay
    </a>
    <a href="#" class="flex items-center gap-2 px-5 py-2 text-gray-600 hover:text-black hover:bg-white hover:shadow-sm rounded-full transition text-sm font-medium">
        <i class="fa-regular fa-face-smile"></i> Experience
    </a>
    <a href="#" class="flex items-center gap-2 px-5 py-2 text-gray-600 hover:text-black hover:bg-white hover:shadow-sm rounded-full transition text-sm font-medium">
        <i class="fa-solid fa-map"></i> Map
    </a>
</div>

<!-- Right Actions -->
<div class="flex items-center gap-2 md:gap-3">
   
    <button class="hidden md:flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-full text-sm font-semibold hover:shadow-md hover:border-gray-300 transition">
        <i class="fa-solid fa-plus text-[#EF4444]"></i> <span>List property</span>
    </button>
    
    <div class="relative" onclick="toggleDropdown(event, 'language-dropdown')">
        <button class="p-2.5 rounded-full hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
            <i class="fa-solid fa-globe text-gray-600"></i>
        </button>
        <div id="language-dropdown" class="dropdown-menu absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 overflow-hidden z-50">
            <div class="py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex justify-between items-center">
                    <span>English</span> <i class="fa-solid fa-check text-[#EF4444] text-xs"></i>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Nepali (नेपाली)</a>
            </div>
        </div>
    </div>
    <div class="relative" onclick="toggleDropdown(event, 'profile-dropdown')">
        <button class="p-1 pl-3 rounded-full hover:bg-gray-100 transition border border-gray-200 flex items-center gap-2 shadow-sm hover:shadow-md">
            <i class="fa-solid fa-bars text-gray-600 text-sm"></i>
            <div class="bg-gray-200 rounded-full p-1.5 text-gray-500 w-8 h-8 flex items-center justify-center hover:bg-gray-300 transition">
                <i class="fa-solid fa-user text-xs"></i>
            </div>
        </button>
        <div id="profile-dropdown" class="dropdown-menu absolute top-full right-0 mt-3 w-64 bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 overflow-hidden z-50 py-2">
            <a href="#" class="block px-4 py-2.5 text-sm font-bold text-gray-900 hover:bg-gray-50">Sign up</a>
            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Log in</a>
            <hr class="my-2 border-gray-100">
            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 font-medium">Become a host</a>
            <hr class="my-2 border-gray-100">
            <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Help Center</a>
        </div>
    </div>
</div>
</div>
</nav>

<!-- ================= MOBILE SEARCH TRIGGER ================= -->
<section class="md:hidden bg-white px-4 py-3 border-b border-gray-100 sticky top-[65px] z-30">
    <button onclick="openMobileSearch()" class="w-full flex items-center gap-3 bg-white border border-gray-200 rounded-2xl p-3 shadow-sm hover:shadow-md transition text-left">
        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
            <i class="fa-solid fa-magnifying-glass text-gray-700"></i>
        </div>
        <div class="flex-1">
            <div class="text-sm font-bold text-gray-900">Where to?</div>
            <div class="text-xs text-gray-500">Anywhere · Any week · Add guests</div>
        </div>
        <div class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center">
            <i class="fa-solid fa-sliders text-gray-700 text-sm"></i>
        </div>
    </button>
</section>

<!-- ================= MOBILE SEARCH OVERLAY ================= -->
<div id="mobile-search-overlay" class="fixed inset-0 bg-white z-[100] flex-col md:hidden flex">
    <div class="flex items-center justify-between p-4 border-b border-gray-100 shadow-sm">
        <button onclick="closeMobileSearch()" class="p-2 rounded-full hover:bg-gray-100 transition">
            <i class="fa-solid fa-arrow-left text-gray-800 text-lg"></i>
        </button>
        <h2 class="font-bold text-lg text-gray-900">Search stays</h2>
        <button class="text-sm font-semibold text-gray-800 underline">Clear</button>
    </div>
    <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
<!-- Where -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
    <label class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Where</label>
    <input type="text" placeholder="Search destinations" class="w-full text-lg text-gray-900 outline-none mt-1 bg-transparent placeholder-gray-400">
    <div class="flex gap-2 mt-4 overflow-x-auto hide-scrollbar pb-1">
        <button class="shrink-0 flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full text-xs font-medium text-gray-700 transition">
            <i class="fa-solid fa-place-of-worship text-orange-500"></i> Kathmandu
        </button>
        <button class="shrink-0 flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full text-xs font-medium text-gray-700 transition">
            <i class="fa-solid fa-water text-blue-500"></i> Pokhara
        </button>
        <button class="shrink-0 flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full text-xs font-medium text-gray-700 transition">
            <i class="fa-solid fa-tree text-green-500"></i> Chitwan
        </button>
    </div>
</div>
<!-- When -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex justify-between items-center cursor-pointer hover:border-gray-300 transition">
    <div>
        <label class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">When</label>
        <div class="text-lg text-gray-400 mt-1">Add dates</div>
    </div>
    <i class="fa-solid fa-chevron-right text-gray-300"></i>
</div>
<!-- Who -->
<div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm flex justify-between items-center cursor-pointer hover:border-gray-300 transition">
    <div>
        <label class="text-[10px] font-bold text-gray-900 uppercase tracking-wider">Who</label>
        <div class="text-lg text-gray-400 mt-1">Add guests</div>
    </div>
    <i class="fa-solid fa-chevron-right text-gray-300"></i>
</div>
</div>
<div class="p-4 bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
    <button class="w-full bg-gradient-to-r from-[#EF4444] to-[#DC2626] text-white py-4 rounded-2xl font-bold text-base flex items-center justify-center gap-2 shadow-lg shadow-red-500/20 active:scale-[0.98] transition">
        <i class="fa-solid fa-magnifying-glass"></i> Search
    </button>
</div>
</div>

<!-- ================= HERO / DESKTOP SEARCH ================= -->
<section id="main-search-section" class="relative pt-8 pb-4 px-4 sm:px-6 lg:px-8 hidden md:block z-40">
    <div class="max-w-[1536px] mx-auto flex justify-center">
        <div class="search-pill relative flex w-full max-w-[840px] items-center bg-white rounded-full border border-gray-200 shadow-sm hover:shadow-lg transition-all cursor-pointer">
            <div class="search-section relative flex-1 px-6 py-3 rounded-full text-left" onclick="toggleSearchSection(event, 'where')">
                <label class="block text-xs font-bold text-gray-900">Where</label>
                <input type="text" id="where-input" placeholder="Search destinations" class="w-full text-sm text-gray-600 outline-none bg-transparent truncate placeholder-gray-400">
                <div id="where-dropdown" class="dropdown-menu absolute top-full left-0 mt-4 w-[680px] max-w-[90vw] bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50">
                    <div class="p-5">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Popular destinations in Nepal</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <button onclick="selectDestination('Kathmandu')" class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition text-left group/btn border border-transparent hover:border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-place-of-worship text-orange-500 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 group-hover/btn:text-[#EF4444] transition">Kathmandu</div>
                                    <div class="text-xs text-gray-500">Capital city</div>
                                </div>
                            </button>
                            <button onclick="selectDestination('Pokhara')" class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition text-left group/btn border border-transparent hover:border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-water text-blue-500 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 group-hover/btn:text-[#EF4444] transition">Pokhara</div>
                                    <div class="text-xs text-gray-500">Lake city</div>
                                </div>
                            </button>
                            <button onclick="selectDestination('Chitwan')" class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition text-left group/btn border border-transparent hover:border-gray-100">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-tree text-green-500 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 group-hover/btn:text-[#EF4444] transition">Chitwan</div>
                                    <div class="text-xs text-gray-500">Jungle safari</div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-px h-8 bg-gray-200"></div>
            <div class="search-section relative flex-1 px-6 py-3 rounded-full text-left" onclick="toggleSearchSection(event, 'when')">
                <label class="block text-xs font-bold text-gray-900">When</label>
                <input type="text" id="when-input" placeholder="Add dates" class="w-full text-sm text-gray-600 outline-none bg-transparent truncate placeholder-gray-400" readonly>
            </div>
            <div class="w-px h-8 bg-gray-200"></div>
            <div class="search-section relative flex-1 px-6 py-3 rounded-full text-left flex items-center justify-between gap-4" onclick="toggleSearchSection(event, 'guests')">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-900">Who</label>
                    <input type="text" id="guests-input" placeholder="Add guests" class="w-full text-sm text-gray-600 outline-none bg-transparent truncate placeholder-gray-400">
                </div>
                <div id="guests-dropdown" class="dropdown-menu absolute top-full right-0 mt-4 w-[380px] max-w-full bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-100">
                            <div>
                                <div class="text-base font-medium text-gray-900">Adults</div>
                                <div class="text-sm text-gray-500">Ages 13 or above</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="counter-btn" onclick="updateGuests('adults', -1)"><i class="fa-solid fa-minus text-xs text-gray-600"></i></button>
                                <span id="adults-count" class="w-8 text-center font-medium text-gray-900">0</span>
                                <button class="counter-btn" onclick="updateGuests('adults', 1)"><i class="fa-solid fa-plus text-xs text-gray-600"></i></button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <div>
                                <div class="text-base font-medium text-gray-900">Children</div>
                                <div class="text-sm text-gray-500">Ages 2-12</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button class="counter-btn" onclick="updateGuests('children', -1)"><i class="fa-solid fa-minus text-xs text-gray-600"></i></button>
                                <span id="children-count" class="w-8 text-center font-medium text-gray-900">0</span>
                                <button class="counter-btn" onclick="updateGuests('children', 1)"><i class="fa-solid fa-plus text-xs text-gray-600"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bg-[#EF4444] hover:bg-[#DC2626] text-white rounded-full p-3.5 transition-all transform hover:scale-105 active:scale-95 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-base"></i>
                </button>
            </div>
            <div id="when-dropdown" class="dropdown-menu absolute top-full left-0 right-0 mt-4 bg-white rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.15)] border border-gray-100 overflow-hidden z-50 p-6">
                <div class="flex items-center justify-between mb-6">
                    <button onclick="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded-full transition"><i class="fa-solid fa-chevron-left text-gray-600"></i></button>
                    <div id="calendar-months-display" class="flex items-center justify-around flex-1 px-4">
                        <h3 class="font-semibold text-gray-900 text-center w-1/2" id="month1-name"></h3>
                        <h3 class="font-semibold text-gray-900 text-center w-1/2" id="month2-name"></h3>
                    </div>
                    <button onclick="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded-full transition"><i class="fa-solid fa-chevron-right text-gray-600"></i></button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="grid grid-cols-7 gap-1 text-center text-[11px] mb-2 text-gray-400 font-medium uppercase">
                            <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                        </div>
                        <div id="calendar-grid-1" class="grid grid-cols-7 gap-1"></div>
                    </div>
                    <div>
                        <div class="grid grid-cols-7 gap-1 text-center text-[11px] mb-2 text-gray-400 font-medium uppercase">
                            <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                        </div>
                        <div id="calendar-grid-2" class="grid grid-cols-7 gap-1"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                    <button onclick="clearDates()" class="text-sm font-bold underline hover:text-gray-500 transition">Clear dates</button>
                    <button onclick="closeAllDropdowns()" class="text-sm font-bold bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-800 transition">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CATEGORIES ================= -->
<section class="bg-white border-b border-gray-100 px-4 sm:px-6 lg:px-8 py-4 z-30">
    <div class="max-w-[1536px] mx-auto flex items-center gap-4">
        <div class="flex-1 overflow-x-auto hide-scrollbar fade-edges">
            <div class="flex gap-6 min-w-max py-1 justify-start lg:justify-center">
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium transition whitespace-nowrap bg-[#2563EB] text-white border border-[#2563EB] shadow-sm">
                    <i class="fa-solid fa-border-all"></i>
                    <span>All</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span>Entire Home</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-people-roof"></i>
                    <span>Homestay</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-hotel"></i>
                    <span>Hotel</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-umbrella-beach"></i>
                    <span>Resort</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-mountain-sun"></i>
                    <span>Views</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-tree"></i>
                    <span>Camping</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-water"></i>
                    <span>Lakefront</span>
                </button>
                <button class="flex items-center gap-4 px-4 py-2.5 rounded-full text-sm font-medium text-gray-600 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition whitespace-nowrap">
                    <i class="fa-solid fa-campground"></i>
                    <span>Trekking</span>
                </button>
            </div>
        </div>
        <button class="shrink-0 flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-xl text-xs font-semibold text-gray-800 hover:border-black hover:shadow-md transition bg-white">
            <i class="fa-solid fa-sliders"></i>
            <span class="hidden sm:inline">Filters</span>
        </button>
    </div>
</section>

<!-- ================= FEATURED PROPERTIES CAROUSEL ================= -->
<section class="bg-white px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="max-w-[1536px] mx-auto">
        <div class="flex items-end justify-between mb-6 px-2">
            <div>
                <h2 class="section-title">Featured Properties</h2>
                <p class="section-subtitle">Top rated stays loved by travelers</p>
            </div>
        </div>
        <div class="swiper mySwiper carousel-container pb-8 px-2">
            <div class="swiper-wrapper">
<!-- Slides -->
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1544985335-937222379894?q=80&w=600&auto=format&fit=crop" alt="Pokhara" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Lakeview Apartment</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Apartment</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.95</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$45</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1626017169472-7472dd41b833?q=80&w=600&auto=format&fit=crop" alt="Kathmandu" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Thamel Heritage Stay</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Heritage</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.80</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$32</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1587595431973-160d0d94add1?q=80&w=600&auto=format&fit=crop" alt="Chitwan" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">New</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Jungle Safari Lodge</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Lodge</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.92</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$85</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1518182170546-0766ce6fec56?q=80&w=600&auto=format&fit=crop" alt="Mustang" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Mountain View Homestay</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Homestay</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.75</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$28</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=600&auto=format&fit=crop" alt="Bhaktapur" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Traditional Newari House</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">House</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.88</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$55</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=600&auto=format&fit=crop" alt="Luxury" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Superhost</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Luxury Villa with Pool</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Villa</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 5.0</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$120</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
<div class="swiper-slide h-auto">
    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Breakfast included</div>
            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                <i class="fa-regular fa-heart text-xl"></i>
            </button>
        </div>
        <h3 class="font-bold text-gray-900 truncate text-sm">Korner Saint-Marcel</h3>
        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
            <span>•</span>
            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.65</span>
        </div>
        <div class="flex items-baseline gap-1">
            <span class="font-bold text-lg text-gray-900">$318</span>
            <span class="text-sm text-gray-500">total for 2 nights</span>
        </div>
    </div>
</div>
</div>
<div class="swiper-button-next"></div>
<div class="swiper-button-prev"></div>
</div>
</div>
</section>

<!-- ================= STAYS NEAR YOU ================= -->
<section class="bg-gray-50 rounded-t-[2.5rem] px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="max-w-[1536px] mx-auto">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="section-title">Stays Near You</h2>
                <p class="section-subtitle">Professional hospitality with local charm</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-4">
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Breakfast included</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Korner Saint-Marcel</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.65</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$318</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Hotel Joke Boutique</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Boutique</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.85</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$357</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Free Cancellation</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">City Center Hotel</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.65</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$120</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">The Dwarika's Resort</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Resort</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.95</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$450</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Eco-Friendly Cabin</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Cabin</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.90</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$80</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Boutique Hotel</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.75</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$95</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>


             <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Boutique Hotel</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.75</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$95</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= HOMESTAYS CAROUSEL ================= -->
<section class="bg-white px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="max-w-[1536px] mx-auto">
        <div class="flex items-end justify-between mb-6 px-2">
            <div>
                <h2 class="section-title">Homestays - Feel like Home</h2>
                <p class="section-subtitle">Top rated stays loved by travelers</p>
            </div>
        </div>
        <div class="swiper mySwiper carousel-container pb-8 px-2">
            <div class="swiper-wrapper">
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?q=80&w=600&auto=format&fit=crop" alt="Bandipur" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Peaceful Valley Homestay</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Homestay</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.98</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$38</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?q=80&w=600&auto=format&fit=crop" alt="Palpa" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Riverside Retreat</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Retreat</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.85</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$42</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=600&auto=format&fit=crop" alt="Bhaktapur" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Traditional Newari House</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">House</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.90</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$55</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1518182170546-0766ce6fec56?q=80&w=600&auto=format&fit=crop" alt="Mustang" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Mountain View Homestay</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Homestay</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.75</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$28</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?q=80&w=600&auto=format&fit=crop" alt="Pokhara" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Superhost</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Cozy Terrace Home</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Home</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.88</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$48</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=600&q=80" alt="Chitwan" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Eco-Friendly Cabin</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Cabin</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 5.0</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$65</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide h-auto">
                    <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100 h-full">
                        <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Breakfast included</div>
                            <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                                <i class="fa-regular fa-heart text-xl"></i>
                            </button>
                        </div>
                        <h3 class="font-bold text-gray-900 truncate text-sm">Korner Saint-Marcel</h3>
                        <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                            <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                            <span>•</span>
                            <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.65</span>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-lg text-gray-900">$318</span>
                            <span class="text-sm text-gray-500">total for 2 nights</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- ================= RECOMMENDED GRID ================= -->
<section class="bg-gray-50 px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="max-w-[1536px] mx-auto">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="section-title">Recommended for you</h2>
                <p class="section-subtitle">Professional hospitality with local charm</p>
            </div>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-7 gap-4">
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Breakfast included</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Himalayan Resort</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Resort</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.80</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$210</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">City Center Hotel</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.65</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$120</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Free Cancellation</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">The Dwarika's Resort</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Resort</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.95</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$450</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Eco-Friendly Cabin</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Cabin</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.90</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$80</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Breakfast included</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Korner Saint-Marcel</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Hotel</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.65</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$318</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Hotel Joke Boutique</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Boutique</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.85</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$357</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1544985335-937222379894?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Lakeview Apartment</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Apartment</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.95</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$45</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1626017169472-7472dd41b833?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Thamel Heritage Stay</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Heritage</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.80</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$32</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1587595431973-160d0d94add1?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">New</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Jungle Safari Lodge</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Lodge</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.92</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$85</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Superhost</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Luxury Villa with Pool</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Villa</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 5.0</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$120</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Traditional Newari House</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">House</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.88</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$55</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>


             <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Superhost</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Luxury Villa with Pool</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">Villa</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 5.0</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$120</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
            <div class="group cursor-pointer bg-white rounded-2xl p-3 hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-200 mb-3 img-zoom-container">
                    <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=600&auto=format&fit=crop" class="object-cover w-full h-full">
                    <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold shadow-sm">Guest favorite</div>
                    <button class="absolute top-3 right-3 text-white hover:scale-110 transition drop-shadow-md active:scale-90">
                        <i class="fa-regular fa-heart text-xl"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 truncate text-sm">Traditional Newari House</h3>
                <div class="flex items-center gap-1 text-xs text-gray-500 mt-1 mb-2">
                    <span class="bg-gray-100 px-1.5 py-0.5 rounded">House</span>
                    <span>•</span>
                    <span class="flex items-center gap-0.5"><i class="fa-solid fa-star text-[#EF4444]"></i> 4.88</span>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="font-bold text-lg text-gray-900">$55</span>
                    <span class="text-sm text-gray-500">total for 2 nights</span>
                </div>
            </div>
        </div>
    </div>
</section>


<footer class="bg-gray-50 border-t border-gray-200 pt-16 pb-8 md:pb-12 px-4 sm:px-6 lg:px-8 mt-12">
    <div class="max-w-[1536px] mx-auto">
        
        <!-- Top Section: CTA & Newsletter -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 mb-16 pb-12 border-b border-gray-200">
            <!-- Left: Brand & Tags -->
            <div class="space-y-6">
                <a href="#" class="flex items-center gap-3 group w-fit">
                    <div class="w-10 h-10 bg-[#EF4444] rounded-xl flex items-center justify-center shadow-md shadow-red-500/20 group-hover:shadow-red-500/30 transition-all duration-300">
                        <i class="fa-solid fa-house-chimney-window text-white text-lg"></i>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-2xl font-extrabold text-gray-900 tracking-tight">
                            Ez<span class="text-[#EF4444]">Property</span>
                        </span>
                        <span class="text-[9px] font-semibold text-gray-500 tracking-[0.2em] uppercase mt-1">Stay • Experience</span>
                    </div>
                </a>
                <p class="text-gray-600 text-sm md:text-base leading-relaxed max-w-md">
                    Your gateway to authentic Nepali hospitality. Find your perfect mountain retreat, city apartment, or jungle lodge.
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">#Kathmandu</span>
                    <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">#Pokhara</span>
                    <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">#Chitwan</span>
                    <span class="px-3 py-1.5 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">#Mustang</span>
                </div>
            </div>

            <!-- Right: Newsletter -->
            <div class="flex flex-col justify-center">
                <h4 class="text-gray-900 font-bold text-xl md:text-2xl mb-2">Stay in the loop</h4>
                <p class="text-gray-500 text-sm mb-6">Get the latest deals, travel guides, and hidden gems delivered to your inbox.</p>
                <form class="flex flex-col sm:flex-row gap-3 max-w-lg" onsubmit="event.preventDefault();">
                    <input type="email" placeholder="Your email address" class="flex-1 bg-white border border-gray-300 text-gray-900 px-4 py-3.5 rounded-xl focus:outline-none focus:border-[#EF4444] focus:ring-2 focus:ring-red-500/10 transition text-sm placeholder-gray-400 shadow-sm">
                    <button type="submit" class="w-full sm:w-auto bg-gray-900 hover:bg-black text-white px-6 py-3.5 rounded-xl font-semibold text-sm transition-all shadow-md flex items-center justify-center gap-2 whitespace-nowrap">
                        Subscribe
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </form>
                <p class="text-[11px] text-gray-400 mt-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-shield-halved"></i> We respect your privacy. Unsubscribe at any time.
                </p>
            </div>
        </div>

        <!-- Links Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 lg:gap-12 mb-16">
            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-sm uppercase tracking-wider">Company</h4>
                <ul class="space-y-3.5 text-sm text-gray-600">
                    <li><a href="#" class="footer-light-link">About Us</a></li>
                    <li><a href="#" class="footer-light-link">Careers</a></li>
                    <li><a href="#" class="footer-light-link">Newsroom</a></li>
                    <li><a href="#" class="footer-light-link">Learn</a></li>
                    <li><a href="#" class="footer-light-link">Investors</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-sm uppercase tracking-wider">Community</h4>
                <ul class="space-y-3.5 text-sm text-gray-600">
                    <li><a href="#" class="footer-light-link">Accessibility</a></li>
                    <li><a href="#" class="footer-light-link">BNB Nepali Associates</a></li>
                    <li><a href="#" class="footer-light-link">Frontline Stays</a></li>
                    <li><a href="#" class="footer-light-link">Guest Referrals</a></li>
                    <li><a href="#" class="footer-light-link">Forum</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-sm uppercase tracking-wider">Host</h4>
                <ul class="space-y-3.5 text-sm text-gray-600">
                    <li><a href="#" class="footer-light-link">List Your Property</a></li>
                    <li><a href="#" class="footer-light-link">Host Resources</a></li>
                    <li><a href="#" class="footer-light-link">Community Forum</a></li>
                    <li><a href="#" class="footer-light-link">Responsible Hosting</a></li>
                    <li><a href="#" class="footer-light-link">Offer an Experience</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-5 text-sm uppercase tracking-wider">Support</h4>
                <ul class="space-y-3.5 text-sm text-gray-600">
                    <li><a href="#" class="footer-light-link">Help Center</a></li>
                    <li><a href="#" class="footer-light-link">Safety Information</a></li>
                    <li><a href="#" class="footer-light-link">Cancellation Options</a></li>
                    <li><a href="#" class="footer-light-link">Report a Concern</a></li>
                    <li><a href="#" class="footer-light-link">Contact Us</a></li>
                </ul>
            </div>
            
            <!-- App Download (Spans full width on mobile, 1 col on desktop) -->
            <div class="col-span-2 md:col-span-4 lg:col-span-1">
                <h4 class="font-bold text-gray-900 mb-5 text-sm uppercase tracking-wider">Get the App</h4>
                <div class="flex flex-col gap-3">
                    <button class="bg-white hover:bg-gray-50 text-gray-900 rounded-xl px-4 py-3 flex items-center gap-3 transition-all w-full border border-gray-200 hover:border-gray-300 shadow-sm group">
                        <i class="fa-brands fa-apple text-2xl text-gray-800"></i>
                        <div class="text-left">
                            <div class="text-[10px] leading-none text-gray-500 mb-0.5">Download on the</div>
                            <div class="text-sm font-bold">App Store</div>
                        </div>
                    </button>
                    <button class="bg-white hover:bg-gray-50 text-gray-900 rounded-xl px-4 py-3 flex items-center gap-3 transition-all w-full border border-gray-200 hover:border-gray-300 shadow-sm group">
                        <i class="fa-brands fa-google-play text-xl text-gray-800"></i>
                        <div class="text-left">
                            <div class="text-[10px] leading-none text-gray-500 mb-0.5">GET IT ON</div>
                            <div class="text-sm font-bold">Google Play</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Bottom Bar: Copyright & Payments -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-8 border-t border-gray-200">
            <div class="text-sm text-gray-500 order-2 md:order-1 flex flex-col md:flex-row items-center gap-2 md:gap-4 text-center md:text-left">
                <span class="flex items-center gap-2">
                    <i class="fa-regular fa-copyright text-xs"></i> 2026 BNB Nepali Pvt. Ltd.
                </span>
                <span class="hidden md:inline text-gray-300">•</span>
                <div class="flex gap-4 text-xs font-medium">
                    <a href="#" class="hover:text-gray-900 hover:underline underline-offset-4 transition">Privacy</a>
                    <a href="#" class="hover:text-gray-900 hover:underline underline-offset-4 transition">Terms</a>
                    <a href="#" class="hover:text-gray-900 hover:underline underline-offset-4 transition">Sitemap</a>
                </div>
            </div>
            
            <div class="flex flex-wrap justify-center items-center gap-4 order-1 md:order-2 bg-white px-5 py-3 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mr-1">Secure Payments:</span>
                <i class="fa-brands fa-cc-visa text-2xl text-gray-600 hover:text-gray-900 transition-all cursor-pointer transform hover:scale-110"></i>
                <i class="fa-brands fa-cc-mastercard text-2xl text-gray-600 hover:text-gray-900 transition-all cursor-pointer transform hover:scale-110"></i>
                <i class="fa-brands fa-cc-paypal text-2xl text-gray-600 hover:text-gray-900 transition-all cursor-pointer transform hover:scale-110"></i>
                
                <div class="w-px h-5 bg-gray-200 mx-1"></div>
                
                <div class="flex gap-2">
                    <span class="text-[10px] font-bold text-green-600 border border-green-200 px-2.5 py-1 rounded-md bg-green-50 flex items-center gap-1.5">
                        <i class="fa-solid fa-check-circle text-[9px]"></i> eSewa
                    </span>
                    <span class="text-[10px] font-bold text-purple-600 border border-purple-200 px-2.5 py-1 rounded-md bg-purple-50 flex items-center gap-1.5">
                        <i class="fa-solid fa-check-circle text-[9px]"></i> Khalti
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// Swiper initialization
    document.querySelectorAll('.mySwiper').forEach(swiperEl => {
        new Swiper(swiperEl, {
            slidesPerView: 2,
            spaceBetween: 12,
            loop: true,
            grabCursor: true,
            autoHeight: false,
            navigation: {
                nextEl: swiperEl.querySelector('.swiper-button-next'),
                prevEl: swiperEl.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 16 },
                768: { slidesPerView: 4, spaceBetween: 16 },
                1024: { slidesPerView: 5, spaceBetween: 16 },
                1280: { slidesPerView: 6, spaceBetween: 16 },
                1536: { slidesPerView: 7, spaceBetween: 16 }
            }
        });
    });

// Mobile Search Overlay Functions
    function openMobileSearch() {
        const overlay = document.getElementById('mobile-search-overlay');
        overlay.classList.add('active');
document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeMobileSearch() {
    const overlay = document.getElementById('mobile-search-overlay');
    overlay.classList.remove('active');
document.body.style.overflow = ''; // Restore scrolling
}

// Desktop Dropdown toggle
function toggleDropdown(event, dropdownId) {
    event.stopPropagation();
    const dropdown = document.getElementById(dropdownId);
    const isActive = dropdown.classList.contains('active');
    closeAllDropdowns();
    if (!isActive) {
        dropdown.classList.add('active');
    }
}

// Desktop Search Section Toggle
function toggleSearchSection(event, section) {
    event.stopPropagation();
    document.querySelectorAll('.dropdown-menu').forEach(d => d.classList.remove('active'));
    const dropdown = document.getElementById(section + '-dropdown');
    if (!dropdown.classList.contains('active')) {
        dropdown.classList.add('active');
    } else {
        dropdown.classList.remove('active');
    }
}

function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-menu').forEach(d => d.classList.remove('active'));
}

function selectDestination(city) {
    document.getElementById('where-input').value = city;
    closeAllDropdowns();
}

let guests = { adults: 0, children: 0 };
function updateGuests(type, change) {
    const newValue = guests[type] + change;
    if (newValue >= 0 && newValue <= 10) {
        guests[type] = newValue;
        const desktopCount = document.getElementById(type + '-count');
        if(desktopCount) desktopCount.textContent = newValue;

        const total = guests.adults + guests.children;
        const val = total > 0 ? `${total} guest${total > 1 ? 's' : ''}` : '';
        const input = document.getElementById('guests-input');
        if(input) input.value = val;
    }
}

// =================CALENDAR LOGIC=================
let currentMonthOffset = 0;
const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

function renderCalendars() {
    const today = new Date();
    const month1Date = new Date(today.getFullYear(), today.getMonth() + currentMonthOffset, 1);
    const month2Date = new Date(today.getFullYear(), today.getMonth() + currentMonthOffset + 1, 1);
    renderCalendar('calendar-grid-1', 'month1-name', month1Date);
    renderCalendar('calendar-grid-2', 'month2-name', month2Date);
}

function renderCalendar(gridId, monthNameId, date) {
    const grid = document.getElementById(gridId);
    const monthName = document.getElementById(monthNameId);
    if(!grid || !monthName) return;
    monthName.textContent = `${monthNames[date.getMonth()]} ${date.getFullYear()}`;
    grid.innerHTML = '';
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
    const daysInMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    const today = new Date();

    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.className = 'calendar-day disabled';
        grid.appendChild(emptyCell);
    }

    for (let i = 1; i <= daysInMonth; i++) {
        const dayCell = document.createElement('div');
        dayCell.className = 'calendar-day';
        dayCell.textContent = i;
        const cellDate = new Date(date.getFullYear(), date.getMonth(), i);
        if (cellDate < new Date(today.getFullYear(), today.getMonth(), today.getDate())) {
            dayCell.classList.add('disabled');
        } else {
            dayCell.addEventListener('click', function() {
                grid.querySelectorAll('.calendar-day.selected').forEach(d => d.classList.remove('selected'));
                this.classList.add('selected');
                updateDateInput();
            });
        }
        grid.appendChild(dayCell);
    }
}

function changeMonth(dir) {
    currentMonthOffset += dir;
    renderCalendars();
}

function clearDates() {
    document.querySelectorAll('.calendar-day.selected').forEach(d => d.classList.remove('selected'));
    const whenInput = document.getElementById('when-input');
    if(whenInput) whenInput.value = '';
}

function updateDateInput() {
    const whenInput = document.getElementById('when-input');
    if(whenInput) whenInput.value = 'Dates selected';
}

// Click outside to close desktop dropdowns
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-menu') && !event.target.closest('[onclick^="toggle"]')) {
        closeAllDropdowns();
    }
});

// Initial render
document.addEventListener('DOMContentLoaded', renderCalendars);
</script>
</body>
</html>