<?php

use Phinx\Seed\AbstractSeed;

class SeedPostTable extends AbstractSeed
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        /** ### Categories Seed ### */
        $categories  = [];
        for($i = 0; $i < 10; $i++){
            $categories[] = [
                'title' => $faker->sentence(1)
            ];
        }
        $this->insert('categories', $categories);
        /** ### End Categories Seed ### */


        /** ### Posts Seed ### */
        $posts  = [];
        $categories = array_map( // Select categories for the foreign key
            function ($category) { return $category['id']; },
            $this->fetchAll('SELECT id FROM categories')
        );
        for($i = 0; $i < 100; $i++){
            $timestamp = $faker->unixTime('now');
            $posts[] = [
                'category_id' => $categories[rand(0,9)],
                'title' => $faker->sentence(5),
                'subtitle' => $faker->sentence(5),
                'content' => $faker->text(500),
                'created_at' => date('Y-m-d H:i:s', $timestamp),
                'updated_at' => date('Y-m-d H:i:s', $timestamp),
                'published_at' => date('Y-m-d H:i:s', $timestamp)
            ];
        }
        $this->insert('posts', $posts);
        /** ### End Posts Seed ### */

        /** ### Medias Seed ### */
        $medias  = [];
        $posts = array_map( // Select categories for the foreign key
            function ($post) { return $post['id']; },
            $this->fetchAll('SELECT id FROM posts')
        );
        for($i = 0; $i < 300; $i++){
            $timestamp = $faker->unixTime('now');
            $medias[] = [
                'post_id' => $posts[rand(0,99)],
                'file_name' => $faker->image('storage/uploads/', $width = 640, $height = 480, 'cats'),
                'file_size' => rand(102400, 2097152),
                'file_type' => 'image/jpg',
                'created_at' => date('Y-m-d H:i:s', $timestamp),
                'updated_at' => date('Y-m-d H:i:s', $timestamp)
            ];
        }
        $this->insert('medias', $medias);
        /** ### End Medias Seed ### */

        /** ### Comments Seed ### */
        $comments  = [];
        $posts = array_map( // Select categories for the foreign key
            function ($post) { return $post['id']; },
            $this->fetchAll('SELECT id FROM posts')
        );
        for($i = 0; $i < 500; $i++){
            $timestamp = $faker->unixTime('now');
            $comments[] = [
                'post_id' => $posts[rand(0,99)],
                'email' => $faker->email(),
                'content' => $faker->paragraph(),
                'created_at' => date('Y-m-d H:i:s', $timestamp)
            ];
        }
        $this->insert('comments', $comments);
        /** ### End Comments Seed ### */

    }
}
