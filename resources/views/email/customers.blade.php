<x-mail::message>
# Introduction

You are recieving this email becuase you have been sent an invitaion as customer against your Van enquiry.

click on the button blow to fill the customer form

<x-mail::button :url="env('FRONT_APP_URL') . '/user/register'">
    Fill the customer form
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
