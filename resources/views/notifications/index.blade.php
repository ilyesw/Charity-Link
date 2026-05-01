<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="section-label">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                Notifications
            </div>
            <h2 class="mb-0" style="font-size:1.5rem;">Notifications</h2>
            <p class="header-sub mb-0">Restez informé de vos activités sur CharityLink.</p>
        </div>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">

            @if($notifications->isEmpty())
                <div class="ls-empty-card">
                    <div class="ls-empty-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--cl-muted)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13.73 21a2 2 0 0 1-3.46 0"/><path d="M18.63 13A17.89 17.89 0 0 1 18 8"/><path d="M6.26 6.26A5.86 5.86 0 0 0 6 8c0 7-3 9-3 9h14"/><path d="M18 8a6 6 0 0 0-9.33-5"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </div>
                    <h5 class="ls-empty-title">Aucune notification</h5>
                    <p class="ls-empty-desc">Quand vous recevrez des dons, validations ou messages, ils apparaîtront ici.</p>
                </div>
            @else
                <div class="ls-count">
                    <strong>{{ $notifications->total() }}</strong> notification(s)
                </div>

                <div class="nt-list">
                    @foreach($notifications as $notification)
                        <div class="nt-card {{ !$notification->is_read ? 'nt-card--unread' : '' }}">

                            <div class="nt-card-body">
                                <div class="nt-icon {{ !$notification->is_read ? 'nt-icon--active' : 'nt-icon--muted' }}">
                                    @if($notification->type === 'don')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                    @elseif($notification->type === 'validation')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    @elseif($notification->type === 'tache')
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
                                    @else
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                    @endif
                                </div>

                                <div class="nt-content">
                                    <div class="nt-head">
                                        <h6 class="nt-title">{{ $notification->title }}</h6>
                                        @if(!$notification->is_read)
                                            <span class="nt-badge-new">Nouveau</span>
                                        @endif
                                    </div>
                                    <p class="nt-message">{{ $notification->message }}</p>
                                    <div class="nt-foot">
                                        @if($notification->url)
                                            <a href="{{ $notification->url }}" class="nt-link">
                                                Voir
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                            </a>
                                        @else
                                            <span></span>
                                        @endif
                                        <time class="nt-time">{{ $notification->created_at->diffForHumans() }}</time>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="ls-pagination">
                    {{ $notifications->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>

<style>
    .ls-count { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 1.25rem; }
    .ls-count strong { color: var(--cl-dark); font-weight: 700; }

    .ls-empty-card {
        text-align: center; padding: 3rem 2rem;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
    }
    .ls-empty-icon {
        width: 72px; height: 72px;
        background: var(--cl-light);
        border-radius: var(--radius-lg);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem;
    }
    .ls-empty-title { font-family: 'Inter', sans-serif; font-weight: 700; font-size: 1rem; color: var(--cl-dark); margin-bottom: 0.4rem; }
    .ls-empty-desc { font-size: 0.85rem; color: var(--cl-muted); margin-bottom: 0; }

    /* ─── Notification list ─── */
    .nt-list { display: flex; flex-direction: column; gap: 0.5rem; }

    .nt-card {
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-xs);
        transition: all 0.25s ease;
        border-left: 3px solid transparent;
    }
    .nt-card:hover { box-shadow: var(--shadow-md); border-color: transparent; }
    .nt-card--unread {
        border-left-color: var(--cl-red);
        background: var(--cl-card-bg);
    }
    .nt-card--unread:hover { border-left-color: var(--cl-red); }
    .nt-card-body {
        display: flex; gap: 0.85rem;
        padding: 0.9rem 1.15rem;
    }

    .nt-icon {
        width: 42px; height: 42px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }
    .nt-icon--active { background: var(--cl-red-glow); color: var(--cl-red); }
    .nt-icon--muted { background: var(--cl-light); color: var(--cl-muted); }

    .nt-content { flex: 1; min-width: 0; }

    .nt-head {
        display: flex; align-items: center; gap: 0.5rem;
        margin-bottom: 0.25rem;
    }
    .nt-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.88rem;
        color: var(--cl-dark);
        margin: 0;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .nt-card--unread .nt-title { font-weight: 800; }

    .nt-badge-new {
        display: inline-flex; align-items: center;
        padding: 0.2rem 0.55rem;
        background: var(--cl-red);
        color: #fff;
        border-radius: var(--radius-full);
        font-family: 'Inter', sans-serif;
        font-size: 0.65rem; font-weight: 700;
        flex-shrink: 0;
        letter-spacing: 0.02em;
    }

    .nt-message {
        font-size: 0.82rem; color: var(--cl-muted);
        line-height: 1.55; margin: 0 0 0.5rem;
    }
    .nt-card--unread .nt-message { color: var(--cl-body); }

    .nt-foot {
        display: flex; align-items: center; justify-content: space-between;
    }
    .nt-link {
        display: inline-flex; align-items: center; gap: 0.3rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem; font-weight: 600;
        color: var(--cl-red);
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .nt-link:hover { gap: 0.5rem; }
    .nt-link svg { transition: transform 0.2s ease; }
    .nt-link:hover svg { transform: translateX(2px); }

    .nt-time {
        font-size: 0.75rem; color: var(--cl-muted-light);
        flex-shrink: 0;
    }

    /* ─── Pagination ─── */
    .ls-pagination { margin-top: 1.5rem; }
    .ls-pagination .pagination .page-link {
        border-radius: var(--radius-sm) !important;
        margin: 0 2px;
        border: 1px solid var(--cl-border) !important;
        color: var(--cl-body) !important;
        font-weight: 500; font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        background: var(--cl-card-bg) !important;
        transition: all 0.2s ease;
    }
    .ls-pagination .pagination .page-link:hover {
        background: var(--cl-light) !important;
        border-color: var(--cl-muted) !important;
        color: var(--cl-dark) !important;
    }
    .ls-pagination .pagination .page-item.active .page-link {
        background: var(--cl-red) !important;
        border-color: var(--cl-red) !important;
        color: #fff !important;
    }

    @media (max-width: 767.98px) {
        .ls-empty-card { padding: 2rem 1.25rem; border-radius: var(--radius-lg); box-shadow: none; border: none; }
        .nt-card-body { padding: 0.8rem 1rem; }
        .nt-card--unread { border-left-width: 3px; }
    }
</style>
