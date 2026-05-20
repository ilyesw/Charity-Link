<?php
namespace App\Exports;

use App\Models\Donation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DonsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Donation::with(['user', 'campaign'])
            ->latest()
            ->get()
            ->map(function ($don) {
                return [
                    'ID'          => $don->id,
                    'Donateur'    => $don->is_anonymous ? 'Anonyme' : ($don->user?->name ?? '—'),
                    'Email'       => $don->is_anonymous ? '—' : ($don->user?->email ?? '—'),
                    'Campagne'    => $don->campaign?->title ?? '—',
                    'Type'        => ucfirst($don->type),
                    'Montant (TND)' => $don->type === 'financier' ? number_format($don->amount, 2) : '—',
                    'Catégorie'   => $don->category ?? '—',
                    'Quantité'    => $don->quantity ?? '—',
                    'Statut'      => ucfirst($don->status),
                    'Date'        => $don->created_at->format('d/m/Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Donateur', 'Email', 'Campagne', 'Type', 'Montant (TND)', 'Catégorie', 'Quantité', 'Statut', 'Date'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFDC3545']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
