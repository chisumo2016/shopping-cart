<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $product = new \App\Product([
        'imagePath' => 'http://vignette3.wikia.nocookie.net/harrypotter/images/0/0e/Philostone.jpg/revision/latest?cb=20101208171110',
        'title'     =>'Harry Porter',
        'description'=> 'Super cool - at least as ac child',
        'price'=>10
    ]);
        $product->save();
        $product = new \App\Product([
            'imagePath' => 'http://vignette3.wikia.nocookie.net/harrypotter/images/0/0e/Philostone.jpg/revision/latest?cb=20101208171110',
            'title'     =>'Harry Porter',
            'description'=> 'Super cool - at least as ac child',
            'price'=>10
        ]);
        $product->save();
        $product = new \App\Product([
            'imagePath' => 'http://vignette3.wikia.nocookie.net/harrypotter/images/0/0e/Philostone.jpg/revision/latest?cb=20101208171110',
            'title'     =>'Harry Porter',
            'description'=> 'Super cool - at least as ac child',
            'price'=>10
        ]);
        $product->save();
        $product = new \App\Product([
            'imagePath' => 'http://vignette3.wikia.nocookie.net/harrypotter/images/0/0e/Philostone.jpg/revision/latest?cb=20101208171110',
            'title'     =>'Harry Porter',
            'description'=> 'Super cool - at least as ac child',
            'price'=>10
        ]);
        $product->save();
        $product = new \App\Product([
            'imagePath' => 'http://vignette3.wikia.nocookie.net/harrypotter/images/0/0e/Philostone.jpg/revision/latest?cb=20101208171110',
            'title'     =>'Harry Porter',
            'description'=> 'Super cool - at least as ac child',
            'price'=>10
        ]);
        $product->save();
    }
}
