<?php

namespace App\Filament\Clusters\Medicine\Resources;

use App\Filament\Clusters\Medicine;
use App\Filament\Clusters\Medicine\Resources\MedicineResource\Pages;
use App\Filament\Clusters\Medicine\Resources\MedicineResource\RelationManagers;
use App\Models\Medicine as MedicineModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MedicineResource extends Resource
{
    protected static ?string $model = MedicineModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Medicine::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->hiddenOn('create'), // Hide on create as it will be auto-generated
                Forms\Components\TextInput::make('generic_name'),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\TextInput::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->columnSpan(1), // This column takes 1 grid unit
                TextColumn::make('generic_name')
                    ->searchable()
                    ->columnSpan(1), // This column takes 1 grid unit
                TextColumn::make('status')
                    ->searchable()
                    ->columnSpan(1), // This column takes 1 grid unit
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
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}
