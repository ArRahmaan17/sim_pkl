<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>
<script>
    function alertLoading() {
        swal('Loading', {
            button: false,
            closeOnClickOutside: false,
            icon: `{{ asset('assets/img/loading.gif') }}`
        });
    }
    document.addEventListener("DOMContentLoaded", (event) => {
        const now = new Date().getFullYear();
        document.querySelector('#year-now').setHTMLUnsafe(`${now}`);
    })
</script>
@stack('vendor-js')
<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
