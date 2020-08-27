<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pizza;

class PizzaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['store', 'create']);
    }

    public function index(){
        //$pizzas = Pizza::all(); //Hepsini gösterir
        $pizzas = Pizza::orderBy('name')->get(); //İsimleri alfabetik sıralar
        //$pizzas = Pizza::orderBy('name', 'desc')->get(); //İsimleri tersine alfabetik sıralar
        //$pizzas = Pizza::where('type', 'hawaiian')->get();
        //$pizzas = Pizza::latest()->get(); //Hepsini gösterir

        return view('pizzas.index', [
            'pizzas' => $pizzas,   
        ]);
    }

    public function show($id)
    {
        $pizza = Pizza::findOrFail($id);
        return view('pizzas.show', ['pizza' => $pizza]);
    }

    public function create()
    {
        return view('pizzas.create');
    }

    public function store()
    {
        $pizza = new Pizza();
        $pizza->name = request('name');
        $pizza->type = request('type');
        $pizza->base = request('base');
        $pizza->toppings = request('toppings');
        //error_log($pizza);
        $pizza->save();
        return redirect('/')->with('mssg','Thanks for your order');
    }

    public function destroy($id)
    {
        $pizza = Pizza::findOrFail($id);
        $pizza->delete();

        return redirect('/pizzas');
    }

}
