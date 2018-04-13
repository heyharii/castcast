@component('mail::message')
# One more step before joining Castcast

We need to confirm your email

@component('mail::button', ['url' => 'http://castcast.tk/API/register/confirm/' . '?token=' . $user->confirm_token])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
