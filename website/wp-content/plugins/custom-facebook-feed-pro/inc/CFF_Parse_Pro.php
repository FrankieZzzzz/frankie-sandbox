<?php
/**
* Class CFF_Parse
*
* The structure of the data coming from the Facebook API is different
* depending on the endpoint. This class provides an easy way to parse
* the response to get the information needed.
*
* @since 3.14
*/

namespace CustomFacebookFeed;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class CFF_Parse_Pro{
	public static function get_post_id( $post ) {
		if ( isset( $post->id ) ) {
			return $post->id;
		} elseif ( ! is_object( $post ) && isset( $post['id'] ) ) {
			return $post['id'];
		}
		return '';
	}

	public static function get_timestamp( $post ) {
		if ( isset( $post->start_time ) ) {
			return strtotime( $post->start_time );
		} elseif ( ! is_object( $post ) && isset( $post['start_time'] ) ) {
			return strtotime( $post['start_time'] );
		} elseif ( isset( $post->created_time ) ) {
			return strtotime( $post->created_time );
		} elseif ( ! is_object( $post ) && isset( $post['created_time'] ) ) {
			return strtotime( $post['created_time'] );
		}
		return '';
	}

	public static function get_media_url( $post, $resolution = 'lightbox' ) {
		if ( isset( $post->full_picture ) ) {
			return $post->full_picture;
		} elseif ( ! is_object( $post ) && isset( $post['full_picture'] ) ) {
			return $post['full_picture'];
		} elseif ( isset( $post->attachments->data[0]->media->image->src ) ) {
			return $post->attachments->data[0]->media->image->src;
		} elseif ( ! is_object( $post ) && isset( $post['attachments']['data'][0]['media']['image']['src'] ) ) {
			return $post['attachments']['data'][0]['media']['image']['src'];
		} elseif ( isset( $post->cover ) ) {
			return $post->cover->source;
		} elseif ( ! is_object( $post ) && isset( $post['cover'] ) ) {
			return $post['cover']['source'];
		} elseif ( isset( $post->images ) ) {
			return $post->images[0]->source;
		} elseif ( ! is_object( $post ) && isset( $post['images'] ) ) {
			return $post['images'][0]['source'];
		} elseif ( isset( $post->format ) ) {
			$num = count( $post->format );
			return $post->format[ $num - 1 ]->picture;
		} elseif ( ! is_object( $post ) && isset( $post['format'] ) ) {
			$num = count( $post['format'] );
			return $post['format'][ $num - 1 ]['picture'];
		} elseif ( isset( $post->cover_photo ) ) {
			return $post->cover_photo->source;
		} elseif ( ! is_object( $post ) && isset( $post['cover_photo'] ) ) {
			return $post['cover_photo']['source'];
		}
		return '';
	}

	public static function get_message( $post ) {

		if ( isset( $post->message ) ) {
			return $post->message;
		} elseif ( ! is_object( $post ) && isset( $post['message'] ) ) {
			return $post['message'];
		} elseif ( isset( $post->description ) ) {
			return $post->description;
		} elseif ( ! is_object( $post ) && isset( $post['description'] ) ) {
			return $post['description'];
		}
		return '';
	}

	public static function get_status_type( $post ) {

		if ( isset( $post->status_type ) ) {
			return $post->status_type;
		} elseif ( ! is_object( $post ) && isset( $post['status_type'] ) ) {
			return $post['status_type'];
		} elseif ( isset( $post->start_time )
		           || (! is_object( $post ) && isset( $post['start_time'] )) ) {
			return 'event';
		} elseif ( isset( $post->images )
				|| (! is_object( $post ) && isset( $post['images'] ))) {
			return 'photo';
		} elseif ( isset( $post->format )
		          || (! is_object( $post ) && isset( $post['format'] ))) {
			return 'video';
		} elseif ( isset( $post->cover_photo )
		          || (! is_object( $post ) && isset( $post['cover_photo'] ))) {
			return 'album';
		}
		return '';
	}

	public static function get_event_name( $post ) {

		if ( isset( $post->name ) ) {
			return $post->name;
		} elseif ( ! is_object( $post ) && isset( $post['name'] ) ) {
			return $post['name'];
		}
		return '';
	}



