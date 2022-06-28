<!doctype html>
<html lang="{{ env('APP_LOCALE', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title }} | {{ env('APP_NAME') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<main>
    <div class="relative flex flex-col justify-center min-h-screen overflow-hidden">
        <div
            class="sm:w-full p-6 m-auto bg-white border-t-4 border-purple-600 rounded-md shadow-md border-top max-w-md">
            <h1 class="text-3xl font-semibold text-center text-purple-700">LOGO</h1>
            <form id="form" action="javascript:void(0)" method="post" class="mt-6">
                <div>
                    <label for="username" class="block text-sm text-gray-800">Username</label>
                    <input id="username" name="username" type="text" autocomplete="username"
                           class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40">
                    <div class="invalid-feedback hidden"></div>
                </div>
                <div class="mt-4">
                    <div>
                        <label for="password" class="block text-sm text-gray-800">Password</label>
                        <input id="password" name="password" type="password" autocomplete="password"
                               class="block w-full px-4 py-2 mt-2 text-purple-700 bg-white border rounded-md focus:border-purple-400 focus:ring-purple-300 focus:outline-none focus:ring focus:ring-opacity-40">
                        <div class="invalid-feedback hidden"></div>
                    </div>
                    <div class="mt-6">
                        <button
                            class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-purple-700 rounded-md hover:bg-purple-600 focus:outline-none focus:bg-purple-600">
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function () {
        $('#form').on('submit', function (e) {
            e.preventDefault()

            const thisForm = this
            const url = $(this).attr('action')
            const method = $(this).attr('method')
            const formData = new FormData(thisForm)
            const data = Object.fromEntries(formData.entries())

            $.ajax({
                url,
                type: method,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "json",
                data,
                beforeSend: function () {
                    $(thisForm).find('.invalid-feedback').addClass('hidden')
                    $(thisForm).find('button[type="submit"]').attr('disabled', true)
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('landing.index') }}"
                        })
                    }
                },
                error: function (response) {
                    const responseJSON = response.responseJSON

                    if (response.status === 422) {
                        for (const [key, value] of Object.entries(responseJSON?.errors)) {
                            $(thisForm).find(`[name="${key}"]`).siblings('.invalid-feedback').html(value).removeClass('hidden')
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: responseJSON.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                complete: function () {
                    $(thisForm).find('button[type="submit"]').attr('disabled', false)
                }
            })
        })
    })
</script>
</html>
