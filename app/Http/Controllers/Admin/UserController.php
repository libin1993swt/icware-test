<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;

use App\Models\Event;
use App\Models\Invitees;
use App\Models\InviteesEvents;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            return $next($request);
        });
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $events = Event::where('created_user_id',$this->userId)
                ->where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $events = Event::with('invities_events')->where('created_user_id',$this->userId)
                ->latest()->paginate($perPage);
        }
        return view('admin.users.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date_format:d-m-Y|date',
            'end_date' => 'required|date_format:d-m-Y|date'
        ]);

        $requestData = $request->all();
        $requestData['start_date'] = date('Y-m-d',strtotime($requestData['start_date']));
        $requestData['end_date'] = date('Y-m-d',strtotime($requestData['end_date']));
        $requestData['created_user_id'] = Auth::user()->id;

        Event::create($requestData);
        if(!empty($requestData['invite_user'])) {
            foreach ($requestData['invite_user'] as $key => $value) {
                if(!empty($value)) {
                    $invitee = Invitees::firstOrNew(array('email' => $value));
                    $invitee->save();

                    $inviteesEventData['event_id'] = $event->id;
                    $inviteesEventData['invitees_id'] = $invitee->id;
                    $inviteeEvent = InviteesEvents::firstOrNew(array('event_id' => $event->id, 'invitees_id' => $invitee->id));
                    $inviteeEvent->save();
                }

            }   
        }

        return redirect('users')->with('flash_message', 'Event added!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id) {
        $event = Event::with('invities_events')->findOrFail($id);
        return view('admin.users.edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id) {
        
        $requestData = $request->all();
        $request->validate([
            'name' => 'required',
            'start_date' => 'required|date_format:d-m-Y|date',
            'end_date' => 'required|date_format:d-m-Y|date'
        ]);

        $event = Event::findOrFail($id);
        $requestData['start_date'] = date('Y-m-d',strtotime($requestData['start_date']));
        $requestData['end_date'] = date('Y-m-d',strtotime($requestData['end_date']));
        $requestData['created_user_id'] = Auth::user()->id;
        $event->update($requestData);

        InviteesEvents::where('event_id', $event->id)->delete();

        if(!empty($requestData['invite_user'])) {
            foreach ($requestData['invite_user'] as $key => $value) {
                if(!empty($value)) {
                    $invitee = Invitees::firstOrNew(array('email' => $value));
                    $invitee->save();

                    $inviteesEventData['event_id'] = $event->id;
                    $inviteesEventData['invitees_id'] = $invitee->id;
                    $inviteeEvent = InviteesEvents::firstOrNew(array('event_id' => $event->id, 'invitees_id' => $invitee->id));
                    $inviteeEvent->save();
                }

            }   
        }

        return redirect('users')->with('flash_message', 'Event updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id) {
        Event::destroy($id);

        return redirect('users')->with('flash_message', 'Event deleted!');
    }
}
