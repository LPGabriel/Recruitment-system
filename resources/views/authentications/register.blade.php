@extends('layouts/blankLayout')

@section('title', 'Crie uma conta')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
    <!-- Alpine Plugins -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@endsection


@section('content')
    <div class="position-relative">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Register Card -->
                <div class="card p-2">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
                            {{-- <span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span> --}}
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">
                        {{-- <h4 class="mb-2">A aventura começa aqui 🚀</h4> --}}
                        {{-- <p class="mb-4">Torne o gerenciamento do seu aplicativo fácil e divertido!</p> --}}

                        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST"
                            x-data="{ tipoConta: 'candidate' }">
                            @csrf
                            <div class="col-md mb-3">
                                <p class="text-bold fw-medium d-block">Tipo de conta</p>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoConta" x-model="tipoConta"
                                        id="inlineRadioCandidato" value="candidate" />
                                    <label class="form-check-label" for="inlineRadioCandidato">Candidato(a)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipoConta" x-model="tipoConta"
                                        id="inlineRadioEmpresa" value="company" />
                                    <label class="form-check-label" for="inlineRadioEmpresa">Empresa</label>
                                </div>

                            </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <input required type="text" class="form-control" id="" name="name"
                                    placeholder="Seu nome completo" autofocus>
                                <label for="name">Nome completo</label>
                            </div>

                            <div x-transition x-show="tipoConta === 'company'"
                                class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="name_company" name="name_company"
                                    x-bind:required="tipoConta === 'company'" placeholder="Razão Social" autofocus>
                                <label for="name_company">Razão Social</label>
                            </div>

                            <div x-transition x-show="tipoConta === 'company'"
                                class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="99.999.999/9999-99"
                                    x-bind:required="tipoConta === 'company'" x-mask="99.999.999/9999-99">
                                <label for="cnpj">CNPJ</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-4">
                                <input required class="form-control" type="tel" placeholder="(99) 99999-9999" name="phone" id="phone" x-mask="(99) 99999-9999" />
                                <label for="phone">Telefone/Whatsapp</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <input required type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email">
                                <label for="email">Email</label>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input required type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <label for="password">Senha</label>
                                    </div>
                                    <span class="input-group-text cursor-pointer"><i
                                            class="mdi mdi-eye-off-outline"></i></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input required class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        Concordo com a
                                        <a href="javascript:void(0);">política e os termos de privacidade</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-primary d-grid w-100">
                                Criar conta gratuitamente
                            </button>
                        </form>

                        <p class="text-center">
                            <span>Já tem uma conta?</span>
                            <a href="{{ route('login') }}">
                                <span>Em vez disso, faça login</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
                <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree"
                    class="authentication-image-object-left d-none d-lg-block">
                <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block" alt="triangle-bg">
                <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree"
                    class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection
