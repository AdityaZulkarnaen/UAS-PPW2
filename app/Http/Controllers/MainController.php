<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index() {
        // Data untuk chart gender
        $genderStats = Pegawai::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();
        
        $maleCount = $genderStats->where('gender', 'male')->first()->total ?? 0;
        $femaleCount = $genderStats->where('gender', 'female')->first()->total ?? 0;
        
        // Data untuk chart top 5 pekerjaan
        $topPekerjaan = Pekerjaan::withCount('pegawai')
            ->orderBy('pegawai_count', 'desc')
            ->take(5)
            ->get();
        
        return view('index', compact('maleCount', 'femaleCount', 'topPekerjaan'));
    }
}
