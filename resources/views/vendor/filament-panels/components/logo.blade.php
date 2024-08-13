<div x-data="{ mode: 'light' }" x-on:dark-mode-toggled.window="mode = $event.detail">
    <span x-show="mode === 'light'">
        <img src="{{ asset('img/logo_rhcontrata_azul.png') }}" alt="Logo" class="h-8" />
    </span>

    <span x-show="mode === 'dark'">
        <img src="{{ asset('img/logo_rhcontrata_branco.png') }}" alt="Logo" class="h-8" />
    </span>
</div>
