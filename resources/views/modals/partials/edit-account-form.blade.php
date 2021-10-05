<div class="modal-header">
	<h5 class="modal-title">Edit Account</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
	</div>
<div class="modal-body">
    <form method="post" id="createAccount" action="{{route('accountUpdate', $account->id)}}" class="form">
        @csrf
		<h5>Account Details</h5>

    	<div class="form-group">
		    <label for="accountName">Account Name (*)</label>
		    <input type="text" class="form-control" value="{{$account->name}}" id="accountName" name="name" required="required">
		    <small id="roninHelp" class="form-text text-muted">xx001 - FirstLast</small>
		</div>
    	<div class="form-group">
		    <label for="accountName">Account Code (*)</label>
		    <input type="text" class="form-control" id="accountName" name="code" value="{{$account->code}}" required="required">
		</div>
    	<div class="form-group">
		    <label for="roninAddress">Ronin address (*)</label>
		    <input type="text" name="ronin_address" value="{{$account->ronin_address}}" class="form-control" id="roninAddress" aria-describedby="roninHelp" required="required">
		    <small id="roninHelp" class="form-text text-muted">Public Ronin address with the ronin: prefix</small>
		</div>
    	<div class="form-group">
		    <label for="managerSplit">Manager percentage (*)</label>
		    <input type="number" name="split" value="{{$account->split}}" class="form-control w-25" id="managerSplit" min="0" max="100" step="1" required="required">
		</div>
    	<div class="form-group">
		    <label for="roninAddress">Tags</label>

		    @foreach(App\ScholarTag::orderBy('tag')->get() as $tag)
		    <div class="form-check">
				<input class="form-check-input" name="tags[]" type="checkbox" value="{{$tag->tag}}" id="tag-{{$tag->tag}}" {!! in_array($tag->tag, $account->tags) ? "checked='checked'" : "" !!}>
				<label class="form-check-label text-capitalize" for="tag-{{$tag->tag}}">
				    {{$tag->tag}}
				</label>
			</div>
			@endforeach
		</div>
    	<div class="form-group">
		    <label for="notes">Notes</label>
		    <textarea name="notes" id="notes" rows="5" class="form-control">{{$account->notes}}</textarea>
		</div>

		<hr />

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
		    <input type="text" name="payment_method" value="{{@$account->scholar->payment_method}}" class="form-control" id="paymentMethod" aria-describedby="paymentHelp">
		    <small id="paymentHelp" class="form-text text-muted">List here or dropdown</small>
		</div>
    	<div class="form-group">
		    <label for="accountName">Account Name</label>
		    <input type="text" name="payment_account" value="{{@$account->scholar->payment_account}}" class="form-control" id="accountName">
		</div>
    	<div class="form-group">
		    <label for="accountNumber">Account Number</label>
		    <input type="text" name="payment_account_number" value="{{@$account->scholar->payment_account_number}}" class="form-control" id="accountNumber">
		</div>
    	<div class="form-group">
		    <label for="mobileNumber">Mobile Number</label>
		    <input type="text" name="mobile" value="{{@$account->scholar->mobile}}" class="form-control" id="mobileNumber">
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
    <button type="submit" class="btn btn-primary rounded-3" form="createAccount">Save</button>
</div>