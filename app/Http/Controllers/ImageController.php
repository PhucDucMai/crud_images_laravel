<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::latest()->paginate(5);
        return view('images.index', compact('images'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('images.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        Image::create($input);
        return redirect()->route('images.index')->with('success', 'Image created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        return view('images.edit',  compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required'
        ]);

        // Fetch the Image instance to update
        $image = Image::findOrFail($id);

        $input = $request->all();
        if ($request->hasFile('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($destinationPath, $profileImage);
            $input['image'] = $profileImage;
        } else {
            unset($input['image']);
        }

        // Update the attributes of the Image instance
        $image->update([
            'name' => $input['name'],
            'detail' => $input['detail'],
            'image' => $input['image'],
        ]);

        return redirect()->route('images.index')->with('success', 'Image updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
