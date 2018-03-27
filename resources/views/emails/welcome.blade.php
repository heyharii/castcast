@component('mail::message')
# Welcome to our saas app, {{$user->name}}

The body of your message.

@component('mail::button', ['url' => ''])
Welcome !
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
