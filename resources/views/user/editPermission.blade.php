@extends('app')

@section('content')

    <div class="rightside bg-grey-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>عذرا!</strong> حدث خطأ ما.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="panel no-border">
                        <div class="panel-title bg-white no-border">
                            <div class="panel-head">ادخل بيانات الصلاحية</div>
                        </div>

                        {!! Form::Open(['method' => 'POST','id' => 'permissionsform','action' => ['AclController@updatePermission',$permission->id]]) !!}

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('name','الاسم') !!}
                                        {!! Form::text('name',$permission->name,['class'=>'form-control', 'id' => 'name']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('display_name','الاسم المعروض') !!}
                                        {!! Form::text('display_name',$permission->display_name,['class'=>'form-control', 'id' => 'display_name']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('description','الوصف') !!}
                                        {!! Form::text('description',$permission->description,['class'=>'form-control', 'id' => 'description']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('group_key','المجموعة') !!}
                                        {!! Form::text('group_key',$permission->group_key,['class'=>'form-control', 'id' => 'group_key']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2 pull-right">
                            <div class="form-group">
                                {!! Form::submit('Update', ['class' => 'btn btn-primary pull-right']) !!}
                            </div>
                        </div>
                    </div>

                    {!! Form::Close() !!}


                </div>
            </div>
        </div>
    </div>
    </div>

@stop