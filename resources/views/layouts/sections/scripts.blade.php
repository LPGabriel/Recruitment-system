<!-- BEGIN: Vendor JS-->
<script type="module" src="/assets/vendor/libs/jquery/jquery.js"></script>
<script type="module" src="/assets/vendor/libs/popper/popper.js"></script>
<script type="module" src="/assets/vendor/js/bootstrap.js"></script>
<script type="module" src="/assets/vendor/libs/node-waves/node-waves.js"></script>
<script type="module" src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script type="module" src="/assets/vendor/js/menu.js"></script>
@yield('vendor-script')
<!-- END: Page Vendor JS-->
@filamentScripts
<!-- BEGIN: Theme JS-->
{{-- <script src="{{ asset(mix('assets/js/main.js')) }}"></script> --}}

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
