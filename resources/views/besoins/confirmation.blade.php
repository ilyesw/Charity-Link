<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="cf-card">
                <div class="cf-icon-wrap">
                    <div class="cf-icon">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>

                <h2 class="cf-title">Demande soumise avec succès !</h2>
                <p class="cf-desc">
                    Votre demande d'aide a été reçue. Notre équipe va l'analyser
                    et vous mettre en contact avec une association compétente
                    dans les plus brefs délais.
                </p>

                <div class="cf-steps">
                    <div class="cf-steps-head">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1A8C38" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Prochaines étapes
                    </div>
                    <ul class="cf-steps-list">
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1A8C38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Votre demande est enregistrée
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1A8C38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Un administrateur va l'examiner
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1A8C38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Une association sera contactée
                        </li>
                        <li>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1A8C38" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Vous recevrez un email de suivi
                        </li>
                    </ul>
                </div>

                <div class="cf-actions">
                    <a href="{{ route('associations.index') }}" class="cf-btn cf-btn--red">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
                        Voir les associations
                    </a>
                    <a href="{{ route('campaigns.index') }}" class="cf-btn cf-btn--ghost">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Voir les campagnes
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

<style>
    .cf-card {
        text-align: center;
        padding: 3rem 2rem 2rem;
        background: var(--cl-card-bg);
        border: 1px solid var(--cl-card-border);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-sm);
        margin-top: 2rem;
    }

    .cf-icon-wrap {
        margin-bottom: 1.5rem;
    }
    .cf-icon {
        width: 72px; height: 72px;
        background: var(--cl-green-soft);
        border: 2px solid rgba(45,198,83,0.2);
        border-radius: var(--radius-full);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto;
        color: #1A8C38;
        animation: cf-pop 0.4s ease;
    }
    @keyframes cf-pop {
        0% { transform: scale(0.5); opacity: 0; }
        70% { transform: scale(1.08); }
        100% { transform: scale(1); opacity: 1; }
    }

    .cf-title {
        font-family: 'Inter', sans-serif;
        font-weight: 800; font-size: 1.35rem;
        color: var(--cl-dark);
        margin-bottom: 0.65rem;
    }
    .cf-desc {
        font-size: 0.9rem; color: var(--cl-muted);
        line-height: 1.65; margin-bottom: 1.75rem;
        max-width: 420px; margin-left: auto; margin-right: auto;
    }

    .cf-steps {
        text-align: left;
        background: var(--cl-green-soft);
        border: 1px solid rgba(45,198,83,0.15);
        border-radius: var(--radius-lg);
        padding: 1.15rem 1.25rem;
        margin-bottom: 1.75rem;
    }
    .cf-steps-head {
        display: flex; align-items: center; gap: 0.45rem;
        font-family: 'Inter', sans-serif;
        font-weight: 700; font-size: 0.88rem;
        color: #1A8C38;
        margin-bottom: 0.75rem;
    }
    .cf-steps-list {
        list-style: none; padding: 0; margin: 0;
        display: flex; flex-direction: column; gap: 0.5rem;
    }
    .cf-steps-list li {
        display: flex; align-items: center; gap: 0.55rem;
        font-size: 0.84rem; color: #1A8C38;
        font-weight: 500;
    }
    .cf-steps-list li svg { flex-shrink: 0; }

    .cf-actions {
        display: flex; flex-direction: column; gap: 0.65rem;
    }
    .cf-btn {
        display: flex; align-items: center; justify-content: center; gap: 0.45rem;
        padding: 0.7rem 1.5rem;
        font-family: 'Inter', sans-serif;
        font-weight: 600; font-size: 0.88rem;
        border-radius: var(--radius-md);
        text-decoration: none; cursor: pointer;
        transition: all 0.25s ease;
        border: none !important; outline: none !important; box-shadow: none !important;
    }
    .cf-btn svg { flex-shrink: 0; }
    .cf-btn--red {
        background: var(--cl-red); color: #fff;
        box-shadow: 0 2px 8px rgba(230,57,70,0.2);
    }
    .cf-btn--red:hover {
        background: var(--cl-red-hover); color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(230,57,70,0.3) !important;
    }
    .cf-btn--ghost {
        background: var(--cl-light); color: var(--cl-body);
        border: 1.5px solid var(--cl-border) !important;
    }
    .cf-btn--ghost:hover {
        color: var(--cl-dark); border-color: var(--cl-muted) !important;
        background: var(--cl-card-bg);
    }

    @media (max-width: 767.98px) {
        .cf-card {
            padding: 2rem 1.25rem 1.5rem;
            border-radius: var(--radius-lg);
            box-shadow: none; border: none;
            margin-top: 1rem;
        }
        .cf-icon { width: 60px; height: 60px; }
        .cf-icon svg { width: 26px; height: 26px; }
        .cf-title { font-size: 1.15rem; }
    }
</style>
