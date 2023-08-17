<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;
use Facades\App\Services\BasicService;


class TicketController extends Controller
{
    use Upload, Notify;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function tickets(string $type = null, Request $request)
    {

        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $title = 'Tickets List';

        if (isset($type) && BasicService::validateKeyword($type, 'open') == 1) {
            $title = 'Open Tickets';
            $type = 0;
        } elseif (isset($type) && BasicService::validateKeyword($type, 'answered') == 1) {
            $title = 'Answered Tickets';
            $type = 1;
        } elseif (isset($type) && BasicService::validateKeyword($type, 'replied') == 1) {
            $title = 'Replied Tickets';
            $type = 2;
        } elseif (isset($type) && BasicService::validateKeyword($type, 'closed') == 1) {
            $title = 'Closed Tickets';
            $type = 3;
        }

        $tickets = Ticket::when(isset($search['ticket']), function ($query) use ($search) {
            return $query->where('ticket', 'LIKE', "%{$search['ticket']}%");
        })
            ->when(isset($search['email']), function ($query) use ($search) {
                return $query->where('email', 'LIKE', "%{$search['email']}%");
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })->with('user')
            ->when(isset($type), function ($query) use ($type) {
                return $query->where('status', $type);
            })
            ->latest()
            ->paginate(config('basic.paginate'));
        $empty_message = 'No Data found.';



        return view('admin.ticket.index', compact('tickets', 'title', 'empty_message'));
    }


    public function ticketReply($id)
    {
        $ticket = Ticket::where('id', $id)->with('user', 'messages')->firstOrFail();
        $title = 'Ticket #' . $ticket->ticket;
        return view('admin.ticket.show', compact('ticket', 'title'));
    }

    public function ticketReplySend(Request $request, $id)
    {
        $ticket = Ticket::where('id', $id)->with('user')->firstOrFail();
        $message = new TicketMessage();
        if ($request->replayTicket == 1) {

            $req = Purify::clean($request->except('_token', '_method'));

            $imgs = $request->file('attachments');
            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

            $request->validate([
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                        foreach ($imgs as $img) {
                            $ext = strtolower($img->getClientOriginalExtension());
                            if (($img->getSize() / 1000000) > 2) {
                                return $fail("Images MAX  2MB ALLOW!");
                            }

                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg, pdf images are allowed");
                            }
                        }
                        if (count($imgs) > 5) {
                            return $fail("Maximum 5 images can be uploaded");
                        }
                    }
                ],
                'message' => 'required',
            ]);


            $ticket->status = 1;
            $ticket->last_reply = Carbon::now();
            $ticket->save();

            $message->ticket_id = $ticket->id;
            $message->admin_id = $this->user->id;
            $message->message = $req['message'];
            $message->save();

            $path = config('location.ticket.path');
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $image) {
                    try {
                        TicketAttachment::create([
                            'ticket_message_id' => $message->id,
                            'image' => $this->uploadImage($image, $path),
                        ]);
                    } catch (\Exception $exp) {
                        return back()->with('error', 'Could not upload your ' . $image)->withInput();
                    }
                }
            }



            $msg = [
                'ticket_id' => $ticket->ticket
            ];
            $action = [
                "link" => route('user.ticket.view', $ticket->ticket),
                "icon" => "fas fa-ticket-alt text-white"
            ];

            $this->userPushNotification($ticket->user, 'ADMIN_REPLIED_TICKET', $msg, $action);


            $this->sendMailSms($ticket->user, 'ADMIN_SUPPORT_REPLY', [
                'ticket_id' => $ticket->ticket,
                'ticket_subject' => $ticket->subject,
                'reply' => $request->message,
            ]);


            return back()->with('success', "Ticket has been replied");
        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->save();
        }

        return back()->with('success', "Ticket has been closed");
    }


    public function ticketDownload($ticket_id)
    {
        $attachment = TicketAttachment::with('supportMessage', 'supportMessage.ticket')->findOrFail(decrypt($ticket_id));
        $file = $attachment->image;
        $path = config('location.ticket.path');
        $full_path = $path . '/' . $file;
        $title = slug($attachment->supportMessage->ticket->subject) . '-' . $file;
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

    public function ticketDelete(Request $request)
    {
        $message = TicketMessage::findOrFail($request->message_id);
        $path = config('location.ticket.path');
        if (count($message->attachments) > 0) {
            foreach ($message->attachments as $img) {
                @unlink($path . '/' . $img->image);
                $img->delete();
            }
        }
        $message->delete();
        return back()->with('success', "Message has been deleted");
    }
}
