<!-- jQuery JS -->
<script src="{{ asset('js/vendor/jquery-1.12.0.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<!-- Plugins JS -->
<script src="{{ asset('js/plugins.js') }}"></script>
<!-- Ajax Mail JS -->
<script src="{{ asset('js/ajax-mail.js') }}"></script>
<!-- Main JS -->
<script src="{{ asset('js/main.js') }}"></script>
@yield('extra-scripts')
@stack('scripts')
</body>
</html>