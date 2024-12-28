<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LeadsResource\Pages;
use App\Filament\Admin\Resources\LeadsResource\RelationManagers;
use App\Filament\Imports\LeadsImporter;
use App\Models\Leads;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Actions;


class LeadsResource extends Resource
{
    protected static ?string $model = Leads::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor')
                    ->label('No Telp/Hp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('dibuat_oleh')
                    ->label('Dibuat Oleh')
                    ->disabled()
                    ->relationship(name: 'users', titleAttribute: 'name')
                    ->default(Auth::user()->id),
                Forms\Components\ToggleButtons::make('status')
                    ->label('Status')
                    ->inline()
                    ->icons([
                        'complete' => 'heroicon-s-check-circle',
                        'pending' => 'heroicon-o-arrow-path',
                        'ditugaskan' => 'heroicon-s-clock',
                        'baru' => 'heroicon-s-sparkles',
                    ])
                    ->options(
                        [
                            'complete' => 'Complete',
                            'pending' => 'Pending',
                            'ditugaskan' => 'Ditugaskan',
                            'baru' => 'Baru',
                        ]
                    )
                    ->default('baru'),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('users.name')
                    ->searchable(),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLeads::route('/create'),
            'edit' => Pages\EditLeads::route('/{record}/edit'),
        ];
    }
}
