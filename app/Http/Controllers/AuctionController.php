<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Image;
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
        $auctions = Auction::orderByDesc('id')->paginate(15)->through(function ($item) {
            return [
                'title' => $item->title,
                'description' => $item->description,
                'buy_now' => $item->buy_now,
                'buy_now_price' => $item->buy_now_price,
                'images' => $item->images->map(function ($image) use ($item) {
                    return [
                        'path' => Storage::url('auction_item/' . $item->id . '/' . $image->path),
                        'title' => $item->title . ' Is missing' ?? 'Auction Image',
                    ];
                }),
            ];
        });
        return Inertia::render('auctions/index', [
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
//        dd($request->file('file'));
        $input = $request->validate([
            'title' => 'string|required|min:2',
            'description' => 'string|required|max:65535',
            'category_id' => 'required|int',
            'buy_now' => 'boolean',
            'auction_length' => 'required',
            'file' => 'required|array',
            'starting_price' => 'required|int',
            'buy_now_price' => 'required_with:buy_now',
        ]);


        $auction = Auction::create(array_merge($input, ['user_id' => auth()->user()->id]));

        $file = $request->file('file');
        if ($file) {
            foreach ($file as $f) {
                $name = $f->getClientOriginalName();
                $extension = $f->getClientOriginalExtension();

                $f->storeAs('auction_item/' . $auction->id, $name, 'public');
                Image::create([
                    'path' => $name,
                    'auction_id' => $auction->id
                ]);
            }
        }


        session()->flash("success", 'Auction Created.');

        return redirect()->to('/');
//        dd("hi", $request->alL());
    }
}
