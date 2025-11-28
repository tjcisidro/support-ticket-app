<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet"> --}}
</head>
<body>
    <div class="container">
        <header>
            <h2>Support Ticket System</h2>
        </header>

        <main>
            <h1>Submit a Support Ticket</h1>
            <p class="subtitle">Fill out the form below and we'll get back to you as soon as possible</p>
            
            <form action="/submit-ticket" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="subject">Subject <span class="required">*</span></label>
                    <input type="text" id="subject" name="subject" placeholder="Brief description of your issue" required>
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea id="description" name="description" placeholder="Please provide detailed information about your issue..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="full_name">Full Name <span class="required">*</span></label>
                    <input type="text" id="full_name" name="full_name" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input type="email" id="email" name="email" placeholder="john@example.com" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number <span class="required">*</span></label>
                    <input type="tel" id="phone" name="phone" placeholder="(+971) 12 345 6789" required>
                </div>

                <div class="form-group">
                    <label for="priority">Priority Level <span class="required">*</span></label>
                    <select id="priority" name="priority" required>
                        <option value="">Select Priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Ticket Type <span class="required">*</span></label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="technical_issues">Technical Issues</option>
                        <option value="account_billing">Account & Billing</option>
                        <option value="product_service">Product & Service</option>
                        <option value="general_inquiry">General Inquiry</option>
                        <option value="feedback">Feedback & Suggestions</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="attachments">Attachments</label>
                    <input type="file" id="attachments" name="attachments[]" multiple>
                </div>

                <div class="form-group">
                    <label for="contact_method">Preferred Contact Method <span class="required">*</span></label>
                    <select id="contact_method" name="contact_method" required>
                        <option value="">Select Method</option>
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="either">Either</option>
                        <option value="none">None</option>
                    </select>
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="consent" name="consent" required>
                    <label for="consent">I consent to the processing of my data <span class="required">*</span></label>
                </div>

                <button type="submit">Submit Ticket</button>
            </form>
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @vite(['resources/js/app.js'])
</body>
</html>
