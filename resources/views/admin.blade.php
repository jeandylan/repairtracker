<!DOCTYPE html>
<html lang="en" data-ng-app="app">
<head>
    <meta charset="utf-8" />
    <title>repair tracker</title>
    <meta name="description" content="repair tracking System 2.0" />
    <meta name="keywords" content="repair ,repair tracker" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link rel="stylesheet" href="assets/css/animate.css/animate.css" type="text/css" />
    <link rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/fonts/simple-line-icons/css/simple-line-icons.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />

    <link rel="stylesheet" href="assets/css/font.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/app.css" type="text/css" />

</head>
<body class="app">
<ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
<div class="col-sm-4">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

{!! Form::open(array('url' => '/registerCompany')) !!}


    <div class="form-group">
        {!! Form::label('company name') !!}
        {!! Form::text('company_name', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the company Domain')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('company Owner Location 1') !!}
        {!! Form::text('company_location_1', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the company Location 1')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('company Owner Location 2') !!}
        {!! Form::text('company_location_2', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the company Location 2')) !!}
    </div>
    <div class="form-group">
        {!! Form::label('Master Password ') !!}
        {!! Form::text('owner_password', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the password used by the admin ')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('owner_first_name ') !!}
        {!! Form::text('owner_first_name', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the company owner first Name')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('owner_last_name ') !!}
        {!! Form::text('owner_last_name', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the company owner first Name')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('owner_email') !!}
        {!! Form::text('owner_email', null,
            array('required',
                  'class'=>'form-control',
                  'placeholder'=>'the company owner first Name')) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('create Saas',
          array('class'=>'btn btn-primary')) !!}
    </div>


    {!! Form::close() !!}
</div>
</body>
</html>
