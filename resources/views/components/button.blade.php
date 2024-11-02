<button type="{{ $type }}" id="{{ $id }}"
    class="{{ $style === 'primary' ? 'bg-blue-500 text-white' : ($style === 'secondary' ? 'bg-gray-500 text-white' : 'bg-white text-black') }} p-2 rounded">
    {{ $label }}
</button>
