<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return cache()->remember('events_list', 3600, fn() => EventResource::collection(Event::with('user')->get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return $event;
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return new EventResource($event->load('user')->load('attendees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Check if the authenticated user is the owner of the event
        // if (Gate::denies('update-event', $event)) {
        //     return response()->json(['message' => 'You are not authorized to update this event.'], 403);
        // }
        // Gate::authorize('update', $event);
        // Check if the authenticated user is the owner of the event
        if ($request->user()->cannot('update', $event)) {
            return response()->json(['message' => 'You are not authorized to update this event.'], 403);
        }


        $event->update([
            ...$request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
            ]),
        ]);

        return $event;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if (request()->user()->cannot('delete', $event)) {
            return response()->json(['message' => 'You are not authorized to delete this event.'], 403);
        }

        $event->delete();

        return response('', 204);

        // return response()->json(['message' => 'Event deleted successfully.']);
    }
}
