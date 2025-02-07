<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
   public function toggle(Request $request)
   {
       $feature = Tasks::find($request->id);
       $feature->status = !$feature->status;
       $feature->save();
       return redirect()->route('tasks.index');
   }
}
