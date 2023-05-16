$(document).ready(function () {
    //get base URL *********************
    var url = $('#url').val();

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function isValidBankAccountNumber(accountNumber) {
        var accountNumberRegex = /^[0-9]{10}$/;
        return accountNumberRegex.test(accountNumber);
    }


    //display modal form for creating new customer *********************
    $('#btn_add').click(function () {
        $('#errors').empty();
        $('#btn-save').val("add");
        $('#frmCustomers').trigger("reset");
        $('#myModal').modal('show');
    });


    //display modal form for customer EDIT ***************************
    $(document).on('click', '.open_modal', function () {
        $('#errors').empty();
        var customer_id = $(this).val();

        // Populate Data in Edit Modal Form
        $.ajax({
            type: "GET",
            url: url + '/api/v1/customer/' + customer_id,
            success: function (data) {
                $('#customer_id').val(data.customer.id);
                $('#first_name').val(data.customer.first_name);
                $('#last_name').val(data.customer.last_name);
                $('#date_of_birth').val(data.customer.date_of_birth);
                $('#email').val(data.customer.email);
                $('#bank_account_number').val(data.customer.bank_account_number);

                var phoneNumber = data.customer.phone_number;
                if (!phoneNumber.startsWith("+")) {
                    phoneNumber = "+" + phoneNumber;
                }
                $('#phone_number').val(phoneNumber);

                $('#btn-save').val("update");
                $('#myModal').modal('show');
            },
            error: function (data) {
                //
            }
        });
    });


    //create new customer / update existing customer ***************************
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();

        // Get the email and bank account number values
        var email = $('#email').val();
        var bankAccountNumber = $('#bank_account_number').val();

        // Perform validation
        var isValid = true;
        var errorMessage = '';

        if (!isValidEmail(email)) {
            isValid = false;
            errorMessage += '<li>' + 'Invalid email format' + '</li>';
        }

        if (!isValidBankAccountNumber(bankAccountNumber)) {
            isValid = false;
            errorMessage += '<li>' + 'Invalid bank account number' + '</li>';
        }

        if (errorMessage !== '') {
            errorMessage = '<ul>' + errorMessage + '</ul>';
            $('#errors').html(errorMessage);
        }

        var formData = {
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            date_of_birth: $('#date_of_birth').val(),
            email: $('#email').val(),
            bank_account_number: $('#bank_account_number').val(),
            phone_number: $('#phone_number').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var customer_id = $('#customer_id').val();
        var my_url = url + '/api/v1/customer';
        if (state == "update") {
            type = "PUT"; //for updating existing resource
            my_url += '/' + customer_id;
        }
        if (isValid) {
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    var customer = '<tr id="customer' + data.customer.id + '"><td>' + formData.first_name + '</td><td>' + formData.last_name + '</td><td>' + formData.date_of_birth + '</td><td>' + formData.email + '</td><td>' + formData.bank_account_number + '</td><td>' + formData.phone_number + '</td>';
                    customer += '<td><button class="btn btn-warning btn-detail open_modal" value="' + data.customer.id + '">Edit</button>';
                    customer += ' <button class="btn btn-danger btn-delete delete-customer" value="' + data.customer.id + '">Delete</button></td></tr>';
                    if (state == "add") { //if user added a new record
                        $('#customers-list').append(customer);
                    } else { //if user updated an existing record
                        $("#customer" + data.customer.id).replaceWith(customer);
                    }
                    $('#frmCustomers').trigger("reset");
                    $('#myModal').modal('hide')
                },
                error: function (xhr, textStatus, errorThrown) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '<ul>';
                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += '<li>' + errors[key][0] + '</li>';
                            }
                        }
                        errorMessage += '</ul>';
                        $('#errors').html(errorMessage);
                        $('#myModal').modal('show');
                    } else {
                        // Display a generic error message to the user or take appropriate action
                    }
                }
            });
        }
    });


    //delete customer and remove it from TABLE list ***************************
    $(document).on('click', '.delete-customer', function () {
        var customer_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            type: "DELETE",
            url: url + '/api/v1/customer/' + customer_id,
            success: function (data) {
                $("#customer" + customer_id).remove();
            },
            error: function (data) {
                //
            }
        });
    });

});
