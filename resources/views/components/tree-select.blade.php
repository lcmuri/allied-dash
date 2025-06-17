<!-- resources/views/components/tree-select.blade.php -->
<div
    x-data="{
        openNodes: JSON.parse(localStorage.getItem('treeSelectOpenNodes')) || [],
        searchQuery: '',
        selected: '{{ $value }}',
        
        toggleNode(id) {
            if (this.openNodes.includes(id)) {
                this.openNodes = this.openNodes.filter(i => i !== id);
            } else {
                this.openNodes.push(id);
            }
            localStorage.setItem('treeSelectOpenNodes', JSON.stringify(this.openNodes));
        },
        
        get filteredOptions() {
            if (!this.searchQuery) return @json($options);
            
            const query = this.searchQuery.toLowerCase();
            return @json($options).filter(([id, name]) => 
                name.toLowerCase().includes(query)
            );
        }
    }"
    class="space-y-1">
    <input type="hidden" name="{{ $name }}" x-model="selected">

    @if($searchable)
    <div class="mb-2">
        <input
            type="text"
            x-model="searchQuery"
            placeholder="Search categories..."
            class="w-full px-3 py-2 border rounded-md">
    </div>
    @endif

    <div class="max-h-64 overflow-y-auto border rounded-md">
        @foreach($options as $id => $name)
        @php
        $level = substr_count($name, ' ');
        $displayName = trim($name);
        $isParent = collect($options)
        ->any(fn($n, $i) => $i !== $id && str_starts_with($n, str_repeat(' ', $level + 1)));
        @endphp

        <div
            x-show="filteredOptions.some(([i]) => i === '{{ $id }}')"
            class="py-1 px-3 hover:bg-gray-50 cursor-pointer flex items-center"
            :class="{
                    'bg-primary-50': selected === '{{ $id }}',
                    'font-medium': selected === '{{ $id }}'
                }"

            @click="selected = '{{ $id }}'">
            @if($isParent)
            <button
                type="button"
                class="mr-2 w-4 text-center text-gray-500 hover:text-gray-700"
                @click.stop="toggleNode('{{ $id }}')">
                <span x-show="!openNodes.includes('{{ $id }}')">+</span>
                <span x-show="openNodes.includes('{{ $id }}')">-</span>
            </button>
            @else
            <span class="w-6"></span>
            @endif

            <span class="truncate">{{ $displayName }}</span>
        </div>

        @if($isParent)
        <div
            x-show="openNodes.includes('{{ $id }}') && filteredOptions.some(([i]) => i === '{{ $id }}')"
            x-collapse>
            <!-- Children will be shown here -->
        </div>
        @endif
        @endforeach
    </div>
</div>