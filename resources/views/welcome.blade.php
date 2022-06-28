<!doctype html>
<html lang="{{ env('APP_LOCALE', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ env('APP_NAME') }}</title>

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
</html>
