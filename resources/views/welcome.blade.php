<x-layout>
    @if (auth()->check() )

    @else
        <login-form></login-form>
    @endif
</x-layout>
