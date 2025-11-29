<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Helpers\TypeHelper;

class TicketController extends Controller
{
    public function submitTicket(Request $request)
    {
        $attachmentPaths = [];
        if(!empty($request->file('attachments'))) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'priority' => 'required|in:low,medium,high,urgent',
            'type' => 'required|in:technical_issues,account_billing,product_service,general_inquiry,feedback',
            'contact_method' => 'required|in:email,phone,either,none',
            'consent' => 'required|accepted',
        ]);
        
        $ticket = Ticket::on(TypeHelper::getDatabaseForType($validatedData['type']))->create([
            'subject' => $validatedData['subject'],
            'description' => $validatedData['description'],
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'priority' => $validatedData['priority'],
            'type' => $validatedData['type'],
            'contact_method' => $validatedData['contact_method'],
            'status' => 'open',
            'notes' => null,
            'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
        ]);

        if($ticket) return response()->json([
            'success' => true,
            'message' => 'Your ticket has been submitted successfully!'
        ]);

        return response()->json([
            'success' => false,
            'message' => 'There was an error submitting your ticket. Please try again.'
        ]);
    }
}