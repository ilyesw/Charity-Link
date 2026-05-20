<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #2d3748; }
    .header { background: #dc3545; color: white; padding: 18px 24px; margin-bottom: 20px; }
    .header h1 { font-size: 20px; font-weight: bold; }
    .header p { font-size: 11px; opacity: .85; margin-top: 4px; }
    .meta { padding: 0 24px 14px; display: flex; justify-content: space-between; font-size: 10px; color: #718096; border-bottom: 1px solid #e2e8f0; margin-bottom: 16px; }
    .stats { padding: 0 24px 16px; display: flex; gap: 16px; }
    .stat-box { background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 16px; flex: 1; text-align: center; }
    .stat-box .val { font-size: 18px; font-weight: bold; color: #dc3545; }
    .stat-box .lbl { font-size: 9px; color: #718096; margin-top: 2px; }
    table { width: 100%; border-collapse: collapse; margin: 0 24px; width: calc(100% - 48px); }
    thead tr { background: #dc3545; color: white; }
    thead th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; }
    tbody tr:nth-child(even) { background: #f7fafc; }
    tbody tr:hover { background: #fff5f5; }
    tbody td { padding: 7px 10px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
    .badge-confirme { background: #c6f6d5; color: #276749; }
    .badge-en_attente { background: #fefcbf; color: #744210; }
    .badge-refuse { background: #fed7d7; color: #9b2c2c; }
    .footer { margin-top: 20px; padding: 12px 24px 0; border-top: 1px solid #e2e8f0; text-align: center; font-size: 9px; color: #a0aec0; }
</style>
</head>
<body>

<div class="header">
    <h1>📋 Rapport des Dons — CharityLink</h1>
    <p>Exporté le {{ now()->format('d/m/Y à H:i') }}</p>
</div>

<div class="meta">
    <span>Généré par l'administrateur</span>
    <span>Total : {{ $dons->count() }} don(s)</span>
</div>

<div class="stats">
    <div class="stat-box">
        <div class="val">{{ $dons->count() }}</div>
        <div class="lbl">Total dons</div>
    </div>
    <div class="stat-box">
        <div class="val">{{ number_format($dons->where('type','financier')->sum('amount'), 2) }} TND</div>
        <div class="lbl">Montant financier</div>
    </div>
    <div class="stat-box">
        <div class="val">{{ $dons->where('status','confirme')->count() }}</div>
        <div class="lbl">Confirmés</div>
    </div>
    <div class="stat-box">
        <div class="val">{{ $dons->where('status','en_attente')->count() }}</div>
        <div class="lbl">En attente</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Donateur</th>
            <th>Campagne</th>
            <th>Type</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dons as $don)
        <tr>
            <td>{{ $don->id }}</td>
            <td>{{ $don->is_anonymous ? 'Anonyme' : ($don->user?->name ?? '—') }}</td>
            <td>{{ $don->campaign?->title ?? '—' }}</td>
            <td>{{ ucfirst($don->type) }}</td>
            <td>{{ $don->type === 'financier' ? number_format($don->amount, 2).' TND' : '—' }}</td>
            <td>
                <span class="badge badge-{{ $don->status }}">{{ ucfirst($don->status) }}</span>
            </td>
            <td>{{ $don->created_at->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    CharityLink — Plateforme de dons &amp; solidarité &bull; Rapport généré automatiquement
</div>

</body>
</html>
