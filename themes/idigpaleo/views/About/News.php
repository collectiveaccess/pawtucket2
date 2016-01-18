<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": News");
	require_once(__CA_APP_DIR__.'/lib/vendor/autoload.php');
	use Guzzle\Http\Client;

	$client = new Client();
	$response = $client->get('http://fossilinsects.colorado.edu/feed/')->send();

	$va_news = json_decode(json_encode($response->xml()),TRUE);
?>
<H1><?php print _t("News"); ?></H1>
<?php
		if(is_array($va_news)){
			$i = 0;
			foreach($va_news["channel"]["item"] as $va_news_item){
				#print_r($va_news_item);
				if($i == 0){
					print "<div class='row'>";
				}
				print "<div class='col-sm-6 news'><H2>";
				if($va_news_item["link"]){
					print "<a href='".$va_news_item["link"]."' target='_blank'>".$va_news_item["title"]."</a>";
				}else{
					print $va_news_item["title"];
				}
				print "</H2>";	
				print date("F j, Y", strtotime($va_news_item["pubDate"]));
				print "</div>";
				$i++;
				if($i == 2){
					print "</div>";
					$i = 0;
				}
			}
			if($i == 1){
				print "</div>"; 
			}
		}
?>