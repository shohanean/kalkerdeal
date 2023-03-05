<x-mail::message>
# Congratulations to {{ $information['name'] }}!

Your account has been created at KalkerDeal.com

<x-mail::panel>
<h1>Role: {{ $information['role'] }}</h1>
</x-mail::panel>

<x-mail::panel>
<p><b>Email: </b> {{ $information['email'] }}</p>
<p><b>Password: </b> {{ $information['password'] }}</p>
</x-mail::panel>

You can change your password by login into your account.

<x-mail::button :url="url('login')" color="success">
Click to Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1 class="bg-info">Congratulations!</h1>
    <h3>Hello {{ $information['name'] }},</h3>
    <p>Your account has been created at KalkerDeal.com</p>
    <p><b>Email: </b> {{ $information['email'] }}</p>
    <p><b>Password: </b> {{ $information['password'] }}</p>
    <p>You can change your password by login into your account.</p>
    <p>
        <a href="{{ url('login') }}">Click to login</a>
    </p>
    <h2>Role: {{ $information['role'] }}</h2>
</body>
</html> --}}
