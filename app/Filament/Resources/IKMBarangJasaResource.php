<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IKMBarangJasaResource\Pages;
use App\Filament\Resources\IKMBarangJasaResource\RelationManagers;
use App\Models\IKMBarangJasa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IKMBarangJasaResource extends Resource
{
    protected static ?string $model = IKMBarangJasa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Indeks Kepuasan Masyarakat';

    protected static ?string $navigationGroup = 'Layanan';

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
                Forms\Components\TextInput::make('nilai_indeks')
                    ->label('Nilai Indeks')
                    ->numeric()
                    ->required(),
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
                Tables\Columns\TextColumn::make('kdsatker')->label('Kode Satker')->sortable(),
                Tables\Columns\TextColumn::make('nmsatker')->label('Nama Satker')->limit(50),
                Tables\Columns\TextColumn::make('nilai_indeks')->label('Nilai Indeks')->sortable(),
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
            'index' => Pages\ListIKMBarangJasas::route('/'),
            'create' => Pages\CreateIKMBarangJasa::route('/create'),
            'view' => Pages\ViewIKMBarangJasa::route('/{record}'),
            'edit' => Pages\EditIKMBarangJasa::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            IKMBarangJasaResource\Widgets\IKMBarangJasaOverview::class,
        ];
    }
}
