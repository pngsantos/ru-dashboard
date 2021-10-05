<div class="modal-header">
	<h5 class="modal-title">Import New Accounts</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
	</div>
<div class="modal-body">
    <form method="post" id="importAccounts" action="{{route('accountsImport')}}" class="form" enctype="multipart/form-data">
        @csrf
		<input type="file" name="import_file" />
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary rounded-3" form="importAccounts">Import</button>
</div>