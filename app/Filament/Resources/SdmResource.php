<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SdmResource\Pages;
use App\Filament\Resources\SdmResource\RelationManagers;
use App\Models\Sdm;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SdmResource extends Resource
{
    protected static ?string $model = Sdm::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data SDM';

    protected static ?string $navigationGroup = 'SDM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('kdsatker')
                ->label('Kode Satuan kerja')
                ->required(),

            Forms\Components\TextInput::make('nmsatker')
                ->label('Nama Satuan kerja')
                ->required(),

            Forms\Components\TextInput::make('pns')
                ->label('PNS')
                ->required()
                ->numeric(),

            Forms\Components\TextInput::make('non_pns')
                ->label('Non PNS')
                ->required()
                ->numeric(),

            Forms\Components\TextInput::make('pppk')
                ->label('PPPK')
                ->required()
                ->numeric(),

            Forms\Components\TextInput::make('tenaga_professional')
                ->label('Tenaga Profesional')
                ->required()
                ->numeric(),

            DatePicker::make('tgl_transaksi')
                ->label('Tanggal Transaksi')
                ->required()
                ->format('Y-m-d')
                ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rn')->label('No Urut'),
                TextColumn::make('kdsatker')->label('Kode'),
                TextColumn::make('nmsatker')->label('Nama Satuan Kerja'),
                TextColumn::make('pns')->label('PNS'),
                TextColumn::make('non_pns')->label('Non PNS'),
                TextColumn::make('pppk')->label('PPPK'),
                TextColumn::make('tenaga_professional')->label('Tenaga Profesional'),
                TextColumn::make('tgl_transaksi')->label('Tanggal Transaksi'),
                TextColumn::make('updated_at')->label('Tanggal Update'),
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
            'index' => Pages\ListSdms::route('/'),
            'create' => Pages\CreateSdm::route('/create'),
            'view' => Pages\ViewSdm::route('/{record}'),
            'edit' => Pages\EditSdm::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            SdmResource\Widgets\SdmOverview::class,
        ];
    }
}
