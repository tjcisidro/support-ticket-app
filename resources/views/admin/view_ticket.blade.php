<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket - Support Ticket System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/admin.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
  
</head>

<body>
    <div class="container" style="max-width:800px;">
        <header>
            <h2>Support Ticket System</h2>
        </header>

        <main>
            <div class="ticket-header">
                <div>
                    <h1>Ticket Details</h1>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="back-btn">
                    ← Back to Dashboard
                </a>
            </div>
            
            <div class="form-group">
                <label>Subject</label>
                <div class="display-field">{{ $ticket->subject }}</div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <div class="display-field display-field-large">{{ $ticket->description }}</div>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <div class="display-field">{{ $ticket->full_name }}</div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <div class="display-field">{{ $ticket->email }}</div>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <div class="display-field">{{ $ticket->phone }}</div>
            </div>

            <div class="form-group">
                <label>Priority Level</label>
                <div class="display-field">
                    <span class="priority-badge priority-{{ $ticket->priority }}">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Ticket Type</label>
                <div class="display-field">{{ ucfirst(str_replace('_', ' ', $ticket->type)) }}</div>
            </div>

            <div class="form-group">
                <label>Status</label>
                <div class="display-field">
                    <span class="status-badge status-{{ $ticket->status }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Preferred Contact Method</label>
                <div class="display-field">{{ ucfirst($ticket->contact_method) }}</div>
            </div>

            @if($ticket->attachments && count($ticket->attachments) > 0)
            <div class="form-group">
                <label>Attachments</label>
                <div class="display-field">
                    <ul class="attachments-list">
                        @foreach($ticket->attachments as $attachment)
                        <li>
                            <a href="{{ Storage::url($attachment) }}" target="_blank" class="attachment-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                </svg>
                                {{ basename($attachment) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="form-group">
                <label>Internal Notes</label>
                <input id="notes" type="hidden" name="notes" value="{{ $ticket->notes }}">
                <trix-editor input="notes"></trix-editor>
            </div>

            <div class="form-group">
                <label>Created At</label>
                <div class="display-field">{{ $ticket->created_at->format('F j, Y, g:i a') }}</div>
            </div>

            <div class="ticket-actions">
                <button type="button" onclick="markAndRedirect()" class="btn-primary">
                    Mark as Noted and Go to Dashboard
                </button>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script>
        function updateContent(){
            const data = new FormData();
            data.append("notes", document.querySelector("input[name='notes']").value);
            $.ajax({
                url: "/update-ticket-notes/{{ $ticket->type }}/{{ $ticket->id }}",
                type: "POST",
                data: data,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        toastr["success"](
                            "Ticket notes updated successfully!",
                            "Success"
                        );
                    } else {
                        toastr["error"](
                            "Failed to update ticket notes. Please try again.",
                            "Error"
                        );
                    }
                },
                error: function (xhr) {
                    toastr["error"](
                        xhr.responseJSON?.message || "An error occurred. Please try again.",
                        "Error"
                    );
                },
            });
        }
        function markAndRedirect(){
            updateContent();
            setTimeout(function(){
                window.location.href = "{{ route('admin.dashboard') }}";
            }, 1000);
        }
        let trixDebounceTimer;
        $(document).ready(function() {
            $('trix-editor').on('trix-change', function() {
                clearTimeout(trixDebounceTimer);
                trixDebounceTimer = setTimeout(function() {
                    updateContent();
                }, 500);
            });
        });
        
    </script>
</body>
</html>
