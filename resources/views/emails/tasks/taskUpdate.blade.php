@component('mail::message')
# Email Notifying Change status

Task status was changed:<br>
Id : {{ $task->id }},<br>
Name task: {{ $task->name_task }},<br>
User : {{ $user->name }}, {{ $user->email }}<br>

@component('mail::button', ['url' => route('home')])
See tasks ->
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
