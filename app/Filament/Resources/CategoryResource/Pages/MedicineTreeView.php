<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\Page;
use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

class MedicineTreeView extends Page
{
    // protected static string $resource = CategoryResource::class;

    protected static string $view = 'filament.resources.category-resource.pages.medicine-tree-view';


    public $categories;

    public function mount()
    {
        $this->categories = Category::getTree();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->form([
                    TextInput::make('name')
                        ->required(),
                    TextInput::make('slug')
                        ->required(),
                ])
                ->action(function (array $data) {
                    Category::create($data);
                }),
        ];
    }
}
