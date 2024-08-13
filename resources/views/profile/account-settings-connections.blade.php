@extends('layouts/contentNavbarLayout')

@section('title', 'Account settings - Pages')

@section('content')
    <div class="position-absolute top-0 start-0 w-100 bg-primary zindex-dropdown" style="height: 398px;z-index: -1;"></div>
    <h4 class="py-3 mb-4 text-light">
        <span class="text-muted text-light">Minha conta / </span> Conexões
    </h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
              <div class="card-body pt-3 mt-1">
                  <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-2">
                      <li class="nav-item border-1"><a class="nav-link"
                              href="{{ route('candidate.profile.profile-settings') }}"><i
                                  class="mdi mdi-account-outline mdi-20px me-1"></i> Perfil</a></li>
                      <li class="nav-item border-1"><a class="nav-link"
                              href="{{ route('candidate.profile.notifications') }}"><i
                                  class="mdi mdi-bell-outline mdi-20px me-1"></i> Notificações</a></li>
                      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i
                                  class="mdi mdi-link mdi-20px me-1"></i> Conexões</a></li>
                  </ul>
              </div>
              <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card-header">
                            <h5 class="mb-2">Contas conectadas</h5>
                            <p class="mb-0 text-body">Exiba conteúdo de suas contas conectadas em seu site</p>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/google.png') }}" alt="google"
                                        class="me-3" height="36">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-9 mb-sm-0 mb-2">
                                        <h6 class="mb-0">Google</h6>
                                        <small>Calendário and contatos</small>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input float-end" type="checkbox" role="switch">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/slack.png') }}" alt="slack"
                                        class="me-3" height="36">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-9 mb-sm-0 mb-2">
                                        <h6 class="mb-0">Slack</h6>
                                        <small>Comunicação</small>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input float-end" type="checkbox" role="switch"
                                                checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/github.png') }}" alt="github"
                                        class="me-3" height="36">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-9 mb-sm-0 mb-2">
                                        <h6 class="mb-0">Github</h6>
                                        <small>Manage your Git repositories</small>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input float-end" type="checkbox" role="switch">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/mailchimp.png') }}" alt="mailchimp"
                                        class="me-3" height="36">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-9 mb-sm-0 mb-2">
                                        <h6 class="mb-0">Mailchimp</h6>
                                        <small>Email marketing service</small>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input float-end" type="checkbox" role="switch"
                                                checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/asana.png') }}" alt="asana"
                                        class="me-3" height="36">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-9 mb-sm-0 mb-2">
                                        <h6 class="mb-0">Asana</h6>
                                        <small>Communication</small>
                                    </div>
                                    <div class="col-3 text-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input float-end" type="checkbox" role="switch"
                                                checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="card-header">
                            <h5 class="mb-2">Contas Sociais</h5>
                            <p class="mb-0 text-body">Exiba conteúdo de contas sociais em seu site</p>
                        </div>
                        <div class="card-body">
                            <!-- Social Accounts -->
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/facebook.png') }}" alt="facebook"
                                        class="me-3" height="30">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-7">
                                        <h6 class="mb-0">Facebook</h6>
                                        <small>Not Connected</small>
                                    </div>
                                    <div class="col-5 text-end">
                                        <button class="btn btn-outline-secondary btn-icon"><i
                                                class="mdi mdi-link mdi-24px"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/twitter.png') }}" alt="twitter"
                                        class="me-3" height="30">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-7">
                                        <h6 class="mb-0">Twitter</h6>
                                        <a href="{{ config('variables.twitterUrl') }}"
                                            target="_blank">{{ '@' . config('variables.creatorName') }}</a>
                                    </div>
                                    <div class="col-5 text-end">
                                        <button class="btn btn-outline-secondary btn-icon"><i
                                                class="mdi mdi-delete-outline mdi-24px"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/instagram.png') }}" alt="instagram"
                                        class="me-3" height="30">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-7">
                                        <h6 class="mb-0">instagram</h6>
                                        <a href="{{ config('variables.instagramUrl') }}"
                                            target="_blank">{{ '@' . config('variables.creatorName') }}</a>
                                    </div>
                                    <div class="col-5 text-end">
                                        <button class="btn btn-outline-secondary btn-icon"><i
                                                class="mdi mdi-delete-outline mdi-24px"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/dribbble.png') }}" alt="dribbble"
                                        class="me-3" height="30">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-7">
                                        <h6 class="mb-0">Dribbble</h6>
                                        <small>Not Connected</small>
                                    </div>
                                    <div class="col-5 text-end">
                                        <button class="btn btn-outline-secondary btn-icon"><i
                                                class="mdi mdi-link mdi-24px"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/behance.png') }}" alt="behance"
                                        class="me-3" height="30">
                                </div>
                                <div class="flex-grow-1 row">
                                    <div class="col-7">
                                        <h6 class="mb-0">Behance</h6>
                                        <small>Not Connected</small>
                                    </div>
                                    <div class="col-5 text-end">
                                        <button class="btn btn-outline-secondary btn-icon"><i
                                                class="mdi mdi-link mdi-24px"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- /Social Accounts -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
