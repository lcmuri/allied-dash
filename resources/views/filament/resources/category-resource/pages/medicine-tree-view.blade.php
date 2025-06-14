<!-- <x-filament-panels::page>

</x-filament-panels::page> -->


<!-- // resources/views/filament/pages/category-tree.blade.php -->
@extends('filament::pages.dashboard')

@section('content')
<div class="space-y-4">
    @foreach($categories as $category)
    <div class="p-4 bg-white rounded-lg shadow">
        <div class="flex items-center justify-between">
            <span class="font-medium">{{ $category->name }}</span>
            <div class="flex space-x-2">
                <x-filament::button
                    wire:click="$dispatch('open-modal', { id: 'edit-category-{{ $category->id }}' })">
                    Edit
                </x-filament::button>
                <x-filament::button
                    color="danger"
                    wire:click="deleteCategory({{ $category->id }})">
                    Delete
                </x-filament::button>
            </div>
        </div>

        @if($category->children->count())
        <div class="mt-4 pl-8 space-y-2">
            @foreach($category->children as $child)
            <div class="p-3 bg-gray-50 rounded">
                {{ $child->name }}
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection