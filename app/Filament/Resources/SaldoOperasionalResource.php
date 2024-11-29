<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaldoOperasionalResource\Pages;
use App\Filament\Resources\SaldoOperasionalResource\RelationManagers;
use App\Models\SaldoOperasional;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaldoOperasionalResource extends Resource
{
    protected static ?string $model = SaldoOperasional::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Data Saldo Operasional';

    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kdsatker')
                    ->label('Kode Satuan kerja')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nmsatker')
                    ->label('Nama Satuan kerja')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_rekening')
                    ->label('Nomor Rekening')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit')
                    ->label('Unit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('saldo_akhir')
                    ->label('Saldo Akhir')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                Forms\Components\TextInput::make('kdbank')
                    ->label('Kode Bank')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->required()
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rn')->label('No. Urut')->sortable(),
                Tables\Columns\TextColumn::make('kdsatker')->label('Kode Satuan kerja')->sortable(),
                Tables\Columns\TextColumn::make('nmsatker')->label('Nama Satuan kerja')->limit(50),
                Tables\Columns\TextColumn::make('no_rekening')->label('Nomor Rekening')->sortable(),
                Tables\Columns\TextColumn::make('unit')->label('Unit')->sortable(),
                Tables\Columns\TextColumn::make('saldo_akhir')->label('Saldo Akhir')->sortable(),
                Tables\Columns\TextColumn::make('kdbank')->label('Kode Bank')->sortable(),
                Tables\Columns\TextColumn::make('tgl_transaksi')->label('Tanggal Transaksi')->date(),
                Tables\Columns\TextColumn::make('updated_at')->label('Tanggal Update')->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSaldoOperasionals::route('/'),
            'create' => Pages\CreateSaldoOperasional::route('/create'),
            'view' => Pages\ViewSaldoOperasional::route('/{record}'),
            'edit' => Pages\EditSaldoOperasional::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            SaldoOperasionalResource\Widgets\SaldoOperasionalOverview::class,
        ];
    }
}
