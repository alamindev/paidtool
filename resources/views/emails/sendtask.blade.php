@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<div style="position: relative;">
    <strong style="text-decoration: underline; font-size: 24px;">Task assigned from paidtool </strong>
</div>

@endcomponent
@endslot
Dear <b>{{$user->name }}</b>, <br>
<br>
Please put a same txt that "you have receive task from paidtool. Please complete the task"
<br>
<br>
Thanks, <br>
<b >Paidtool</b>
<br />

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }}
@endcomponent
@endslot
@endcomponent
