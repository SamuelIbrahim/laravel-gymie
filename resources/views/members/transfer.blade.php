@extends('app')

@section('content')

    <?php
    use Carbon\Carbon;
    ?>
    <div class="rightside bg-grey-100">
        <div class="container-fluid">
            <!-- Error Log -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::Open(['url' => 'members','id'=>'membersform','files'=>'true']) !!}
            {!! Form::hidden('transfer_id',$enquiry->id) !!}
            {!! Form::hidden('memberCounter',$memberCounter) !!}
            {!! Form::hidden('invoiceCounter',$invoiceCounter) !!}
        <!-- Member Details -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head font-size-20">ادخل بيانات العميل</div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('name','Name',['class'=>'control-label']) !!}
                                        {!! Form::text('name',$enquiry->name,['class'=>'form-control', 'id' => 'name']) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('photo','Photo') !!}
                                        {!! Form::file('photo',['class'=>'form-control', 'id' => 'photo']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('DOB','Date Of Birth') !!}
                                        {!! Form::text('DOB',$enquiry->DOB,['class'=>'form-control datepicker', 'id' => 'DOB']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('gender','Gender') !!}
                                        {!! Form::select('gender',array('m' => 'ذكر', 'f' => 'انثى'),null,['class'=>'form-control selectpicker show-tick show-menu-arrow', 'id' => 'gender']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('contact','Contact') !!}
                                        {!! Form::text('contact',$enquiry->contact,['class'=>'form-control', 'id' => 'contact']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('health_issues','Health issues') !!}
                                        {!! Form::text('health_issues',null,['class'=>'form-control', 'id' => 'health_issues']) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('member_code','Member Code') !!}
                                        {!! Form::text('member_code',$member_code,['class'=>'form-control', 'id' => 'member_code', ($member_number_mode == \constNumberingMode::Auto ? 'readonly' : '')]) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                    {!! Form::label('status','Status') !!}
                                    <!--0 for inactive , 1 for active-->
                                        {!! Form::select('status',array('1' => 'Active', '0' => 'InActive'),null,['class' => 'form-control selectpicker show-tick show-menu-arrow', 'id' => 'status']) !!}
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>

            <!-- Subscription Details -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head font-size-20">بيانات الاشتراك</div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    {!! Form::label('plan_0','خطة الاشتراك') !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::label('start_date_0','تاريخ بداية الاشتراك') !!}
                                </div>

                                <div class="col-sm-3">
                                    {!! Form::label('end_date_0','تاريخ نهاية الاشتراك') !!}
                                </div>

                                <div class="col-sm-1">
                                    <label>&nbsp;</label><br/>
                                </div>
                            </div> <!-- / Row -->
                            <div id="servicesContainer">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group plan-id">
                                            <?php $plans = App\Plan::where('status', '=', '1')->get(); ?>

                                            <select id="plan_0" name="plan[0][id]" class="form-control selectpicker show-tick show-menu-arrow childPlan"
                                                    data-live-search="true" data-row-id="0">
                                                @foreach($plans as $plan)
                                                    <option value="{{ $plan->id }}" data-price="{{ $plan->amount }}" data-days="{{ $plan->days }}"
                                                            data-row-id="0">{{ $plan->plan_display }} </option>
                                                @endforeach
                                            </select>
                                            <div class="plan-price">
                                                {!! Form::hidden('plan[0][price]','', array('id' => 'price_0')) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group plan-start-date">
                                            {!! Form::text('plan[0][start_date]',Carbon::today()->format('Y-m-d'),['class'=>'form-control datepicker-startdate childStartDate', 'id' => 'start_date_0', 'data-row-id' => '0']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group plan-end-date">
                                            {!! Form::text('plan[0][end_date]',null,['class'=>'form-control childEndDate', 'id' => 'end_date_0', 'readonly' => 'readonly','data-row-id' => '0']) !!}
                                        </div>
                                    </div>

                                    <div class="col-sm-1">
                                        <div class="form-group">
                            <span class="btn btn-sm btn-danger pull-right hide remove-service">
                              <i class="fa fa-times"></i>
                            </span>
                                        </div>
                                    </div>
                                </div> <!-- / Row -->
                            </div>
                            <div class="row">
                                <div class="col-sm-2 pull-right">
                                    <div class="form-group">
                                        <span class="btn btn-sm btn-primary pull-right" id="addSubscription">اضافة</span>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- / Panel Body -->

                    </div> <!-- /Panel -->
                </div> <!-- /Main Column -->
            </div> <!-- /Main Row -->

            <!-- Invoice Details -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head font-size-20">Enter details of the invoice</div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('invoice_number','Invoice Number') !!}
                                        {!! Form::text('invoice_number',$invoice_number,['class'=>'form-control', 'id' => 'invoice_number', ($invoice_number_mode == \constNumberingMode::Auto ? 'readonly' : '')]) !!}
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('admission_amount','Admission') !!}
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                            {!! Form::text('admission_amount',Utilities::getSetting('admission_fee'),['class'=>'form-control', 'id' => 'admission_amount']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('subscription_amount','Gym subscription fee') !!}
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                            {!! Form::text('subscription_amount',null,['class'=>'form-control', 'id' => 'subscription_amount','readonly' => 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('taxes_amount',sprintf('Tax @ %s %%',Utilities::getSetting('taxes'))) !!}
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                            {!! Form::text('taxes_amount',0,['class'=>'form-control', 'id' => 'taxes_amount','readonly' => 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /Row -->

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('discount_percent','Discount') !!}
                                        <?php
                                        $discounts = explode(",", str_replace(" ", "", (Utilities::getSetting('discounts'))));
                                        $discounts_list = array_combine($discounts, $discounts);
                                        ?>
                                        <select id="discount_percent" name="discount_percent" class="form-control selectpicker show-tick show-menu-arrow">
                                            <option value="0">None</option>
                                            @foreach($discounts_list as $list)
                                                <option value="{{ $list }}">{{ $list.'%' }}</option>
                                            @endforeach
                                            <option value="custom">Custom(Rs.)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('discount_amount','Discount amount') !!}
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                            {!! Form::text('discount_amount',null,['class'=>'form-control', 'id' => 'discount_amount','readonly' => 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        {!! Form::label('discount_note','Discount note') !!}
                                        {!! Form::text('discount_note',null,['class'=>'form-control', 'id' => 'discount_note']) !!}
                                    </div>
                                </div>
                            </div>

                        </div> <!-- /Panel-body -->

                    </div> <!-- /Panel -->
                </div> <!-- /Main Column -->
            </div> <!-- /Main Row -->

            <!-- Payment Details -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head font-size-20">بيانات الدفع</div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('payment_amount','المبلغ المستلم') !!}
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                            {!! Form::text('payment_amount',null,['class'=>'form-control', 'id' => 'payment_amount', 'data-amounttotal' => '0']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        {!! Form::label('payment_amount_pending','المبلغ المتبقي') !!}
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-inr"></i></div>
                                            {!! Form::text('payment_amount_pending',null,['class'=>'form-control', 'id' => 'payment_amount_pending', 'readonly']) !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('mode','طريقة الدفع') !!}
                                        {!! Form::select('mode',array('1' => 'نقدي', '0' => 'شيك'),1,['class'=>'form-control selectpicker show-tick', 'id' => 'mode']) !!}
                                    </div>
                                </div>
                            </div> <!-- /Row -->
                            <div class="row" id="chequeDetails">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('number','رقم الشيك') !!}
                                        {!! Form::text('number',null,['class'=>'form-control', 'id' => 'number']) !!}
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('date','تاريخ الشيك') !!}
                                        {!! Form::text('date',null,['class'=>'form-control datepicker-default', 'id' => 'date']) !!}
                                    </div>
                                </div>
                            </div>

                        </div> <!-- /Panel-body -->

                    </div> <!-- /Panel -->
                </div> <!-- /Main Column -->
            </div> <!-- /Main Row -->

            <!-- Submit Button Row -->
            <div class="row">
                <div class="col-sm-2 pull-right">
                    <div class="form-group">
                        {!! Form::submit('Create', ['class' => 'btn btn-primary pull-right']) !!}
                    </div>
                </div>
            </div>

            {!! Form::Close() !!}

        </div> <!-- content -->
    </div> <!-- rightside -->

@stop
@section('footer_scripts')
    <script src="{{ URL::asset('assets/js/member.js') }}" type="text/javascript"></script>
@stop
@section('footer_script_init')
    <script type="text/javascript">
        $(document).ready(function () {
            gymie.loaddatepickerstart();
            gymie.chequedetails();
            gymie.subscription();
        });
    </script>
@stop
