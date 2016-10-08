<?php

use App\Models\Quote;
use Illuminate\Database\Eloquent\ModelNotFoundException;

$app->get('/', function() use ($app) {
    $count = Quote::query()->get()->count();
    $day = (int) date('z');
    $page = $day % $count + 1;
    $quotes = Quote::query()->get()->forPage($page, 1)->all();

    if (empty($quotes)) {
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }

    return view('quote', ['quote' => $quotes[0]]);
});

$app->get('/{id}', function($id) use ($app) {
    try {
        $quote = Quote::query()->findOrFail($id);
        return view('quote', ['quote' => $quote]);
    } catch (ModelNotFoundException $mnfe) {
        return view('404');
    }
});