	public static function get_permalink( $post ) {
		if ( isset( $post->start_time ) ) {
			return 'https://www.facebook.com/events/' . $post->id;
		} elseif ( ! is_object( $post ) && isset( $post['start_time'] ) ) {
			return 'https://www.facebook.com/events/' . $post['id'];
		} elseif ( isset( $post->id ) ) {
			return 'https://www.facebook.com/' . $post->id;
		} elseif ( ! is_object( $post ) && isset( $post['id'] ) ) {
			return 'https://www.facebook.com/' . $post['id'];
		} elseif ( isset( $post->link ) ) {
			return $post->link;
		} elseif ( ! is_object( $post ) && isset( $post['link'] ) ) {
			return $post['link'];
		}
		return 'https://www.facebook.com/';
	}

	public static function get_from_link( $post ) {
		if ( isset( $post->from->link ) ) {
			return $post->from->link;
		} elseif ( ! is_object( $post ) && isset( $post['from']['link'] ) ) {
			return $post['from']['link'];
		} elseif ( isset( $post->owner->link ) ) {
			return $post->owner->link;
		} elseif ( ! is_object( $post ) && isset( $post['owner']['link'] ) ) {
			return $post['owner']['link'];
		}
		return 'https://www.facebook.com/';
	}

	public static function get_comments_count( $post ) {
		if ( isset( $post->comments->summary->total_count ) ) {
			return $post->comments->summary->total_count;
		} elseif ( ! is_object( $post ) && isset( $post['comments']['summary']['total_count'] ) ) {
			return $post['comments']['summary']['total_count'];
		} elseif ( isset( $post->comments->data[0]->summary->total_count ) ) {
			return $post->comments->data[0]->summary->total_count;
		} elseif ( ! is_object( $post ) && isset( $post['comments']['data'][0]['summary']['total_count'] ) ) {
			return $post['comments']['data'][0]['summary']['total_count'];
		}
		return '';
	}

	public static function get_likes_count( $post ) {
		if ( isset( $post->likes->summary->total_count ) ) {
			return $post->likes->summary->total_count;
		} elseif ( ! is_object( $post ) && isset( $post['likes']['summary']['total_count'] ) ) {
			return $post['likes']['summary']['total_count'];
		} elseif ( isset( $post->likes->data[0]->summary->total_count ) ) {
			return $post->likes->data[0]->summary->total_count;
		} elseif ( ! is_object( $post ) && isset( $post['likes']['data'][0]['summary']['total_count'] ) ) {
			return $post['likes']['data'][0]['summary']['total_count'];
		}
		return '';
	}

	public static function get_interested_count( $post ) {
		if ( isset( $post->interested_count ) ) {
			return $post->interested_count;
		} elseif ( ! is_object( $post ) && isset( $post['interested_count'] ) ) {
			return $post['interested_count'];
		}
		return '';
	}

	public static function get_attending_count( $post ) {
		if ( isset( $post->attending_count ) ) {
			return $post->attending_count;
		} elseif ( ! is_object( $post ) && isset( $post['attending_count'] ) ) {
			return $post['attending_count'];
		}
		return '';
	}

	public static function get_count_count( $post ) {

		if ( isset( $post->count ) ) {
			return $post->count;
		} elseif ( ! is_object( $post ) && isset( $post['count'] ) ) {
			return $post['count'];
		}
		return '';
	}

	public static function get_video_length( $post ) {

		if ( isset( $post->length ) ) {
			return $post->length;
		} elseif ( ! is_object( $post ) && isset( $post['length'] ) ) {
			return $post['length'];
		}
		return '';
	}

	public static function get_link( $header_data ) {
		$link = isset( $header_data->link) ? $header_data->link : "https://facebook.com";
		return $link;
	}

	public static function get_cover_source( $header_data ) {
		$url = isset( $header_data->cover->source ) ? $header_data->cover->source : '';
		return $url;
	}

