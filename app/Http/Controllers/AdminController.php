<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Helpers\TypeHelper;

class AdminController extends Controller
{
    // Display the admin dashboard
    public function dashboard()
    {
        $allTicketsForType = [];
        
        foreach (TypeHelper::getAllTypes() as $type) {
            $all = Ticket::on($type)->get();
            
            $varName = $type . '_tickets';
            $allTicketsForType[$varName] = $all;
        }
        $columns = (new Ticket)->getFillable();
        // dd($ticketCounts);
        return view('admin.dashboard', ['all_tickets' => $allTicketsForType, 'columns' => $columns]);
    }

    public function viewTicket($type, $id)
    {
        $ticket = null;
        $database = TypeHelper::getDatabaseForType($type);
        $ticket = Ticket::on($database)->find($id);
        
        if (!$ticket) {
            return redirect()->route('admin.dashboard')->with('error', 'Ticket not found.');
        }
        
        return view('admin.view_ticket', ['ticket' => $ticket]);
    }

    public function updateTicketNotes(Request $request, $type, $id)
    {
        $database = TypeHelper::getDatabaseForType($type);
        $ticket = Ticket::on($database)->find($id);
        
        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found.'
            ], 404);
        }
        
        $validatedData = $request->validate([
            'notes' => 'nullable|string',
        ]);
        
        $ticket->notes = $validatedData['notes'];
        $ticket->status = 'noted';
        $ticket->updated_at = now();
        $ticket->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Ticket notes updated successfully.'
        ]);
    }
    
    // Authenticate admin user
    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        
        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Authentication successful!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'The provided credentials do not match our records.'
        ], 401);
    }
    
    // Logout admin user
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
