@extends('layouts/contentNavbarLayout')

@section('title', 'Perfil - Notificações')

@section('content')
    <div class="position-absolute top-0 start-0 w-100 bg-primary zindex-dropdown" style="height: 398px;z-index: -1;"></div>

    <h4 class="py-3 mb-4 text-light">
        <span class="text-muted text-light">Minha conta /</span> Notificações
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
              <div class="card-body pt-2 mt-1">
                <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-2">
                  <li class="nav-item border-1"><a class="nav-link" href="{{ route('candidate.profile.profile-settings') }}"><i
                              class="mdi mdi-account-outline mdi-20px me-1"></i> Perfil</a></li>
                  <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                              class="mdi mdi-bell-outline mdi-20px me-1"></i> Notificações</a></li>
                  <li class="nav-item border-1"><a class="nav-link" href="{{ route('candidate.profile.connections') }}"><i
                              class="mdi mdi-link mdi-20px me-1"></i> Conexões</a></li>
              </ul>
              </div>
                <!-- Notifications -->
                <h5 class="card-header">Dispositivos recentes</h5>
                <div class="card-body">
                    <span>Precisamos da permissão do seu navegador para mostrar notificações.<a href="javascript:void(0);"
                            class="notificationRequest">Solicitar permissão</a></span>
                    <div class="error"></div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-nowrap fw-medium">Time</th>
                                <th class="text-nowrap fw-medium text-center">✉️ Email</th>
                                <th class="text-nowrap fw-medium text-center">🖥 Navegador</th>
                                <th class="text-nowrap fw-medium text-center">📲 SMS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap text-heading">Novidade para você</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck2" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck3" checked />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap text-heading">Atividade da conta</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck4" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck5" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck6" checked />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap text-heading">Um novo navegador usado para fazer login</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck7" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck8" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck9" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap text-heading">Um novo dispositivo está vinculado</td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck10" checked />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck11" />
                                    </div>
                                </td>
                                <td>
                                    <div class="form-check mb-0 d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck12" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <h6 class="mb-4">Quando devemos enviar notificações para você?</h6>
                    <form action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-6">
                                <select id="sendNotification" class="form-select" name="sendNotification">
                                    <option selected>Somente quando estou online</option>
                                    <option>A qualquer momento</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Salvar alterações</button>
                                {{-- <button type="reset" class="btn btn-outline-secondary">Reset</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Notifications -->
            </div>
        </div>
    </div>
@endsection
