<div class="{{$viewClass['form-group']}}" style="margin-top: .3rem">
    <label class="{{$viewClass['label']}} control-label">{!! $label !!}</label>
    <div class="{{$viewClass['field']}}">
        <div class="box box-solid box-default no-margin">
            <div class="box-body" style="background-color: rgb(240, 240, 240) !important;">
                <div class="{{$class}}">{!! $value !!}&nbsp;</div>
            </div>
        </div>

        @include('admin::form.help-block')

    </div>
</div>
