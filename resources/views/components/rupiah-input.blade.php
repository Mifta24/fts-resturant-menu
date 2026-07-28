@props(['name', 'value' => 0, 'required' => false, 'nullable' => false])

<div
    x-data="{
        nullable: {{ $nullable ? 'true' : 'false' }},
        raw: {{ $value !== null ? (int) $value : 'null' }},
        get formatted() {
            return (this.raw !== null && this.raw !== 0) ? new Intl.NumberFormat('id-ID').format(this.raw) : (this.raw === 0 ? '0' : '');
        },
        onInput(event) {
            const digits = event.target.value.replace(/[^0-9]/g, '');
            this.raw = digits === '' ? (this.nullable ? null : 0) : parseInt(digits, 10);
            event.target.value = this.formatted;
        },
    }"
    class="relative"
>
    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500 dark:text-gray-400">Rp</span>
    <input
        type="text"
        inputmode="numeric"
        :value="formatted"
        @input="onInput"
        @focus="$el.select()"
        {{ $attributes->merge(['class' => 'w-full pl-9 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm text-sm']) }}
        @if ($required) required @endif
    >
    <input type="hidden" name="{{ $name }}" :value="raw === null ? '' : raw">
</div>
