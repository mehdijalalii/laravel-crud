<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laravel CRUD Test Assignment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Important to work AJAX CSRF -->
    <meta name="_token" content="{!! csrf_token() !!}" />
    <!-- Scripts -->
    <script src="{{asset ('js/jquery-3.5.1.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset ('css/darkly-bootstrap.min.css')}}" media="screen">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0);">
                Laravel CRUD Test Assignment
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <button id="btn_add" name="btn_add" class="btn btn-default pull-right">Add New Customer</button>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <table class="table table-striped table-hover ">
                <thead>
                <tr class="info">
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date Of Birth</th>
                    <th>Email</th>
                    <th>Bank Account Number</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="customers-list" name="customers-list">
                @foreach ($customers as $customer)
                    <tr id="customer{{$customer->id}}" class="active">
                        <td>{{$customer->first_name}}</td>
                        <td>{{$customer->last_name}}</td>
                        <td>{{$customer->date_of_birth}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->bank_account_number}}</td>
                        <td>{{$customer->phone_number}}</td>
                        <td>
                            <button class="btn btn-warning btn-detail open_modal" value="{{$customer->id}}">Edit</button>
                            <button class="btn btn-danger btn-delete delete-customer" value="{{$customer->id}}">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Passing BASE URL to AJAX -->
<input id="url" type="hidden" value="{{ \Request::url() }}">

<!-- MODAL SECTION -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Customer Form</h4>
            </div>
            <div class="modal-body">
                <form id="frmCustomers" name="frmCustomers" class="form-horizontal" novalidate="">
                    <div class="form-group error">
                        <label for="inputName" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control has-error" id="first_name" name="first_name" placeholder="First Name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Date Of Birth</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="date_of_birth" name="date_of_birth" placeholder="2020-01-20" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="email" name="email" placeholder="sample@sample.com" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Bank Account Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" placeholder="1234567890" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDetail" class="col-sm-3 control-label">Phone Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="+989120000000" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div id="errors" style="color: #ff0707;"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Save Changes</button>
                <input type="hidden" id="customer_id" name="customer_id" value="0">
            </div>
        </div>
    </div>
</div>
</body>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--<script src="{{asset ('js/bootstrap.min.js')}}"></script>--}}
{{--<script src="{{asset ('js/jquery-1.11.3.min.js')}}"></script>--}}
<script src="{{asset('js/ajaxscript.js')}}"></script>s
</html>
