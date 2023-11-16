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
			</div>
		</div>
	</div>
</main>