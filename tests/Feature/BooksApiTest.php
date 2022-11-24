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
        /*
        $books = Book::factory(4)->create();
        
        $response = $this->getJson(route('books.index'));

         $response->assertJsonFragment([
            'title' => $books[0]->title
        ]);
        */

        //6. Devolviendo dos libros de un Fragmento con JSON 
        $books = Book::factory(4)->create();
        
        $response = $this->getJson(route('books.index'));

         $response->assertJsonFragment([
            'title' => $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);

        
    }


     /** @test */

    function can_get_one_book()
    {
        //1.//Se crea un libro con factory
        
        $book = Book::factory()->create();

         //Un getJson a la ruta books.show, para que genere la ruta. 
        dd(route('books.show', $book)); 
        //Guardando la respuesta 
        $response->$this->getJson(route('books.show', $book));
        //Generamos la verificación
        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */

    function can_create_books()
    {
        
        //2. Utilizamos un test de regresión para hacerlo falla, mediante el metodo asserJsonValidationErrorFor
        //donde enviamos un PostJson y esperamos un error de validación en el campo title 
        //es importante enviar un Json para recibir un JSON
        $this->postJson(route('books.store'),[])
        ->assertJsonValidationErrorFor('title');


        //1. No necesitamos un libro que exista en la Bd a la ruta books.store, y como segundo parametro 
        //el primer parametro es la URL, el segundo parametro son los datos que vamos a enviar. en este caso un titulo y un nuevo libro 
        //Esperando un fragmento como respuesta que contenga el mismo valor

        $this->postJson(route('books.store'), [
            'title' => 'My new book'
        ])->assertJsonFragment([
         ]);

        //Este metodo recibe un primer parametro books y como segundo parametro recibe un array con los datos a verificar
        $this ->assertDatabaseHas('books', [
           'title' => 'My new book' 
        ]);

    }
    
}
