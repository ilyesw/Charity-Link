{{-- Gestion Utilisateurs Admin C:\xampp\htdocs\Charity-Link\resources\views\dashboard\admin-users.blade.php --}}
<x-app-layout>
<x-slot name="header">
    <div>
        <div class="section-label"><i class="bi bi-people-fill"></i> ADMIN</div>
        <h2 class="mb-0" style="font-size:1.5rem; letter-spacing:-0.02em;">Gestion des Utilisateurs</h2>
        <p class="header-sub mb-0">Bloquer, débloquer ou supprimer des comptes utilisateurs.</p>

    </div>
</x-slot>

{{-- Banner --}}
<div class="da-banner">
    <div class="da-banner-icon">
        <i class="bi bi-people-fill"></i>
    </div>
    <div>
        <div class="da-banner-title">Gestion des Utilisateurs</div>
        <div class="da-banner-sub">Bloquer, débloquer ou supprimer des comptes</div>
    </div>
</div>

{{-- Success / Error --}}
@if(session('success'))
    <div class="da-alert da-alert--green">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
@endif

{{-- Stats rapides --}}
<div class="da-stats" style="grid-template-columns: repeat(3,1fr); margin-bottom:1.5rem;">
    <div class="da-stat">
        <div class="da-stat-icon da-stat-icon--blue"><i class="bi bi-people-fill"></i></div>
        <div class="da-stat-value">{{ $users->total() }}</div>
        <div class="da-stat-label">Total utilisateurs</div>
    </div>
    <div class="da-stat">
        <div class="da-stat-icon da-stat-icon--green"><i class="bi bi-person-check-fill"></i></div>
        <div class="da-stat-value">{{ $users->getCollection()->where('is_blocked', false)->count() }}</div>
        <div class="da-stat-label">Actifs</div>
    </div>
    <div class="da-stat">
        <div class="da-stat-icon da-stat-icon--red"><i class="bi bi-person-x-fill"></i></div>
        <div class="da-stat-value">{{ $users->getCollection()->where('is_blocked', true)->count() }}</div>
        <div class="da-stat-label">Bloqués</div>
    </div>
</div>

