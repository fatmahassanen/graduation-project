<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\InternalProtocol;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

class InternalProtocolsController extends Controller
{
    public function index()
    {
        $protocols = InternalProtocol::orderBy('year', 'desc')
            ->orderBy('order')
            ->get();

        return view('admin.internal-protocols.index', compact('protocols'));
    }

    public function create()
    {
        $years = range(date('Y') + 5, 2019);

        return view('admin.internal-protocols.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|integer|min:2019|max:2050',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $protocol = new InternalProtocol;
        $protocol->title = $request->title;
        $protocol->description = $request->description;
        $protocol->organization_name = $request->organization_name;
        $protocol->year = $request->year;
        $protocol->is_active = $request->has('is_active');
        $protocol->order = $request->order ?? 0;

        if ($request->hasFile('image')) {
            $protocol->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped')
            );
        }

        $protocol->save();

        return redirect()->route('admin.internal-protocols.index')->with('success', 'Protocol created successfully!');
    }

    public function edit(InternalProtocol $internalProtocol)
    {
        $years = range(date('Y') + 5, 2020);

        return view('admin.internal-protocols.edit', compact('internalProtocol', 'years'));
    }

    public function update(Request $request, InternalProtocol $internalProtocol)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|integer|min:2019|max:2050',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $internalProtocol->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $internalProtocol->image
            );
        }

        $internalProtocol->title = $request->title;
        $internalProtocol->description = $request->description;
        $internalProtocol->organization_name = $request->organization_name;
        $internalProtocol->year = $request->year;
        $internalProtocol->is_active = $request->has('is_active');
        $internalProtocol->order = $request->order ?? $internalProtocol->order;
        $internalProtocol->save();

        return redirect()->route('admin.internal-protocols.index')->with('success', 'Protocol updated successfully!');
    }

    public function destroy(InternalProtocol $internalProtocol)
    {
        ImageProcessor::deleteStoredImage($internalProtocol->image);

        $internalProtocol->delete();

        return redirect()->route('admin.internal-protocols.index')->with('success', 'Protocol deleted successfully!');
    }
}
