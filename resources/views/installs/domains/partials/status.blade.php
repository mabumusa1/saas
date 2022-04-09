@if($domain->verified_at)
<span class="svg-icon svg-icon-2 svg-icon-success">
    {!! get_svg_icon('skin/media/icons/duotone/Navigation/Check.svg') !!}
</span>
@else
<span class="svg-icon svg-icon-2 svg-icon-danger">
{!! get_svg_icon('skin/media/icons/duotone/Code/Warning-1-circle.svg') !!}
</span>
@endif
