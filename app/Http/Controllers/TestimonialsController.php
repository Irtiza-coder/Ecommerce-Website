<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testmonials;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class TestimonialsController extends Controller
{
    public function index()
    {
        $testimonials = Testmonials::latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }
    public function create(){
        return view('admin.testimonials.create');
    }
    public function store(Request $request){
        $data= $request->validate([
            'name'   => 'required|string|max:255',
            'role'   => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data ['image']  = $request->file('image')->store('Testimonials','public');   
        }
        Testmonials::create($data);
        return redirect()->route('admin.testimonials.index')->with('message','Testimonials added successfully');
    }   
    public function edit(Testmonials $testimonial){
        return view('admin.testimonials.edit' , compact('testimonial'));
    }
    public function update(Request $request, Testmonials $testimonial){
        $data= $request->validate([
            'name'   => 'required|string|max:255',
            'role'   => 'nullable|string|max:255',
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'nullable|boolean',
        ]);
        $data['status'] = $request->has('status') ? 1 : 0;
        if($request->hasFile('image')){
            if ($testimonial->image && Storage::disk('public')->exists('$testimonial->image ')){
                Storage::disk('public')->delete($testimonial->image);
            }
            $data['image'] = $request->file('image')->store('Testimonials','public');
        }
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('message', 'Testimonial updated successfully!');
    }
    public function destroy (Testmonials $testimonial){
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)){
            Storage::disk('public')->delete($testimonial->image);
        }
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('message', 'Testimonial deleted successfully!');
    }
}