<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            [
                'title' => 'Pemrograman Laravel Pemula',
                'author' => 'John Doe',
                'publisher' => 'Gramedia',
                'description' => 'Buku panduan pemrograman Laravel untuk pemula.',
                'stock' => 10,
                'category' => 'Programming',
                'price' => '10000',
                'created_at' => now(),
                'updated_at' => now(),
                
            ],
            [
                'title' => 'Mastering PHP',
                'author' => 'Jane Smith',
                'publisher' => 'Penerbit Informatika',
                'description' => 'Panduan lengkap untuk menguasai PHP.',
                'stock' => 5,
                'category' => 'Programming',
                'price' => '20000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Belajar Database MySQL',
                'author' => 'Ali Akbar',
                'publisher' => 'Erlangga',
                'description' => 'Membahas dasar-dasar MySQL untuk pengelolaan database.',
                'stock' => 8,
                'category' => 'Database',
                'price' => '30000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Data Science dengan Python',
                'author' => 'Maria Tan',
                'publisher' => 'Python Press',
                'description' => 'Buku pengantar data science menggunakan Python.',
                'stock' => 12,
                'category' => 'Data Science',
                'price' => '35000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'How to Kill Black People',
                'author' => 'Restu',
                'publisher' => 'Hytam Automatic',
                'description' => 'Buku tentang org hitam.',
                'stock' => 12,
                'category' => 'Gore',
                'price' => '35000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
