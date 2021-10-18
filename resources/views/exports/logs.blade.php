<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Code</th>
            <th>SLP</th>
        </tr>
    </thead>
    <tbody>
    @foreach($logs as $log)
        <tr>
            <td>{{ $log->date->format('Y-m-d') }}</td>
            <td>{{ $log->account->code }}</td>
            <td>{{ $log->slp }}</td>
        </tr>
    @endforeach
    </tbody>
</table>