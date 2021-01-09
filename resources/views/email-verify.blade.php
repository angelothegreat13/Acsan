@component('mail::message')
Hi {{ $firstname }},

We're happy you signed up for Acsan. To start 
exploring the Acsan Ecommerce Website, 
please confirm your email address.

@component('mail::button', ['url' => route('registration.verify-customer',$verificationCode)])
Verify Now
@endcomponent

Welcome to {{ config('app.name') }},<br>
The {{ config('app.name') }} Team
@endcomponent
