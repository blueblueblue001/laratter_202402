<?php

namespace App\Http\Controllers;

// 🔽 追加
use App\Http\Requests\StoreTweetRequest;
// 🔽 追加
use App\Http\Requests\UpdateTweetRequest;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Auth;
// 🔽 追加
use App\Services\TweetService;


class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      // 🔽 追加
    protected $tweetService;

    // 🔽 追加
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function index()
    {
       // 🔽 追加
        $this->authorize('viewAny', Tweet::class);

        // 🔽 編集
        $tweets = $this->tweetService->allTweets();
        return view('tweets.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    // 🔽 追加
     $this->authorize('create', Tweet::class);
    // 🔽 追加
      return view('tweets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTweetRequest $request)
    {
        // 🔽 追加
         $this->authorize('create', Tweet::class);

        // 🔽 編集
        $tweet = $this->tweetService->createTweet($request->only('tweet'), $request->user());

        return redirect()->route('tweets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tweet $tweet)
    {
          // 🔽 追加
        $this->authorize('view', $tweet);

        return view('tweets.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tweet $tweet)
    {
        return view('tweets.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    // 🔽 編集
    public function update(UpdateTweetRequest $request, Tweet $tweet)
    {
        // 🔽 追加
        $this->authorize('update', $tweet);
        // 🔽 追加
        $this->authorize('update', $tweet);

        // バリデーションは削除
        $updatedTweet = $this->tweetService->updateTweet($tweet, $request->all());

        return redirect()->route('tweets.show', $tweet);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tweet $tweet)
    {
        // 🔽 追加
        $this->authorize('delete', $tweet);

        // 🔽 編集
        $this->tweetService->deleteTweet($tweet);

        return redirect()->route('tweets.index');
    }
}
