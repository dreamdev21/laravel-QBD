@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            Welcome
            @if (auth()->check())
              <strong>
                {{ auth()->user()->name }}
              </strong>
            @endif
          </div>

          <div class="panel-body">
            @if (auth()->guest())
              To access <a href="/qgrid">Qgrid</a> menu,
              you need to
              <a href="/register">register</a> new account.
              You will automatically logged in after registered.
            @else
                <div class="text-center" style="margin-top: 20px;margin-bottom: 20px;">
                    You can upload xlsx file here.
                </div>

                  {!! Form::open(array('route' => 'fileUpload','enctype' => 'multipart/form-data')) !!}

                  <div class="row">

                      <div class="col-md-4 col-md-offset-2">

                          {!! Form::file('report', array('class' => 'form-group','required'=> true)) !!}

                      </div>

                      <div class="col-md-4">

                          <button type="submit" class="btn btn-success">Create</button>

                      </div>

                  </div>
                  {!! Form::close() !!}
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
