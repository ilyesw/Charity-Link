<style>
    #clProgress {
        position: fixed;
        top: 0; left: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--cl-red), #f87171);
        width: 0%;
        z-index: 1060;
        transition: width 0.08s linear;
        box-shadow: 0 0 8px rgba(230,57,70,0.4);
    }

    .cl-nav {
        position: sticky;
        top: 0;
        z-index: 1050;
        background: var(--cl-nav-bg);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border-bottom: 1px solid var(--cl-nav-border);
        padding: 0.75rem 0;
        transition: all 0.35s ease;
        font-family: 'Inter', sans-serif;
    }
    .cl-nav.scrolled {
        background: var(--cl-nav-scrolled);
        box-shadow: var(--cl-nav-shadow);
    }
    .cl-nav__inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .cl-logo {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        flex-shrink: 0;
    }
    .cl-logo__icon {
        width: 40px; height: 40px;
        background: var(--cl-red);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .cl-logo__icon::after {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.15) 50%, transparent 60%);
        animation: shimmer 3s ease-in-out infinite;
        background-size: 200% 100%;
    }
    .cl-logo__icon i { color: #fff; font-size: 1.1rem; position: relative; z-index: 1; }
    .cl-logo:hover .cl-logo__icon { transform: rotate(-6deg) scale(1.06); }
    .cl-logo__text {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--cl-dark);
        letter-spacing: -0.03em;
        transition: color 0.35s ease;
    }
    .cl-logo__text span { color: var(--cl-red); }

    .cl-links {
        display: flex;
        align-items: center;
        gap: 0.15rem;
        list-style: none;
        flex: 1;
        justify-content: center;
        margin: 0;
        padding: 0;
    }
    .cl-link {
        position: relative;
        text-decoration: none;
        color: var(--cl-body);
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.5rem 0.85rem;
        border-radius: var(--radius-sm);
        transition: all 0.2s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .cl-link .nav-icon-ai {
        font-size: 0.95rem;
        transition: transform 0.3s ease;
    }
    .cl-link:hover {
        color: var(--cl-red);
        background: var(--cl-red-glow);
    }
    .cl-link:hover .nav-icon-ai { transform: rotate(15deg) scale(1.1); }
    .cl-link.active {
        color: var(--cl-red);
        font-weight: 600;
        background: var(--cl-red-glow);
    }

    .cl-actions {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        flex-shrink: 0;
    }

    .dark-toggle-nav {
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--cl-border);
        background: var(--cl-card-bg);
        color: var(--cl-body);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        cursor: pointer;
        transition: all 0.25s ease;
        flex-shrink: 0;
    }
    .dark-toggle-nav:hover {
        border-color: var(--cl-red);
        color: var(--cl-red);
        background: var(--cl-red-glow);
        transform: rotate(15deg);
    }
    .dark-toggle-nav .icon-sun { display: none; }
    .dark-toggle-nav .icon-moon { display: block; }
    html.dark .dark-toggle-nav .icon-sun { display: block; }
    html.dark .dark-toggle-nav .icon-moon { display: none; }

    .cl-notif {
        position: relative;
        text-decoration: none;
        color: var(--cl-body);
        width: 38px; height: 38px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s ease;
        border: 1px solid var(--cl-border);
        background: var(--cl-card-bg);
        font-size: 1rem;
    }
    .cl-notif:hover {
        background: var(--cl-red-glow);
        color: var(--cl-red);
        border-color: rgba(230,57,70,0.2);
    }
    .cl-notif__badge {
        position: absolute;
        top: -5px; right: -5px;
        background: var(--cl-red);
        color: white;
        font-size: 0.62rem;
        font-weight: 700;
        min-width: 18px; height: 18px;
        padding: 0 4px;
        border-radius: 10px;
        border: 2px solid var(--cl-white);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 1px 4px rgba(230,57,70,0.3);
    }

    .cl-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.55rem 1.25rem;
        border-radius: var(--radius-full);
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.25s ease;
        white-space: nowrap;
    }
    .cl-btn--ghost {
        background: transparent;
        color: var(--cl-muted);
        padding: 0.55rem 0.75rem;
    }
    .cl-btn--ghost:hover {
        color: var(--cl-dark);
        background: var(--cl-red-glow);
    }
    .cl-btn--primary {
        background: var(--cl-red);
        color: white;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }
    .cl-btn--primary:hover {
        background: var(--cl-red-hover);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(230,57,70,0.3);
    }
    .cl-btn--full {
        width: 100%;
        justify-content: center;
    }

    .cl-user { position: relative; }
    .cl-user__btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--cl-light);
        border: 1.5px solid var(--cl-border);
        border-radius: var(--radius-full);
        padding: 0.32rem 0.6rem 0.32rem 0.32rem;
        cursor: pointer;
        transition: all 0.25s ease;
        font-family: 'Inter', sans-serif;
        color: var(--cl-dark);
    }
    .cl-user__btn:hover {
        border-color: var(--cl-muted-light);
        background: var(--cl-border-light);
    }
    .cl-user__avatar {
        width: 30px; height: 30px;
        background: linear-gradient(135deg, var(--cl-blue), #152B47);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.68rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }
    .cl-user__name {
        font-size: 0.82rem;
        font-weight: 500;
        color: var(--cl-dark);
        max-width: 110px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        transition: color 0.35s ease;
    }
    .cl-user__arrow {
        width: 14px; height: 14px;
        color: var(--cl-muted);
        transition: transform 0.25s ease;
        flex-shrink: 0;
    }
    .cl-user__btn[aria-expanded="true"] .cl-user__arrow { transform: rotate(180deg); }

    .cl-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 220px;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        padding: 0.4rem;
        box-shadow: var(--shadow-xl);
        opacity: 0;
        pointer-events: none;
        transform: translateY(-8px) scale(0.97);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 100;
    }
    .cl-dropdown.open {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0) scale(1);
    }
    .cl-dropdown__item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 0.8rem;
        color: var(--cl-body);
        text-decoration: none;
        font-size: 0.84rem;
        font-weight: 500;
        border-radius: var(--radius-sm);
        transition: all 0.18s ease;
        width: 100%;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
        font-family: 'Inter', sans-serif;
    }
    .cl-dropdown__item:hover {
        background: var(--cl-red-glow);
        color: var(--cl-red);
        padding-left: 0.95rem;
    }
    .cl-dropdown__item--admin { color: #BFA14A; }
    .cl-dropdown__item--admin:hover { background: rgba(191,161,74,0.08); color: #BFA14A; }
    .cl-dropdown__item--danger { color: #e57373; }
    .cl-dropdown__item--danger:hover { background: rgba(230,57,70,0.08); color: #ef5350; }
    .cl-dropdown__sep {
        height: 1px;
        background: var(--cl-border);
        margin: 0.3rem 0.5rem;
    }

    .cl-burger {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        padding: 0.45rem 0.6rem;
        background: none;
        border: 1px solid var(--cl-border);
        border-radius: var(--radius-sm);
        transition: all 0.2s ease;
    }
    .cl-burger:hover { border-color: var(--cl-red); }
    .cl-burger span {
        display: block;
        width: 20px; height: 2px;
        background: var(--cl-dark);
        border-radius: 2px;
        transition: all 0.3s ease;
        transform-origin: center;
    }
    .cl-burger.open { border-color: transparent; background: transparent; }
    .cl-burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); background: var(--cl-red); }
    .cl-burger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
    .cl-burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); background: var(--cl-red); }

    .cl-mobile {
        display: none;
        position: fixed;
        top: 62px;
        left: 0; right: 0;
        background: var(--cl-card-bg);
        border-bottom: 1px solid var(--cl-border);
        padding: 0.75rem 1.25rem 1.5rem;
        transform: translateY(-100%);
        opacity: 0;
        transition: transform 0.35s ease, opacity 0.35s ease;
        max-height: calc(100vh - 62px);
        overflow-y: auto;
        z-index: 1035;
        box-shadow: var(--shadow-xl);
    }
    .cl-mobile.open {
        transform: translateY(0);
        opacity: 1;
    }
    .cl-mobile__link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.8rem 0.85rem;
        color: var(--cl-body);
        text-decoration: none;
        font-size: 0.92rem;
        font-weight: 500;
        border-radius: var(--radius-sm);
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
    }
    .cl-mobile__link:hover,
    .cl-mobile__link.active {
        background: var(--cl-red-glow);
        color: var(--cl-red);
    }
    .cl-mobile__sep {
        height: 1px;
        background: var(--cl-border);
        margin: 0.75rem 0;
    }
    .cl-mobile__actions {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    html.dark .cl-user__btn {
        background: var(--cl-light);
        border-color: var(--cl-border);
    }
    html.dark .cl-user__btn:hover { background: var(--cl-border); }
    html.dark .cl-burger span { background: var(--cl-dark); }

    /* ══════════════ LANGUAGE SWITCHER ══════════════ */
    .lang-switcher {
        display: flex;
        align-items: center;
        gap: 0.2rem;
        background: var(--cl-light);
        border: 1px solid var(--cl-border);
        border-radius: var(--radius-sm);
        padding: 0.2rem;
        transition: all 0.35s ease;
    }
    .lang-btn {
        padding: 0.25rem 0.45rem;
        border-radius: 5px;
        font-size: 1rem;
        text-decoration: none;
        transition: background 0.2s ease;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lang-btn:hover { background: var(--cl-card-bg); }
    .lang-btn--active {
        background: var(--cl-card-bg);
        box-shadow: var(--shadow-xs);
    }

    @media (max-width: 991.98px) {
        .cl-links { display: none; }
        .cl-burger { display: flex; }
        .cl-mobile { display: block; }
        .cl-user { order: -1; }
    }
    @media (max-width: 575.98px) {
        .cl-logo__icon { width: 34px; height: 34px; }
        .cl-logo__icon i { font-size: 0.95rem; }
        .cl-logo__text { font-size: 1.05rem; }
        .cl-user__name { display: none; }
        .cl-user__btn { padding: 0.25rem 0.35rem; border-radius: var(--radius-sm); }
        .cl-notif { width: 34px; height: 34px; font-size: 0.9rem; }
        .dark-toggle-nav { width: 34px; height: 34px; font-size: 0.95rem; }
        .cl-mobile { top: 58px; }
    }
</style>

<div id="clProgress"></div>

<nav class="cl-nav" id="clNav">
    <div class="container cl-nav__inner">

        <a href="/" class="cl-logo">
            <div class="cl-logo__icon">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <span class="cl-logo__text">Charity<span>Link</span></span>
        </a>

        <ul class="cl-links">
            <li>
                <a href="{{ route('associations.index') }}" class="cl-link {{ request()->routeIs('associations.*') ? 'active' : '' }}">
                    {{ __('Associations') }}
                </a>
            </li>
            <li>
                <a href="{{ route('campaigns.index') }}" class="cl-link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}">
                    {{ __('Campagnes') }}
                </a>
            </li>
            <li>
                <a href="{{ route('taches.index') }}" class="cl-link {{ request()->routeIs('taches.*') ? 'active' : '' }}">
                    {{ __('Bénévolat') }}
                </a>
            </li>
            <li>
                <a href="{{ route('besoins.index') }}" class="cl-link {{ request()->routeIs('besoins.*') ? 'active' : '' }}">
                    {{ __("Besoin d'aide") }}
                </a>
            </li>
            <li>
                <a href="{{ route('chatbot.index') }}" class="cl-link {{ request()->routeIs('chatbot.*') ? 'active' : '' }}">
                    <i class="bi bi-robot nav-icon-ai"></i> {{ __('Assistant IA') }}
                </a>
            </li>
        </ul>

        <div class="cl-actions">
            @auth
                @php
                    $notifCount = \App\Models\Notification::where('user_id', auth()->id())
                                    ->where('is_read', false)
                                    ->count();
                @endphp

                <button class="dark-toggle-nav d-none d-lg-flex" onclick="clToggleDark()" aria-label="Mode sombre">
                    <i class="bi bi-moon-stars-fill icon-moon"></i>
                    <i class="bi bi-sun-fill icon-sun"></i>
                </button>

                {{-- Language Switcher Desktop --}}
                <div class="lang-switcher d-none d-lg-flex">
                    <a href="{{ route('lang.switch', 'fr') }}"
                       class="lang-btn {{ app()->getLocale() === 'fr' ? 'lang-btn--active' : '' }}"
                       title="Français">🇫🇷</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="lang-btn {{ app()->getLocale() === 'en' ? 'lang-btn--active' : '' }}"
                       title="English">🇬🇧</a>
                </div>

                <a href="{{ route('notifications.index') }}" class="cl-notif" aria-label="Notifications">
                    <i class="bi bi-bell-fill"></i>
                    @if($notifCount > 0)
                        <span class="cl-notif__badge">{{ $notifCount }}</span>
                    @endif
                </a>

                <div class="cl-user">
                    <button class="cl-user__btn" id="clUserBtn" onclick="clToggleDropdown(event)" aria-expanded="false" aria-haspopup="true">
                        <div class="cl-user__avatar" style="overflow:hidden; padding:0;">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                    alt="avatar"
                                    style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            @endif
                        </div>
                        <span class="cl-user__name">{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down cl-user__arrow"></i>
                    </button>

                    <div class="cl-dropdown" id="clDropdown" role="menu">
                        <a href="{{ route('dashboard') }}" class="cl-dropdown__item">
                            <i class="bi bi-grid-1x2-fill"></i> {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="cl-dropdown__item">
                            <i class="bi bi-person-fill"></i> {{ __('Mon profil') }}
                        </a>
                        @if(Auth::user()->isAdmin())
                            <div class="cl-dropdown__sep"></div>
                            <a href="{{ route('admin.index') }}" class="cl-dropdown__item cl-dropdown__item--admin">
                                <i class="bi bi-gear-fill"></i> {{ __('Panel Admin') }}
                            </a>
                        @endif
                        <div class="cl-dropdown__sep"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="cl-dropdown__item cl-dropdown__item--danger">
                                <i class="bi bi-box-arrow-right"></i> {{ __('Déconnexion') }}
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <button class="dark-toggle-nav d-none d-lg-flex" onclick="clToggleDark()" aria-label="Mode sombre">
                    <i class="bi bi-moon-stars-fill icon-moon"></i>
                    <i class="bi bi-sun-fill icon-sun"></i>
                </button>

                {{-- Language Switcher Desktop (non connecté) --}}
                <div class="lang-switcher d-none d-lg-flex">
                    <a href="{{ route('lang.switch', 'fr') }}"
                       class="lang-btn {{ app()->getLocale() === 'fr' ? 'lang-btn--active' : '' }}"
                       title="Français">🇫🇷</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="lang-btn {{ app()->getLocale() === 'en' ? 'lang-btn--active' : '' }}"
                       title="English">🇬🇧</a>
                </div>

                <a href="{{ route('login') }}" class="cl-btn cl-btn--ghost">{{ __('Connexion') }}</a>
                <a href="{{ route('register') }}" class="cl-btn cl-btn--primary">{{ __("S'inscrire") }}</a>
            @endauth

            <button class="cl-burger" id="clBurger" onclick="clToggleBurger()" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>

    </div>
</nav>

<div class="cl-mobile" id="clMobile" aria-hidden="true">

    {{-- Dark mode + Language switcher mobile --}}
    <div class="d-flex align-items-center gap-2 mb-2 d-lg-none">
        <button class="dark-toggle-nav" onclick="clToggleDark()" aria-label="Mode sombre">
            <i class="bi bi-moon-stars-fill icon-moon"></i>
            <i class="bi bi-sun-fill icon-sun"></i>
        </button>
        <div class="lang-switcher">
            <a href="{{ route('lang.switch', 'fr') }}"
               class="lang-btn {{ app()->getLocale() === 'fr' ? 'lang-btn--active' : '' }}">🇫🇷</a>
            <a href="{{ route('lang.switch', 'en') }}"
               class="lang-btn {{ app()->getLocale() === 'en' ? 'lang-btn--active' : '' }}">🇬🇧</a>
        </div>
    </div>

    <a href="{{ route('associations.index') }}" class="cl-mobile__link {{ request()->routeIs('associations.*') ? 'active' : '' }}">
        <i class="bi bi-building"></i> {{ __('Associations') }}
    </a>
    <a href="{{ route('campaigns.index') }}" class="cl-mobile__link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}">
        <i class="bi bi-megaphone-fill"></i> {{ __('Campagnes') }}
    </a>
    <a href="{{ route('taches.index') }}" class="cl-mobile__link {{ request()->routeIs('taches.*') ? 'active' : '' }}">
        <i class="bi bi-hand-index-thumb"></i> {{ __('Bénévolat') }}
    </a>
    <a href="{{ route('besoins.index') }}" class="cl-mobile__link {{ request()->routeIs('besoins.*') ? 'active' : '' }}">
        <i class="bi bi-life-preserver"></i> {{ __("Besoin d'aide") }}
    </a>
    <a href="{{ route('chatbot.index') }}" class="cl-mobile__link {{ request()->routeIs('chatbot.*') ? 'active' : '' }}">
        <i class="bi bi-robot"></i> {{ __('Assistant IA') }}
    </a>

    <div class="cl-mobile__sep"></div>

    <div class="cl-mobile__actions">
        @auth
            <a href="{{ route('notifications.index') }}" class="cl-mobile__link">
                <i class="bi bi-bell-fill"></i> {{ __('Notifications') }}
                @if($notifCount > 0)
                    <span class="badge rounded-pill" style="background:var(--cl-red);font-size:0.65rem;">{{ $notifCount }}</span>
                @endif
            </a>
            <a href="{{ route('dashboard') }}" class="cl-btn cl-btn--ghost cl-btn--full">
                <i class="bi bi-grid-1x2-fill"></i> {{ __('Dashboard') }}
            </a>
            <a href="{{ route('profile.edit') }}" class="cl-btn cl-btn--ghost cl-btn--full">
                <i class="bi bi-person-fill"></i> {{ __('Mon profil') }}
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.index') }}" class="cl-btn cl-btn--full"
                   style="color:#BFA14A;border:1px solid rgba(191,161,74,0.3);background:rgba(191,161,74,0.06);">
                    <i class="bi bi-gear-fill"></i> {{ __('Panel Admin') }}
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="cl-btn cl-btn--full"
                        style="background:rgba(230,57,70,0.08);color:#ef5350;border:1px solid rgba(230,57,70,0.2);">
                    <i class="bi bi-box-arrow-right"></i> {{ __('Déconnexion') }}
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="cl-btn cl-btn--ghost cl-btn--full">{{ __('Connexion') }}</a>
            <a href="{{ route('register') }}" class="cl-btn cl-btn--primary cl-btn--full">{{ __("S'inscrire") }}</a>
        @endauth
    </div>
</div>
