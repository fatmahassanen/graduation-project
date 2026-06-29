<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ExternalProtocol;
use App\Support\ImageProcessor;
use Illuminate\Http\Request;

class ExternalProtocolsController extends Controller
{
    public function index()
    {
        $protocols = ExternalProtocol::orderBy('year', 'desc')
            ->orderBy('order')
            ->get();

        return view('admin.external-protocols.index', compact('protocols'));
    }

    public function create()
    {
        $years = range(date('Y') + 5, 2020);

        return view('admin.external-protocols.create', compact('years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|integer|min:2020|max:2050',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $protocol = new ExternalProtocol;
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

        return redirect()->route('admin.external-protocols.index')->with('success', 'Protocol created successfully!');
    }

    public function edit(ExternalProtocol $externalProtocol)
    {
        $years = range(date('Y') + 5, 2020);

        return view('admin.external-protocols.edit', compact('externalProtocol', 'years'));
    }

    public function update(Request $request, ExternalProtocol $externalProtocol)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'organization_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'year' => 'required|integer|min:2020|max:2050',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $externalProtocol->image = ImageProcessor::storeUploadedImage(
                $request->file('image'),
                $request->boolean('image_cropped'),
                400,
                $externalProtocol->image
            );
        }

        $externalProtocol->title = $request->title;
        $externalProtocol->description = $request->description;
        $externalProtocol->organization_name = $request->organization_name;
        $externalProtocol->year = $request->year;
        $externalProtocol->is_active = $request->has('is_active');
        $externalProtocol->order = $request->order ?? $externalProtocol->order;
        $externalProtocol->save();

        return redirect()->route('admin.external-protocols.index')->with('success', 'Protocol updated successfully!');
    }

    public function destroy(ExternalProtocol $externalProtocol)
    {
        ImageProcessor::deleteStoredImage($externalProtocol->image);

        $externalProtocol->delete();

        return redirect()->route('admin.external-protocols.index')->with('success', 'Protocol deleted successfully!');
    }
}
