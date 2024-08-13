<div>
    @livewire('notifications')

    @if (!$registration)
        <div class="shadow-md p-8 w-full border rounded-xl bg-black bg-opacity-20">
            <form wire:submit="create">
                <h2 class="mb-4 text-white text-xl font-bold">Faça sua inscrição agora!</h2>
                {{ $this->form }}
                @auth
                    <button type="submit"
                        class="bg-transparent w-full border border-white rounded-xl py-2 mt-4 px-8 text-xl uppercase font-bold text-white hover:bg-white hover:text-gray-800 hover:border-transparent">
                        Confirmar minha inscrição
                    </button>
                @endauth
                @guest
                    <button onclick="window.location.href='/app/login'" href="{{ asset(route('filament.app.auth.login')) }}"
                        class="bg-black w-full border-white rounded-xl py-2 mt-4 px-8 text-xl uppercase font-bold text-white hover:bg-white hover:text-gray-800 hover:border-transparent">
                        <div class="flex">
                            FAÇA LOGIN PARA SE INSCREVER
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="animate-ping w-7 h-7 pt-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                            </svg>
                        </div>
                    </button>
                @endguest
            </form>
        </div>
    @endif

    @if ($registration)
        {{ $this->registrationInfolist }}
        <div>
        </div>
    @endif

    <x-filament-actions::modals />
</div>
