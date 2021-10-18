<div class="modal fade" id="export-log-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Account Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            <div class="modal-body">
                <form method="post" id="importLogs" action="{{route('logsExport')}}" class="form">
                    @csrf

                    <div class="form-group">
                        <label for="accountName">From</label>
                        <input type="date" class="form-control" name="start_date" value="{{\Carbon\Carbon::now()->subDays(14)->format('Y-m-d')}}" />
                    </div>

                    <div class="form-group">
                        <label for="accountName">To</label>
                        <input type="date" class="form-control" name="end_date" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary rounded-3" form="importLogs">Export</button>
            </div>
    	</div>
	</div>
</div>