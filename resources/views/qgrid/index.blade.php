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
    </style>
    <div class="container">

        <div class="clearfix">
            <div class="pull-left">
                <div class="lead">QGrid Datatable</div>
            </div>
            <div class="pull-right">
                <a href="/qgrid/add" class="btn btn-success" data-toggle="modal" data-target="#newmodal">Add new</a>
                <a href="/qgrid/export_csv" class="btn btn-primary">Export CSV</a>
                <a href="/qgrid/export_json" class="btn btn-primary">Export JSON</a>
            </div>

        </div>

        <hr>

        <table class="table table-bordered table-hover table-striped">
            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th class="col-xs-1">--}}
            {{--ID--}}
            {{--<div class="pull-right">--}}
            {{--<a href="?sortby=id&sortdir=ASC"--}}
            {{--class="btn btn-xs {{ is_active_sorter('id', 'ASC') ? 'btn-primary' : 'btn-default' }}">--}}
            {{--<i class="fa fa-arrow-up"></i>--}}
            {{--</a>--}}
            {{--<a href="?sortby=id&sortdir=DESC"--}}
            {{--class="btn btn-xs {{ is_active_sorter('id', 'DESC') ? 'btn-primary' : 'btn-default' }}">--}}
            {{--<i class="fa fa-arrow-down"></i>--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</th>--}}
            {{--<th class="col-xs-3">--}}
            {{--Page title--}}
            {{--<div class="pull-right">--}}
            {{--<a href="?sortby=title&sortdir=ASC"--}}
            {{--class="btn btn-xs {{ is_active_sorter('title', 'ASC') ? 'btn-primary' : 'btn-default' }}">--}}
            {{--<i class="fa fa-arrow-up"></i>--}}
            {{--</a>--}}
            {{--<a href="?sortby=title&sortdir=DESC"--}}
            {{--class="btn btn-xs {{ is_active_sorter('title', 'DESC') ? 'btn-primary' : 'btn-default' }}">--}}
            {{--<i class="fa fa-arrow-down"></i>--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</th>--}}
            {{--<th class="col-xs-3">--}}
            {{--Last modified--}}
            {{--<div class="pull-right">--}}
            {{--<a href="?sortby=updated_at&sortdir=ASC"--}}
            {{--class="btn btn-xs {{ is_active_sorter('updated_at', 'ASC') ? 'btn-primary' : 'btn-default' }}">--}}
            {{--<i class="fa fa-arrow-up"></i>--}}
            {{--</a>--}}
            {{--<a href="?sortby=updated_at&sortdir=DESC"--}}
            {{--class="btn btn-xs {{ is_active_sorter('updated_at', 'DESC') ? 'btn-primary' : 'btn-default' }}">--}}
            {{--<i class="fa fa-arrow-down"></i>--}}
            {{--</a>--}}
            {{--</div>--}}
            {{--</th>--}}
            {{--<th class="col-xs-2">--}}
            {{--Action--}}
            {{--</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
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
                                                            onclick="showContent{{$dpdata['id']}}()" data-toggle="modal"
                                                            data-target="#detail{{$dpdata->id}}">
                                                            {{ $dpdata['content'] }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    {{--@foreach($dpdatas as $dpdata)--}}
                                    {{--<td style="display: none" id = "hidecontent{{$dpdata['id']}}">--}}
                                    {{--<table class="table">--}}
                                    {{--<tbody>--}}
                                    {{--<tr>--}}
                                    {{--<td>--}}
                                    {{--<table>--}}
                                    {{--<tr>--}}
                                    {{--<td>{{ $dpdata['id'] }}</td>--}}
                                    {{--<td>{{ $dpdata['id'] }}</td>--}}
                                    {{--<td>{{ $dpdata['id'] }}</td>--}}
                                    {{--<td>{{ $dpdata['id'] }}</td>--}}
                                    {{--</tr>--}}
                                    {{--</table>--}}
                                    {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--</tbody>--}}
                                    {{--</table>--}}
                                    {{--</td>--}}
                                    {{--@endforeach--}}
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

    @foreach( $datas as $data)
        <div id="detail{{$data->id}}" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <h3 class="m-t-none m-b  text-center">Details</h3>
                            <div class="col-sm-10 col-sm-offset-1 ">
                                {{ Form::open(['method' => 'Update','route' => ['/qgrid/update', $data->id],'style'=>'display:inline','class'=>'form-horizontal']) }}

                                <div class="form-group"><label>Content ID : </label> <input type="number"
                                                                                            name="content_id"
                                                                                            required autofocus
                                                                                            value="{{$data['content_id']}}"
                                                                                            class="form-control">
                                </div>
                                <div class="form-group"><label>Parent ID : </label> <input type="number"
                                                                                           name="parent_id" required
                                                                                           autofocus
                                                                                           value="{{$data['parent_id']}}"
                                                                                           class="form-control">
                                </div>

                                <div class="form-group"><label>Content : </label> <input type="text"
                                                                                         name="content" required
                                                                                         autofocus
                                                                                         value="{{$data['content']}}"
                                                                                         class="form-control">
                                </div>

                                <div class="form-group"><label>Created Date : {{$data['created_at']}}</label>
                                    {{--<input type="date" name="crated_at" required autofocus  value="{{$data['crated_at']}}" class="form-control">--}}
                                </div>
                                <div class="form-group"><label>Changed Date : {{$data['updated_at']}}</label>
                                    {{--<input type="date" name="updated_at" required autofocus  value="{{$data['updated_at']}}"  class="form-control">--}}
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            {{ Form::submit('Update', ['class' => 'btn btn-sm btn-success pull-right m-t-n-xs','style' => 'margin-right: 60px;']) }}
                            {{ Form::close() }}
                            {{ Form::open(['method' => 'Destroy','route' => ['/qgrid/delete', $data->id],'style'=>'display:inline','class'=>'form-horizontal']) }}
                            {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger pull-left m-t-n-xs','style' => 'margin-left: 60px;']) }}

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    @endforeach

    <div id="newmodal" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <h3 class="m-t-none m-b  text-center">Add new</h3>
                        <div class="col-sm-10 col-sm-offset-1 ">
                            {{ Form::open(['method' => 'get','route' => ['/qgrid/add', $data->id],'style'=>'display:inline','class'=>'form-horizontal']) }}

                            <div class="form-group"><label>Content ID : </label> <input type="number"
                                                                                        name="content_id"
                                                                                        required autofocus
                                                                                        value=""
                                                                                        class="form-control">
                            </div>
                            <div class="form-group"><label>Parent ID : </label> <input type="number"
                                                                                       name="parent_id" required
                                                                                       autofocus
                                                                                       value=""
                                                                                       class="form-control">
                            </div>
                            <div class="form-group"><label>Content Type : </label> <input type="text"
                                                                                          name="content_type" required
                                                                                          autofocus
                                                                                          value=""
                                                                                          class="form-control">
                            </div>
                            <div class="form-group"><label>Content Order : </label> <input type="text"
                                                                                          name="content_order" required
                                                                                          autofocus
                                                                                          value=""
                                                                                          class="form-control">
                            </div>
                            <div class="form-group"><label>Content : </label> <input type="text"
                                                                                     name="content" required
                                                                                     autofocus
                                                                                     value=""
                                                                                     class="form-control">
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

    {{--<script type="text/javascript">--}}
    {{--@foreach($datas as $data)--}}
    {{--function showContent{{$data['id']}}(){--}}
    {{--console.log('#hidecontent{{$data['id']}}');--}}
    {{--hideContent();--}}
    {{--$('#hidecontent{{$data['id']}}').show();--}}
    {{--}--}}

    {{--@endforeach--}}
    {{--function hideContent(){--}}
    {{--@foreach($datas as $data)--}}
    {{--$('#hidecontent{{$data['id']}}').hide();--}}
    {{--@endforeach--}}
    {{--}--}}
    {{--</script>--}}
@endsection
