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
		$host->add_hook($host::HOOK_IFRAME_WHITELISTED, $this);
	}

	function hook_iframe_whitelisted($src) {
		return in_array($src, ["www.youtube.com", "youtube.com", "youtu.be"]);
	}

	function hook_article_filter($article) {

		// Basic link matching
		if ( strpos($article["link"], "youtube.com") !==false ){
                        $domDocument = new DOMDocument();
                        $domElement = $domDocument->createElement("div","");
                        $newnode = $domDocument->appendChild($domElement);

                           // Get video ID from link
                        $urlparts = explode("v=", $article["link"]);
                        $embed_link = "https://www.youtube.com/embed/".$urlparts[1];

                        // Add src attribute
                        $newnode->setAttribute("src", $embed_link);

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
