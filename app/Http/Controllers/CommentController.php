<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsService;

class CommentController extends Controller
{
    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function index()
    {
        $comments = $this->googleSheetsService->getComments();

        return view('dashboard', ['comments' => $comments]);
    }
}
