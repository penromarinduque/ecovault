<button type="{{ $type }}" id="{{ $id }}" onclick="{{ $onclick ?? null }}"
    {{ $attributes->merge([
        'class' =>
            $style === 'primary'
                ? 'focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5'
                : ($style === 'secondary'
                    ? 'text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5'
                    : ''),
    ]) }}>
    {{ $label }}
</button>
