<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$pages=['Kariyer','Vizyonumuz','Misyonumuz','Hakkımızda','İletişim'];
		$count=0;
		foreach ($pages as $page)
		{
			$count++;
			DB::table('pages')->insert
			([
				'title' => $page,
				'image' => 'https://cdn-res.keymedia.com/cms/images/us/018/0248_637269465913199350.jpg',
				'slug' => str_slug($page),
				'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							Alias aperiam autem doloremque dolores 
							id iusto possimus provident, repellendus sit. Ab? 
							Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							Alias aperiam autem doloremque dolores 
							id iusto possimus provident, repellendus sit. Ab?
							Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							Alias aperiam autem doloremque dolores 
							id iusto possimus provident, repellendus sit. Ab?',
				'order' => $count,
				'created_at' => now(),
				'updated_at' => now()
			]);
		}
    }
}


