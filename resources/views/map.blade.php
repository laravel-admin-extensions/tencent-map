<div class="{{$viewClass['form-group']}} {!! !$errors->has($errorKey) ? '' : 'has-error' !!}">

    <label for="{{$id['lat']}}" class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="row">

            <div class="col-md-6">
                <input id="keyword" class="form-control" value="">
            </div>
            <div class="col-md-2">
                <input type="button" id="map_search" value="搜索" class="form-control btn btn-info">
            </div>
            <div class="col-md-2">
                <input id="{{$id['lat']}}" name="{{$name['lat']}}" class="form-control"
                       value="{{ old($column['lat'], $value['lat']) }}" {!! $attributes !!} />
            </div>
            <div class="col-md-2">
                <input id="{{$id['lng']}}" name="{{$name['lng']}}" class="form-control"
                       value="{{ old($column['lng'], $value['lng']) }}" {!! $attributes !!} />
            </div>
        </div>
        <br>

        <div class="row">
            <div id="map_{{$id['lat'].$id['lng']}}" style="width: 100%;height: {{ $height }}px"></div>
        </div>

        @include('admin::form.help-block')

    </div>
</div>
