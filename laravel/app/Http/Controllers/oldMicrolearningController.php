<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class oldMicrolearningController extends Controller
{
    public function index()
    {
        $lessons = [
            ['id' => 1, 'title' => 'Lesson 1: Introduction to Laravel', 'content' => 'Learn the basics of Laravel, a powerful PHP framework.'],
            ['id' => 2, 'title' => 'Lesson 2: Routing in Laravel', 'content' => 'Understand how routing works in Laravel to handle HTTP requests.'],
            ['id' => 3, 'title' => 'Lesson 3: Controllers in Laravel', 'content' => 'Explore how controllers manage application logic in Laravel.'],
        ];
    
        return view('microlearning.index', compact('lessons'));
    }
    
    public function lesson($id)
    {
        $lesson = [
            'id' => $id,
            'title' => 'Lesson ' . $id . ': Some Topic',
            'content' => 'This is the content for lesson ' . $id . '. In this lesson, you will learn about key concepts in Laravel development.',
        ];
    
        return view('microlearning.lesson', compact('lesson'));
    }
    

    public function quiz()
    {
        return view('microlearning.quiz');
    }
}