<div class="container-fluid">
    <div class="row">
    <div class="col-sm-12">

    <div class="col-sm-7">
        <h5 style="color:#3393FF">Tenant Info..</h5>
        <div>Date : <strong>{{ date('d M, Y', strtotime($tenant->created_at)) }}</strong> </div>
        <div>
            Name: <strong>{{ $tenant->tenants->tenant_name }} </strong>
        </div>
        <div>Flat Name: <strong>{{ $tenant->flats->flat_name }}</strong>  </div>
        <div>RentTitle: <strong>{{ $tenant->rents->rent_title }}</strong>  </div>
        <div>Flat Rent: <strong>{{ $tenant->rents->total_rent }}</strong>  </div>
        <div>Rental Month: <strong>{{ date('F, Y', strtotime($tenant->rental_month)) }} </strong> </div>
        <div>Paid Amount: <strong>{{ json_decode($tenant->amount) }} </strong> </div>
        <div>Due Amount: <strong>{{ $due }} </strong> </div>
        <div>Phone: <strong>{{ $tenant->tenants->contact_no }} </strong> </div>
        <div>Email: <strong>{{ $tenant->tenants->email }} </strong> </div>
        <div>Address: <strong>{{ $tenant->tenants->address }}</strong> </div>
    </div>

    </div>
</div>
</div>

