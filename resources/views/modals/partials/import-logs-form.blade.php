<div class="modal-header">
	<h5 class="modal-title">Import Account Logs</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      	<span aria-hidden="true">&times;</span>
    </button>
	</div>
<div class="modal-body">
    <form method="post" id="importLogs" action="{{route('logsImport')}}" class="form" enctype="multipart/form-data">
        @csrf
		<input type="file" name="import_file" required="required" />
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary rounded-3" form="importLogs">Import</button>
</div>