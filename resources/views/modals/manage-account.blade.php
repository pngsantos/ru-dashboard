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
</script>
@endpush