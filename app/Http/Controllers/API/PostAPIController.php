<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\Post;
use Validator;


class PostAPIController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse($posts->toArray(), 'Posts retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $post = Post::create($input);


        return $this->sendResponse($post->toArray(), 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);


        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }


        return $this->sendResponse($post->toArray(), 'Post retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }


        $post = Post::find($id);
        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }


        $post->name = $input['name'];
        $post->description = $input['description'];
        $post->save();


        return $this->sendResponse($post->toArray(), 'Post updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);


        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }


        $post->delete();


        return $this->sendResponse($id, 'Tag deleted successfully.');
    }
}
