<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Article; // Pastikan untuk mengimpor model Article

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();


        if ($user->hasRole('owner')) {
        $totalArticles = Article::count();
        $pendingArticles = Article::where('is_confirm', 0)->count();
        $totalSuccess = Article::where('is_confirm', 1)->where('is_confirm', 1)->count();
    
        // Mengambil kategori dan jumlah artikel per kategori
        $categories = Article::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->get();

        } else {
            // Jika penulis, ambil artikel yang ditulis oleh penulis tersebut
            $totalArticles = Article::where('user_id', $user->id)->count();
            $pendingArticles = Article::where('user_id', $user->id)->where('is_confirm', 0)->count();
            $totalSuccess = Article::where('user_id', $user->id)->where('is_confirm', 1)->where('is_confirm', 1)->count();
          
            // Ambil kategori dan total artikel per kategori untuk penulis
            $categories = Article::where('user_id', $user->id)
                ->select('category_id', DB::raw('count(*) as total'))
                ->groupBy('category_id')
                ->with('category:id,name') // Mengambil nama kategori
                ->get();
        }

        return view('backend.dashboard.index', compact(
            'totalArticles', 
            'pendingArticles', 
            'totalSuccess', 
            'categories'));
    }
}

   

