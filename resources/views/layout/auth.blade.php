<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITE FORCE | @yield('siteTitle', 'IMS')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.ico') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('assets/css/shared/iconly.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div id="auth">
        <div class="row h-100">
        <div class="col-lg-12 h-50 d-none d-lg-block">
                <div id="auth-right"> </div>
            </div>
            <div class="col-lg-12 col-12">
                <div id="auth-left">
                    <div class="auth-logo text-center">
                        <a href="#"><img src="{{ asset('assets/images/logo/logo.png')}}" alt="Logo"></a>
                    </div>

                    @yield('content')

                </div>
            </div>

        </div>
    </div>


    <script src="{{ asset('/assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"></script>

    <script>
        /*var iti = window.intlTelInput(input, {
            initialCountry: "jp",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
            initialCountry: 'auto',
            geoIpLookup: function(success, failure) {
                $.get('https://ipinfo.io', function() {}, 'jsonp').always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : '';
                    success(countryCode);
                    $("#country_id").val(countryCode).change();
                });
            }
        });*/
        var phoneNumberInput = document.querySelector("#phone");
        var countrySelect = document.querySelector("#country_id");
        var iti = window.intlTelInput(phoneNumberInput, {
            initialCountry: countrySelect.value,
            separateDialCode: true
        });

        // When the selected country changes, update the phone number input
        countrySelect.addEventListener("change", function() {
            iti.setCountry(this.value);
        });




        // Validate the phone number on form submit
        $("form").on("submit", function() {
            var isValid = iti.isValidNumber();
            if (!isValid) {
                alert("Please enter a valid phone number.");
                return false;
            }
        });
    </script>
    @stack('scripts')

</body>

</html>
