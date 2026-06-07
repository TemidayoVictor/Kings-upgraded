@extends('layouts.web')

@section('title')
    Brands
@endsection

@section('content')
    <!-- ==================== MAINTAINED HERO HEADER ==================== -->
    <header class="bg-premium-dark text-white pt-14 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff01_1px,transparent_1px),linear-gradient(to_bottom,#ffffff01_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] bg-brand-primary/5 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-6">
            <div class="space-y-2">
                <span class="text-brand-primary font-bold text-xs uppercase tracking-widest block">The Supplier Directory</span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight max-w-2xl mx-auto leading-tight">
                    Connect With Verified <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-primary to-amber-200">Active Supply Hubs</span>
                </h1>
                <p class="text-stone-400 text-xs sm:text-sm max-w-md mx-auto">
                    Source high-margin products directly from origin manufacturing layers with instantaneous 1-click node cloning protocols.
                </p>
            </div>

            <!-- Main Search Bar Interactivity Component Wrapper -->
            <div class="max-w-xl mx-auto pt-2">
                <div class="bg-white p-2 rounded-2xl border border-white/10 shadow-xl flex items-center gap-2">
                    <div class="flex items-center gap-3 pl-3 flex-1">
                        <i class="fas fa-magnifying-glass text-stone-400 text-sm"></i>
                        <input type="text" id="directory-search" placeholder="Search brands, items, or niche tags..." class="w-full bg-transparent border-none text-stone-900 text-sm placeholder-stone-400 focus:outline-none focus:ring-0">
                    </div>
                    <button class="bg-brand-primary hover:bg-amber-400 text-brand-dark font-bold text-xs px-5 py-3 rounded-xl transition flex items-center gap-2 shrink-0">
                        Find Inventory
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- ==================== RESPONSIVE ACTIVE CATEGORY CONTROL BAR ==================== -->
    <section class="bg-white border-b border-stone-200 sticky top-[73px] z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">

            <div class="flex items-center gap-3 relative w-full sm:w-auto">
                <span class="text-xs font-bold text-stone-400 uppercase tracking-wider hidden xs:block">Niche:</span>
                <div class="relative inline-block w-full sm:w-64">
                    <button id="category-dropdown-btn" class="w-full bg-stone-50 text-stone-900 font-bold text-xs px-4 py-2.5 rounded-xl border border-stone-200 hover:border-brand-primary text-left flex items-center justify-between transition focus:outline-none">
                        <span id="selected-category-label"><i class="fas fa-layer-group text-brand-accent mr-1.5"></i> All Categories</span>
                        <i class="fas fa-chevron-down text-[10px] text-stone-400 transition-transform duration-200" id="dropdown-chevron"></i>
                    </button>

                    <!-- Dropdown List Container -->
                    <div id="category-dropdown-menu" class="absolute left-0 mt-2 w-full bg-white border border-stone-200 rounded-xl shadow-xl py-2 hidden z-50 max-h-80 overflow-y-auto no-scrollbar subcat-animate">
                        <button onclick="selectCategory('all')" class="w-full text-left px-4 py-2 text-xs font-bold text-stone-900 hover:bg-amber-50 hover:text-brand-accent transition flex items-center justify-between">
                            <span>All Hub Networks</span>
                            <span class="text-[10px] bg-stone-100 px-2 py-0.5 rounded-md">6</span>
                        </button>
                        <hr class="border-stone-100 my-1">
                        <button onclick="selectCategory('apparel')" class="w-full text-left px-4 py-2 text-xs font-semibold text-stone-700 hover:bg-amber-50 hover:text-brand-accent transition flex items-center gap-2"><i class="fas fa-shirt w-4 text-stone-400"></i> Apparel & Fashion</button>
                        <button onclick="selectCategory('electronics')" class="w-full text-left px-4 py-2 text-xs font-semibold text-stone-700 hover:bg-amber-50 hover:text-brand-accent transition flex items-center gap-2"><i class="fas fa-laptop w-4 text-stone-400"></i> Electronics & Tech</button>
                        <button onclick="selectCategory('beauty')" class="w-full text-left px-4 py-2 text-xs font-semibold text-stone-700 hover:bg-amber-50 hover:text-brand-accent transition flex items-center gap-2"><i class="fas fa-sparkles w-4 text-stone-400"></i> Beauty & Wellness</button>
                        <button onclick="selectCategory('home')" class="w-full text-left px-4 py-2 text-xs font-semibold text-stone-700 hover:bg-amber-50 hover:text-brand-accent transition flex items-center gap-2"><i class="fas fa-couch w-4 text-stone-400"></i> Home & Living</button>
                    </div>
                </div>
            </div>

            <!-- Mobile Sub-Category Slide Action Trigger Toggle Button -->
            <button id="drawer-open-toggle" class="lg:hidden bg-stone-50 text-stone-800 border border-stone-200 rounded-xl px-4 py-2.5 font-bold text-xs flex items-center gap-2 shrink-0 hover:bg-stone-100 transition">
                <i class="fas fa-sliders text-brand-primary"></i> Sub-Filters
            </button>

            <!-- Desktop Metadata Tracker Display Frame -->
            <div class="hidden lg:flex items-center gap-4 text-xs font-medium text-stone-500 shrink-0">
                <div id="filter-crumbs" class="italic text-stone-400">Root / All Hubs</div>
                <div class="bg-amber-50 border border-amber-100/60 rounded-lg px-3 py-1.5 font-bold text-brand-accent text-[11px]">
                    Showing <span id="counter-display" class="text-stone-900">6</span> Clusters
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MAIN SECTION GRID CONTAINER ==================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="grid lg:grid-cols-12 gap-8 items-start">

            <!-- DESKTOP MODE FILTER SIDEBAR (Hidden on layout down-scale breakpoints) -->
            <aside class="hidden lg:block lg:col-span-3 space-y-6 bg-white p-6 rounded-2xl border border-stone-200/70 shadow-sm sticky top-[150px]">
                <div>
                    <div class="border-b border-stone-100 pb-2 flex items-center justify-between">
                        <h3 class="text-xs font-black text-stone-900 uppercase tracking-wider">Sub-Categories</h3>
                        <span id="sidebar-context-pill" class="text-[9px] font-extrabold uppercase bg-brand-primary text-brand-dark px-2 py-0.5 rounded">Global</span>
                    </div>
                    <div id="subcategories-container-desktop" class="space-y-2.5 pt-4">
                        <!-- Populated Reactively -->
                    </div>
                </div>
            </aside>

            <!-- BRAND CARDS RENDERING COMPONENT CANVAS -->
            <main class="lg:col-span-9">
                <div id="brands-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Handled inside runtime routine loops -->
                </div>
            </main>

        </div>
    </section>

    <!-- ==================== MOBILE SLIDE OUT FILTER DRAWER CANVAS OVERLAY ==================== -->
    <div id="mobile-drawer-backdrop" class="fixed inset-0 bg-stone-900/40 z-50 backdrop-blur-sm hidden transition-opacity opacity-0 duration-300">
        <div id="mobile-drawer-body" class="fixed right-0 top-0 bottom-0 w-80 max-w-[85vw] bg-white h-full shadow-2xl p-6 flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out">

            <div>
                <div class="flex items-center justify-between border-b border-stone-100 pb-4">
                    <div>
                        <h3 class="text-sm font-black text-stone-900 uppercase tracking-wider">Sub-Filters</h3>
                        <p class="text-[11px] text-stone-400 font-medium mt-0.5" id="mobile-crumbs">Root / Distributed</p>
                    </div>
                    <button id="drawer-close-toggle" class="w-8 h-8 rounded-xl bg-stone-50 hover:bg-stone-100 text-stone-500 text-xs flex items-center justify-center transition">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>

                <!-- Dynamic Context Node Target Target Box -->
                <div class="pt-6">
                    <span id="sidebar-context-pill-mobile" class="text-[9px] font-extrabold uppercase bg-brand-primary text-brand-dark px-2 py-0.5 rounded inline-block mb-3">Global</span>
                    <div id="subcategories-container-mobile" class="space-y-3 max-h-[60vh] overflow-y-auto no-scrollbar pr-1">
                        <!-- Appended programmatically -->
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-100">
                <button id="drawer-apply-btn" class="w-full bg-brand-dark text-white text-xs font-bold py-3.5 rounded-xl transition shadow-lg shadow-stone-900/10">
                    Apply Filter Matrix
                </button>
            </div>

        </div>
    </div>