{{-- Table utilisateurs --}}
<div class="da-card">
    <div class="da-card-head">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-lines-fill da-card-head-icon da-card-head-icon--red"></i>
            <span class="da-card-head-title">Liste des utilisateurs</span>
        </div>
        <span class="da-badge da-badge--red">{{ $users->total() }}</span>
    </div>
    <div class="da-card-body" style="padding: 0;">
        @if($users->isEmpty())
            <div class="da-empty">
                <i class="bi bi-people"></i>
                <span>Aucun utilisateur trouvé</span>
            </div>
        @else
            <div class="da-users-table">
                <table class="da-table">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Rôle</th>
                            <th>Inscrit le</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="{{ $user->is_blocked ? 'da-row--blocked' : '' }}">
                            <td>
                                <div class="da-user-cell">
                                    <div class="da-user-avatar">
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" alt="">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="da-user-name">{{ $user->name }}</div>
                                        <div class="da-user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleColors = [
                                        'donateur'    => 'blue',
                                        'association' => 'orange',
                                        'benevole'    => 'green',
                                    ];
                                    $roleColor = $roleColors[$user->role] ?? 'muted';
                                @endphp
                                <span class="da-badge da-badge--{{ $roleColor }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="da-user-date">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($user->is_blocked)
                                    <span class="da-badge da-badge--red">
                                        <i class="bi bi-lock-fill"></i> Bloqué
                                    </span>
                                @else
                                    <span class="da-badge da-badge--green">
                                        <i class="bi bi-check-circle-fill"></i> Actif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="da-user-actions">
                                    {{-- Bloquer / Débloquer --}}
                                    @if($user->is_blocked)
                                        <form method="POST" action="{{ route('admin.users.debloquer', $user) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="da-btn da-btn--green" title="Débloquer">
                                                <i class="bi bi-unlock-fill"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.bloquer', $user) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="da-btn da-btn--orange" title="Bloquer">
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Supprimer --}}
                                    <form method="POST" action="{{ route('admin.users.supprimer', $user) }}"
                                          onsubmit="return confirm('Supprimer définitivement {{ $user->name }} ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="da-btn da-btn--red" title="Supprimer">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
                <div style="padding: 1rem 1.35rem;">
                    {{ $users->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

{{-- Retour dashboard --}}
<div style="margin-top: 0.5rem;">
    <a href="{{ route('admin.index') }}" class="da-action da-action--outline" style="display:inline-flex; width:auto; padding: 0.65rem 1.25rem;">
        <i class="bi bi-arrow-left"></i> Retour au dashboard
    </a>
</div>

<style>
    .da-banner{display:flex;align-items:center;gap:1rem;padding:1.5rem;background:linear-gradient(135deg,var(--cl-blue),#2A4A73);border-radius:var(--radius-xl);margin-bottom:1.5rem;}
    .da-banner-icon{width:52px;height:52px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.15);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;}
    .da-banner-icon i{font-size:1.4rem;color:#fff;}
    .da-banner-title{font-weight:700;font-size:1.2rem;color:#fff;}
    .da-banner-sub{font-size:.8rem;color:rgba(255,255,255,.5);margin-top:2px;}
    .da-stats{display:grid;gap:.85rem;margin-bottom:1.5rem;}
    .da-stat{background:var(--cl-card-bg);border:1px solid var(--cl-card-border);border-radius:var(--radius-lg);padding:1.1rem 1rem;text-align:center;box-shadow:var(--shadow-xs);}
    .da-stat-icon{width:40px;height:40px;border-radius:var(--radius-sm);display:inline-flex;align-items:center;justify-content:center;margin-bottom:.6rem;}
    .da-stat-icon i{font-size:1.1rem;}
    .da-stat-icon--red{background:var(--cl-red-glow);} .da-stat-icon--red i{color:var(--cl-red);}
    .da-stat-icon--blue{background:var(--cl-blue-mid);} .da-stat-icon--blue i{color:var(--cl-blue);}
    .da-stat-icon--green{background:var(--cl-green-glow);} .da-stat-icon--green i{color:var(--cl-green);}
    .da-stat-value{font-weight:800;font-size:1.45rem;color:var(--cl-dark);}
    .da-stat-label{font-size:.73rem;color:var(--cl-muted);margin-top:.2rem;font-weight:500;}
    .da-card{background:var(--cl-card-bg);border:1px solid var(--cl-card-border);border-radius:var(--radius-xl);margin-bottom:1.25rem;box-shadow:var(--shadow-xs);overflow:hidden;}
    .da-card-head{display:flex;align-items:center;justify-content:space-between;padding:1.1rem 1.35rem;border-bottom:1px solid var(--cl-border);}
    .da-card-head-icon--red{color:var(--cl-red);}
    .da-card-head-title{font-weight:700;font-size:.92rem;color:var(--cl-dark);}
    .da-card-body{padding:.5rem 1.35rem 1.1rem;}
    .da-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:var(--radius-full);font-size:.7rem;font-weight:600;}
    .da-badge--red{background:var(--cl-red-glow);color:var(--cl-red);}
    .da-badge--green{background:var(--cl-green-glow);color:var(--cl-green);}
    .da-badge--blue{background:var(--cl-blue-mid);color:var(--cl-blue);}
    .da-badge--orange{background:rgba(245,166,35,.1);color:#D4940A;}
    .da-badge--muted{background:var(--cl-light);color:var(--cl-muted);border:1px solid var(--cl-border);}
    .da-empty{display:flex;flex-direction:column;align-items:center;gap:.6rem;padding:2.5rem 1rem;color:var(--cl-muted-light);font-size:.85rem;}
    .da-empty i{font-size:2.5rem;opacity:.5;}
    .da-btn{display:inline-flex;align-items:center;gap:.35rem;padding:.35rem .85rem;font-weight:600;font-size:.78rem;border-radius:var(--radius-full);border:none!important;cursor:pointer;text-decoration:none;transition:all .2s ease;}
    .da-btn--red{background:var(--cl-red);color:#fff;} .da-btn--red:hover{background:var(--cl-red-hover);color:#fff;transform:translateY(-1px);}
    .da-btn--green{background:var(--cl-green);color:#fff;} .da-btn--green:hover{background:#25a846;color:#fff;}
    .da-btn--orange{background:rgba(245,166,35,.12);color:#D4940A;border:1px solid rgba(245,166,35,.25)!important;}
    .da-btn--orange:hover{background:rgba(245,166,35,.22);transform:translateY(-1px);}
    .da-action{display:flex;align-items:center;justify-content:center;gap:.6rem;padding:1rem;border-radius:var(--radius-lg);font-weight:700;font-size:.88rem;text-decoration:none;transition:all .25s ease;}
    .da-action--outline{background:transparent;color:var(--cl-red);border:1.5px solid var(--cl-red);}
    .da-action--outline:hover{background:var(--cl-red-glow);color:var(--cl-red);text-decoration:none;}
    .da-alert{display:flex;align-items:center;gap:.5rem;padding:.85rem 1.1rem;border-radius:var(--radius-lg);font-size:.85rem;font-weight:600;margin-bottom:1.25rem;}
    .da-alert--green{background:var(--cl-green-glow);color:var(--cl-green);border:1px solid rgba(45,198,83,.2);}
    .da-users-table{overflow-x:auto;}
    .da-table{width:100%;border-collapse:collapse;font-size:.85rem;}
    .da-table thead tr{border-bottom:1px solid var(--cl-border);}
    .da-table th{padding:.75rem 1.35rem;font-size:.75rem;font-weight:700;color:var(--cl-muted);text-transform:uppercase;letter-spacing:.04em;text-align:left;}
    .da-table td{padding:.85rem 1.35rem;border-bottom:1px solid var(--cl-border);vertical-align:middle;transition:background .2s;}
    .da-table tbody tr:last-child td{border-bottom:none;}
    .da-table tbody tr:hover td{background:var(--cl-light);}
    .da-row--blocked td{opacity:.6;}
    .da-user-cell{display:flex;align-items:center;gap:.75rem;}
    .da-user-avatar{width:36px;height:36px;border-radius:50%;background:var(--cl-red-glow);color:var(--cl-red);font-weight:700;font-size:.85rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;}
    .da-user-avatar img{width:100%;height:100%;object-fit:cover;}
    .da-user-name{font-weight:600;font-size:.88rem;color:var(--cl-dark);}
    .da-user-email{font-size:.75rem;color:var(--cl-muted);margin-top:.1rem;}
    .da-user-date{font-size:.8rem;color:var(--cl-muted);white-space:nowrap;}
    .da-user-actions{display:flex;gap:.4rem;align-items:center;}
    @media(max-width:767.98px){.da-table th,.da-table td{padding:.65rem .75rem;}.da-user-email{display:none;}}
</style>
</x-app-layout>
