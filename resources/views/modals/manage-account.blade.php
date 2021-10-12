<div class="modal fade" id="manage-account-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
        	@include('modals.partials.add-account-form')
    	</div>
	</div>
</div>

@push('added-scripts')
<script>
function validateAccountForm()
{
    let paymentMethod = $("#manage-account-modal *[name='payment_method']").val();
    let accountNumber = $("#manage-account-modal *[name='payment_account_number']").val();

    if(paymentMethod == 'ronin')
    {
        if(accountNumber.startsWith('ronin:'))
        {
            $("#manage-account-modal *[name='payment_account_number']").removeClass('is-invalid');
            return true;
        }
        else
        {
            $("#manage-account-modal *[name='payment_account_number']").addClass('is-invalid');
            return false;
        }
    }
}

function toggleAccountNumber(select)
{
    if(select.value == 'ronin')
    {
        $("#accountNameHelp").show();
    }
    else
    {
        $("#accountNameHelp").hide();
    }
}


function kickScholar(account_id)
{
    Swal.fire({
        title: "Remove scholar from this account?",
        icon: "warning",
        confirmButtonText: "Confirm",
        closeOnConfirm: false,
        reverseButtons: true,
        showCancelButton: true
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'post',
                url: "{{route('kickScholar')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    account_id : account_id
                },
                success: function (response) {
                    console.log(response);
                    document.location.reload();
                },
                error: function (data, text, error) {
                    console.log(data);
                }
            });
        }
    });
}
</script>
@endpush