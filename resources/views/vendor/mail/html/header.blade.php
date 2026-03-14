@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Mbacol Communication')
<img src="{{ asset('images/logo.webp') }}" class="logo" alt="Mbacol Communication" loading="eager">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>