<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();

        return view('admin.events.index', compact('events'));
    }

    // فتح صفحة الفورمة للإضافة
    public function create()
    {
        return view('admin.events.create');
    }

    // حفظ البيانات الجديدة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'required|string|max:500',
        ]);

        $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('uploads'), $filename);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => 'uploads/' . $filename,
            'link' => $request->link,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event added successfully!');
    }

    // فتح صفحة التعديل
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // حفظ التعديلات
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'required|string|max:500',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
        ];

        if ($request->hasFile('image')) {
            // مسح الصورة القديمة
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }
            
            $filename = time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads'), $filename);
            $data['image'] = 'uploads/' . $filename;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    // مسح ايفينت
    public function destroy(Event $event)
    {
        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted!');
    }
}
