<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/output.css">
    <title>Forgot Password</title>
</head>

<div class="flex py-10 md:py-20 px-5 md:px-32 bg-gray-200 min-h-screen">
    <div class="flex shadow w-full flex-col-reverse lg:flex-row">
        <div class="w-full lg:w-1/2 bg-white p-10 px-5 md:px-20">
            <h1 class="font-bold text-xl text-gray-700">Forgot Password</h1>
            <p class="text-gray-600">Please enter your email to reset your password.</p>
            <br>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-10">
                @csrf
                <div class="my-3">
                    <label class="font-semibold" for="email">E-mail</label>
                    <input type="email" placeholder="yourmail@example.com" name="email" id="email" class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                </div>
                <div class="my-5">
                    <button type="submit" class="w-full rounded-full bg-blue-400 hover:bg-blue-600 text-white py-2">RESET PASSWORD</button>
                </div>
            </form>

        </div>
        <div class="w-full lg:w-1/2 bg-blue-400 flex justify-center items-center">
            <img src="/assets/vayya.jpeg" alt="Forgot Password Image" class="w-full">
        </div>
    </div>
</div>

<body>

</body>

</html>