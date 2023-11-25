<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTga9ihRLdD8NLkTJ5BzzUmjuW5erdegn2_RkaCrMNJyzoSuzSN" class="logo" alt="Emporium">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
