<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Artikel;
use Illuminate\Support\Facades\Session;

class LikeController extends Controller
{
    public function index()
    {
        $liked_articles = collect();
        
        if (auth()->check()) {
            $liked_articles = Artikel::with(['kategori', 'user'])
                ->whereHas('likes', function($query) {
                    $query->where('id_user', auth()->user()->id_user);
                })
                ->where('status', 'publikasi')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Guest user - get from session
            $sessionLikes = session()->get('guest_likes', []);
            if (!empty($sessionLikes)) {
                $liked_articles = Artikel::with(['kategori', 'user'])
                    ->whereIn('id_artikel', $sessionLikes)
                    ->where('status', 'publikasi')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
        
        return view('pages.like', compact('liked_articles'));
    }
    
    public function toggle(Request $request)
    {
        $artikel_id = $request->artikel_id;
        
        if (auth()->check()) {
            // User logged in - use database
            $user_id = auth()->user()->id_user;
            
            $like = Like::where('id_artikel', $artikel_id)
                       ->where('id_user', $user_id)
                       ->first();
            
            if ($like) {
                $like->delete();
                $liked = false;
            } else {
                Like::create([
                    'id_artikel' => $artikel_id,
                    'id_user' => $user_id
                ]);
                $liked = true;
            }
        } else {
            // Guest user - use session
            $sessionLikes = session()->get('guest_likes', []);
            
            if (in_array($artikel_id, $sessionLikes)) {
                $sessionLikes = array_diff($sessionLikes, [$artikel_id]);
                $liked = false;
            } else {
                $sessionLikes[] = $artikel_id;
                $liked = true;
            }
            
            session()->put('guest_likes', array_values($sessionLikes));
        }
        
        // Count total likes (database + session)
        $dbLikes = Like::where('id_artikel', $artikel_id)->count();
        $sessionLikes = session()->get('guest_likes', []);
        $guestLikes = in_array($artikel_id, $sessionLikes) ? 1 : 0;
        $total_likes = $dbLikes + $guestLikes;
        
        return response()->json([
            'liked' => $liked,
            'total_likes' => $total_likes
        ]);
    }
}