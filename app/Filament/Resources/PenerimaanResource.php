<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenerimaanResource\Pages;
use App\Filament\Resources\PenerimaanResource\RelationManagers;
use App\Models\Penerimaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenerimaanResource extends Resource
{
    protected static ?string $model = Penerimaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-end-on-rectangle';

    protected static ?string $navigationLabel = 'Data Penerimaan';

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
            Forms\Components\TextInput::make('kd_akun')
                ->label('Kode Akun')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->prefix('Rp')
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
                Tables\Columns\TextColumn::make('kdsatker')->label('Kode Satuan kerja')->sortable(),
                Tables\Columns\TextColumn::make('nmsatker')->label('Nama Satuan kerja')->limit(50),
                Tables\Columns\TextColumn::make('kd_akun')->label('Kode Akun')->sortable(),
                Tables\Columns\TextColumn::make('jumlah')->label('Jumlah')->sortable(),
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
            'index' => Pages\ListPenerimaans::route('/'),
            'create' => Pages\CreatePenerimaan::route('/create'),
            'view' => Pages\ViewPenerimaan::route('/{record}'),
            'edit' => Pages\EditPenerimaan::route('/{record}/edit'),
        ];
    }
}
