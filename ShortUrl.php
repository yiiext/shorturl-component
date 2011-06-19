<?php
/**
 * Goo.gl API Class File
 *
 * @author Zagirov Rustam <rustam@zagirov.name>
 * @link http://www.zagirov.name/
 * @copyright Zagirov Rustam
 * @license http://www.yiiframework.com/license/
 *
 */

/**
 * Description:
 * ------------
 * This extensions allows you to short url by the {@link goo.gl} service.
 *
 * Installation:
 * -------------
 * In order to activate the extension and use it's methods you will need to add the following 
 * component code to your application configuration.
 *
 * 	'shorturl' => array(
 *		'class' => 'ext.shorturl.ShortUrl',
 *		'apiKey' => 'xxxxxx', // apikey
 *	),
 */
class ShortUrl extends CApplicationComponent
{
	/**
	 * @var Current class version
	 */
	const CLASS_VERSION = '1.0.0';
	/**
	 * @var API URL
	 */
	const API_URL = 'https://www.googleapis.com/urlshortener/v1/url';
	/**
	 * @var API Key
	 */
	public $apiKey = null;
	/**
	 * Component initializer
	 *
	 * @throws CException on missing CURL PHP Extension
	 */
	public function init()
	{
		// Make sure we have CURL enabled
		if( ! function_exists('curl_init') )
		{
			throw new CException(Yii::t('ShortUrl.extension', 'Sorry, Buy you need to have the CURL extension enabled in order to be able to use this class.'), 500);
		}
		parent::init();
	}
	
	/**
	 * Short url by goo.gl
	 * @param string $longUrl
	 * @return string
	 */
	public function short($longUrl)
	{
		if ( ! $this->apiKey)
		{
			throw new CException('Set apiKey in config', 500);
		}
		return $this->shortenUrl($longUrl, $this->apiKey);
	}

	/**
	 * @param string $longUrl
	 * @param string $apiKey
	 * @return string|false
	 */
	function shortenUrl($longUrl, $apiKey)
	{
		// initialize the cURL connection
		$ch = curl_init(
			self::API_URL . '?key=' . $apiKey
		);

		// tell cURL to return the data rather than outputting it
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// create the data to be encoded into JSON
		$requestData = array(
			'longUrl' => $longUrl
		);

		// change the request type to POST
		curl_setopt($ch, CURLOPT_POST, true);

		// set the form content type for JSON data
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

		// set the post body to encoded JSON data
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

		// perform the request
		$result = curl_exec($ch);
		curl_close($ch);

		// decode and return the JSON response
		$json = json_decode($result, true);
		//return short link if available or false
		return $json['id'] ? $json['id'] : false;
	}

}