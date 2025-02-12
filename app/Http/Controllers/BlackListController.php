<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlackList;

class BlackListController extends Controller
{
    public function index()
    {
        $blacklists = BlackList::all();
        $mainmenu = 'Block List IP';      // Define $mainmenu variable
        $submenu = 'Block List IP';       // Define $submenu variable
    
        // Pass variables to the view
        return view('admin.blacklist.blacklist', compact('blacklists', 'mainmenu', 'submenu'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:black_lists,ip_address',
        ]);

        // Create a new BlackList entry
        BlackList::create([
            'ip_address' => $request->ip_address,
        ]);

        return redirect()->route('blacklist.index')->with('success', 'IP Address has been blacklisted successfully!');
    }

    public function destroy($id)
    {
        $blacklist = BlackList::findOrFail($id);
        $blacklist->delete();

        return redirect()->route('blacklist.index')->with('success', 'IP Address has been removed from the blacklist!');
    }
}