	public static function get_avatar( $data ) {
		if ( isset( $data->from->picture->data->url ) ) {
			$avatar = $data->from->picture->data->url;
		} elseif ( ! is_object( $data ) && isset( $data['from']['picture']['data']['url'] ) ) {
			$avatar = $data['from']['picture']['data']['url'];
		} elseif ( isset( $data->owner->picture->data->url ) ) {
			$avatar = $data->owner->picture->data->url;
		} elseif ( ! is_object( $data ) && isset( $data['owner']['picture']['data']['url'] ) ) {
			$avatar = $data['owner']['picture']['data']['url'];
		} else {
			$avatar = isset( $data->picture->data->url ) ? $data->picture->data->url : '';
		}
		return $avatar;
	}

	public static function get_name( $data ) {
		if ( isset( $data->from->name ) ) {
			$name = $data->from->name;
		} elseif ( ! is_object( $data ) && isset( $data['from']['name'] ) ) {
			$name = $data['from']['name'];
		} elseif ( isset( $data->owner->name ) ) {
			$name = $data->owner->name;
		} elseif ( ! is_object( $data ) && isset( $data['owner']['name'] ) ) {
			$name = $data['owner']['name'];
		} elseif ( isset( $data->name ) ) {
			$name = $data->name;
		} elseif ( ! is_object( $data ) && isset( $data['name'] ) ) {
			$name = $data['name'];
		} else {
			$name = '';
		}
		return $name;
	}

	public static function get_item_title( $data ) {
		$title = '';
		if ( isset( $data->name ) ) {
			$title = $data->name;
		} elseif ( ! is_object( $data ) && isset( $data['name'] ) ) {
			$title = $data['name'];
		}
		return $title;
	}

	public static function get_bio( $header_data ) {
		$about = isset( $header_data->about ) ? $header_data->about : '';
		return $about;
	}

	public static function get_likes( $header_data ) {
		$likes = isset( $header_data->fan_count ) ? $header_data->fan_count : '';
		return $likes;
	}

	public static function get_attachments( $post ) {

		if ( isset( $post->attachments ) ) {
			return $post->attachments->data;
		} elseif ( ! is_object( $post ) && isset( $post['attachments'] ) ) {
			return $post['attachments']['data'];
		}
		return '';
	}
	public static function get_sub_attachments( $post ) {

		if ( isset( $post->attachments ) && isset( $post->attachments->data[0]->subattachments ) ) {
			return $post->attachments->data[0]->subattachments->data ;
		} elseif ( ! is_object( $post ) && isset( $post['attachments']['data'][0]['subattachments'] ) ) {
			return $post['attachments']['data'][0]['subattachments']['data'];
		} elseif ( isset( $post->subattachments ) ) {
			return $post->subattachments->data ;
		} elseif ( ! is_object( $post ) && isset( $post['subattachments'] ) ) {
			return $post['subattachments']['data'];
		}else {
			return array();
		}
	}

	public static function get_sub_attachment_type( $sub_attachment ) {

		if ( isset( $sub_attachment->type ) ) {
			return $sub_attachment->type;
		} elseif ( ! is_object( $sub_attachment ) && isset( $sub_attachment['type'] ) ) {
			return $sub_attachment['type'];
		}
		return '';
	}


	public static function get_attachment_title( $attachment ) {

		if ( isset( $attachment->title ) ) {
			return $attachment->title;
		} elseif ( ! is_object( $attachment ) && isset( $attachment['title'] ) ) {
			return $attachment['title'];
		}
		return '';
	}

	public static function get_attachment_description( $attachment ) {

		if ( isset( $attachment->description ) ) {
			return $attachment->description;
		} elseif ( ! is_object( $attachment ) && isset( $attachment['description'] ) ) {
			return $attachment['description'];
		}
		return '';
	}

	public static function get_attachment_unshimmed_url( $attachment ) {

		if ( isset( $attachment->unshimmed_url ) ) {
			return $attachment->unshimmed_url;
		} elseif ( ! is_object( $attachment ) && isset( $attachment['unshimmed_url'] ) ) {
			return $attachment['unshimmed_url'];
		}
		return '';
	}

	public static function get_attachment_media_type( $attachment ) {

		if ( isset( $attachment->media_type ) ) {
			return $attachment->media_type;
		} elseif ( ! is_object( $attachment ) && isset( $attachment['media_type'] ) ) {
			return $attachment['media_type'];
		}
		return '';
	}

