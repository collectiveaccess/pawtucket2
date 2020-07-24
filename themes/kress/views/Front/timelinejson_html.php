<?php
$va_data = [
	'title' => [
		'text' => [
			'headline' => "This is the Intro Slide",
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
		],
		'media' => [
			'url' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'history1.jpg'),
			'credit' => 'caption',
			'caption' => ''
		]
	],
	'scale' => 'human'
];


	$va_data['events'] = [
								['text' => [
										'headline' => 'Slide 1',
										'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed',
									],
									'media' => [
										'url' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'apartment1.jpg'),
										'thumbnail' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'apartment1.jpg'),
										'credit' => 'caption',
										'caption' => ''
									],
									'start_date' => [
										'year' => '1949',
										'month' => '2',
										'day'	=> '14'
									],
									'end_date' => [
										'year' => '1949',
										'month' => '2',
										'day'	=> '14'
									]
								],
								['text' => [
										'headline' => 'Slide 2',
										'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed',
									],
									'media' => [
										'url' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'art2.jpg'),
										'thumbnail' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'art2.jpg'),
										'credit' => 'caption',
										'caption' => ''
									],
									'start_date' => [
										'year' => '1950',
										'month' => '7',
										'day'	=> '1'
									],
									'end_date' => [
										'year' => '1950',
										'month' => '8',
										'day'	=> '1'
									]
								],
								['text' => [
										'headline' => 'Slide 3',
										'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed',
									],
									'media' => [
										'url' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'people.jpg'),
										'thumbnail' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'people.jpg'),
										'credit' => 'caption',
										'caption' => ''
									],
									'start_date' => [
										'year' => '1952'
									],
									'end_date' => [
										'year' => '1952'
									]
								],
								['text' => [
										'headline' => 'Slide 4',
										'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed',
									],
									'media' => [
										'url' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'art3.jpg'),
										'thumbnail' => $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'art3.jpg'),
										'credit' => 'caption',
										'caption' => ''
									],
									'start_date' => [
										'year' => '1955'
									],
									'end_date' => [
										'year' => '1955'
									]
								],
								
	];

print json_encode($va_data);
?>