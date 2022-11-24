<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
     
    use RefreshDatabase;

     /** @test */

    function can_get_all_books()
    {

        //1. Un registro en la BD
        //$book = Book::factory()->create();

        //dd($book); //dom by die o dye dom para inspeccionar este libro
        
        //2. Multiples registros en la BD
        //$books = Book::factory(4)->create();
        //dd($books->count()); //Inspeccion de multiples inserciones

        //3. Se hace un peticion de tipo GET
        //$books = Book::factory(4)->create();
        //$this->get('/api/books')->dump(); //Se inspecciona la respuesta

        //4. Utilizando un nombre de ruta
        /*$books = Book::factory(4)->create();
        dd(route('books.index'));
        $this->get(route('books.index'))->dump();*/

        //5. Devolviendo un Fragmento con JSON con el primer resultado
        $books = Book::factory(4)->create();
        
        $response = $this->getJson(route('books.index'));

         $response->assertJsonFragment([
            'title' => $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);

    
        
    }
    
}
