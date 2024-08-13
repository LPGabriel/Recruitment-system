{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl leading-tight">
        {{ __($quiz->title) }}
    </h2>
</x-slot>

--}}
<div class="h-screen">


    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.1.0/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        [x-cloak] {
            display: none;
        }

        [type="checkbox"] {
            box-sizing: border-box;
            padding: 0;
        }

        .form-checkbox,
        .form-radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            display: inline-block;
            vertical-align: middle;
            background-origin: border-box;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            flex-shrink: 0;
            color: currentColor;
            background-color: #fff;
            border-color: #e2e8f0;
            border-width: 1px;
            height: 1.4em;
            width: 1.4em;
        }

        .form-checkbox {
            border-radius: 0.25rem;
        }

        .form-radio {
            border-radius: 50%;
        }

        .form-checkbox:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-radio:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
            border-color: transparent;
            background-color: currentColor;
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <div x-data="app()" x-cloak class="max-w-4xl mx-auto bg-base-200 my-12 rounded-lg">
        <form wire:submit="save" id="quiz-form">
            <div class="max-w-4xl mx-auto px-4">
                <div x-show.transition="step === 'complete' || quiz_result > 0">
                    <div class="rounded-lg p-10 flex items-center text-center justify-between">
                        <div>
                            <svg class="mb-4 h-20 w-20 text-green-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>

                            <h2 class="text-2xl mb-4 text-center font-bold">Teste DISC concluído com
                                sucesso!</h2>

                            <div class="text-gray-600 mb-8">
                                Agradecemos por ter completado o Teste DISC. Seu perfil comportamental foi registrado
                                com sucesso.
                                Nossos recrutadores irão analisar os resultados para uma possível inclusão em futuras
                                seleções.
                            </div>
                            <div class="flex justify-center">
                                <img class="h-80 object-none object-center " src="{{ asset('img/appreciation-bro.svg') }}"/>
                            </div>

                            <a href="{{ route('filament.app.pages.profile') }}"
                                class="btn btn-info w-full border-white rounded-xl py-2 px-8 text-xl uppercase font-bold text-white border">
                                Voltar para meu perfil
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                  </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div x-show.transition="step != 'complete' && quiz_result == 0">
                    <!-- Top Navigation -->
                    <div class="border-b-2 py-4">
                        {{-- <div class="uppercase tracking-wide text-xs font-bold text-gray-500 mb-1 leading-tight" x-text="`Step: ${step} of 3`"></div> --}}
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div>
                                    <div class="text-lg font-bold leading-tight">Olá
                                        {{ explode(' ', auth()->user()->name)[0] . '!' }} 👋</div>
                                </div>

                                {{-- <div x-show="step === 2">
								<div class="text-lg font-bold text-gray-700 leading-tight">Your Password</div>
							</div>

							<div x-show="step === 3">
								<div class="text-lg font-bold text-gray-700 leading-tight">Tell me about yourself</div>
							</div> --}}
                            </div>

                            <div class="flex items-center md:w-64">
                                <div class="w-full rounded-full mr-2 border">
                                    <div class="rounded-full bg-green-500 text-xs leading-none h-2 text-center text-white"
                                        :style="'width: ' + parseInt(step / {{ $quiz->questions()->count() }} * 100) + '%'">
                                    </div>
                                </div>
                                <div class="text-xs w-10"
                                    x-text="parseInt(step / {{ $quiz->questions()->count() }} * 100) +'%'"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /Top Navigation -->

                    <!-- Step Content -->
                    <div class="py-10">
                        <div x-show.transition.in="step === 0">

                            <h2 class="text-2xl mb-4 text-center font-bold">Você está pronta(o) para
                                conhecer
                                seu perfil comportamental predominante?</h2>

                            <div class="mb-8 py-20">
                                <div class="col-md-8" style="padding: 40px 0px 0px 20px;">
                                    <p><strong>DICAS:</strong></p>
                                    <ol>
                                        <li>Não há resultado bom ou ruim, por isso, seja sincera(o). </li>
                                        <li>Escolha um momento tranquilo para fazer o teste. </li>
                                        <li>Não pense muito, a primeira resposta geralmente será a mais correta. </li>
                                        <li>Responda pensando em quem você é e não em quem gostaria de ser.</li>
                                    </ol>
                                </div>
                            </div>

                        </div>

                        @foreach ($quiz->questions as $question)
                            <div x-show.transition.in="step === {{ $loop->iteration }}">
                                <div class="mb-5 text-center">
                                    <label for="{{ $question->id }}"
                                        class="text-2xl mb-4 text-center font-bold py-8">Selecione o
                                        adjetivo que melhor descreve você!</label><br>
                                    <span class="text-md mb-4 text-center font-normal">(Mesmo que você se
                                        identifique com mais de um, escolha o que mais se encaixa)</span>

                                    <div class="flex flex-col sm:flex-row  justify-center gap-3 pt-20">
                                        @foreach ($question->answers as $answer)
                                            <label
                                                class="flex justify-center items-center text-truncate rounded-lg border pl-4 pr-6 py-3 shadow-md">
                                                <label class="label cursor-pointer">
                                                <div class="mr-3">
                                                    <input id="{{ $answer->id }}" {{-- value="{{ $answer->score }}" --}}
                                                        name="{{ $question->id }}"
                                                        wire:click="saveAnswer({{ $question->id }},{{ $answer->id }})"
                                                        type="radio"
                                                        @click="step < {{ $quiz->questions->count() }} ? step++ : null"
                                                        class="radio radio-success"
                                                        {{-- @click="selectAnswer({{ $question->id }}, {{ $answer->score }})" --}} />

                                                    </div>
                                                    <div class="select-none">
                                                        {{ $answer->text }}
                                                        {{-- -{{ $answer->score }} --}}
                                                    </div>
                                                </label>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- / Step Content -->
                </div>
            </div>

            <!-- Bottom Navigation -->

            <div class="py-5 shadow-md" x-show="step != 'complete'">
                <div class="max-w-3xl mx-auto px-4">
                    <div class="flex justify-between py-8">
                        <div class="w-1/2 ">
                            <a x-show="step > 0" @click="step--"
                                class="w-32 focus:outline-none py-2 px-5 rounded-lg shadow-sm text-center text-gray-600 bg-white hover:bg-gray-100 font-medium border">Voltar</a>
                        </div>

                        <div class="w-1/2 text-right">
                            @if(!auth()->user()->quiz_results->count() )
                            <a x-show="step == 0" @click="step++"
                                class="w-32 btn focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">
                                Avançar
                            </a>
                            @endif

                            <button type="submit" {{-- @click="step = 'complete'" --}}
                                x-show="step === {{ $quiz->questions()->count() }}"
                                class="w-32 focus:outline-none border border-transparent py-2 px-5 rounded-lg shadow-sm text-center text-white bg-blue-500 hover:bg-blue-600 font-medium">Finalizar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Bottom Navigation https://placehold.co/300x300/e2e8f0/cccccc -->
        </form>
    </div>

    <script>
        function app() {
            return {
                step: 0,
                quiz_result: {{ auth()->user()->quiz_results->count() }},
                userChoices: [],

                selectAnswer(questionId, answerScore) {
                    // Adiciona a escolha do usuário ao array
                    this.userChoices[questionId] = answerScore;

                    // Avança para a próxima pergunta
                    this.step++;
                },

                save() {
                    // Envie o array userChoices para o backend
                    @this.call('save', userChoices);
                }
            }
        }
    </script>
</div>
