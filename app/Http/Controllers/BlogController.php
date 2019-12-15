<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Resources\BlogResource;
use App\Http\Requests\BlogRequest;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BlogResource::collection(Blog::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $blog = new Blog;
        $blog->title = $request->title;

        /**Generate Slug for the title */
        $slug = str_slug($request->title);

        /**Check for uniqueness of the slug....If Not, Append a random unique id based on the microtime */
        if (Blog::where('slug', $slug)->first()) {
            $slug = $slug . '-' . uniqid();
        }
        $blog->slug = $slug;
        $blog->body = $request->body;
        $blog->save();
        return response([
            'data' => new BlogResource($blog)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $blog->title = $request->title ?? $blog->title;

        if ($request->title) {

            /**Generate Slug for the title */
            $slug = str_slug($request->title);

            /**Check for uniqueness of the slug....If Not, Append a random unique id based on the microtime */
            if (Blog::where('slug', $slug)->first()) {
                $slug = $slug . '-' . uniqid();
            }
            $blog->slug = $slug;
        }
        $blog->body = $request->body ?? $blog->body;
        $blog->save();

        return response(['data' => new BlogResource($blog)], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}