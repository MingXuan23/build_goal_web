<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicrolearningController extends Controller
{
    private $dummyData = [
        [
            'id' => 1,
            'title' => 'How to Learn Laravel',
            'thumbnail' => 'https://via.placeholder.com/150',
            'content' => 'This is a guide on how to learn Laravel effectively.',
        ],
        [
            'id' => 2,
            'title' => 'Tips for Effective Studying',
            'thumbnail' => 'https://via.placeholder.com/150',
            'content' => 'These are tips for improving your study habits.',
        ],
    ];

    public function upload()
    {
        return view('microlearning.upload');
    }

    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $filteredData = collect($this->dummyData)->filter(function ($item) use ($search) {
        return str_contains(strtolower($item['title']), strtolower($search));
    });

        return view('microlearning.index', ['contents' => $filteredData]);
    }

    public function show($id)
    {
        $content = collect($this->dummyData)->firstWhere('id', $id);

        if (!$content) {
            abort(404, 'Content not found');
        }

        return view('microlearning.show', ['content' => $content]);
    }

}
