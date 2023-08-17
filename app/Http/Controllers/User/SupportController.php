<?php

namespace App\Http\Controllers\User;


use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->theme = template();
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function index()
    {

        if ($this->user->id == null) {
            abort(404);
        }
        $page_title = "Support Ticket";
        $tickets = Ticket::where('user_id', $this->user->id)->latest()->paginate(config('basic.paginate'));
        return view($this->theme.'user.support.index', compact('tickets', 'page_title'));
    }

    public function create()
    {
        $page_title = "New Ticket";
        $user = $this->user;
        return view($this->theme.'user.support.create', compact('page_title', 'user'));
    }

    public function store(Request $request)
    {

        $this->newTicketValidation($request);
        $random = rand(100000, 999999);
        $ticket = $this->saveTicket($request, $random);

        $message = $this->saveMsgTicket($request, $ticket);

        $path = config('location.ticket.path');
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    $this->saveAttachment($message, $image, $path);
                } catch (\Exception $exp) {
                    return back()->withInput()->with('error', 'Could not upload your ' . $image);
                }
            }
        }
        $msg = [
            'username' => optional($ticket->user)->username,
            'ticket_id' => $ticket->ticket
        ];
        $action = [
            "link" => route('admin.ticket.view',$ticket->id),
            "icon" => "fas fa-ticket-alt text-white"
        ];
        $this->adminPushNotification('SUPPORT_TICKET_CREATE', $msg, $action);
        return redirect()->route('user.ticket.list')->with('success', 'Your Ticket has been pending');
    }

    public function ticketView($ticketId)
    {
        $page_title = "Ticket: #".$ticketId;
        $ticket = Ticket::where('ticket', $ticketId)->latest()->with('messages')->firstOrFail();
        $user = $this->user;
        return view($this->theme.'user.support.view', compact('ticket', 'page_title', 'user'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $message = new TicketMessage();

        if ($request->replayTicket == 1) {
            $images = $request->file('attachments');
            $allowedExtensions = array('jpg', 'png', 'jpeg', 'pdf');
            $this->validate($request, [
                'attachments' => [
                    'max:4096',
                    function ($fail) use ($images, $allowedExtensions) {
                        foreach ($images as $img) {
                            $ext = strtolower($img->getClientOriginalExtension());
                            if (($img->getSize() / 1000000) > 2) {
                                return $fail("Images MAX  2MB ALLOW!");
                            }
                            if (!in_array($ext, $allowedExtensions)) {
                                return $fail("Only png, jpg, jpeg, pdf images are allowed");
                            }
                        }
                        if (count($images) > 5) {
                            return $fail("Maximum 5 images can be uploaded");
                        }
                    },
                ],
                'message' => 'required',
            ]);

            $ticket->status = 2;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->ticket_id = $ticket->id;
            $message->message = $request->message;
            $message->save();

            $path = config('location.ticket.path');
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $image) {
                    try {
                        $this->saveAttachment($message, $image, $path);
                    } catch (\Exception $exp) {
                        return back()->with('error', 'Could not upload your ' . $image)->withInput();
                    }
                }
            }
            $msg = [
                'username' => optional($ticket->user)->username,
                'ticket_id' => $ticket->ticket
            ];
            $action = [
                "link" => route('admin.ticket.view',$ticket->id),
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $this->adminPushNotification('SUPPORT_TICKET_REPLIED', $msg, $action);

            return back()->with('success', 'Ticket has been replied');
        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            return back()->with('success', 'Ticket has been closed');
        }
        return back();
    }


    public function download($ticket_id)
    {
        $attachment = TicketAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->image;
        $path = config('location.ticket.path');
        $full_path = $path . '/' . $file;

        if(file_exists($full_path)){
            $title = slug($attachment->supportMessage->ticket->subject);
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $mimetype = mime_content_type($full_path);
            header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
            header("Content-Type: " . $mimetype);
            return readfile($full_path);
        }
        abort(404);
    }


    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newTicketValidation(Request $request): void
    {
        $images = $request->file('attachments');
        $allowedExtension = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($images, $allowedExtension) {
                    foreach ($images as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExtension)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($images) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'subject' => 'required|max:100',
            'message' => 'required'
        ]);
    }

    /**
     * @param Request $request
     * @param $random
     * @return
     */
    public function saveTicket(Request $request, $random): Ticket
    {
        $ticket = new Ticket();
        $ticket->user_id = $this->user->id;
        $ticket->name = $this->user->username;
        $ticket->email = $this->user->email;
        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->status = 0;
        $ticket->last_reply = Carbon::now();
        $ticket->save();
        return $ticket;
    }

    /**
     * @param Request $request
     * @param $ticket
     * @return Models\TicketMessage
     */
    public function saveMsgTicket(Request $request, $ticket): TicketMessage
    {
        $message = new TicketMessage();
        $message->ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        return $message;
    }

    /**
     * @param $message
     * @param $image
     * @param $path
     * @throws \Exception
     */
    public function saveAttachment($message, $image, $path): void
    {
        $attachment = new TicketAttachment();
        $attachment->ticket_message_id = $message->id;
        $attachment->image = $this->uploadImage($image, $path);
        $attachment->save();
    }


}
