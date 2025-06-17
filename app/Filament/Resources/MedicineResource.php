<?php

namespace App\Filament\Resources;

use App\Enums\ActiveStatus;
use App\Filament\Resources\MedicineResource\Pages;
use App\Filament\Resources\MedicineResource\RelationManagers;
use App\Models\AtcCode;
use App\Models\Category;
use App\Models\DoseForm;
use App\Models\Medicine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Inventory Management'; // This groups it under Inventory Management
    // protected static ?string $navigationLabel = 'Manage Medicines'; // This becomes the parent
    // protected static ?string $navigationParentItem = 'Medicines';

    // protected static ?string $navigationGroup = 'Inventory Management';

    // protected static ?string $navigationParentItem = 'Manage Medicines';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('generic_name')
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options(collect(ActiveStatus::cases())->mapWithKeys(fn($case) => [
                                $case->value => $case->name
                            ])->toArray())
                            ->default(ActiveStatus::Active->value)
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->columnSpanFull()
                    ])->columns(2),

                Forms\Components\Section::make('Classification')
                    ->schema([
                        // Category selection (single or multiple depending on your needs)
                        // Forms\Components\Select::make('categories')
                        //     ->label('Category')
                        //     ->relationship('categories', 'name')
                        //     ->multiple()
                        //     ->searchable()
                        //     ->preload()
                        //     ->required(),
                        // Select::make('category_id')
                        //     ->label('Category')
                        //     ->options(
                        //         Category::query()
                        //             ->defaultOrder()
                        //             ->get()
                        //             ->toTree()
                        //             ->flatMap(function ($category) {
                        //                 return $category->descendantsAndSelf()
                        //                     ->pluck('name', 'id')
                        //                     ->mapWithKeys(function ($name, $id) use ($category) {
                        //                         $prefix = str_repeat('— ', $category->depth);
                        //                         return [$id => $prefix . $name];
                        //                     });
                        //             })
                        //             ->toArray()
                        //     )
                        //     ->searchable()
                        //     ->preload(),

                        // Category selection with hierarchical structure
                        // Forms\Components\Select::make('category_id')
                        //     ->label('Category')
                        //     ->options(
                        //         Category::orderBy('name') // or any other column you want to order by
                        //             ->get()
                        //             ->toTree()
                        //             ->flatMap(function ($category) {
                        //                 return $category->descendantsAndSelf()
                        //                     ->pluck('name', 'id')
                        //                     ->mapWithKeys(function ($name, $id) use ($category) {
                        //                         $prefix = str_repeat('— ', $category->depth);
                        //                         return [$id => $prefix . $name];
                        //                     });
                        //             })
                        //             ->toArray()
                        //     )
                        //     ->searchable()
                        //     ->preload(),

                        Forms\Components\Select::make('categories')
                            ->multiple() // Allow selecting multiple categories
                            ->relationship('categories', 'name') // Connects to the 'categories' relationship on the Medicine model
                            ->options(static::getCategoryTreeOptions()) // Use the helper method for tree display
                            ->preload() // Eager load options for better performance
                            ->searchable() // Allow searching through the categories
                            ->helperText('Select one or more categories. Sub-categories are indented.'),

                        // Forms\Components\Select::make('category_id')
                        // ->label('Category')
                        // ->options(function () {
                        //     // Cache the tree structure to improve performance
                        //     return cache()->remember('category-tree-select', 3600, function () {
                        //         return Category::with('descendants') // Eager load descendants
                        //             ->whereNull('parent_id') // Start with root categories
                        //             ->orderBy('name')
                        //             ->get()
                        //             ->flatMap(function (Category $category) {
                        //                 // Create hierarchical options with proper indentation
                        //                 return static::formatCategoryOptions($category);
                        //             })
                        //             ->toArray();
                        //     });
                        // })
                        // ->searchable()
                        // ->preload()
                        // ->live()
                        // ->afterStateUpdated(function ($state, Forms\Set $set) {
                        //     // Optional: Set additional fields when category changes
                        //     if ($category = Category::find($state)) {
                        //         $set('some_related_field', $category->related_value);
                        //     }
                        // }),

                        // ATC Code selection
                        //     Forms\Components\Select::make('atc_code_id')
                        //         ->label('ATC Code')
                        //         ->relationship('atcCode', 'name')
                        //         ->getOptionLabelFromRecordUsing(fn(AtcCode $record) => "{$record->code} - {$record->name}")
                        //         ->searchable(['code', 'name'])
                        //         ->preload()
                        //         ->required(),
                    ])->columns(2),

                // Forms\Components\Section::make('Dosage Forms & Strengths')
                //     ->schema([
                //         // Dynamic strength entry
                //         Forms\Components\Repeater::make('strengths')
                //             ->relationship('strengths')
                //             ->schema([
                //                 Forms\Components\Select::make('dose_form_id')
                //                     ->label('Dose Form')
                //                     ->options(DoseForm::all()->pluck('name', 'id'))
                //                     ->required(),

                //                 Forms\Components\TextInput::make('value')
                //                     ->numeric()
                //                     ->required(),

                //                 Forms\Components\Select::make('unit')
                //                     ->options([
                //                         'mg' => 'mg',
                //                         'mcg' => 'μg',
                //                         'g' => 'g',
                //                         'ml' => 'ml',
                //                     ])
                //                     ->default('mg')
                //                     ->required(),

                //                 Forms\Components\TextInput::make('volume')
                //                     ->label('Volume (if liquid)')
                //                     ->numeric()
                //                     ->hidden(fn(Forms\Get $get) => $get('unit') !== 'ml'),
                //             ])
                //             ->columns(3)
                //             ->itemLabel(fn(array $state) =>
                //             DoseForm::find($state['dose_form_id'])?->name . ' ' .
                //                 $state['value'] . $state['unit'] .
                //                 ($state['unit'] === 'ml' && $state['volume'] ? "/{$state['volume']}ml" : '')),
                //     ]),
            ]);
    }

    /**
     * Recursively fetches and formats categories for a tree-like display in a select input.
     *
     * @param Collection $categories The collection of categories to process (initially, root categories).
     * @param int $level The current depth level in the tree, used for indentation.
     * @param array $options The array to store the formatted options.
     * @return array The flattened array of category options with indentation.
     */
    protected static function getCategoryTreeOptions(Collection $categories = null, int $level = 0, array &$options = []): array
    {
        if (is_null($categories)) {
            // Get root categories (those without a parent) and order them
            $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        }

        foreach ($categories as $category) {
            // Add indentation based on the level
            $prefix = str_repeat('—', $level * 2); // Two dashes per level for indentation
            $options[$category->id] = ($prefix ? $prefix . ' ' : '') . $category->name;

            // Recursively add children
            if ($category->children->isNotEmpty()) {
                static::getCategoryTreeOptions($category->children()->orderBy('name')->get(), $level + 1, $options);
            }
        }

        return $options;
    }

    // public static function formatCategoryOptions(Category $category, int $depth = 0): array
    // {
    //     $prefix = str_repeat(' ', $depth); // Using em-space for better alignment
    //     $options = [$category->id => $prefix . $category->name];

    //     foreach ($category->children as $child) {
    //         $options += static::formatCategoryOptions($child, $depth + 1);
    //     }

    //     return $options;
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('generic_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
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
