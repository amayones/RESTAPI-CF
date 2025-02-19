<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // field user ==
        $admin = User::create([
            'email' => 'admin@gmail.com',
            'username' => 'lord etmin',
            'password' => Hash::make('admin'),
            'firstname' => 'lord',
            'lastname' => 'etmin',
        ]);

        $rangga = User::create([
            'email' => 'rangga@gmail.com',
            'username' => 'lord rangga',
            'password' => Hash::make('rangga'),
            'firstname' => 'lord',
            'lastname' => 'rangga',
        ]);
        // ==

        // // field Post ==
        Post::create([
            'title' => 'Welcome to portal berita',
            'news_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras mattis consectetur purus sit amet fermentum.',
            'author_id' => $admin->id,
        ]);

        Post::create([
            'title' => 'Pengumuman',
            'news_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'author_id' => $admin->id,
        ]);
        // ==
    }
}
