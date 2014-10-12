<?php

class SitemapController extends BaseController {

	// ********** Generate Sitemap //

	public function generate(){
		
		$sitemap = App::make("sitemap");

		// Add the Homepage and Popular Pages
		$sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
		$sitemap->add(URL::to('/popular'), date('Y-m-d H:i:s'),'1.0', 'daily');
		$sitemap->add(URL::to('/popular/week'), date('Y-m-d H:i:s'),'1.0', 'daily');
		$sitemap->add(URL::to('/popular/month'), date('Y-m-d H:i:s'),'1.0', 'daily');
		$sitemap->add(URL::to('/popular/year'), date('Y-m-d H:i:s'),'1.0', 'daily');

		// Display all Media
		$items = Media::all();
		foreach($items as $item) {
		  $sitemap->add(URL::to("media/{$item->slug}"), $item->created_at, '0.9', 'weekly');
		}

		$categories = Category::all();

		foreach($categories as $category) {
		  $sitemap->add(URL::to("category/{$category->name}"), $category->created_at, '0.9', 'weekly');
		}

		// Now, output the sitemap:
		return $sitemap->render('xml'); 

	}

}