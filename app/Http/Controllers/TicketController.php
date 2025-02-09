<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Attachment;
use App\Models\TicketReply;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAssignedTickets()
    {
        $officeHead = Auth::user(); // Assuming the authenticated user is the Office Head
        $assignedTickets = Ticket::where('assigned_to', $officeHead->id)->get();

        return view('show-assigned-tickets', compact('assignedTickets'));
    }

    public function getTicketCount()
    {
        $ticketCount = Ticket::count();
        return view('tickets', compact('ticketCount'));
    }
    
    public function viewMethod()
    {
        $getTicketCount = $this->getTicketCount();
        return view('tickets', compact('getTicketCount'));
    }

    public function index()
    {
        // $categories = Ticket::all();
        // return view('add-ticket', compact('categories'));

        // $tickets = Ticket::all();
        // return view('tickets', compact('tickets'));
        $dumps =  Ticket::with('user')
        ->get()
        ->sortByDesc('updated_at');

        $tickets = Ticket::with('user')
        ->whereIn('status', ['open', 'sent'])
        ->get()
        ->sortByDesc('updated_at');
        
        $assignedTickets = Ticket::with('user')
        ->where('status', 'open')
        ->get()
        ->sortByDesc('updated_at');

        $unreadTickets = Ticket::with('user')
        ->where('status', 'sent')
        ->get()
        ->sortByDesc('created_at');

        $closedTickets = Ticket::with('user')
        ->where('status', 'closed')
        ->get()
        ->sortByDesc('updated_at');

        $dumpsCount = Ticket::all()->count();
        $unreadTicketsCount = Ticket::where('status', 'sent')->count();
        $closedTicketsCount = Ticket::where('status', 'closed')->count();
        $assignedTicketsCount = Ticket::where('status', 'open')->count();
        $allTickets = Ticket::whereIn('status', ['open', 'sent'])->count();
    
    return view('tickets', compact('dumps', 'tickets', 'assignedTickets', 'closedTickets', 'unreadTickets', 'dumpsCount', 'unreadTicketsCount', 'closedTicketsCount', 'assignedTicketsCount', 'allTickets'));
    }

    public function userIndex() 
    {
        $tickets = Ticket::where('id', Auth::id())->get()->sortByDesc('created_at');

        $sentTickets = Ticket::with('user')
        ->where('status', 'open')
        ->get()
        ->sortByDesc('updated_at');

        $closedTickets = Ticket::with('user')
        ->where('status', 'closed')
        ->get()
        ->sortByDesc('updated_at');

        $sentTicketsCount = Ticket::where('status', 'sent')->count();
        $closedTicketsCount = Ticket::where('status', 'closed')->count();
        $allTicketsCount = Ticket::all()->count();

        return view('my-tickets', compact('tickets', 'sentTickets', 'closedTickets', 'sentTicketsCount', 'closedTicketsCount', 'allTicketsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add-ticket');
    }

    public function addUser() {
        return view('add-user');
    }

    public function addUserForm(Request $request)
    {
        dd($request->all());
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,office,student',
        ]);

        // Create a new ticket
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        // Redirect back with a success message
        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $uploadsDirectory = 'images/uploads/';
        $request->validate([
            'attachments' => 'nullable|array',
            'attachments.*' => 'image|mimes:png,jpg,jpeg|max:10240',
        ]);
    
        $ticket = new Ticket();
        $ticket->subject = $request->subject;
        $ticket->category = $request->category;
        $ticket->content = $request->content;
        $ticket->level = $request->level;
        $ticket->sender_id = Auth::id();
        $ticket->save();
    
        // Store the file(s) in the project
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                
                // Move the file to the uploads directory
                $path = $file->move($uploadsDirectory, $fileName);
        
                // Save attachment details in the Attachment model
                Attachment::create([
                    'sender_id' => Auth::id(),
                    'ticket_id' => $ticket->id,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'file_location' => $uploadsDirectory . $fileName, // Use the moved path directly
                ]);
            }
        }
        
    
        return redirect()->back();
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('attachments');
        return view('show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delete = Ticket::find($id);
        $delete->status = 'closed';
        $delete->save();

        return back()->with('success', 'Ticket has been CLOSED.');
    }

    public function unread(Request $request, string $id)
    {
        $unread = Ticket::find($id);
        $unread->status = 'sent';
        $unread->assigned_to = null;
        $unread->save();

        return back()->with('success', 'Ticket has been marked UNREAD.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }











    // public function getOfficeUsers()
    // {
    //     $officeUsers = User::whereHasRole('Office')->get();

    //     // You can now use $officeUsers as needed
    //     return view('show', compact('show'));
    // }

    public function showAssignForm(Ticket $ticket)
    {
        $users = User::where('role', 'Office')->get();
    
        return view('assign-ticket', compact('ticket', 'users'));
    }

    public function assignTicket(Request $request, Ticket $ticket)
    {
        $ticket->assigned_to = $request->assigned_to;
        $ticket->status = "open";
        $ticket->save();
        
        session()->flash('message', 'The ticket has been assigned to '. $ticket->user->name .'.');

        return redirect()->back()->with('success', 'Ticket assigned successfully.');

    }

    public function fetchReplies($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        return view('_replies', compact('ticket'));
    }
    
    public function submitReply(Request $request, Ticket $ticket)
    {
        $uploadsDirectory = 'images/uploads/';

        $validatedData = $request->validate([
            'content' => 'required',
            'attachment' => 'nullable|file|max:10240',
        ]);
    
        $reply = new TicketReply([
            'ticket_id' => $ticket->id,
            'content' => $validatedData['content'],
            'assigned_to_id' => $ticket->assigned_to,
            'sender_id' => auth()->id(),
        ]);
    
        $reply->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = $file->getClientOriginalName();
                
                // Move the file to the uploads directory
                $path = $file->move($uploadsDirectory, $fileName);
        
                // Save attachment details in the Attachment model
                Attachment::create([
                    'sender_id' => Auth::id(),
                    'ticket_reply_id' => $reply->id,
                    'file_name' => $fileName,
                    'file_location' => $uploadsDirectory . $fileName, // Use the moved path directly
                ]);
            }
        }
    
        return response()->json(['message' => 'Reply submitted successfully']);
    }

    public function fetchUpdates($ticketId) 
    {
        $ticket = Ticket::findOrFail($ticketId);
        return view('_updates', compact('ticket'));

    }
    
}
