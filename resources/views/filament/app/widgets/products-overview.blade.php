@php
    $user = auth()->user();
@endphp


<x-filament-widgets::widget>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <p class="fi-header-subheading mb-2 max-w-2xl text-lg text-gray-600 font-bold dark:text-gray-400 ">
        Ir para
    </p>
    <div class="grid grid-cols-3 gap-2 text-center place-content-center justify-items-center">
        <div class="grid justify-items-center">
            <section x-data="{ isCollapsed: false, }"
                class=" flex items-center h-32 w-32 rounded-xl shadow-md ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 ">
                <div class="fi-section-content-ctn p-6">
                    <div class="fi-section-content">
                        <div class="flex-1">
                            <a href="{{ env('APP_VAGAS_URL') }}" rel="noopener noreferrer" target="_blank">
                                <img src="{{ asset('img/community.png') }}" alt="Vagas" class="">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            @if(auth()->user()->type->value !== "company")
            <h2 class="pt-2 font-medium">Painel de vagas</h2>
            @endif
            @if(auth()->user()->type->value == "company")
            <h2 class="pt-2 font-medium">Recrutamento e seleção</h2>
            @endif
        </div>

        {{-- <div class="grid justify-items-center">
            <section x-data="{ isCollapsed: false, }"
                class="fi-section flex items-center h-32 w-32 rounded-xl shadow-md ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-content-ctn p-6">
                    <div class="fi-section-content">
                        <div class="flex-1">
                            <a href="https://testes.rhcontratapa.com.br/teste-de-personalidade"
                                rel="noopener noreferrer" target="_blank">
                                <img src="{{ asset('img/consulting.png') }}" alt="Gestor" class="">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <h2 class="pt-2 font-medium">Portal do Gestor</h2>
        </div> --}}
        {{-- <div class="grid justify-items-center">
            <section x-data="{ isCollapsed: false, }"
                class="fi-section flex items-center h-32 w-32 rounded-xl shadow-md ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-content-ctn">
                    <div class="fi-section-content p-6">
                        <div class="flex-1">
                            <a target="_blank" href="https://academy.rhcontratapa.com.br" rel="noopener noreferrer"
                                target="_blank">
                                <img src="{{ asset('img/mortarboard.png') }}" alt="Cursos" class="">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <h2 class="pt-2 font-medium">Educação Corporativa</h2>
        </div> --}}
        <div class="grid justify-items-center">
            <section x-data="{ isCollapsed: false, }"
                class="fi-section flex items-center h-32 w-32 rounded-xl shadow-md ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="fi-section-content-ctn">
                    <div class="fi-section-content p-6">
                        <div class="flex-1">
                            <a href="{{ route('billing') }}" rel="noopener noreferrer" target="_blank">
                                <img src="{{ asset('img/invoice2.png') }}" alt="Vagas" class="">
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <h2 class="pt-2 font-medium">Pedidos e Cobranças</h2>
        </div>

    </div>
</x-filament-widgets::widget>
