<x-mail::message>
# Reset Password

Click the button below to reset the password

<x-mail::button :url="$url" color="success">
Reset Password
</x-mail::button>

Thanks,
{{ config('app.name') }}
</x-mail::message>
