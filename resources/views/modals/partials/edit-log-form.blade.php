<div class="modal-header">
	<h5 class="modal-title">Edit Log</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
	</div>
<div class="modal-body">
    <form method="post" id="editLog" action="{{route('logUpdate', $log->id)}}" class="form">
        @csrf
    	<div class="form-group">
		    <label for="logDate">Date</label>
		    <input type="text" class="form-control" value="{{$log->date->format('m-d-y')}}" id="logDate" name="date" readonly="readonly">
		</div>

		@if(Auth::check())
    	<div class="form-group">
		    <label for="logSLP">SLP</label>
		    <input type="number" class="form-control" value="{{$log->slp}}" id="logSLP" name="slp">
		</div>
		@endif
    	<div class="form-group">
		    <label for="logScholar">Scholar Input</label>
		    <input type="text" class="form-control" value="{{$log->slp_scholar}}" id="logScholar" name="slp_scholar">
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary rounded-3" form="editLog">Save</button>
</div>