@endsection

<script>
    const CATEGORY_DATA = {
        all: {
            label: "All Categories",
            crumbs: "Root / Distributed Global Network",
            subcategories: [
                { id: "all_street", name: "Active Streetwear", count: 14 },
                { id: "all_minimal", name: "Premium Minimalist", count: 8 },
                { id: "all_eco", name: "Eco Sustainable Goods", count: 19 },
                { id: "all_tech", name: "Consumer Hardware Matrix", count: 7 }
            ]
        },
        apparel: {
            label: "Apparel & Fashion",
            crumbs: "Root / Consumer Textiles",
            subcategories: [
                { id: "app_heavy", name: "Heavyweight Box-Fit Tees", count: 6 },
                { id: "app_lounge", name: "Luxury Loungewear Arrays", count: 4 },
                { id: "app_denim", name: "Selvedge Technical Denim", count: 3 },
                { id: "app_athleisure", name: "High-Performance Athletic Wear", count: 5 }
            ]
        },
        electronics: {
            label: "Electronics & Tech",
            crumbs: "Root / Semiconductors & Hardware",
            subcategories: [
                { id: "elec_edc", name: "Anodized EDC Hubs", count: 3 },
                { id: "elec_charge", name: "MagSafe Architecture Rails", count: 2 },
                { id: "elec_audio", name: "Audiophile Audio Transducers", count: 2 }
            ]
        },
        beauty: {
            label: "Beauty & Wellness",
            crumbs: "Root / Cosmetic Formulation Units",
            subcategories: [
                { id: "beau_vegan", name: "Vegan Botanical Serums", count: 5 },
                { id: "beau_clinical", name: "Clinical Grade Oils", count: 3 }
            ]
        },
        home: {
            label: "Home & Living",
            crumbs: "Root / Interior Elements",
            subcategories: [
                { id: "home_nordic", name: "Nordic Minimalist Wood", count: 4 },
                { id: "home_light", name: "Ambient Luminescence Controls", count: 2 }
            ]
        }
    };

    const CARDS_DATA = [
        { id: 1, name: "Aura Wear Premium", cat: "apparel", desc: "Heavyweight organic garments, premium dropshoulder lounge apparel and box-fit essentials layouts.", split: "40% Margin", icon: "fa-shirt", badge: "Verified Supply" },
        { id: 2, name: "EcoLife Labs", cat: "apparel", desc: "Sustainable carbon-neutral living accessories and high-quality premium bamboo lifestyle elements.", split: "35% Margin", icon: "fa-bolt", badge: "Verified Supply" },
        { id: 3, name: "VoltForge Global", cat: "electronics", desc: "Precision-engineered workspace charging elements, mechanical arrays, and desktop accessories.", split: "25% Margin", icon: "fa-plug", badge: "Verified Supply" },
        { id: 4, name: "Gourmet Grid Architecture", cat: "home", desc: "Small-batch artisanal organic cooking oils, premium spices, and distributed culinary nodes.", split: "30% Margin", icon: "fa-cookie", badge: "Verified Supply" },
        { id: 5, name: "Lumina Skincare", cat: "beauty", desc: "Vegan botanical serums, clinical-grade facial oils, and clean luxury wellness formulations.", split: "45% Margin", icon: "fa-wand-magic-sparkles", badge: "Rising Star Node" },
        { id: 6, name: "Modura Interiors", cat: "home", desc: "Flat-pack sleek mid-century modern organizing pieces, custom lighting elements, and soft luxury decor.", split: "22% Margin", icon: "fa-couch", badge: "Verified Supply" }
    ];

    // NODE OBJECT DICTIONARY REFERENCES
    const dropdownBtn = document.getElementById('category-dropdown-btn');
    const dropdownMenu = document.getElementById('category-dropdown-menu');
    const dropdownChevron = document.getElementById('dropdown-chevron');
    const labelDisplay = document.getElementById('selected-category-label');
    const subcatsDesktop = document.getElementById('subcategories-container-desktop');
    const subcatsMobile = document.getElementById('subcategories-container-mobile');
    const crumbTrail = document.getElementById('filter-crumbs');
    const mobileCrumbs = document.getElementById('mobile-crumbs');
    const contextPillDesktop = document.getElementById('sidebar-context-pill');
    const contextPillMobile = document.getElementById('sidebar-context-pill-mobile');
    const brandsGrid = document.getElementById('brands-grid');
    const counterDisplay = document.getElementById('counter-display');
    const searchInput = document.getElementById('directory-search');

    // MOBILE DRAWER INTERACTION ELEMENTS
    const drawerOpenToggle = document.getElementById('drawer-open-toggle');
    const drawerCloseToggle = document.getElementById('drawer-close-toggle');
    const drawerApplyBtn = document.getElementById('drawer-apply-btn');
    const drawerBackdrop = document.getElementById('mobile-drawer-backdrop');
    const drawerBody = document.getElementById('mobile-drawer-body');

    let currentCategory = 'all';

    // TRIGGER DROPDOWN TO DISPLAY POOLS
    dropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = !dropdownMenu.classList.contains('hidden');
        dropdownMenu.classList.toggle('hidden');
        dropdownChevron.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    });

    document.addEventListener('click', () => {
        dropdownMenu.classList.add('hidden');
        dropdownChevron.style.transform = 'rotate(0deg)';
    });

    // OPEN / CLOSE MOBILE DRAWER LOGIC SUBSYSTEMS
    function openDrawer() {
        drawerBackdrop.classList.remove('hidden');
        setTimeout(() => {
            drawerBackdrop.classList.remove('opacity-0');
            drawerBody.classList.remove('translate-x-full');
        }, 20);
    }

    function closeDrawer() {
        drawerBody.classList.add('translate-x-full');
        drawerBackdrop.classList.add('opacity-0');
        setTimeout(() => {
            drawerBackdrop.classList.add('hidden');
        }, 300);
    }

    drawerOpenToggle.addEventListener('click', openDrawer);
    drawerCloseToggle.addEventListener('click', closeDrawer);
    drawerBackdrop.addEventListener('click', (e) => {
        if (e.target === drawerBackdrop) closeDrawer();
    });
    drawerApplyBtn.addEventListener('click', closeDrawer);

    // SYSTEM ROUTINE SYNC: POPULATE INTERACTIVE LIST MATRICES NATIVELY
    window.selectCategory = function(catKey) {
        currentCategory = catKey;
        const targetData = CATEGORY_DATA[catKey];

        labelDisplay.innerHTML = `<i class="fas fa-layer-group text-brand-accent mr-1.5"></i> ${targetData.label}`;
        if(crumbTrail) crumbTrail.innerText = targetData.crumbs;
        if(mobileCrumbs) mobileCrumbs.innerText = targetData.crumbs;

        const badgeText = catKey === 'all' ? 'Global' : catKey;
        if(contextPillDesktop) contextPillDesktop.innerText = badgeText;
        if(contextPillMobile) contextPillMobile.innerText = badgeText;

        // Sync and empty content paths
        subcatsDesktop.innerHTML = '';
        subcatsMobile.innerHTML = '';

        targetData.subcategories.forEach((sub, index) => {
            const layoutHTML = `
          <div class="flex items-center gap-2.5">
            <input type="checkbox" name="subcat" id="cb-${catKey}-${index}" class="rounded border-stone-300 text-brand-primary focus:ring-brand-primary/50 w-4 h-4">
            <span>${sub.name}</span>
          </div>
          <span class="text-[10px] text-stone-400 bg-stone-50 px-2 py-0.5 rounded-md group-hover:bg-amber-50 group-hover:text-brand-accent transition">${sub.count}</span>
        `;

            // Create Desktop Row
            const dRow = document.createElement('label');
            dRow.className = "flex items-center justify-between text-xs font-semibold text-stone-600 hover:text-stone-900 cursor-pointer group subcat-animate";
            dRow.style.animationDelay = `${index * 30}ms`;
            dRow.innerHTML = layoutHTML;
            subcatsDesktop.appendChild(dRow);

            // Create Mobile Row
            const mRow = document.createElement('label');
            mRow.className = "flex items-center justify-between text-xs font-semibold text-stone-600 hover:text-stone-900 cursor-pointer group";
            mRow.innerHTML = layoutHTML;
            subcatsMobile.appendChild(mRow);
        });

        renderFilteredCards();
    };

    function renderFilteredCards() {
        const query = searchInput.value.toLowerCase().trim();
        brandsGrid.innerHTML = '';

        let filtered = CARDS_DATA.filter(card => {
            const matchesCategory = currentCategory === 'all' || card.cat === currentCategory;
            const matchesSearch = card.name.toLowerCase().includes(query) || card.desc.toLowerCase().includes(query);
            return matchesCategory && matchesSearch;
        });

        if(counterDisplay) counterDisplay.innerText = filtered.length;

        if(filtered.length === 0) {
            brandsGrid.innerHTML = `
          <div class="col-span-full py-16 text-center space-y-3">
            <div class="text-stone-300 text-4xl"><i class="fas fa-folder-open"></i></div>
            <p class="text-stone-500 font-bold text-xs uppercase tracking-wider">No matching supply nodes verified.</p>
          </div>`;
            return;
        }

        filtered.forEach((card, index) => {
            const cardLayout = document.createElement('div');
            cardLayout.className = "card-brand flex flex-col justify-between overflow-hidden subcat-animate";
            cardLayout.style.animationDelay = `${index * 40}ms`;
            cardLayout.innerHTML = `
          <div class="p-6 space-y-4">
            <div class="flex items-start justify-between">
              <div class="w-12 h-12 rounded-2xl bg-stone-50 flex items-center justify-center border border-stone-100 shadow-sm text-brand-primary text-xl font-bold">
                <i class="fas ${card.icon}"></i>
              </div>
              <span class="bg-emerald-50 text-emerald-700 font-bold text-[10px] px-2 py-1 rounded-md flex items-center gap-1 border border-emerald-100">
                <i class="fas fa-circle-check text-[8px]"></i> ${card.badge}
              </span>
            </div>
            <div>
              <h3 class="font-extrabold text-stone-900 text-base leading-tight">${card.name}</h3>
              <p class="text-xs text-brand-muted mt-1 line-clamp-2 leading-relaxed">${card.desc}</p>
            </div>
          </div>
          <div class="p-6 pt-0 border-t border-stone-100/80 mt-2 bg-stone-50/50 flex items-center justify-between gap-4">
            <div class="text-xs">
              <div class="text-stone-400 font-medium">Avg Profit Split</div>
              <div class="font-black text-stone-900 text-sm mt-0.5">${card.split}</div>
            </div>
            <a href="#" class="bg-brand-dark hover:bg-stone-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition">Analyze Hub</a>
          </div>
        `;
            brandsGrid.appendChild(cardLayout);
        });
    }

    searchInput.addEventListener('input', renderFilteredCards);

    document.addEventListener('DOMContentLoaded', () => {
        selectCategory('all');
    });
</script>
