<div class="row">
    <div class="col-md-12">
        <div class="box box-info">

{{--            <div class="box-header with-border">--}}
{{--                <h3 class="box-title">E分期管理后台权限</h3>--}}
{{--            </div>--}}

            <div class="form-horizontal">
                <div class="box-body">
                    <div style="">
                        @foreach ($menu as $k=>$item1)
                            <div class="first-box" style="float: left;margin-right: 20px;">
                                <div class="first-item">
                                    <label>
                                        <input class="first-checkbox" onclick="firstItem(this)" @if(in_array($item1['id'], $companyMenuIds))checked="checked" @endif type="checkbox" name="menu_id[]" value="{{$item1['id']}}">{{$item1['title']}}
                                    </label>
                                    <div class="second-box" style="margin-left: 20px;">
                                        @foreach($item1['children'] as $k=>$item2)
                                            <div class="second-item">
                                                <label>
                                                    <input class="second-checkbox" type="checkbox" name="menu_id[]" value="{{$item2['id']}}" onclick="secondItem(this)" @if(in_array($item2['id'], $companyMenuIds))checked="checked" @endif > {{$item2['title']}}
                                                </label>
                                                <div class="third-box" style="margin-left: 20px;">
                                                    @foreach($item2['children'] as $k=>$item3)
                                                        <div class="third-item">
                                                            <label>
                                                                <input class="third-checkbox" onclick="thirdItem(this)" @if(in_array($item3['id'], $companyMenuIds))checked @endif type="checkbox" name="menu_id[]" value="{{$item3['id']}}"> {{$item3['title']}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="display: none">
    <div class="col-md-12">
        <div class="box box-info">

            <div class="box-header with-border">
                <h3 class="box-title">E分期管理后台APP端权限</h3>
            </div>

            <div class="form-horizontal">
                <div class="box-body">
                    <div style="">
                        @foreach ($appMenu as $k=>$item1)
                            <div class="first-box" style="float: left;margin-right: 20px;">
                                <div class="first-item">
                                    <label>
                                        <input class="first-checkbox" onclick="firstItem(this)" @if(in_array($item1['id'], $appCompanyMenuIds))checked="checked" @endif type="checkbox" name="app_menu_id[]" value="{{$item1['id']}}">{{$item1['title']}}
                                    </label>
                                    <div class="second-box" style="margin-left: 20px;">
                                        @foreach($item1['children'] as $k=>$item2)
                                            <div class="second-item">
                                                <label>
                                                    <input class="second-checkbox" type="checkbox" name="app_menu_id[]" value="{{$item2['id']}}" onclick="secondItem(this)" @if(in_array($item2['id'], $appCompanyMenuIds))checked="checked" @endif > {{$item2['title']}}
                                                </label>
                                                <div class="third-box" style="margin-left: 20px;">
                                                    @foreach($item2['children'] as $k=>$item3)
                                                        <div class="third-item">
                                                            <label>
                                                                <input class="third-checkbox" onclick="thirdItem(this)" @if(in_array($item3['id'], $appCompanyMenuIds))checked @endif type="checkbox" name="app_menu_id[]" value="{{$item3['id']}}"> {{$item3['title']}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function firstItem(obj) {
        var firstCheckStatus = $(obj).is(':checked')
        $(obj).parent().parent('.first-item').find('.second-checkbox').prop('checked', firstCheckStatus)
        $(obj).parent().parent('.first-item').find('.third-checkbox').prop('checked', firstCheckStatus)
    }

    function secondItem(obj) {
        var secondCheckStatus = $(obj).is(':checked')
        var secondItemObj = $(obj).parent().parent()
        var firstItemObj = $(secondItemObj).parent().parent()
        secondItemObj.find('.third-checkbox').prop('checked', secondCheckStatus)

        // 一级选中
        var fullSecond = true
        var hasCheckedSecond = false
        firstItemObj.find('.second-checkbox').each(function () {
            if ($(this).is(':checked') == false) {
                fullSecond = false
            }
            if ($(this).is(':checked') == true) {
                hasCheckedSecond = true
            }
        })

        if (fullSecond == true || hasCheckedSecond == true) {
            $(firstItemObj).find('.first-checkbox').prop('checked', true)
        }
    }

    function thirdItem(obj) {

        var fullThird = true    //全部有选中状态
        var hasCheckedThird = false //有选中状态
        var secondItemObj = $(obj).parent().parent().parent().parent()
        var firstItemObj = $(secondItemObj).parent().parent()

        // 二级选中
        secondItemObj.find('.third-checkbox').each(function () {
            if ($(this).is(':checked') == false) {
                fullThird = false
            }
            if ($(this).is(':checked') == true) {
                hasCheckedThird = true
            }
        })
        console.log(fullThird)
        if (fullThird == true || hasCheckedThird == true) {
            $(secondItemObj).find('.second-checkbox').prop('checked', true)
        }

        // 一级选中
        var fullSecond = true
        var hasCheckedSecond = false
        firstItemObj.find('.second-checkbox').each(function () {
            if ($(this).is(':checked') == false) {
                fullSecond = false
            }
            if ($(this).is(':checked') == true) {
                hasCheckedSecond = true
            }
        })

        if (fullSecond == true || hasCheckedSecond == true) {
            $(firstItemObj).find('.first-checkbox').prop('checked', true)
        }


    }


    $(function () {
        $('.box-title').click(function () {
            $('.second-checkbox').attr('checked', true)

        })
    })

</script>
