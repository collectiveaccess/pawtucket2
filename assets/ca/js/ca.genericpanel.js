# ----------------------------------------------------------------------------------------------------------------
#  Processing for object representations
# ----------------------------------------------------------------------------------------------------------------

#
# If you want original media fetched from URLs to *NOT* be stored in CA, but rather
# for CA to directly reference the media via the URL used to fetch it set use_external_url_when_available to 1
# 
# If you have no idea what this means then leave this set to zero
#
use_external_url_when_available = 0

#
# Filesize (in bytes) above which media should be queued for background processing
# Files smaller than the threshold will be processed at the time of upload, so you should set this to a 
# small enough value that your server has a shot at processing the media in near-realtime. A safe bet is
# 500,000 bytes (eg. 0.5 megabytes), but you may need to go lower (or higher). 
#
# Note that you can override this setting for specific media types and versions below if you wish. Also keep in
# mind a few other fun facts:
#
#	1. If the queue_enabled setting in global.conf is set to zero then no background processing will take place, no matter what you set here.
#	2. The default setting for queue_enabled is zero, so make sure you change it if you want background processing to happen.
#	3. Versions that have no QUEUE_WHEN_FILE_LARGER_THAN are never queued for background processing; versions with a QUEUE_WHEN_FILE_LARGER_THAN settings of zero are similarly never queued (absence and zero are one and the same, config-wise).
#	4. Some types of media are setup by default to never queue no matter the "queue_threshold_in_bytes" and "queue_enabled" settings. This includes media types for much little or no processing is done, including XML and MSWord.
#
queue_threshold_in_bytes = 500000

