<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Support Ticket System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/admin.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" />
  

</head>

<body>
    <div class="container">
        <header>
            <h2>Support Ticket System</h2>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </header>
        <main>
            <div class="dashboard-welcome">
                <h1>Admin Dashboard</h1>
            </div>
                <table id="myTable" class="display">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                        @if($column == 'notes') @continue @endif
                            <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_tickets as $ticketType)
                        @foreach ($ticketType as $ticket)
                            <tr>
                                @foreach ($columns as $column)
                                @if($column == 'notes') @continue @endif
                                @if ($column == 'attachments' && $ticket->attachments)
                                    <td>
                                        @foreach ($ticket->attachments as $attachment)
                                            <a href="{{ asset('storage/attachments/' . $attachment) }}" target="_blank"  style="display: inline-flex; align-items: center; gap: 0.5rem; color: #4a5568; text-decoration: none; transition: color 0.2s ease;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>{{ basename($attachment) }}</a><br>
                                        @endforeach
                                    </td>
                                    @continue
                                @endif
                                    <td>{{ $ticket->$column }}</td>
                                @endforeach
                                <td>
                                    <a href="/view-ticket/{{ $ticket->type }}/{{ $ticket->id }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #4a5568; text-decoration: none; transition: color 0.2s ease;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <script>
        $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>
</body>

</html>