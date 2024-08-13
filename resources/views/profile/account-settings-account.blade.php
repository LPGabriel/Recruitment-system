@extends('layouts/contentNavbarLayout')

@section('title', 'Perfil')

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

@section('content')
    <div class="position-absolute top-0 start-0 w-100 bg-primary zindex-dropdown" style="height: 398px;z-index: -1;"></div>

    <h4 class="py-3 mb-4 text-light">
        <span class="text-muted text-light">Minha conta /</span> Perfil
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h4 class="card-header">Seu perfil</h4>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar"
                            class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">Atualizar foto</span>
                                <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-outline-danger account-image-reset mb-3">
                                <i class="mdi mdi-reload d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <div class="text-muted small">Formatos JPG, GIF or PNG. Com no máximo 800kb de tamanho</div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2 mt-1">
                    <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-2">
                        <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                                    class="mdi mdi-account-outline mdi-20px me-1"></i>Perfil</a></li>
                        <li class="nav-item shadow-sm border-1"><a class="nav-link"
                                href="{{ route('candidate.profile.notifications') }}"><i
                                    class="mdi mdi-bell-outline mdi-20px me-1"></i>Notificações</a></li>
                        <li class="nav-item shadow-sm border-1"><a class="nav-link"
                                href="{{ route('candidate.profile.connections') }}"><i
                                    class="mdi mdi-link mdi-20px me-1"></i>Conexões</a></li>
                    </ul>
                </div>
                <div class="card-body pt-2 mt-1">
                    <form id="formAccountSettings" method="POST" onsubmit="return false">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input value="" class="form-control" type="text" id="name" name="name"
                                        autofocus />
                                    <label for="firstName">Nome completo</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" name="lastName" id="lastName"
                                        value="" />
                                    <label for="lastName">Como gostaria de ser chamado(a)?</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input class="form-control" type="date" id="html5-date-input" />
                                    <label for="html5-datetime-local-input">Data de nascimento</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input class="form-control" type="tel" placeholder="91 9999-9999"
                                        id="html5-tel-input" value="" autofocus />
                                    <label for="html5-tel-input">Telefone</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="john.doe@example.com" placeholder="john.doe@example.com" />
                                    <label for="email">E-mail</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="qualification" class="select2 form-select">
                                        <option value="">Selecione</option>
                                        <option value="fundamental">Ensino Fundamental</option>
                                        <option value="medio">Ensino Médio</option>
                                        <option value="tecnico">Técnico</option>
                                        <option value="superio">Ensino Superior</option>
                                        <option value="mestrado">Mestrado</option>
                                    </select>
                                    <label for="qualification">Nível educacional</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="languages" class="select2 form-select">
                                        <option value="">Selecione</option>
                                        <option value="en">Inglês</option>
                                        <option value="fr">Francês</option>
                                        <option value="de">Espanhol</option>
                                        <option value="pt">Alemão</option>
                                    </select>
                                    <label for="language">Idiomas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="salary_expectation" class="select2 form-select">
                                        <option value="">Selecione</option>
                                        <option value="1">Estágio</option>
                                        <option value="2">Bolsa</option>
                                        <option value="3">Salário mínimo</option>
                                        <option value="4">de R$1500,00 a R$2500,00</option>
                                        <option value="5">de R$2500,00 a R$4000,00</option>
                                        <option value="6">de R$4000,00 a R$5000,00</option>
                                        <option value="7">acima de R$5000,00</option>
                                    </select>
                                    <label for="salary_expectation">Pretenção salarial</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="salary_expectation" class="select2 form-select">
                                        <option value="">Selecione</option>
                                    </select>
                                    <label for="salary_expectation">Áreas de interesse</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="salary_expectation" class="select2 form-select">
                                        <option value="">Selecione</option>
                                    </select>
                                    <label for="salary_expectation">Cargos de interesse</label>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="state" name="state"
                                        placeholder="California" />
                                    <label for="state">State</label>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="zipCode" name="zipCode"
                                        placeholder="231465" maxlength="6" />
                                    <label for="zipCode">Zip Code</label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Salvar alterações</button>
                            {{-- <button type="reset" class="btn btn-outline-secondary">Desfazer</button> --}}
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header fw-normal">Desativar conta</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading mb-1">Tem certeza de que deseja desativar sua conta?</h6>
                            <p class="mb-0">Depois de excluir sua conta, não há como voltar atrás. Por favor, tenha
                                certeza.</p>
                        </div>
                    </div>
                    <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-3 ms-3">
                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                id="accountActivation" />
                            <label class="form-check-label" for="accountActivation">Eu confirmo minha conta
                                desativação</label>
                        </div>
                        <button type="submit" class="btn btn-danger">Desativar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