ca_object_representations = {
	MEDIA_METADATA = "media_metadata",
	MEDIA_CONTENT = "media_content",
				
	MEDIA_ACCEPT = {
		image/jpeg 						= image,
		image/gif 						= image,
		image/png						= image,
		image/tiff						= image,
		image/x-bmp						= image,
		image/x-dcraw					= image,
		image/x-psd						= image,
		image/x-dpx						= dpx_image,
		image/x-exr						= image,
		image/jp2						= image,
		image/x-adobe-dng				= image,
		image/x-canon-cr2				= image,
		image/x-canon-crw				= image,
		image/x-sony-arw				= image,
		image/x-olympus-orf				= image,
		image/x-pentax-pef				= image,
		image/x-epson-erf				= image,
		image/x-nikon-nef				= image,
		image/x-sony-sr2				= image,
		image/x-sony-srf				= image,
		image/x-sigma-x3f				= image,
		application/dicom				= image,
		image/heic				        = image,
		
		application/pdf					= pdf,
		application/postscript 			= pdf,
		
		video/quicktime					= quicktime,
		video/x-ms-asf					= windowsmedia,
		video/x-ms-wmv					= windowsmedia,
		video/x-flv						= flv,
		video/mpeg						= mpeg,
		video/mp4						= mpeg4,
		video/ogg						= quicktime,
		video/avi						= windowsmedia,
		video/x-dv						= quicktime,
		video/x-matroska                = quicktime,
		video/MP2T                      = quicktime,
		
		audio/ogg						= ogg,
		audio/mpeg						= mp3,
		audio/x-aiff					= aiff,
		audio/mp4						= aiff,
		audio/x-wav						= aiff,
		audio/x-flac					= aiff,
		
		application/msword				= msword,
		application/vnd.ms-excel		= msword,
		application/vnd.ms-powerpoint 	= msword,
		application/vnd.openxmlformats-officedocument.wordprocessingml.document				= msword,
		application/vnd.openxmlformats-officedocument.spreadsheetml.sheet		= msword,
		application/vnd.openxmlformats-officedocument.presentationml.presentation 	= msword,
		text/xml						= xml,

		application/ply 				= ply_mesh,
		application/stl 				= mesh,
		text/prs.wavefront-obj			= mesh,
		application/surf 				= mesh,
		model/gltf+json                 = mesh,
		
		x-world/x-qtvr					= quicktimevr,
		
		application/octet-stream		= binaryfile
	},
	
	MEDIA_TYPES = {
		image = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Image is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {	
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		dpx_image = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Image is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {	
				icon 		= {
					RULE = rule_icon_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				small 	= {
					RULE = rule_small_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview = {
					RULE = rule_preview_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_dpx_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>0
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				},
				tilepic 	= {
					RULE = rule_tilepic_dpx_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		pdf = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN 	= <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN 	= <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				compressed	= {
					RULE = rule_compressed_pdf, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		msword = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 		= {
					RULE = rule_iconlarge_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				pdf 	= {
					RULE = rule_to_pdf, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575
		},
		xml = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575
		},
		mesh = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images
				},	
				iconlarge 		= {
					RULE = rule_iconlarge_image, VOLUME = images
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = small,
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575,	
		},
		ply_mesh = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images
				},	
				iconlarge 		= {
					RULE = rule_iconlarge_image, VOLUME = images
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images
				},
				stl = {
					RULE = rule_to_stl, VOLUME = images
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = stl,
			MEDIA_PREVIEW_DEFAULT_VERSION = small,
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575,	
		},
		flv = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Video is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {	
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				h264_hi 	= {
					RULE = rule_video_to_h264_hi, VOLUME = quicktime,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_video, VOLUME = flv
				}
			}
			MEDIA_VIEW_DEFAULT_VERSION = h264_hi,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		windowsmedia = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Video is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				h264_hi 	= {
					RULE = rule_video_to_h264_hi, VOLUME = quicktime,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_video, VOLUME = windowsmedia
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = h264_hi,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		mpeg = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Media is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {	
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				h264_hi 	= {
					RULE = rule_video_to_h264_hi, VOLUME = quicktime,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_video, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = h264_hi,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		quicktime = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Media is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				h264_hi 	= {
					RULE = rule_video_to_h264_hi, VOLUME = quicktime,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				# EXAMPLE OF HOW TO ENCODE Ogg Theora video
				#ogg 	= {
				#	RULE = rule_video_to_ogg_theora, VOLUME = quicktime,
				#	QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				#},
				original 	= {
					RULE = rule_video, VOLUME = quicktime,
					#SKIP_WHEN_FILE_LARGER_THAN = 500000,
					#REPLACE_WITH_VERSION = page
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = h264_hi,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		quicktimevr = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Media is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_video, VOLUME = quicktime
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		mpeg4 = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Media is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				#
				# Uncomment this if you want to generate a an h.264 derivative for your MPEG-4's
				# If your MPEG-4's are already h.264 compressed (they probably are) and ready
				# for web-viewing then generating this version is probably a waste of processor
				# time and disk space. Not to mention that recompressed MPEG-4's usually look like mud.
				#
				#h264_hi 	= {
				#	RULE = rule_video_to_h264_hi, VOLUME = quicktime,
				#	QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				#},
				original 	= {
					RULE = rule_video, VOLUME = quicktime,
					#SKIP_WHEN_FILE_LARGER_THAN = 500000,
					#REPLACE_WITH_VERSION = large
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		mp3 = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Audio is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {	
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				# This is not a mistake - we re-encode to ensure a uniform bit-rate for all MP3 streams
				mp3 	= {
					RULE = rule_to_mp3, VOLUME = mp3,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				# EXAMPLE OF HOW TO ENCODE Ogg Vorbis audio
				#ogg = {
				#	RULE = rule_to_ogg_vorbis, VOLUME = mp3,
				#	QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				#},
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = mp3,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		aiff = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Audio is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				icon 		= {
					RULE = rule_icon_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				preview = {
					RULE = rule_preview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				small 	= {
					RULE = rule_small_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mp3 	= {
					RULE = rule_to_mp3, VOLUME = mp3,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				# EXAMPLE OF HOW TO ENCODE Ogg Vorbis audio
				#ogg = {
				#	RULE = rule_to_ogg_vorbis, VOLUME = mp3,
				#	QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				#},
				page 	= {
					RULE = rule_page_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = mp3,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		},
		binaryfile = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Image is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {	
				icon 		= {
					RULE = rule_icon_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				iconlarge 	= {
					RULE = rule_iconlarge_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				tiny 		= {
					RULE = rule_tiny_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},	
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widethumbnail = {
					RULE = rule_widethumbnail_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},				
				small 	= {
					RULE = rule_small_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview = {
					RULE = rule_preview_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				preview170 = {
					RULE = rule_preview170_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				widepreview = {
					RULE = rule_widepreview_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				medium 	= {
					RULE = rule_medium_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				mediumlarge = {
					RULE = rule_mediumlarge_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				large 	= {
					RULE = rule_large_image, VOLUME = images,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				page 	= {
					RULE = rule_page_image, VOLUME = images, BASIS = large,
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images,
					USE_EXTERNAL_URL_WHEN_AVAILABLE = <use_external_url_when_available>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large,
			MEDIA_PREVIEW_DEFAULT_VERSION = small
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		# Image rules
		# ---------------------------------------------------------
		rule_icon_image = {
			SCALE = {
				width = 72, height = 72, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_iconlarge_image = {
			SCALE = {
				width = 250, height = 250, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_tiny_image = {
			SCALE = {
				width = 72, height = 72, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_thumbnail_image = {
			SCALE = {
				width = 120, height = 120, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_widethumbnail_image = {
			SCALE = {
				width = 110, height = 75, mode = fill_box, crop_from = center, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},		
		rule_preview170_image = {
			SCALE = {
				width = 170, height = 170, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_widepreview_image = {
			SCALE = {
				width = 200, height = 120, mode = fill_box, crop_from = center, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_preview_image = {
			SCALE = {
				width = 180, height = 180, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_small_image = {
			SCALE = {
				width = 240, height = 240, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_medium_image = {
			SCALE = {
				width = 400, height = 400, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_mediumlarge_image = {
			SCALE = {
				width = 580, height = 450, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_image = {
			SCALE = {
				width = 700, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_page_image = {
			SCALE = {
				width = 1000, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_to_stl = {
			SET = {format = application/stl}
		},
		rule_to_pdf = {
			SET = {format = application/pdf}
		},
		rule_compressed_pdf = {
		    SET = {format = application/pdf, compress = screen }
		},
		rule_original_image = {},
		rule_tilepic_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic}
		},
		# ---------------------------------------------------------
		# Image rules (DPX format only)
		# ---------------------------------------------------------
		rule_icon_dpx_image = {
			SCALE = {
				width = 72, height = 72, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_iconlarge_dpx_image = {
			SCALE = {
				width = 250, height = 250, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_tiny_dpx_image = {
			SCALE = {
				width = 72, height = 72, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_thumbnail_dpx_image = {
			SCALE = {
				width = 120, height = 120, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_widethumbnail_dpx_image = {
			SCALE = {
				width = 110, height = 75, mode = fill_box, crop_from = center, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},		
		rule_preview170_dpx_image = {
			SCALE = {
				width = 170, height = 170, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_widepreview_dpx_image = {
			SCALE = {
				width = 200, height = 120, mode = fill_box, crop_from = center, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_preview_dpx_image = {
			SCALE = {
				width = 180, height = 180, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_small_dpx_image = {
			SCALE = {
				width = 240, height = 240, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_medium_dpx_image = {
			SCALE = {
				width = 400, height = 400, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_mediumlarge_dpx_image = {
			SCALE = {
				width = 580, height = 450, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_large_dpx_image = {
			SCALE = {
				width = 700, height = 600, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_tilepic_dpx_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic, gamma = 1.7, reference-black = 6080, reference-white = 43840}
		},
		# ---------------------------------------------------------
		# Video rules
		# ---------------------------------------------------------
		rule_video = {},
		#
		#
		# 
		rule_video_to_h264_hi = {
			SET = {
				format = video/mpeg,
				command = "-s 1280x720 -y -c:a aac -ab 96k -ac 1 -ar 44100 -c:v libx264 -crf 23 -threads 2 -async 1 -strict -2 -pix_fmt yuv420p"
			}
		},
		# Rule used to encode video as Ogg Theora; you'll have to actually add versions using this rule to get Ogg files actually encoded
		rule_video_to_ogg_theora = {
			SET = {
				format = video/ogg,
				command = " -acodec libvorbis -vcodec libtheora -ab 128k -ar 44100"
			}
		},
		# ---------------------------------------------------------
		# Audio rules
		# ---------------------------------------------------------
		rule_to_mp3 = {
			SET = {bitrate = 192000, format = audio/mpeg, channels = 1, sample_frequency = 44100}
		},
		# Rule used to encode audio as Ogg Vorbis; you'll have to actually add versions using this rule to get Ogg files actually encoded
		rule_to_ogg_vorbis = {
			SET = {bitrate = 192000, format = audio/ogg, channels = 1, sample_frequency = 44100}
		}
		# ---------------------------------------------------------
	}
}
# ----------------------------------------------------------------------------------------------------------------
#  Processing for object representation multifiles
# ----------------------------------------------------------------------------------------------------------------
ca_object_representation_multifiles = {
	MEDIA_METADATA = "media_metadata",
	MEDIA_CONTENT = "media_content", 
				
	MEDIA_ACCEPT = {
		image/jpeg 						= image,
		image/gif 						= image,
		image/png						= image,
		image/tiff						= image,
		image/x-bmp						= image,
		image/x-dcraw					= image,
		image/x-psd						= image,
		image/x-dpx						= dpx_image,
		image/x-exr						= image,
		image/jp2						= image,
		image/x-adobe-dng				= image,
		image/x-canon-cr2				= image,
		image/x-canon-crw				= image,
		image/x-sony-arw				= image,
		image/x-olympus-orf				= image,
		image/x-pentax-pef				= image,
		image/x-epson-erf				= image,
		image/x-nikon-nef				= image,
		image/x-sony-sr2				= image,
		image/x-sony-srf				= image,
		image/x-sigma-x3f				= image,
		
		application/pdf					= pdf,
		application/postscript 			= pdf,
		
		video/quicktime					= quicktime,
		video/x-ms-asf					= windowsmedia,
		video/x-ms-wmv					= windowsmedia,
		video/x-flv						= flv,
		video/mpeg						= mpeg,
		video/mp4						= mpeg4,
		video/ogg						= quicktime,
		video/avi						= windowsmedia,
		video/x-dv						= quicktime,
		video/x-matroska                = quicktime,
		video/MP2T                      = quicktime,
		
		audio/ogg						= ogg,
		audio/mpeg						= mp3,
		audio/x-aiff					= aiff,
		audio/mp4						= aiff,
		audio/x-wav						= aiff,
		audio/x-flac					= aiff,		

		application/msword				= msword,
		text/xml						= xml
	},
	
	MEDIA_TYPES = {
		image = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		dpx_image = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_dpx_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_dpx_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		pdf = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		msword = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview,
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575
		},
		xml = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview,
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575
		},
		flv = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = flv
				}
			}
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		windowsmedia = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = windowsmedia
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		mpeg = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		quicktime = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = quicktime
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		mp3 = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		aiff = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		# Image rules
		# ---------------------------------------------------------
		rule_preview_image = {
			SCALE = {
				width = 180, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_preview_image = {
			SCALE = {
				width = 700, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_page_preview_image = {
			SCALE = {
				width = 1000, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_page_preview_image = {
			SCALE = {
				width = 2000, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_original_image = {},
		rule_tilepic_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic}
		},
		# ---------------------------------------------------------
		# Image rules (DPX format only)
		# ---------------------------------------------------------
		rule_preview_dpx_image = {
			SCALE = {
				width = 180, height = 180, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_tilepic_dpx_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		# ---------------------------------------------------------
		rule_large_preview_dpx_image = {
			SCALE = {
				width = 250, height = 250, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		# ---------------------------------------------------------
		rule_video = {}
		# ---------------------------------------------------------
	}	
}

# ----------------------------------------------------------------------------------------------------------------
#  Processing for attribute value multifiles
# ----------------------------------------------------------------------------------------------------------------
ca_attribute_value_multifiles = {
	MEDIA_METADATA = "media_metadata",
	MEDIA_CONTENT = "media_content", 
				
	MEDIA_ACCEPT = {
		image/jpeg 						= image,
		image/gif 						= image,
		image/png						= image,
		image/tiff						= image,
		image/x-bmp						= image,
		image/x-dcraw					= image,
		image/x-psd						= image,
		image/x-dpx						= dpx_image,
		image/x-exr						= image,
		image/jp2						= image,
		image/x-adobe-dng				= image,
		image/x-canon-cr2				= image,
		image/x-canon-crw				= image,
		image/x-sony-arw				= image,
		image/x-olympus-orf				= image,
		image/x-pentax-pef				= image,
		image/x-epson-erf				= image,
		image/x-nikon-nef				= image,
		image/x-sony-sr2				= image,
		image/x-sony-srf				= image,
		image/x-sigma-x3f				= image,
		
		application/pdf					= pdf,
		application/postscript 			= pdf,
		
		video/quicktime					= quicktime,
		video/x-ms-asf					= windowsmedia,
		video/x-ms-wmv					= windowsmedia,
		video/x-flv						= flv,
		video/mpeg						= mpeg,
		video/mp4						= mpeg4,
		video/ogg						= quicktime,
		video/avi						= windowsmedia,
		video/x-dv						= quicktime,
		video/x-matroska                = quicktime,
		video/MP2T                      = quicktime,
		
		audio/ogg						= ogg,
		audio/mpeg						= mp3,
		audio/x-aiff					= aiff,
		audio/mp4						= aiff,
		audio/x-wav						= aiff,
		
		application/msword				= msword,
		text/xml						= xml,
	},
	
	MEDIA_TYPES = {
		image = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Image is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		dpx_image = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Image is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_dpx_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_dpx_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		pdf = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		msword = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview,
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575
		},
		xml = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview,
			MEDIA_VIEW_WINDOW_WIDTH = 775,
			MEDIA_VIEW_WINDOW_HEIGHT = 575
		},
		flv = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = flv
				}
			}
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		windowsmedia = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = windowsmedia
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		mpeg = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		quicktime = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = quicktime
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = large_preview,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		mp3 = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		aiff = {
			QUEUE = mediaproc, 
			QUEUED_MESSAGE =  _("Document is being processed"),
			QUEUE_USING_VERSION = original,
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		# Image rules
		# ---------------------------------------------------------
		rule_preview_image = {
			SCALE = {
				width = 180, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_preview_image = {
			SCALE = {
				width = 700, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_page_preview_image = {
			SCALE = {
				width = 1000, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_page_preview_image = {
			SCALE = {
				width = 2000, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_original_image = {},
		rule_tilepic_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic}
		},
		# ---------------------------------------------------------
		# Image rules (DPX format only)
		# ---------------------------------------------------------
		rule_preview_dpx_image = {
			SCALE = {
				width = 180, height = 180, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		# ---------------------------------------------------------
		rule_large_preview_dpx_image = {
			SCALE = {
				width = 250, height = 250, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, gamma = 1.7, reference-black = 6080, reference-white = 43840, background = "#ffffff" }
		},
		rule_tilepic_dpx_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic, gamma = 1.7, reference-black = 6080, reference-white = 43840}
		},
		# ---------------------------------------------------------
		rule_video = {}
		# ---------------------------------------------------------
	}	
}

# ----------------------------------------------------------------------------------------------------------------
#  Processing for icons (used in ca_list_items, ca_editor_uis and ca_editor_ui_screens)
# ----------------------------------------------------------------------------------------------------------------
ca_icons = {
	MEDIA_ACCEPT = {
		image/jpeg 						= icon,
		image/gif 						= icon,
		image/png						= icon,
		image/tiff						= icon,
		image/x-bmp						= icon,
		image/x-psd						= icon,
		image/x-exr						= icon,
		image/jp2						= icon,
		image/x-adobe-dng				= icon
	},
	
	MEDIA_TYPES = {
		icon = {
			VERSIONS = {
				icon = {
					RULE = rule_icon_image, VOLUME = images
				},
				largeicon = {
					RULE = rule_largeicon_image, VOLUME = images
				},
				large = {
					RULE = rule_large_image, VOLUME = images
				},
				original = {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = icon,
			MEDIA_PREVIEW_DEFAULT_VERSION = icon
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		# Image rules
		# ---------------------------------------------------------
		rule_icon_image = {
			SCALE = {
				width = 48, height = 48, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		# ---------------------------------------------------------
		rule_largeicon_image = {
			SCALE = {
				width = 72, height = 72, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		# ---------------------------------------------------------
		rule_large_image = {
			SCALE = {
				width = 700, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		# ---------------------------------------------------------
		rule_original_image = {}
		# ---------------------------------------------------------
	}	
}

# ----------------------------------------------------------------------------------------------------------------
#  Processing for floor plans (used in ca_places)
# ----------------------------------------------------------------------------------------------------------------
floorplans = {
	MEDIA_METADATA = "media_metadata",
	MEDIA_CONTENT = "media_content", 
				
	MEDIA_ACCEPT = {
		image/jpeg 						= image,
		image/gif 						= image,
		image/png						= image,
		image/tiff						= image,
		image/x-bmp						= image,
		image/x-dcraw					= image,
		image/x-psd						= image,
		image/x-dpx						= dpx_image,
		image/x-exr						= image,
		image/jp2						= image,
		image/x-adobe-dng				= image,
		image/x-canon-cr2				= image,
		image/x-canon-crw				= image,
		image/x-sony-arw				= image,
		image/x-olympus-orf				= image,
		image/x-pentax-pef				= image,
		image/x-epson-erf				= image,
		image/x-nikon-nef				= image,
		image/x-sony-sr2				= image,
		image/x-sony-srf				= image,
		image/x-sigma-x3f				= image,
		
		application/pdf					= pdf,
		application/postscript 			= pdf
	},
	
	MEDIA_TYPES = {
		image = {
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		},
		pdf = {
			VERSIONS = {
				preview = {
					RULE = rule_preview_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				page_preview = {
					RULE = rule_page_preview_image, VOLUME = images
				},
				tilepic 	= {
					RULE = rule_tilepic_image, VOLUME = tilepics, 
					QUEUE_WHEN_FILE_LARGER_THAN = <queue_threshold_in_bytes>
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = preview
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		# Image rules
		# ---------------------------------------------------------
		rule_preview_image = {
			SCALE = {
				width = 180, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_preview_image = {
			SCALE = {
				width = 700, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_page_preview_image = {
			SCALE = {
				width = 1000, mode = width, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_page_preview_image = {
			SCALE = {
				width = 2000, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_original_image = {},
		rule_tilepic_image = {
			SET = {quality = 40, tile_mimetype = image/jpeg, format = image/tilepic}
		}
		# ---------------------------------------------------------
	}	
}

# ----------------------------------------------------------------------------------------------------------------
#  Processing for user comment media (used in ca_item_comments)
# ----------------------------------------------------------------------------------------------------------------
ca_item_comments_media = {
	MEDIA_ACCEPT = {
		image/jpeg 						= image,
		image/gif 						= image,
		image/png						= image,
		image/tiff						= image,
		image/x-bmp						= image,
		image/x-dcraw					= image,
		image/x-psd						= image,
		image/x-exr						= image,
		image/jp2						= image,
		image/x-adobe-dng				= image,
		image/x-canon-cr2				= image,
		image/x-canon-crw				= image,
		image/x-sony-arw				= image,
		image/x-olympus-orf				= image,
		image/x-pentax-pef				= image,
		image/x-epson-erf				= image,
		image/x-nikon-nef				= image,
		image/x-sony-sr2				= image,
		image/x-sony-srf				= image,
		image/x-sigma-x3f				= image
	},
	
	MEDIA_TYPES = {
		image = {
			VERSIONS = {
				icon = {
					RULE = rule_icon_image, VOLUME = images
				},
				tiny = {
					RULE = rule_tiny_image, VOLUME = images
				},
				thumbnail = {
					RULE = rule_thumbnail_image, VOLUME = images
				},
				large_preview = {
					RULE = rule_large_preview_image, VOLUME = images
				},
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = tilepic,
			MEDIA_PREVIEW_DEFAULT_VERSION = icon
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		# Image rules
		# ---------------------------------------------------------
		rule_icon_image = {
			SCALE = {
				width = 72, height = 72, mode = fill_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_tiny_image = {
			SCALE = {
				width = 72, height = 72, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_thumbnail_image = {
			SCALE = {
				width = 120, height = 120, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_large_preview_image = {
			SCALE = {
				width = 250, height = 250, mode = bounding_box, antialiasing = 0.5
			},
			SET = {quality = 75, format = image/jpeg, background = "#ffffff" }
		},
		rule_original_image = {},
		# ---------------------------------------------------------
	}	
}
# ----------------------------------------------------------------------------------------------------------------
#  Processing for representation annotation previews
# ----------------------------------------------------------------------------------------------------------------
ca_representation_annotation_previews = {
	MEDIA_ACCEPT = {
		image/jpeg 						= image,
		image/gif 						= image,
		image/png						= image,
		image/tiff						= image,
		image/x-bmp						= image,
		image/x-dcraw					= image,
		image/x-psd						= image,
		image/x-dpx						= dpx_image,
		image/x-exr						= image,
		image/jp2						= image,
		image/x-adobe-dng				= image,
		image/x-canon-cr2				= image,
		image/x-canon-crw				= image,
		image/x-sony-arw				= image,
		image/x-olympus-orf				= image,
		image/x-pentax-pef				= image,
		image/x-epson-erf				= image,
		image/x-nikon-nef				= image,
		image/x-sony-sr2				= image,
		image/x-sony-srf				= image,
		image/x-sigma-x3f				= image,
		
		application/pdf					= pdf,
		application/postscript 			= pdf,
		
		video/quicktime					= quicktime,
		video/x-ms-asf					= windowsmedia,
		video/x-ms-wmv					= windowsmedia,
		video/x-flv						= flv,
		video/mpeg						= mpeg,
		video/mp4						= mpeg4,
		video/ogg						= quicktime,
		video/avi						= windowsmedia,
		video/x-dv						= quicktime,
		video/x-matroska                = quicktime,
		video/MP2T                      = quicktime,
		
		audio/ogg						= ogg,
		audio/mpeg						= mp3,
		audio/x-aiff					= aiff,
		audio/mp4						= aiff,
		audio/x-wav						= aiff,
		
		application/msword				= msword,
		text/xml						= xml,
	},
	
	MEDIA_TYPES = {
		image = {
			VERSIONS = {
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		dpx_image = {
			VERSIONS = {
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		pdf = {
			VERSIONS = {
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		msword = {
			VERSIONS = {
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		xml = {
			VERSIONS = {
				original 	= {
					RULE = rule_original_image, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		flv = {
			VERSIONS = {
				original 	= {
					RULE = rule_video, VOLUME = flv
				}
			}
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		windowsmedia = {
			VERSIONS = {
				original 	= {
					RULE = rule_video, VOLUME = windowsmedia
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		mpeg = {
			VERSIONS = {
				original 	= {
					RULE = rule_video, VOLUME = images
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		quicktime = {
			VERSIONS = {
				original 	= {
					RULE = rule_video, VOLUME = quicktime
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		mp3 = {
			VERSIONS = {
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		},
		aiff = {
			VERSIONS = {
				original 	= {
					RULE = rule_video, VOLUME = mp3
				}
			},
			MEDIA_VIEW_DEFAULT_VERSION = original,
			MEDIA_PREVIEW_DEFAULT_VERSION = original
		}
	},
	MEDIA_TRANSFORMATION_RULES = {
		# ---------------------------------------------------------
		rule_original_image = {},
		rule_video = {}
		# ---------------------------------------------------------
	}	
}
# ----------------------------------------------------------------------------------------------------------------
