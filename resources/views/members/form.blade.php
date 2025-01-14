<?php use Carbon\Carbon; ?>

<!-- Hidden Fields -->
@if(Request::is('members/create'))
    {!! Form::hidden('invoiceCounter',$invoiceCounter) !!}
    {!! Form::hidden('memberCounter',$memberCounter) !!}
@endif

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('member_code','كود العميل') !!}
            {!! Form::text('member_code',$member_code,['class'=>'form-control', 'id' => 'member_code', ($member_number_mode == \constNumberingMode::Auto ? 'readonly' : '')]) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('name','الاسم',['class'=>'control-label']) !!}
            {!! Form::text('name',null,['class'=>'form-control', 'id' => 'name']) !!}
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('DOB','تاريخ الميلاد') !!}
            {!! Form::text('DOB',null,['class'=>'form-control datepicker-default', 'id' => 'DOB']) !!}
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('gender','النوع') !!}
            {!! Form::select('gender',array('m' => 'ذكر', 'f' => 'انثى'),null,['class'=>'form-control selectpicker show-tick show-menu-arrow', 'id' => 'gender']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('contact','رقم الهاتف') !!}
            {!! Form::text('contact',null,['class'=>'form-control', 'id' => 'contact']) !!}
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::label('health_issues','مشاكل صحية ان وجدت') !!}
            {!! Form::text('health_issues',null,['class'=>'form-control', 'id' => 'health_issues']) !!}
        </div>
    </div>
</div>


<div class="row">
    @if(isset($member))
        <?php
        $media = $member->getMedia('profile');
        $image = ($media->isEmpty() ? 'https://placeholdit.imgix.net/~text?txtsize=18&txt=NA&w=70&h=70' : url($media[0]->getUrl('form')));
        ?>
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('photo','صورة') !!}
                {!! Form::file('photo',['class'=>'form-control', 'id' => 'photo']) !!}
            </div>
        </div>
        <div class="col-sm-2">
            <img alt="profile Pic" class="pull-right" src="{{ $image }}"/>
        </div>
    @else
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('photo','صورة') !!}
                {!! Form::file('photo',['class'=>'form-control', 'id' => 'photo']) !!}
            </div>
        </div>
    @endif

    <div class="col-sm-6">
        <div class="form-group">
        {!! Form::label('status','الحالة') !!}
        <!--0 for inactive , 1 for active-->
            {!! Form::select('status',array('1' => 'Active', '0' => 'InActive'),null,['class' => 'form-control selectpicker show-tick show-menu-arrow', 'id' => 'status']) !!}
        </div>
    </div>
</div>



