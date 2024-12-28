<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\HistoryLeadsResource\Pages;
use App\Filament\Admin\Resources\HistoryLeadsResource\RelationManagers;
use App\Filament\Admin\Resources\HistoryLeadsResource\Widgets\HistoryLeadsOverview;
use App\Models\HistoryLeads;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class HistoryLeadsResource extends Resource
{
    protected static ?string $model = HistoryLeads::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getWidgets(): array
    {
        return [
            HistoryLeadsOverview::class,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lead_id')
                    ->relationship('lead', 'nama')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Salesman')
                    ->disabled()
                    ->relationship(
                        name: 'users',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->whereHas('lead', function ($q) {
                            $q->where('status', 'baru')->orWhere('status','pending')->whereNull('ditugaskan_oleh');
                        })
                    )
                    ->default(Auth::user()->id),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pekerjaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('hobi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('followup_via')
                    ->required()
                    ->options([
                        'telephone' => 'Telephone',
                        'chat' => 'Chat',
                        'email' => 'Email',
                        'onsite' => 'onsite',
                    ]),
                Forms\Components\DatePicker::make('tanggal_followup')
                    ->required(),
                Forms\Components\ToggleButtons::make('status')
                    ->label('Status')
                    ->inline()
                    ->icons([
                        'sudah' => 'heroicon-s-check-circle',
                        'belum' => 'heroicon-o-arrow-path',
                        'ulang' => 'heroicon-s-clock',
                    ])
                    ->options(
                        [
                            'sudah' => 'Sudah follow up',
                            'belum' => 'Belum follow up',
                            'ulang' => 'Follow up ulang',
                        ]
                    )
                    ->default('baru'),
                Forms\Components\Textarea::make('keterangan')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_followup_lanjutan')
                    ->helperText('Jika follow up lanjutan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lead.nama')
                    ->label('Lead di follow up')
                    ->sortable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Salesman')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hobi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('followup_via')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_followup')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(color: fn(string $state): string => match ($state) {
                        'belum' => 'danger',
                        'sudah' => 'success',
                        'ulang' => 'warning',
                    })
                    ->formatStateUsing(fn(string $state): string => __(ucwords("{$state} di follow up"))),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_followup_lanjutan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->visible(fn() => Auth::user()->role === 'admin'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryLeads::route('/'),
            'create' => Pages\CreateHistoryLeads::route('/create'),
            'edit' => Pages\EditHistoryLeads::route('/{record}/edit'),
        ];
    }
}
