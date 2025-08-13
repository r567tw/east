<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        if (Gate::denies('list-attendees', $event)) {
            return response()->json(['message' => 'You are not authorized to view attendees for this event.'], 403);
        }
        return AttendeeResource::collection($event->attendees()->latest()->paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

        if ($event->attendees()->where('email', $request->email)->exists()) {
            return response()->json(['message' => 'You are already registered for this event.'], 409);
        }

        $attendee = $event->attendees()->create([
            'email' => $request->email,
            'name' => $request->name,
        ]);

        return new AttendeeResource($attendee);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Attendee $attendee)
    {
        if (Gate::denies('show-attendee', [$event, $attendee])) {
            return response()->json(['message' => 'You are not authorized to view this attendee.'], 403);
        }
        return new AttendeeResource($attendee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, Attendee $attendee)
    {
        //
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
        ]);

        if ($attendee->email !== $request->email) {
            return response()->json(['message' => 'Email Not exists.'], 409);
        }

        $attendee->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Attendee Name updated successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Attendee $attendee)
    {
        if (Gate::denies('delete-attendee', [$event, $attendee])) {
            return response()->json(['message' => 'You are not authorized to delete this attendee.'], 403);
        }

        $attendee->delete();

        return response()->noContent();
    }
}
