@if(auth()->user()->role_id != 5)
    <div v-show="renderForm === 14 && reportRender == 0" id="report">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Invoice
                    <button type="button" onclick="javascript:print()" class="btn btn-success btn-xs"><i class="fa fa-print"></i></button>
                    <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">

                <address>
                    <strong>{{ auth()->user()->company->name }}</strong><br>
                    Address: {{ auth()->user()->company->address }}<br>
                    Phone: {{ auth()->user()->company->phone }}<br>
                    Email: {{ auth()->user()->company->email }}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                Client/Patient
                <address>
                    <strong>
                        @{{ reportData.claimant.title }} @{{ reportData.claimant.firstName }} @{{ reportData.claimant.lastName }}
                    </strong><br>
                    Address: @{{ reportData.claimant.address }} <br>
                    <hr>

                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice </b>#00HN - 7<br>
                <br>
                <b>Payment Due:</b>
                <p>Not Set</p>
                <br>

            </div>
            <!-- /.col -->
        </div>
    </div>
@endif
