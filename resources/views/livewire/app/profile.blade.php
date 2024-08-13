<div>
    <form wire:submit="saveUser">
        {{ $this->userForm }}

        <div class="py-6">
            <x-filament::button wire:click="saveUser">
                Salvar alterações
            </x-filament::button>
        </div>
    </form>
    <x-filament-actions::modals />

    <form wire:submit="saveCandidate">
        {{ $this->candidateForm }}

        <div class="py-4">
            <x-filament::button wire:click="saveCandidate">
                Salvar alterações
            </x-filament::button>
        </div>
    </form>
    <x-filament-actions::modals />
</div>
