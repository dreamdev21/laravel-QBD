@extends('layouts.app')

@section('content')
    <style>
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 0px;
            line-height: 3.42857143;
            vertical-align: top;
            border: 1px solid #e2e2e2;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px;
        }

        td.table_hover:hover {
            background-color: lightgreen;
        }
        .table>tbody>tr.active>td, .table>tbody>tr.active>th, .table>tbody>tr>td.active, .table>tbody>tr>th.active, .table>tfoot>tr.active>td, .table>tfoot>tr.active>th, .table>tfoot>tr>td.active, .table>tfoot>tr>th.active, .table>thead>tr.active>td, .table>thead>tr.active>th, .table>thead>tr>td.active, .table>thead>tr>th.active {
            background-color: lawngreen;
        }
    </style>
    <div class="container">

        <div class="clearfix">
            <div class="pull-left">
                <div class="lead">QGrid Datatable</div>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" data-toggle="modal" data-target="#newmodal">Add new</a>
                <a href="/qgrid/export_csv" class="btn btn-primary">Export CSV</a>
                <a href="/qgrid/export_json" class="btn btn-primary">Export JSON</a>
            </div>

        </div>

        <hr>

        @if(count($datas))

            <table class="table table-bordered table-hover table-striped">
                <tbody>
                <tr>
                    <td>Description</td>
                    <td>
                        <table class="table">
                            <tbody>

                            @foreach($datas as $data)
                                @if($data['parent_id'] == 0)
                                    <tr>
                                        <td>
                                            {{ $data['content'] }}
                                        </td>
                                        <td>
                                            <table class="table">
                                                <tbody>
                                                @foreach($dpdatas as $dpdata)
                                                    @if($data['content_id'] == $dpdata['parent_id'] && $dpdata['content_type'] == "background")
                                                        <tr>
                                                            <td id="question{{$dpdata['id']}}" class="table_hover"
                                                                onclick="showContent{{$dpdata['id']}}()">
                                                                {{ $dpdata['content'] }}<i id = "narrow{{$dpdata['id']}}" class="fa fa-arrow-right" aria-hidden="true"></i>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="border: 0;display: none;border-left: 6px solid lawngreen;" class="showcontent" id="showcontent">

                                        </td>
                                        <td>
                                            <table class="table">
                                                <tbody>
                                                @foreach($dpdatas as $dpdata)
                                                    @if($data['content_id'] == $dpdata['parent_id'] && $dpdata['content_type'] == "discussion")
                                                        <tr>
                                                            <td>
                                                                {{ $dpdata['content'] }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="text-center">
                {{--{!! $datas->appends(request()->except('data'))->links() !!}--}}
            </div>

    </div>
    <div id="newmodal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <h3 class="m-t-none m-b  text-center">Add new</h3>
                        <div class="col-sm-10 col-sm-offset-1">
                            {{ Form::open(['method' => 'get','route' => ['/qgrid/add'],'style'=>'display:inline','class'=>'form-horizontal','id'=>'addform']) }}
                            <div class="form-group" style="display: none;"><label>Content ID : </label> <input type="number"
                                                                                        name="content_id"

                                                                                        value=""
                                                                                        class="form-control">
                            </div>
                            <div class="form-group"><label>Content Type : </label>
                                <select class="selectpicker form-control" name="content_type" onchange="selectContent_type(this.value);">
                                    <option value=""></option>
                                    <option value="question">question</option>
                                    <option value="background">background</option>
                                    <option value="discussion">discussion</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{ Form::submit('Submit', ['class' => 'btn btn-sm btn-success pull-right m-t-n-xs','style' => 'margin-right: 60px;']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

<script type="text/javascript">
function selectContent_type(sel)
{
    if(sel == "question"){
        $('#addcontent').remove();
        $('#addform').append('<div id="addcontent">\n' +
            '    <div class="form-group"><input type="hidden"\n' +
            '                                                               name="parent_id" required\n' +
            '                                                               autofocus\n' +
            '                                                               value="0"\n' +
            '                                                               class="form-control">\n' +
            '    </div>\n' +
            '    <div class="form-group"><label>Content Order : </label> <input type="text"\n' +
            '                                                                   name="content_order" required\n' +
            '                                                                   autofocus\n' +
            '                                                                   value=""\n' +
            '                                                                   class="form-control">\n' +
            '    </div>\n' +
            '    <div class="form-group"><label>Content : </label> <input type="text"\n' +
            '                                                             name="content" required\n' +
            '                                                             autofocus\n' +
            '                                                             value=""\n' +
            '                                                             class="form-control">\n' +
            '    </div>\n' +
            '</div>');
    }else if(sel == "background"){
        $('#addcontent').remove();
        $('#addform').append('<div id="addcontent">\n' +
            '    <div class="form-group"><label>Parent : </label>\n' +
            '        <select class="selectpicker form-control" name="parent_id">\n' +
            '            @foreach($datas as $data)\n' +
            '                @if($data['content_type'] == 'question')\n' +
            '                    <option value="{{$data['content_id'] }}">{{ $data['content'] }}</option>\n' +
            '                @endif\n' +
            '            @endforeach\n' +
            '        </select>\n' +
            '\n' +
            '    </div>\n' +
            '    <div class="form-group"><label>Content Order : </label> <input type="text"\n' +
            '                                                                   name="content_order" required\n' +
            '                                                                   autofocus\n' +
            '                                                                   value=""\n' +
            '                                                                   class="form-control">\n' +
            '    </div>\n' +
            '    <div class="form-group"><label>Content : </label> <input type="text"\n' +
            '                                                             name="content" required\n' +
            '                                                             autofocus\n' +
            '                                                             value=""\n' +
            '                                                             class="form-control">\n' +
            '    </div>\n' +
            '</div>');
    }else if(sel == "discussion"){
        $('#addcontent').remove();
        $('#addform').append('<div id="addcontent">\n' +
            '    <div class="form-group"><label>Parent : </label>\n' +
            '        <select class="selectpicker form-control" name="parent_id">\n' +
            '            @foreach($datas as $data)\n' +
            '                @if($data['content_type'] == 'background')\n' +
            '                    <option value="{{$data['parent_id'] }}">{{ $data['content'] }}</option>\n' +
            '                @endif\n' +
            '            @endforeach\n' +
            '        </select>\n' +
            '    </div>\n' +
            '    <div class="form-group"><label>Content Order : </label> <input type="text"\n' +
            '                                                                   name="content_order" required\n' +
            '                                                                   autofocus\n' +
            '                                                                   value=""\n' +
            '                                                                   class="form-control">\n' +
            '    </div>\n' +
            '    <div class="form-group"><label>Content : </label> <input type="text"\n' +
            '                                                             name="content" required\n' +
            '                                                             autofocus\n' +
            '                                                             value=""\n' +
            '                                                             class="form-control">\n' +
            '    </div>\n' +
            '</div>');
    }
}
@foreach($datas as $data)
function showContent{{$data['id']}}() {
    hideContent();
    $('#question{{$data['id']}}').addClass('active');
    $("#narrow{{$data['id']}}").remove();
    $('#question{{$data['id']}}').append('<i id = "narrow{{$data['id']}}" class="fa fa-arrow-left" aria-hidden="true" style = "color:white"></i>');
    $('.showcontent').show();
    $('#showcontent').append('<div id="content{{$data["id"]}}"><div class="row">\n' +
        '                            <h3 class="m-t-none m-b  text-center">Details</h3>\n' +
        '                                {{ Form::open(['method' => 'Update','route' => ['/qgrid/update', $data->id],'style'=>'display:inline','class'=>'form-horizontal']) }}\n' +
        '                            <div class="col-sm-10 col-sm-offset-1 ">\n' +
        '\n' +
        '                                <div class="form-group" style = "display:none;"><label>Content ID : </label> <input type="number"\n' +
        '                                                                                            name="content_id"\n' +
        '                                                                                            required autofocus\n' +
        '                                                                                            value="{{$data["content_id"]}}"\n' +
        '                                                                                            class="form-control">\n' +
        '                                </div>\n' +
        '                                <div class="form-group"><label>Parent ID : </label> \n' +
        '<select class="selectpicker form-control" name="parent_id">\n' +
        '            @foreach($dpdatas as $dpdata)\n' +
        '                @if($dpdata['parent_id'] == '0')\n' +
        '                    @if($dpdata['parent_id'] == $data['content_id'])\n' +
        '                        <option value="{{$dpdata['content_id'] }}" selected>{{ $dpdata['content'] }}</option>\n' +
        '                    @else\n' +
        '                        <option value="{{$dpdata['content_id'] }}">{{ $dpdata['content'] }}</option>\n' +
        '                    @endif\n' +
        '                @endif'+
        '            @endforeach\n' +
        '        </select>'+
        '                                </div>\n' +
        '\n' +
        '                                <div class="form-group"><label>Content : </label> <input type="text"\n' +
        '                                                                                         name="content" required\n' +
        '                                                                                         autofocus\n' +
        '                                                                                         value="{{$data["content"]}}"\n' +
        '                                                                                         class="form-control">\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="form-group"><label>Created Date : {{$data["created_at"]}}</label>\n' +
        '                                </div>\n' +
        '                                <div class="form-group"><label>Changed Date : {{$data["updated_at"]}}</label>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '\n' +
        '                            {{ Form::submit('Update', ['class' => 'btn btn-sm btn-success pull-right m-t-n-xs','style' => 'margin-right: 60px;']) }}\n' +
        '                            {{ Form::close() }}\n' +
        '                            {{ Form::open(['method' => 'Destroy','route' => ['/qgrid/delete', $data->id],'style'=>'display:inline','class'=>'form-horizontal']) }}\n' +
        '                            {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger pull-left m-t-n-xs','style' => 'margin-left: 60px;']) }}\n' +
        '\n' +
        '                            {{ Form::close() }}\n' +
        '                        </div></div>');
}

@endforeach
function hideContent() {
    @foreach($datas as $data)
        $('#question{{$data['id']}}').removeClass('active');
        $('#content{{$data['id']}}').remove();
        $("#narrow{{$data['id']}}").remove();
        $('#question{{$data['id']}}').append('<i id = "narrow{{$data['id']}}" class="fa fa-arrow-right" aria-hidden="true"></i>');
    @endforeach
}
</script>

@else
No Data!
@endif
@endsection
