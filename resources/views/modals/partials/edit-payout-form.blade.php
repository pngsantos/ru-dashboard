<div class="modal-header">
	<h5 class="modal-title">Edit Payout</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
	</div>
<div class="modal-body">
    <form method="post" id="updatePayout" action="{{route('updatePayout', $payout->id)}}" class="form">
        @csrf
        <div class="form-group">
            <label for="accountName">Payout Start</label>
            <input type="date" class="form-control" name="from_date" value="{{$payout->from_date->format('Y-m-d')}}" />
        </div>

        <div class="form-group">
            <label for="accountName">Next Payout</label>
            <input type="date" class="form-control" name="to_date" value="{{$payout->to_date->format('Y-m-d')}}" />
        </div>
		<div class="form-group">
		    <label for="payoutSplit">Split</label>
		    <input type="number" class="form-control" id="payoutSplit" name="split" value="{{$payout->split}}">
		</div>
		<div class="form-group">
		    <label for="initBalance">Initial Balance</label>
		    <input type="number" class="form-control" id="initBalance" name="balance" value="{{$payout->balance}}">
		</div>

		<div class="form-group">
		    <label for="payoutBonus">Bonus</label>
		    <input type="number" class="form-control" id="payoutBonus" name="bonus" value="{{$payout->bonus}}">
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary rounded-3" form="updatePayout">Save</button>
</div>