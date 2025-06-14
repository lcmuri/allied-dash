<?php

namespace App\Filament\Clusters\AtcCode\Resources;

use App\Filament\Clusters\AtcCode as AtcCodeCluster;
use App\Filament\Clusters\AtcCode\Resources\AtcCodeResource\Pages;
use App\Filament\Clusters\AtcCode\Resources\AtcCodeResource\RelationManagers;
use App\Models\AtcCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtcCodeResource extends Resource
{
    protected static ?string $model = AtcCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = AtcCodeCluster::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListAtcCodes::route('/'),
            'create' => Pages\CreateAtcCode::route('/create'),
            'edit' => Pages\EditAtcCode::route('/{record}/edit'),
        ];
    }
}
