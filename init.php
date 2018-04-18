<?php
class YoutubeFrames extends Plugin {

	private $host;

	function about() {
		return array(1.0,
		"Embed Youtube videos using iframes",
		"dugite-code");
	}

	function init($host) {
		$this->host = $host;

		$host->add_hook($host::HOOK_ARTICLE_FILTER, $this);
	}

	function hook_article_filter($article) {

		// Basic link matching
		if ( strpos($article["link"], "youtube.com") !==false ){
			$domDocument = new DOMDocument();
			$domElement = $domDocument->createElement("iframe","");

			// Add width attribute
			$domAttribute = $domDocument->createAttribute('width');
			$domAttribute->value = '640';
			$domElement->appendChild($domAttribute);

			// Add height attribute
			$domAttribute = $domDocument->createAttribute('height');
			$domAttribute->value = '360';
			$domElement->appendChild($domAttribute);

			// Get video ID from link
			$urlparts = explode("v=", $article["link"]);
			$embed_link = "https://www.youtube.com/embed/".$urlparts[1];

			// Add src attribute
			$domAttribute = $domDocument->createAttribute('src');
			$domAttribute->value =  $embed_link;
			$domElement->appendChild($domAttribute);

			// Add iframe to domDocument
			$domDocument->appendChild($domElement);

			// Save domDocument as html and replace article content
			$article["content"] = $domDocument->saveHTML();

		}

		// Return article
		return $article;
	}

	function api_version() {
		return 2;
	}

}
