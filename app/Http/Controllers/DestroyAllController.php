<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Answer;
use DB;

class DestroyAllController extends Controller
{
    public function AllUsersDestroy()
    {
      User::where('role', '!=', 'A')->getQuery()->delete();
      DB::delete('delete from application');
      // User::where('role', '!=', 'A')->truncate();
      return back()->with('deleted', 'All Candidates Has Been Deleted');
    }

    public function AllAnswersDestroy() {
      Answer::truncate();
      return back()->with('deleted', 'All Answer Sheets Has Been Deleted');
    }

}
