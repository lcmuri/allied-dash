<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtcCodeResource\Pages;
use App\Filament\Resources\AtcCodeResource\RelationManagers;
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

    protected static ?string $navigationGroup = 'Inventory Management'; // This groups it under Inventory Management
    // protected static ?string $navigationLabel = 'Manage Medicines'; // This becomes the parent
    protected static ?string $navigationParentItem = 'Medicines';
    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';
    // protected static ?int $navigationSort = 3; // Adjust position
    // Ensure navigation is enabled
    // protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('parent_id')
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->required(),
                Forms\Components\TextInput::make('level')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('created_by'),
                Forms\Components\TextInput::make('updated_by'),
                Forms\Components\TextInput::make('deleted_by'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_by')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
