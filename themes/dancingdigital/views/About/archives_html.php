<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 $t_set = ca_sets::findAsInstance(['set_code' => 'archives_landing'], ['checkAccess' => caGetUserAccessValues($this->request)]);
 $set_items = $t_set ? $t_set->getItems(['thumbnailVersion' => 'medium']) : [];
 ?>
<main data-barba="container" data-barba-namespace="archives" class="barba-main-container archives-section">
	<div class="general-page">
		<div class="container">
			<div class="row justify-content-start">
				<div class="col-auto ms-5">
					<h1 class="page-heading heading-size-2 ps-0">Archives</h1>
					<p class="page-content content-size-2 ms-3">
						How to use the Archive
					</p>	
					
					<div class="explore-grid">

						<div class="explore-grid-item">
							<a href="/Browse/Objects">
								<div class="explore-text">
									<h4 >Browse Archival Items</h4>
								</div>
 							</a>
						</div>

						<div class="explore-grid-item">
							<a href="/Browse/entities">
								<div class="explore-text">
									<h4 >Browse People</h4>
								</div>
 							</a>
						</div>

						<div class="explore-grid-item">
							<a href="/Browse/choreographic_works">
								<div class="explore-text">
									<h4 >Browse Choreographic Works</h4>
								</div>
 							</a>
						</div>

						<div class="explore-grid-item">
							<a href="/Browse/events">
								<div class="explore-text">
									<h4 >Browse Events</h4>
								</div>
							</a>
						</div>

						<div class="explore-grid-item">
							<div class="explore-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="15" fill="white"></circle><path d="M14.484 12.51C14.484 12.138 14.448 11.868 14.376 11.7C14.304 11.532 14.16 11.418 13.944 11.358C13.74 11.298 13.404 11.268 12.936 11.268C12.9 11.268 12.882 11.232 12.882 11.16C12.882 11.088 12.9 11.052 12.936 11.052C13.284 11.052 13.56 11.058 13.764 11.07L14.988 11.088L16.194 11.07C16.398 11.058 16.68 11.052 17.04 11.052C17.076 11.052 17.094 11.088 17.094 11.16C17.094 11.232 17.076 11.268 17.04 11.268C16.596 11.268 16.266 11.304 16.05 11.376C15.846 11.436 15.702 11.55 15.618 11.718C15.534 11.886 15.492 12.15 15.492 12.51V16.542C15.492 16.914 15.528 17.184 15.6 17.352C15.672 17.52 15.81 17.634 16.014 17.694C16.23 17.754 16.572 17.784 17.04 17.784C17.076 17.784 17.094 17.82 17.094 17.892C17.094 17.964 17.076 18 17.04 18C16.692 18 16.416 17.994 16.212 17.982L14.988 17.964L13.782 17.982C13.578 17.994 13.296 18 12.936 18C12.9 18 12.882 17.964 12.882 17.892C12.882 17.82 12.9 17.784 12.936 17.784C13.38 17.784 13.704 17.754 13.908 17.694C14.124 17.622 14.274 17.502 14.358 17.334C14.442 17.166 14.484 16.902 14.484 16.542V12.51Z" fill="black"></path></svg>				
							</div>
							<div class="explore-text">
								<h4 >Click</h4>
								<p>Click on any image, or the “Explore Archive” button, to dive into your own journey.</p>
							</div>
						</div>

						<div class="explore-grid-item">
							<div class="explore-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="15" fill="white"></circle><path d="M12.666 17.73C13.722 16.866 14.538 16.164 15.114 15.624C15.69 15.072 16.104 14.58 16.356 14.148C16.608 13.716 16.734 13.284 16.734 12.852C16.734 12.372 16.584 11.982 16.284 11.682C15.996 11.37 15.618 11.214 15.15 11.214C14.202 11.214 13.518 11.958 13.098 13.446C13.098 13.458 13.074 13.464 13.026 13.464C12.918 13.464 12.87 13.44 12.882 13.392L13.584 10.656C13.584 10.632 13.608 10.62 13.656 10.62C13.692 10.62 13.722 10.632 13.746 10.656C13.782 10.668 13.794 10.68 13.782 10.692C13.77 10.74 13.764 10.806 13.764 10.89C13.764 11.082 13.854 11.178 14.034 11.178C14.142 11.178 14.322 11.136 14.574 11.052C15.066 10.896 15.504 10.818 15.888 10.818C16.5 10.818 16.98 10.986 17.328 11.322C17.688 11.646 17.868 12.072 17.868 12.6C17.868 13.02 17.73 13.44 17.454 13.86C17.19 14.28 16.794 14.73 16.266 15.21C15.75 15.678 15.024 16.272 14.088 16.992C14.04 17.028 14.022 17.058 14.034 17.082C14.058 17.106 14.1 17.118 14.16 17.118C15.48 17.118 16.398 17.1 16.914 17.064C17.43 17.028 17.802 16.932 18.03 16.776C18.258 16.62 18.414 16.344 18.498 15.948C18.498 15.924 18.528 15.912 18.588 15.912C18.672 15.912 18.714 15.93 18.714 15.966L18.444 17.802C18.444 17.85 18.426 17.898 18.39 17.946C18.366 17.982 18.33 18 18.282 18H12.792C12.732 18 12.684 17.97 12.648 17.91C12.612 17.838 12.618 17.778 12.666 17.73Z" fill="black"></path></svg>				
							</div>
							<div class="explore-text">
								<h4 >Watch</h4>
								<p>Watch, annotate, and compare videos; create your own playlist.</p>
							</div>
						</div>

						<div class="explore-grid-item">
							<div class="explore-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="15" fill="white"></circle><path d="M15.852 15.642C16.644 15.726 17.244 16.008 17.652 16.488C18.072 16.968 18.282 17.526 18.282 18.162C18.282 18.75 18.09 19.35 17.706 19.962C17.322 20.586 16.734 21.162 15.942 21.69C15.162 22.218 14.202 22.638 13.062 22.95C13.014 22.962 12.972 22.932 12.936 22.86C12.912 22.8 12.924 22.764 12.972 22.752C14.412 22.308 15.438 21.678 16.05 20.862C16.674 20.046 16.986 19.212 16.986 18.36C16.986 17.712 16.818 17.166 16.482 16.722C16.146 16.278 15.636 16.056 14.952 16.056C14.616 16.056 14.328 16.092 14.088 16.164C14.052 16.176 14.022 16.146 13.998 16.074C13.974 16.002 13.98 15.96 14.016 15.948C14.952 15.708 15.612 15.372 15.996 14.94C16.392 14.508 16.59 13.92 16.59 13.176C16.59 12.564 16.458 12.084 16.194 11.736C15.942 11.388 15.552 11.214 15.024 11.214C13.956 11.214 13.218 11.928 12.81 13.356C12.798 13.368 12.774 13.374 12.738 13.374C12.63 13.374 12.582 13.35 12.594 13.302L13.26 10.674C13.284 10.65 13.308 10.638 13.332 10.638C13.368 10.638 13.404 10.65 13.44 10.674C13.476 10.686 13.488 10.698 13.476 10.71C13.452 10.806 13.44 10.872 13.44 10.908C13.44 11.112 13.542 11.214 13.746 11.214C13.854 11.214 14.034 11.172 14.286 11.088C14.778 10.908 15.222 10.818 15.618 10.818C16.29 10.818 16.812 11.022 17.184 11.43C17.556 11.826 17.742 12.306 17.742 12.87C17.742 13.458 17.574 14.01 17.238 14.526C16.902 15.03 16.44 15.402 15.852 15.642Z" fill="black"></path></svg>
							</div>
							<div class="explore-text">
								<h4 >Find</h4>
								<p>Find relationships and connections across the field of dance.</p>
							</div>
						</div>

						<div class="explore-grid-item">
							<div class="explore-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="15" fill="white"></circle><path d="M19.452 17.208C19.5 17.208 19.524 17.322 19.524 17.55C19.524 17.646 19.512 17.742 19.488 17.838C19.476 17.934 19.458 17.982 19.434 17.982C19.074 17.958 18.57 17.934 17.922 17.91V20.754C17.922 20.886 17.874 20.97 17.778 21.006L17.022 21.384C16.95 21.408 16.914 21.42 16.914 21.42C16.878 21.42 16.86 21.372 16.86 21.276V17.892C16.104 17.868 14.658 17.856 12.522 17.856C12.462 17.856 12.414 17.832 12.378 17.784C12.342 17.736 12.348 17.688 12.396 17.64L17.652 10.872C17.676 10.848 17.712 10.836 17.76 10.836C17.796 10.836 17.832 10.848 17.868 10.872C17.904 10.884 17.922 10.908 17.922 10.944V17.244C18.198 17.244 18.708 17.232 19.452 17.208ZM13.404 17.316C14.436 17.316 15.588 17.304 16.86 17.28V12.654L13.314 17.19C13.278 17.226 13.266 17.256 13.278 17.28C13.302 17.304 13.344 17.316 13.404 17.316Z" fill="black"></path></svg>
							</div>
							<div class="explore-text">
								<h4 >Read</h4>
								<p>Read programs, scholarly articles, choreographic notes.</p>
							</div>
						</div>

					</div>

				</div> 

				<div class="col-auto" style="position: fixed; right: -40px; top: 50px;">
					<?php
						foreach($set_items as $item) {	
							$item = array_shift($item);
							//print_R($item);
					?>
						<div class='archive-landing-img'>
							<?= $item['representation_tag']; ?>
						</div>
					<?php
						}
					?>
				</div>

			</div>

		</div>
		<div class="nb-graphic position-fixed" style="left: 0;top: 750px;">
			<svg width="418" height="168" viewBox="0 0 418 168" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M66.5 108.14C66.5 107.953 66.6867 107.86 67.06 107.86C67.34 107.86 67.5733 107.907 67.76 108C68.04 108.093 68.18 108.233 68.18 108.42C67.34 114.3 66.92 120.46 66.92 126.9C66.92 127.647 66.7333 128.207 66.36 128.58C66.08 128.86 65.52 129 64.68 129H6.02C5.83333 129 5.74 128.72 5.74 128.16C5.74 127.6 5.83333 127.32 6.02 127.32C9.56667 127.32 12.1333 127.087 13.72 126.62C15.4 126.153 16.52 125.267 17.08 123.96C17.7333 122.56 18.06 120.46 18.06 117.66V52.84C18.06 50.04 17.7333 47.9867 17.08 46.68C16.52 45.3733 15.4 44.4867 13.72 44.02C12.1333 43.46 9.56667 43.18 6.02 43.18C5.83333 43.18 5.74 42.9 5.74 42.34C5.74 41.78 5.83333 41.5 6.02 41.5H62.3C63.14 41.5 63.56 41.92 63.56 42.76L63.84 59.98C63.84 60.26 63.6067 60.4467 63.14 60.54C62.6733 60.54 62.3933 60.4 62.3 60.12C62.02 55.1733 60.5267 51.3467 57.82 48.64C55.1133 45.84 51.52 44.44 47.04 44.44H38.5C35.2333 44.44 32.8067 44.72 31.22 45.28C29.7267 45.7467 28.6533 46.6333 28 47.94C27.44 49.1533 27.16 51.02 27.16 53.54V81.96H44.24C48.72 81.96 51.8933 81.2133 53.76 79.72C55.72 78.2267 56.7 75.7067 56.7 72.16C56.7 71.9733 56.98 71.88 57.54 71.88C58.1 71.88 58.38 71.9733 58.38 72.16L58.24 83.5C58.24 86.2067 58.2867 88.26 58.38 89.66L58.52 96.38C58.52 96.5667 58.24 96.66 57.68 96.66C57.12 96.66 56.84 96.5667 56.84 96.38C56.84 92.2733 55.8133 89.3333 53.76 87.56C51.8 85.7867 48.4867 84.9 43.82 84.9H27.16V117.1C27.16 119.713 27.44 121.627 28 122.84C28.56 124.053 29.5867 124.893 31.08 125.36C32.5733 125.827 34.9067 126.06 38.08 126.06H49.28C53.76 126.06 57.4933 124.473 60.48 121.3C63.4667 118.127 65.4733 113.74 66.5 108.14ZM134.975 127.32C135.162 127.32 135.255 127.6 135.255 128.16C135.255 128.72 135.162 129 134.975 129L130.495 128.86C129.469 128.767 127.975 128.72 126.015 128.72L117.055 128.86C115.655 128.953 113.789 129 111.455 129C111.175 129 111.035 128.72 111.035 128.16C111.035 127.6 111.175 127.32 111.455 127.32C113.135 127.32 114.302 127.227 114.955 127.04C115.702 126.76 116.075 126.293 116.075 125.64C116.075 124.8 115.515 123.54 114.395 121.86L103.755 105.76L95.3553 117.8C93.4886 120.6 92.5553 122.653 92.5553 123.96C92.5553 125.08 93.162 125.92 94.3753 126.48C95.682 127.04 97.7353 127.32 100.535 127.32C100.815 127.32 100.955 127.6 100.955 128.16C100.955 128.72 100.815 129 100.535 129C98.0153 129 96.1486 128.953 94.9353 128.86L86.5353 128.72L81.4953 128.86C80.562 128.953 79.0686 129 77.0153 129C76.8286 129 76.7353 128.72 76.7353 128.16C76.7353 127.6 76.8286 127.32 77.0153 127.32C79.442 127.32 82.0553 126.433 84.8553 124.66C87.7486 122.887 90.4086 120.32 92.8353 116.96L102.355 103.66L91.0153 86.58C88.7753 83.1267 86.442 80.6067 84.0153 79.02C81.5886 77.4333 79.3953 76.64 77.4353 76.64C77.2486 76.64 77.1553 76.36 77.1553 75.8C77.1553 75.24 77.2486 74.96 77.4353 74.96C79.3953 74.96 80.842 75.0067 81.7753 75.1L86.1153 75.24L95.0753 75.1C96.382 75.0067 98.202 74.96 100.535 74.96C100.722 74.96 100.815 75.24 100.815 75.8C100.815 76.36 100.722 76.64 100.535 76.64C98.9486 76.64 97.782 76.78 97.0353 77.06C96.2886 77.2467 95.9153 77.6667 95.9153 78.32C95.9153 78.9733 96.522 80.2333 97.7353 82.1L107.395 96.66L114.535 86.16C116.495 83.2667 117.475 81.1667 117.475 79.86C117.475 78.74 116.822 77.9467 115.515 77.48C114.302 76.92 112.249 76.64 109.355 76.64C109.169 76.64 109.075 76.36 109.075 75.8C109.075 75.24 109.169 74.96 109.355 74.96C111.875 74.96 113.789 75.0067 115.095 75.1L123.495 75.24L128.535 75.1C129.469 75.0067 130.962 74.96 133.015 74.96C133.202 74.96 133.295 75.24 133.295 75.8C133.295 76.36 133.202 76.64 133.015 76.64C130.495 76.64 127.835 77.5267 125.035 79.3C122.329 80.98 119.715 83.5467 117.195 87L108.655 98.62L121.115 117.38C123.449 120.927 125.829 123.493 128.255 125.08C130.775 126.573 133.015 127.32 134.975 127.32ZM181.379 73.14C185.205 73.14 188.752 74.1667 192.019 76.22C195.285 78.2733 197.899 81.26 199.859 85.18C201.819 89.1 202.799 93.6733 202.799 98.9C202.799 105.9 201.212 111.827 198.039 116.68C194.865 121.44 190.945 124.987 186.279 127.32C181.705 129.653 177.179 130.82 172.699 130.82C169.805 130.82 167.192 130.54 164.859 129.98C162.619 129.42 160.285 128.487 157.859 127.18V156.16C157.859 158.96 158.185 161.013 158.839 162.32C159.585 163.627 160.939 164.513 162.899 164.98C164.859 165.54 167.845 165.82 171.859 165.82C172.045 165.82 172.139 166.1 172.139 166.66C172.139 167.22 172.045 167.5 171.859 167.5C168.685 167.5 166.165 167.453 164.299 167.36L154.079 167.22L146.379 167.36C145.072 167.453 143.345 167.5 141.199 167.5C140.919 167.5 140.779 167.22 140.779 166.66C140.779 166.1 140.919 165.82 141.199 165.82C143.719 165.82 145.585 165.54 146.799 164.98C148.012 164.513 148.852 163.627 149.319 162.32C149.785 161.013 150.019 158.96 150.019 156.16V90.36C150.019 87 149.645 84.62 148.899 83.22C148.152 81.7267 146.845 80.98 144.979 80.98C142.925 80.98 140.452 81.6333 137.559 82.94L137.279 83.08C136.905 83.08 136.672 82.8467 136.579 82.38C136.392 81.9133 136.439 81.5867 136.719 81.4L152.259 73.98C152.445 73.8867 152.772 73.84 153.239 73.84C154.545 73.84 155.619 74.82 156.459 76.78C157.299 78.74 157.765 81.54 157.859 85.18C165.792 77.1533 173.632 73.14 181.379 73.14ZM176.899 127.88C181.845 127.88 185.905 125.733 189.079 121.44C192.252 117.053 193.839 110.987 193.839 103.24C193.839 95.4 192.112 89.3333 188.659 85.04C185.205 80.6533 180.819 78.46 175.499 78.46C172.232 78.46 169.199 79.2533 166.399 80.84C163.599 82.4267 160.752 84.6667 157.859 87.56V119.06C160.472 121.953 163.225 124.147 166.119 125.64C169.105 127.133 172.699 127.88 176.899 127.88ZM213.823 129C213.543 129 213.403 128.72 213.403 128.16C213.403 127.6 213.543 127.32 213.823 127.32C216.343 127.32 218.209 127.087 219.423 126.62C220.636 126.06 221.476 125.127 221.943 123.82C222.409 122.42 222.643 120.367 222.643 117.66V45.28C222.643 41.92 222.316 39.4933 221.663 38C221.009 36.5067 219.843 35.76 218.163 35.76C216.763 35.76 214.616 36.4133 211.723 37.72H211.443C211.163 37.72 210.929 37.4867 210.743 37.02C210.649 36.5533 210.743 36.2733 211.023 36.18L228.943 27.64C229.129 27.5467 229.363 27.5 229.643 27.5C229.829 27.5 230.063 27.64 230.343 27.92C230.716 28.1067 230.903 28.34 230.903 28.62V117.66C230.903 120.367 231.089 122.373 231.463 123.68C231.929 124.987 232.769 125.92 233.983 126.48C235.196 127.04 237.063 127.32 239.583 127.32C239.863 127.32 240.003 127.6 240.003 128.16C240.003 128.72 239.863 129 239.583 129C237.529 129 235.849 128.953 234.543 128.86L226.703 128.72L219.143 128.86C217.836 128.953 216.063 129 213.823 129ZM276.656 130.82C271.243 130.82 266.436 129.513 262.236 126.9C258.13 124.193 254.956 120.6 252.716 116.12C250.476 111.547 249.356 106.6 249.356 101.28C249.356 95.2133 250.803 90.08 253.696 85.88C256.683 81.5867 260.463 78.4133 265.036 76.36C269.703 74.2133 274.416 73.14 279.176 73.14C284.683 73.14 289.49 74.4933 293.596 77.2C297.703 79.9067 300.83 83.5 302.976 87.98C305.216 92.3667 306.336 97.0333 306.336 101.98C306.336 107.767 304.983 112.853 302.276 117.24C299.57 121.533 295.93 124.893 291.356 127.32C286.876 129.653 281.976 130.82 276.656 130.82ZM280.716 128.16C285.85 128.16 289.816 126.34 292.616 122.7C295.416 119.06 296.816 113.46 296.816 105.9C296.816 100.113 295.836 94.9333 293.876 90.36C292.01 85.7867 289.396 82.24 286.036 79.72C282.676 77.1067 278.85 75.8 274.556 75.8C269.516 75.8 265.596 77.62 262.796 81.26C260.09 84.9 258.736 90.1267 258.736 96.94C258.736 102.633 259.67 107.86 261.536 112.62C263.403 117.38 266.016 121.16 269.376 123.96C272.736 126.76 276.516 128.16 280.716 128.16ZM349.809 73.7C351.862 73.7 353.822 74.26 355.689 75.38C357.555 76.5 358.489 77.8533 358.489 79.44C358.489 80.6533 358.069 81.68 357.229 82.52C356.482 83.36 355.362 83.78 353.869 83.78C353.029 83.78 352.282 83.64 351.629 83.36C351.069 82.9867 350.369 82.4733 349.529 81.82C348.689 81.0733 347.895 80.5133 347.149 80.14C346.402 79.7667 345.515 79.58 344.489 79.58C343.275 79.58 341.969 80.0933 340.569 81.12C339.262 82.1467 337.162 84.34 334.269 87.7V117.66C334.269 120.46 334.595 122.513 335.249 123.82C335.995 125.127 337.302 126.06 339.169 126.62C341.035 127.087 343.929 127.32 347.849 127.32C348.222 127.32 348.409 127.6 348.409 128.16C348.409 128.72 348.222 129 347.849 129C344.862 129 342.482 128.953 340.709 128.86L330.349 128.72L322.649 128.86C321.435 128.953 319.755 129 317.609 129C317.329 129 317.189 128.72 317.189 128.16C317.189 127.6 317.329 127.32 317.609 127.32C320.129 127.32 321.995 127.087 323.209 126.62C324.422 126.06 325.215 125.127 325.589 123.82C326.055 122.513 326.289 120.46 326.289 117.66V89.94C326.289 86.7667 325.915 84.48 325.169 83.08C324.422 81.68 323.162 80.98 321.389 80.98C319.895 80.98 317.375 81.68 313.829 83.08H313.549C313.175 83.08 312.895 82.8933 312.709 82.52C312.615 82.0533 312.755 81.7267 313.129 81.54L329.369 73.84L330.209 73.7C331.049 73.7 331.935 74.7733 332.869 76.92C333.802 79.0667 334.269 81.82 334.269 85.18V85.32C338.095 80.84 341.129 77.8067 343.369 76.22C345.609 74.54 347.755 73.7 349.809 73.7ZM410.924 121.16C411.204 121.16 411.437 121.347 411.624 121.72C411.904 122 411.951 122.28 411.764 122.56C405.604 127.973 398.791 130.68 391.324 130.68C385.911 130.68 381.291 129.42 377.464 126.9C373.637 124.38 370.697 121.067 368.644 116.96C366.684 112.853 365.704 108.467 365.704 103.8C365.704 98.2933 367.011 93.2533 369.624 88.68C372.237 84.0133 375.784 80.3733 380.264 77.76C384.837 75.0533 389.831 73.7 395.244 73.7C400.471 73.7 404.484 75.1 407.284 77.9C410.084 80.7 411.484 84.62 411.484 89.66C411.484 90.9667 411.344 91.9 411.064 92.46C410.877 93.02 410.504 93.3 409.944 93.3L375.224 93.44C375.037 95.4933 374.944 97.1733 374.944 98.48C374.944 106.6 376.857 113.18 380.684 118.22C384.511 123.26 389.877 125.78 396.784 125.78C399.584 125.78 401.964 125.407 403.924 124.66C405.977 123.913 408.264 122.747 410.784 121.16H410.924ZM390.624 76.5C386.611 76.5 383.297 77.8533 380.684 80.56C378.071 83.1733 376.344 86.86 375.504 91.62L402.104 91.06C402.104 86.3 401.077 82.7067 399.024 80.28C396.971 77.76 394.171 76.5 390.624 76.5Z" fill="white" fill-opacity="0.1"/>
			</svg>
		</div>
	</div>
</main>