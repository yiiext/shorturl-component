Description:
------------
This extensions allows you to short url by the {@link goo.gl} service.
Documentation for Google URL Shortener API: {@link http://code.google.com/intl/ru/apis/urlshortener/}

Installation:
-------------
In order to activate the extension and use it's methods you will need to add the following 
component code to your application configuration.

'shorturl' => array(
	'class' => 'ext.shorturl.ShortUrl',
	'apiKey' => 'xxxxxx', // apikey
),

-------------
Usage:
Yii::app()->shorturl->short('http://mysite.com/MyReallyLongUrl?withLongLongParams=1');