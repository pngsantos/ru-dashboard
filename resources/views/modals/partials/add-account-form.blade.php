<div class="modal-header">
	<h5 class="modal-title">Add New Account</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form method="post" id="createAccount" action="{{route('accountStore')}}" class="form" onsubmit="return validateAccountForm()">
        @csrf
		<h5>Account Details</h5>

    	<div class="form-group">
		    <label for="accountName">Account Name (*)</label>
		    <input type="text" class="form-control" id="accountName" name="name" required="required">
		    <small id="roninHelp" class="form-text text-muted">xx001 - FirstLast</small>
		</div>
    	<div class="form-group">
		    <label for="accountName">Account Code (*)</label>
		    <input type="text" class="form-control" id="accountName" name="code" required="required">
		</div>
    	<div class="form-group">
		    <label for="roninAddress">Ronin address (*)</label>
		    <input type="text" name="ronin_address" class="form-control" id="roninAddress" aria-describedby="roninHelp" required="required">
		    <small id="roninHelp" class="form-text text-muted">Public Ronin address with the ronin: prefix</small>
		</div>
    	<div class="form-group">
		    <label for="managerSplit">Manager percentage (*)</label>
		    <input type="number" name="split" class="form-control w-25" id="managerSplit" min="0" max="100" step="1" required="required">
		</div>
    	<div class="form-group">
		    <label for="roninAddress">Tags</label>

		    @foreach(App\ScholarTag::orderBy('tag')->get() as $index => $tag)
		    <div class="form-check">
				<input class="form-check-input" name="tags[]" type="checkbox" value="{{$tag->tag}}" id="tag-{{$index}}">
				<label class="form-check-label text-capitalize" for="tag-{{$index}}">
				    {{$tag->tag}}
				</label>
			</div>
			@endforeach
		</div>
    	<div class="form-group">
		    <label for="account-owner">Owner</label>
		    <input type="text" name="owner" class="form-control" id="account-owner" aria-describedby="account-owner">
		</div>
    	<div class="form-group">
		    <label for="notes">Notes</label>
		    <textarea name="notes" id="notes" rows="5" class="form-control"></textarea>
		</div>

		<hr />

		<h5>Onboarding details</h5>

		<div class="row">
			<div class="col-6">
				<div class="form-group">
				    <label for="startDate">Account Start Date</label>
				    <input type="date" class="form-control" id="startDate" name="start_date">
				</div>
			</div>
			<div class="col-6">
				<div class="form-group">
				    <label for="initBalance">Initial Balance</label>
				    <input type="number" class="form-control" id="initBalance" name="balance">
				</div>
			</div>
		</div>

		<hr />

		<h5>Scholar Details</h5>

		<div class="row">
			<div class="col-6">
				<div class="form-group">
				    <label for="scholarFname">First Name</label>
				    <input type="text" class="form-control" id="scholarFname" name="first_name">
				</div>
			</div>
			<div class="col-6">
				<div class="form-group">
				    <label for="scholarLname">Last Name</label>
				    <input type="text" class="form-control" id="scholarLname" name="last_name">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-6">
				<div class="form-group">
				    <label for="scholarStartDate">Started on</label>
				    <input type="date" class="form-control" id="scholarStartDate" name="scholar_start_date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" >
				</div>
			</div>
			<div class="col-6">
		    	<div class="form-group">
				    <label for="scholarEmail">Email</label>
				    <input type="email" class="form-control" id="scholarEmail" name="email">
				</div>
			</div>
		</div>

    	<div class="form-group">
		    <label for="paymentMethod">Payment Method</label>
		    <select name="payment_method" class="form-control" id="paymentMethod" aria-describedby="paymentHelp" onchange="toggleAccountNumber(this)" placeholder='Payment Method'>
		    	<option></option>
		    	<option value="gcash">GCash</option>
		    	<option value="ronin">Ronin</option>
		    </select>
		</div>
    	<div class="form-group">
		    <label for="accountName">Account Name</label>
		    <input type="text" name="payment_account" class="form-control" id="accountName">
		</div>
    	<div class="form-group">
		    <label for="accountNumber">Account Number</label>
		    <input type="text" name="payment_account_number" class="form-control" id="accountNumber">
		    <small style="display:none" id="accountNameHelp" class="form-text text-muted">Public Ronin address with the ronin: prefix</small>
		</div>
    	<div class="form-group">
		    <label for="mobileNumber">Mobile Number</label>
		    <input type="tel" name="mobile" class="form-control" id="mobileNumber">
		</div>
    	<div class="form-group">
		    <label for="discord">Discord</label>
		    <input type="text" name="discord" class="form-control" id="discord">
		</div>
    	<div class="form-group">
		    <label for="referrer">Referrer</label>
		    <input type="text" name="referrer" class="form-control" id="referrer">
		</div>
    	<div class="form-group">
		    <label for="address">Address</label>
		    <input type="text" name="address" class="form-control mb-2" id="address">
		    <input type="text" name="address2" class="form-control" id="address2">
		</div>

	    <div class="row">
	    	<div class="col-6">
    			<div class="form-group">
				    <label for="city">City</label>
				    <input type="text" name="city" class="form-control" id="city">
		    	</div>
	    	</div>
	    	<div class="col-6">
    			<div class="form-group">
				    <label for="province">Province</label>
				    <input type="text" name="province" class="form-control" id="province">
		    	</div>
	    	</div>
	    </div>
    	<div class="form-group">
		    <label for="zip">Zip</label>
		    <input type="number" name="zip" class="form-control w-25" id="zip">
		</div>
    	<div class="form-group">
		    <label for="scholar_notes">Scholar Notes</label>
		    <textarea name="scholar_notes" id="scholar_notes" rows="5" class="form-control"></textarea>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary rounded-3" form="createAccount">Add</button>
</div>