	public static function get_attachment_image( $attachment ) {

		if ( isset( $attachment->media ) ) {
			return $attachment->media->image->src;
		} elseif ( ! is_object( $attachment ) && isset( $attachment['media'] ) ) {
			return $attachment['media']['image']['src'];
		}
		return '';
	}

	public static function get_format_source_set( $post ) {
		$data_array = array();

		if ( isset( $post->format ) ) {
			$i = 0;
			foreach ( $post->format as $format ) {
				if ( $i === 0 ) {
					$res = 130;
				} elseif ( $i === 1 ) {
					$res = 480;
				} else {
					$res = 720;
				}
				$data_array[0][ $res ] = $format->picture;
				$i++;
			}

		} elseif ( ! is_object( $post ) && isset( $post['format'] ) ) {
			$i = 0;
			foreach ( $post['format'] as $format ) {
				if ( $i === 0 ) {
					$res = 130;
				} elseif ( $i === 1 ) {
					$res = 480;
				} else {
					$res = 720;
				}
				$data_array[0][ $res ] = $format['picture'];
				$i++;
			}
		}

		return $data_array;
	}

	public static function get_images_source_set( $post ) {
		$data_array = array();

		if ( isset( $post->images ) ) {
			$i = 0;
			if ( count( $post->images ) > 4 ) {
				foreach ( $post->images as $image ) {
					if ( $i === 2 ) {
						$data_array[0][ $image->width ] = $image->source;
					} elseif ( $i === 4  ) {
						$data_array[0][ $image->width ] = $image->source;
					} elseif ( $i === 5  ) {
						$data_array[0][ $image->width ] = $image->source;
					} elseif ( $i === 7  ) {
						$data_array[0][ $image->width ] = $image->source;
					}

					$i++;
				}
			} else {
				foreach ( $post->images as $image ) {
					$data_array[0][ $image->width ] = $image->source;
				}
			}


		} elseif ( ! is_object( $post ) && isset( $post['images'] ) ) {
			$i = 0;
			if ( count( $post['images'] ) > 4 ) {

				foreach ( $post['images'] as $image ) {
					if ( $i === 2 ) {
						$data_array[0][ $image['width'] ] = $image['source'];
					} elseif ( $i === 4 ) {
						$data_array[0][ $image['width'] ] = $image['source'];
					} elseif ( $i === 5 ) {
						$data_array[0][ $image['width'] ] = $image['source'];
					} elseif ( $i === 7 ) {
						$data_array[0][ $image['width'] ] = $image['source'];
					}

					$i ++;
				}
			} else {
				foreach ( $post['images'] as $image ) {
					$data_array[0][ $image['width'] ] = $image['source'];
				}
			}
		}

		return $data_array;
	}

