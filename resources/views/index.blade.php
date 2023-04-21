<style>
    .china-area-dropdown, .china-area-input {
        display: inline-block;
    }
</style>
@php(is_null($value) ? $value = array_fill_keys($column, '') : $value = array_combine($column, $value))
<div class="{{$viewClass['form-group']}}">

    <label class="{{$viewClass['label']}} control-label">{{$label}}</label>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')
        <div class="clearfix">
            @foreach($column as $c)
                <div class="china-area-dropdown">
                    @if($loop->first)
                        <select name="{{ $c }}" class="custom-select multilevel-linkage" @if($required) required="1" @endif>
                            <option value="">请选择</option>
                            @foreach($options as $k => $option)
                                <option value="{{ $k }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    @else
                        <select name="{{ $c }}" class="custom-select multilevel-linkage" disabled>
                            <option value="">请选择</option>
                        </select>
                    @endif
                </div>
            @endforeach

        </div>
        @include('admin::form.help-block')

    </div>
</div>

<script>
    $(function (){
        let options = @json($options);
        //内容改变后，为disable的select
        let change = @json($change);
        //请求url
        let urls = @json($arr);
        //value值
        let values = @json($value);
        $.each(values, function (index, value){
            let el = $("select[name="+index+"]")
            if (value){
                el.val(value);
                ajax(el);
            }
        })

        $('select.multilevel-linkage').on('change', function(){
            ajax($(this))
        })

        function ajax(that){
            let value = that.val();
            //当前改变的select
            let name = that.attr('name');
            //需要重置的select
            let reset_names = change.reset[name];
            //需要禁用的select
            let disable_names = change.disable[name];
            //需要填充的select
            let fill_name = change.fill[name];
            //请求链接
            let url = urls[name];
            $.ajax({
                url:url,
                type:'get',
                async: false,
                data: {
                    'q': value,
                },success:function (res){
                    if (res.length > 0){
                        //清除后面的select
                        $.each(reset_names, function (index,item){
                            $('select[name="'+item+'"]').empty().append('<option value="">请选择</option>');
                        })
                        //设置禁止选择
                        $.each(disable_names, function (index,item){
                            $('select[name="'+item+'"]').attr('disabled', true);
                        })
                        $.each(res,function (index,item){
                            $('select[name="'+fill_name+'"]').append('<option value="'+index+'">'+item+'</option>');
                        })
                        $('select[name="'+fill_name+'"]').attr('disabled', false);
                    }
                }
            })
        }
    })


</script>
