<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'User Management';
    // protected static ?string $navigationParentItem = 'Manage Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('guard_name')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ])
                    ->default('web')
                    ->required(),

                Forms\Components\Section::make('Permissions')
                    ->schema([
                        Forms\Components\Tabs::make('Permissions')
                            ->tabs(function () {
                                $models = ['Post', 'User', 'Category']; // Add your models here
                                $tabs = [];

                                foreach ($models as $model) {
                                    $tabs[] = Forms\Components\Tabs\Tab::make($model)
                                        ->schema([
                                            Forms\Components\CheckboxList::make('permissions')
                                                ->label("{$model} Permissions")
                                                ->options(Permission::where('name', 'like', "%{$model}%")
                                                    ->pluck('name', 'id'))
                                                ->columns(2)
                                                ->columnSpan(1),
                                        ]);
                                }

                                return $tabs;
                            })
                    ]),

                // Permission management section
                Forms\Components\Section::make('Permissions')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema(array_map(function ($model) {
                                return Forms\Components\CheckboxList::make('permissions')
                                    ->label(ucfirst($model))
                                    ->bulkToggleable()
                                    ->options(Permission::where('name', 'like', "%{$model}%")
                                        ->pluck('name', 'id'))
                                    ->columns(2)
                                    ->columnSpan(1);
                            }, ['post', 'user', 'category'])) // Add your models here
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('guard_name')
                    ->badge(),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissions')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('guard_name')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ]),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