	public static function get_media_src_set( $post, $connected_account = false ) {
		$data_array = array();

		if ( is_string( $post) ) {
			$data_array[0][720] = $post;
		} else {
			$maybe_images_images = CFF_Parse_Pro::get_images_source_set( $post );
			$maybe_format_images = CFF_Parse_Pro::get_format_source_set( $post );
			$maybe_sub_attachments = CFF_Parse_Pro::get_sub_attachments( $post );

			if ( ! empty( $maybe_images_images ) ) {
				$data_array = $maybe_images_images;
			} elseif ( ! empty( $maybe_format_images ) ) {
				$data_array = $maybe_format_images;
			} elseif ( ! empty( $maybe_sub_attachments ) ) {
				foreach ( $maybe_sub_attachments as $attachment_item ) {
					//Check whether it's a product attachment
					$sub_attach_type = CFF_Parse_Pro::get_sub_attachment_type( $attachment_item );

					if ( strpos( $sub_attach_type, 'product' ) === false ){
						if ( is_object( $attachment_item ) && isset( $attachment_item->media ) ) {
							$data_array[][ $attachment_item->media->image->width ] = $attachment_item->media->image->src;
						} elseif ( ! is_object( $attachment_item ) && isset( $attachment_item['media'] ) ) {
							$data_array[][ $attachment_item['media']['image']['width'] ] = $attachment_item['media']['image']['src'];
						};
					}

				}
				if ( isset( $post->attachments->data ) && isset( $post->attachments->data[0]->media ) ) {
					if ( isset( $post->picture ) ) {
						$aspect_ratio = $post->attachments->data[0]->media->image->width / $post->attachments->data[0]->media->image->height;
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 130 : 130;
						$data_array[][ absint( $actual_width ) ] = $post->picture;
					}elseif ( isset( $post->full_picture ) ) {
						$aspect_ratio = $post->attachments->data[0]->media->image->width / $post->attachments->data[0]->media->image->height;
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 720 : 720;
						$data_array[][ absint( $actual_width ) ] = $post->full_picture;
					} else {
						$data_array[][ $post->attachments->data[0]->media->image->width ] = $post->attachments->data[0]->media->image->src;
					}

				} elseif ( ! is_object( $post ) && isset( $post['attachments']['data'][0]['media']['image']['src'] ) ) {
					if ( isset( $post['picture'] ) ) {
						$aspect_ratio = $post['attachments']['data'][0]['media']['image']['width'] / $post['attachments']['data'][0]['media']['image']['height'];
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 130 : 130;
						$data_array[][ absint( $actual_width ) ] = $post['picture'];
					} elseif ( isset( $post['full_picture'] ) ) {
						$aspect_ratio = $post['attachments']['data'][0]['media']['image']['width'] / $post['attachments']['data'][0]['media']['image']['height'] ;
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 720 : 720;
						$data_array[][ absint( $actual_width ) ] = $post['full_picture'];
					} else {
						$data_array[][ $post['attachments']['data'][0]['media']['image']['width'] ] = $post['attachments']['data'][0]['media']['image']['src'];
					}
				}
			} else {
				if ( isset( $post->attachments->data ) && isset( $post->attachments->data[0]->media ) ) {
					if ( isset( $post->picture ) ) {
						$aspect_ratio = $post->attachments->data[0]->media->image->width / $post->attachments->data[0]->media->image->height;
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 130 : 130;
						$data_array[0][ absint( $actual_width ) ] = $post->picture;
					}
					if ( isset( $post->full_picture ) ) {
						$aspect_ratio = $post->attachments->data[0]->media->image->width / $post->attachments->data[0]->media->image->height;
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 720 : 720;
						$data_array[0][ absint( $actual_width ) ] = $post->full_picture;
					} else {
						$data_array[0][ $post->attachments->data[0]->media->image->width ] = $post->attachments->data[0]->media->image->src;
					}

				} elseif ( ! is_object( $post ) && isset( $post['attachments']['data'][0]['media']['image']['src'] ) ) {
					if ( isset( $post['picture'] ) ) {
						$aspect_ratio = $post['attachments']['data'][0]['media']['image']['width'] / $post['attachments']['data'][0]['media']['image']['height'];
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 130 : 130;
						$data_array[0][ absint( $actual_width ) ] = $post['picture'];
					}
					if ( isset( $post['full_picture'] ) ) {
						$aspect_ratio = $post['attachments']['data'][0]['media']['image']['width'] / $post['attachments']['data'][0]['media']['image']['height'] ;
						$actual_width = $aspect_ratio < 1 ? $aspect_ratio * 720 : 720;
						$data_array[0][ absint( $actual_width ) ] = $post['full_picture'];
					} else {
						$data_array[0][ $post['attachments']['data'][0]['media']['image']['width'] ] = $post['attachments']['data'][0]['media']['image']['src'];
					}
				} elseif ( isset( $post->full_picture ) ) {
					$data_array[0][720] = $post->full_picture;
					if ( isset( $post->picture ) ) {
						$data_array[0][130] = $post->picture;
					}
				} elseif ( ! is_object( $post ) && isset( $post['full_picture'] ) ) {
					$data_array[0][720] = $post['full_picture'];
					if ( isset( $post['picture'] ) ) {
						$data_array[0][130] = $post['picture'];
					}
				} elseif ( isset( $post->cover_photo ) || (! is_object( $post ) && isset( $post['cover_photo'] )) ) {
					if ( isset( $post->cover_photo->source ) ) {
						$data_array[0][720] = $post->cover_photo->source;
					} elseif (!is_object( $post ) && isset( $post['cover_photo']['source'] )) {
						$data_array[0][720] = $post['cover_photo']['source'];
					} else {
						$id = is_object( $post ) ? $post->cover_photo->id : $post['cover_photo']['id'];
						$access_token_after = is_object( $connected_account ) ? '?access_token=' . $connected_account->accesstoken : '';
						$data_array[0][720] = 'https://graph.facebook.com/' . $id . '/picture' . $access_token_after;
					}
				} elseif ( isset( $post->cover ) ) {
					$data_array[0][720] = $post->cover->source;
				} elseif ( ! is_object( $post ) && isset( $post['cover'] ) ) {
					$data_array[0][720] = $post['cover']['source'];
				}
			}
		}

		return $data_array;
	}

