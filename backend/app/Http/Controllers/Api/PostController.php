<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'voice_text' => 'required|string',
            'thumbnail' => 'required|image',
            'voice' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav',
            'bgm' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav',
            'commenting_status' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user;

        $audiosPath = storage_path('app/audios');
        $videosPath = storage_path('app/videos');

        if (!File::exists($audiosPath)) {
            File::makeDirectory($audiosPath, 0755, true);
        }
        if (!File::exists($videosPath)) {
            File::makeDirectory($videosPath, 0755, true);
        }

        $thumbnailPath = storage_path("app/") . $request->file('thumbnail')->store('thumbnails');
        $thumbnailFileName = basename($thumbnailPath);

        $voicePath = storage_path("app/") . $request->file('voice')->store('voices');
        $voiceFileName = basename($voicePath);

        $bgmPath = storage_path("app/") . $request->file('bgm')->store('bgms');
        $bgmFileName = basename($bgmPath);

        $ffmpegPath = "C:\\ffmpeg\\bin\\ffmpeg.EXE";

        $tempAudioPath = storage_path("app/") . 'audios/' . uniqid() . '.mp3';
        $command = "$ffmpegPath -i $bgmPath -i $voicePath -filter_complex amix=inputs=2:duration=longest $tempAudioPath";
        exec($command);

        $outputVideoPath = storage_path("app/") . 'videos/' . uniqid() . '.mp4';
        $outputVideoFileName = basename($outputVideoPath);
        $command = "$ffmpegPath -loop 1 -i $thumbnailPath -i $tempAudioPath -c:v libx264 -tune stillimage -c:a aac -b:a 192k -vf \"scale='iw-mod(iw,2)':'ih-mod(ih,2)',format=yuv420p\" -shortest -movflags +faststart $outputVideoPath";
        exec($command);

        unlink($tempAudioPath);

        $post = new Post();

        $post->title = $request->title;
        $post->thumbnail = $thumbnailFileName;
        $post->voice_text = $request->voice_text;
        $post->voice = $voiceFileName;
        $post->video = $outputVideoFileName;
        $post->bgm = $bgmFileName;
        $post->commenting_status = $request->commenting_status;
        $post->category_id = $request->category_id;
        $post->user_id = $user->id;
        $post->save();

        return response()->json(['message' => '投稿は正常に作成されました。', 'status' => 201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $post_id = $request->id;
        $post = Post::with(['comments.user', 'comments.replies.user'])->findOrFail($post_id);

        $formattedPost = $this->formatPost($post);

        return response()->json(['data' => $formattedPost, 'status' => 201]);
    }

    private function formatPost($post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'thumbnail' => $post->thumbnail,
            'commenting_status' => $post->commenting_status,
            'bgm' => $post->bgm,
            'voice' => $post->voice,
            'voice_text' => $post->voice_text,
            'video' => $post->video,
            'category_id' => $post->category_id,
            'user_id' => $post->user_id,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'comments' => $this->formatComments($post->comments),
        ];
    }

    private function formatComments($comments)
    {
        $formattedComments = [];

        foreach ($comments as $comment) {
            $formattedComments[] = $this->formatComment($comment);
        }

        return $formattedComments;
    }

    private function formatComment($comment)
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'parent_post_id' => $comment->parent_post_id,
            'parent_comment_id' => $comment->parent_comment_id,
            'user' => $comment->user,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at,
            'replies' => $this->formatComments($comment->replies),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function search(Request $request)
    {
        $userId = $request->user_id;
        $categoryId = $request->category_id;
        $q = $request->q;

        $query = Post::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($q) {
            $query->where(function ($innerQuery) use ($q) {
                $innerQuery->where('title', 'like', "%$q%")
                            ->orWhere('voice_text', 'like', "%$q%");
            });
        }

        $query->with(['user', 'category']);

        $posts = $query->get();

        return response()->json(['posts' => $posts, 'status' => '201']);
    }
}
