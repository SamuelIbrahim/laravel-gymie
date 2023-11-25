@extends('app')

@section('content')

    <div class="rightside bg-white">
        <!-- BEGIN PAGE HEADING -->
        <div class="page-head bg-grey-100 margin-bottom-20 hidden-print">
            @include('flash::message')
            <h1 class="page-title">فاتورة</h1>
        </div>
        <!-- END PAGE HEADING -->

        <div class="container-fluid">
            <div class="row"> <!--Main Row-->
                <div class="col-lg-12"> <!-- Main column -->
                    <div class="panel"> <!-- Main Panel-->
                        <div class="panel-body">
                            <div class="border-bottom-1 border-grey-100 padding-bottom-20 margin-bottom-20 clearfix">

                                @if($settings['invoice_name_type'] == 'gym_logo')
                                    <img class="no-margin display-inline-block pull-left" src="{{url('/images/Invoice/'.'gym_logo'.'.jpg') }}" alt="Gym-logo">
                                @else
                                    <h3 class="no-margin display-inline-block pull-left"> {{ $settings['gym_name'] }}</h3>
                                @endif

                                <h4 class="pull-right no-margin">فاتورة # {{ $invoice->invoice_number}}</h4>
                            </div>

                            <div class="row"> <!-- Inner row -->
                                <div class="col-xs-6"> <!--Left Side Details -->
                                    <address>
                                        <strong>العميل :</strong><br>
                                        {{ $invoice->member->name }} ({{$invoice->member->member_code}})<br>

                                        <strong>طريقة الدفع</strong><br>
                                        <?php
                                        $modes = array();
                                        foreach ($invoice->paymentDetails->unique('mode') as $payment_mode) {
                                            $modes[] = Utilities::getPaymentMode($payment_mode->mode);
                                        }
                                        echo implode($modes, ',');
                                        ?><br>
                                        <strong>حالة الدفع</strong><br>
                                        {{ Utilities::getInvoiceStatus ($invoice->status) }}<br>
                                    </address>
                                </div>
                                <div class="col-xs-6 text-right"> <!--Right Side Details -->
                                    <address>
                                        <strong>عنوان الجيم</strong><br>
                                        {{ $settings['gym_address_1'] }}<br>
                                        {{ $settings['gym_address_2'] }}<br>
                                        <strong>تاريخ الانشاء</strong><br>
                                        {{ $invoice->created_at->toDayDateTimeString()}}<br>
                                        <strong>تاريخ الفاتورة القادمة</strong><br>
                                        In {{ $invoice->subscription->start_date->diffInDays($invoice->subscription->end_date) }} days
                                        On {{ $invoice->subscription->end_date->toFormattedDateString() }}<br>
                                    </address>
                                </div>
                            </div>        <!-- / inner row -->

                            <!--Invoice Details view -->

                            <div class="bg-amber-50 padding-md margin-bottom-20 margin-top-20" id="invoiceBlock">
                                <h4 class="margin-bottom-30 color-grey-700">بيانات الفاتورة</h4>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td><strong>خطة الاشتراك</strong></td>
                                            <td class="text-right"><strong>المبلغ</strong></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($invoice->invoiceDetails as $invoiceDetail)
                                            <tr>
                                                <td>{{ $invoiceDetail->plan->plan_name }}</td>
                                                <td class="text-right">{{ $invoiceDetail->item_amount }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>الضريبة</td>
                                            <td class="text-right">{{ $invoice->tax}}</td>
                                        </tr>
                                        @if($invoice->additional_fees != 0)
                                            <tr>
                                                <td>رسوم اضافية</td>
                                                <td class="text-right">{{ $invoice->additional_fees}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-left"><strong>خصم</strong></td>
                                            <td class="text-right">- {{ $invoice->discount_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left"><strong>الاجمالي</strong></td>
                                            <td class="text-right">{{ $invoice->total}}</td>
                                        </tr>
                                        @if($invoice->pending_amount != 0)
                                            <tr>
                                                <td class="no-border text-left"><strong>المتبقي</strong></td>
                                                <td class="no-border text-right">{{$invoice->pending_amount}}</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- / Panel - body no padding -->

                        <!-- Footer buttons -->
                        <div class="panel-footer bg-white no-padding-top padding-bottom-20 hidden-print">
                            @if($invoice->pending_amount != 0)
                                @permission(['manage-gymie','manage-payments','add-payment'])
                                <a class="btn btn-success pull-right" href="{{ action('InvoicesController@createPayment',['id' => $invoice->id]) }}"><i
                                            class="ion-card margin-right-5"></i> دفع</a>
                                @endpermission
                            @endif
                            @permission(['manage-gymie','manage-invoices','print-invoice'])
                            <button class="btn btn-primary pull-right margin-right-10" onclick="window.print();"><i class="ion-printer margin-right-5"></i>
                                Print
                            </button>
                            @endpermission
                        </div> <!-- / Footer buttons -->


                    </div> <!-- / Main Panel-->
                </div> <!-- / Main Column -->
            </div><!-- / Main row -->


            <!-- Payment Details -->
            <div class="row hidden-print"> <!--Main Row-->
                <div class="col-lg-12"> <!-- Main column -->
                    <div class="panel no-shadow"> <!-- Main Panel-->
                        <div class="panel-body no-padding">
                            <div class="bg-grey-100 padding-md margin-bottom-20 margin-top-20">
                                <h4 class="margin-bottom-30 color-grey-700">بيانات الدفع</h4>

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td><strong>المبلغ</strong></td>
                                            <td class="text-center"><strong>طريقة الدفع</strong></td>
                                            <td class="text-right"><strong>تاريخ الدفع</strong></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($invoice->paymentDetails as $paymentDetail)
                                            <tr>
                                                <td>{{ ($paymentDetail->payment_amount >= 0 ? $paymentDetail->payment_amount : str_replace("-","",$paymentDetail->payment_amount)." (Paid)") }}</td>
                                                <td class="text-center">{{ Utilities::getPaymentMode ($paymentDetail->mode) }}</td>
                                                <td class="text-right">{{ $paymentDetail->created_at->toDayDateTimeString() }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- / Panel - body no padding -->

                    </div> <!-- / Main Panel-->
                </div> <!-- / Main Column -->
            </div><!-- / Main row -->


        </div> <!-- / Container Fluid -->
    </div> <!-- / Right Side -->

@stop