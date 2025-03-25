<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AuctionController extends Controller
{

    public function index(): Response
    {
        $auctions = Auction::paginate(15)->through(function ($item) {
            return [
                'title' => $item->title,
                'description' => $item->description,
                'buy_now' => $item->buy_now,
                'image_path' => Storage::url($item->image_path)
                // etc
            ];
        });
        return Inertia::render('auctions/hehe', [
            'auctions' => $auctions
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('auctions/create', [
            'categories' => Tag::all()
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'title' => 'string|required|min:2',
            'description' => 'string|required|max:65535',
            'category_id' => 'required|int',
            'buy_now' => 'boolean',
            'auction_length' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png',
            'starting_price' => 'required|int',
            'buy_now_price' => 'required_with:buy_now',
        ]);

        $file = $request->file('file');

        if ($file) {
            $name = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            $file->storeAs('auction_item', $name, 'public');
        }

        $input['image_path'] = $name;
        $input['user_id'] = auth()->user()->id;


        Auction::create($input);

        session()->flash("success", 'Auction Created.');

        return redirect()->to('/');
//        dd("hi", $request->alL());
    }
}
