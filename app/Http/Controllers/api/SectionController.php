<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\SectionListRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SectionListRequest $request)
    {
        $sections = SectionResource::collection(Section::where('class_id', $request->query('class_id'))->get());

        return response()->json([
            'data' => $sections,
        ]);
    }
}