	public static function get_event_start_time( $event ) {
		$time = '';
		$timezone = 'UTC';

		if ( isset( $event->start_time ) ) {
			$time = $event->start_time;
			$timezone = isset( $event->timezone ) ? $event->timezone : 'UTC';
		} elseif ( ! is_object( $event ) &&  isset( $event['start_time'] ) ) {
			$time = $event['start_time'];
			$timezone = isset( $event['timezone'] ) ? $event['timezone'] : 'UTC';
		}

		$timestamp = CFF_Utils::cff_set_timezone( strtotime( $time ), $timezone );

		return $timestamp;
	}

	public static function get_event_end_time( $event ) {
		$time = '';
		$timezone = 'UTC';

		if ( isset( $event->end_time ) ) {
			$time = $event->end_time;
			$timezone = isset( $event->timezone ) ? $event->timezone : 'UTC';
		} elseif ( ! is_object( $event ) &&  isset( $event['end_time'] ) ) {
			$time = $event['end_time'];
			$timezone = isset( $event['timezone'] ) ? $event['timezone'] : 'UTC';
		}

		$timestamp = CFF_Utils::cff_set_timezone( strtotime( $time ), $timezone );

		return $timestamp;
	}

	public static function get_event_location_name( $event ) {
		if ( isset( $event->place->name ) ) {
			return $event->place->name;
		} elseif ( ! is_object( $event ) &&  isset( $event['place']['name'] ) ) {
			return $event['place']['name'];
		}
		return '';
	}

	public static function get_event_street( $event ) {
		if ( isset( $event->place->location->street ) ) {
			return $event->place->location->street;
		} elseif ( ! is_object( $event ) &&  isset( $event['place']['location']['street'] ) ) {
			return $event['place']['location']['street'];
		}
		return '';
	}

	public static function get_event_state( $event ) {
		if ( isset( $event->place->location->state ) ) {
			return $event->place->location->state;
		} elseif ( ! is_object( $event ) &&  isset( $event['place']['location']['state'] ) ) {
			return $event['place']['location']['state'];
		}
		return '';
	}

	public static function get_event_city( $event ) {
		if ( isset( $event->place->location->city ) ) {
			return $event->place->location->city;
		} elseif ( ! is_object( $event ) &&  isset( $event['place']['location']['city'] ) ) {
			return $event['place']['location']['city'];
		}
		return '';
	}

	public static function get_event_zip( $event ) {
		if ( isset( $event->place->location->zip ) ) {
			return $event->place->location->zip;
		} elseif ( ! is_object( $event ) &&  isset( $event['place']['location']['zip'] ) ) {
			return $event['place']['location']['zip'];
		}
		return '';
	}

	public static function get_event_strings( $event ) {

		if ( is_array( $event ) ) {
			$event = (object) $event;
		}

		return $event;
	}

	public static function get_iframe_html( $post ) {
		if ( isset( $post->embed_html ) ) {
			return $post->embed_html;
		} elseif ( ! is_object( $post ) && isset( $post['embed_html'] ) ) {
			return $post['embed_html'];
		}

		return '';
	}

	public static function is_album( $post ) {
		return (isset( $post->cover_photo ) || (! is_object( $post ) && isset( $post['cover_photo'] )));
	}

	public static function get_from_id( $post ) {
		if ( is_object( $post ) && isset( $post->from->id ) ) {
			return $post->from->id;
		} elseif ( ! is_object( $post ) && isset( $post['from']['id'] ) ) {
			return $post['from']['id'];
		}

		return 0;
	}
}