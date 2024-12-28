<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use App\Models\Leads;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class LeadsTable extends BaseWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Mobil', Leads::query()->count())
                ->description('Jumlah seluruh mobil'),
            Stat::make('Mobil Away', Leads::query()->where('status', 'belum')->count())
                ->description('Jumlah mobil berjalan'),
            Stat::make('Mobil Ready', Leads::query()->where('status', 'sudah')->count())
                ->description('Jumlah mobil ready'),
        ];
    }
    public static function canView(): bool
    {
        return Auth::user()->role == 'admin';
    }
    public function table(Table $table): Table
    {

        return $table
            ->query(
                Leads::query()->with('users')->where('status', 'complete')->orWhere('status', 'baru')->orWhere('status', 'pending')->orderBy('created_at', 'desc')
            )
            ->columns(
                [
                    TextColumn::make('nama'),
                    TextColumn::make('nomor'),
                    Tables\Columns\TextColumn::make('status')
                        ->searchable()
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            'baru' => 'danger',
                            'complete' => 'success',
                            'pending' => 'warning',
                            'ditugaskan' => 'warning',
                        })
                        ->formatStateUsing(fn(string $state): string => __(ucwords("{$state}"))),

                ]
            )
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Belum di follow up',
                        'sudah' => 'Sudah di follow up',
                    ])
            ]);
    }
}
