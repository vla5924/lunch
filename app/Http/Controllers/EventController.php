<?php

namespace App\Http\Controllers;

use App\Helpers\CommentHelper;
use App\Helpers\DeleteHelper;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    const PER_PAGE = 20;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->requirePermission('view events');

        $events = Event::query()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('day', 'desc')
            ->orderBy('name', 'asc')
            ->paginate(self::PER_PAGE);

        return view('pages.events.index', [
            'events' => $events,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->requirePermission('create events');

        return view('pages.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->requirePermission('create events');
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'day' => 'required|integer|between:1,31',
            'month' => 'required|integer|between:1,12',
            'year' => 'nullable|integer|min:0',
            'annual' => 'sometimes|accepted',
        ]);

        $event = new Event;
        $event->name = $request->name;
        $event->description = $request->get('description');
        $event->day = $request->day;
        $event->month = $request->month;
        $event->year = $request->year;
        $event->annual = ($request->annual === "on");
        $this->setUserId($event);
        $event->save();

        return redirect()->route('events.show', $event->id)->with('success', __('events.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->requirePermission('view events');

        return view('pages.events.show', [
            'event' => $event,
            'comments' => $event->comments()->paginate(CommentHelper::PER_PAGE),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->requirePermission('edit events');

        return view('pages.events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->requirePermission('edit events');
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'day' => 'required|integer|between:1,31',
            'month' => 'required|integer|between:1,12',
            'year' => 'nullable|integer|min:0',
            'annual' => 'sometimes|accepted',
        ]);

        $event->name = $request->name;
        $event->description = $request->get('description');
        $event->day = $request->day;
        $event->month = $request->month;
        $event->year = $request->year;
        $event->annual = ($request->annual === "on");
        $this->setUserId($event);
        $event->save();

        return redirect()->route('events.show', $event->id)->with('success', __('events.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->requirePermission('delete events');

        DeleteHelper::deleteEvent($event);

        return redirect()->route('events.index')->with('success', __('events.deleted_successfully'));
    }
}
