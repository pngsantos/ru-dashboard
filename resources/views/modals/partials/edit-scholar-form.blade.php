<div class="modal-header">
	<h5 class="modal-title">Edit Scholar Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
	</div>
<div class="modal-body">
    <form method="post" id="updateScholar" action="{{route('scholarUpdate', $account->id)}}" class="form" onsubmit="return validateAccountForm()">
        @csrf
		<h5>Scholar Details</h5>

		<div class="row">
			<div class="col-6">
				<div class="form-group">
				    <label for="scholarFname">First Name</label>
				    <input type="text" class="form-control" id="scholarFname" name="first_name" value="{{@$account->scholar->first_name}}">
				</div>
			</div>
			<div class="col-6">
				<div class="form-group">
				    <label for="scholarLname">Last Name</label>
				    <input type="text" class="form-control" id="scholarLname" name="last_name" value="{{@$account->scholar->last_name}}">
				</div>
			</div>
		</div>

    	<div class="form-group">
		    <label for="scholarEmail">Email</label>
		    <input type="email" class="form-control" id="scholarEmail" name="email" value="{{@$account->scholar->email}}">
		</div>

    	<div class="form-group">
		    <label for="paymentMethod">Payment Method</label>
		    {!! Form::select('payment_method', ['gcash'=>'GCash', 'ronin'=>'Ronin'], @$account->scholar->payment_method,  ['class'=>'form-control', 'placeholder'=>'Payment Method',  'onchange'=>"toggleAccountNumber(this)"]) !!}
		</div>
    	<div class="form-group">
		    <label for="accountName">Account Name</label>
		    <input type="text" name="payment_account" value="{{@$account->scholar->payment_account}}" class="form-control" id="accountName">
		</div>
    	<div class="form-group">
		    <label for="accountNumber">Account Number</label>
		    <input type="text" name="payment_account_number" value="{{@$account->scholar->payment_account_number}}" class="form-control" id="accountNumber">
		    <small style="{!! @$account->scholar->payment_method == 'ronin' ? '' : 'display:none' !!}" id="accountNameHelp" class="form-text text-muted">Public Ronin address with the ronin: prefix</small>
		</div>
    	<div class="form-group">
		    <label for="mobileNumber">Mobile Number</label>
		    <input type="tel" name="mobile" value="{{@$account->scholar->mobile}}" class="form-control" id="mobileNumber">
		</div>
    	<div class="form-group">
		    <label for="discord">Discord</label>
		    <input type="text" name="discord" value="{{@$account->scholar->discord}}" class="form-control" id="discord">
		</div>
    	<div class="form-group">
		    <label for="referrer">Referrer</label>
		    <input type="text" name="referrer" value="{{@$account->scholar->referrer}}" class="form-control" id="referrer">
		</div>
    	<div class="form-group">
		    <label for="address">Address</label>
		    <textarea name="address" id="address" rows="5" class="form-control">{{@$account->scholar->address}}</textarea>
		</div>
    	<div class="form-group">
		    <label for="scholar_notes">Scholar Notes</label>
		    <textarea name="scholar_notes" id="scholar_notes" rows="5" class="form-control">{{@$account->scholar->notes}}</textarea>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary rounded-3" form="updateScholar">Save</button>
</div>